<?php
/**
 * Created by PHP Storm
 * User : jmartinez
 * Date : 3/07/19
 * Time : 11:30 PM
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;
use File;
use Codedge\Fpdf\Fpdf\Fpdf;

class Ticket extends Facade
{
    private $_printerName;
    private $_today;
    public  $_pdf;

    /**
     * Ticket constructor.
     * @param string|$namePrinter
     * @throws \Exception
     */
    public function __construct(string $namePrinter = null)
    {
        $this->_printerName = $namePrinter;
        $this->_today = new \DateTime("now");
        $this->_pdf = new FPDF('P', 'mm', [45, 217], true, 'UTF-8', false);
    }
    /**
     * This method is used generate pdf and print for ticket
     * @param array $data
     * @param bool $close
     * @return array
     */
    public function printer(array $data = [], bool $close = false )
    {
        try {
            $this->_pdf->SetAuthor('Jorge Martinez Quezada');
            $this->_pdf->SetTitle("Sales of ticket");
            $this->_pdf->SetFont('Helvetica', 'B', 7, '', true);
            $this->_pdf->AddPage();
            $textYPos = 5;
            $this->_pdf->setY(2);
            $this->_pdf->setX(1);
            $this->_pdf->Cell(2,$textYPos,$data['social_reason'],false,false,"L");
            $textYPos += 6;
            $this->_pdf->setX(1);
            $this->_pdf->SetFont('Helvetica', 'B', 5, '', true);
            $this->_pdf->Cell(2,$textYPos,"RFC ".$data['rfc'],false,false,"L");
            $textYPos += 6;
            $this->_pdf->SetFont('Helvetica','B',2.5);
            $this->_pdf->setX(1);
            $this->_pdf->Cell(2,$textYPos,utf8_decode($data['address']." ".$data['state'].", ".$data['country'].", C.P: ".$data['postal_code']),false,false,"L" );
            $textYPos += 6;
            $this->_pdf->SetFont('Helvetica','',5);
            $this->_pdf->setX(1);
            $this->_pdf->Cell(2,$textYPos,'-----------------------------------------------------------------------');
            $this->_pdf->SetFont('Helvetica','',4);
            $textYPos += 4;
            $this->_pdf->setX(1);
            $this->_pdf->Cell(2,$textYPos,"Cajero: ". strtolower($data['cajero']) ,false,false,"L" );
            $textYPos += 4;
            $this->_pdf->setX(1);
            $this->_pdf->Cell(2,$textYPos,"Caja: ". strtolower($data['caja']),false,false,"L" );
            $textYPos += 4;
            $this->_pdf->setX(1);
            $this->_pdf->Cell(2,$textYPos,"Fecha: ". $this->_today->format("Y-m-d h:i:s"),false,false,"L" );
            $textYPos += 4;
            $this->_pdf->setX(1);
            if (!$close){
                $orders     = (isset($data['order']) ) ? $data['order'] : "";
                $this->_pdf->Cell(2,$textYPos,"No. Orden: ". $orders ,false,false,"L" );
            }else{
                $mountStart = (isset($data['init_mount']) ) ? $data['init_mount'] : "";
                $this->_pdf->Cell(2,$textYPos,"No. Orden: ". "Corte de Caja" ,false,false,"L" );
                $textYPos += 4;
                $this->_pdf->setX(1);
                $this->_pdf->Cell(2,$textYPos,"Monto Inicial: ". format_currency($mountStart) ,false,false,"L" );
            }
            $textYPos +=6;
            $this->_pdf->SetFont('Helvetica','',5);
            $this->_pdf->setX(1);
            $this->_pdf->Cell(2,$textYPos,'-----------------------------------------------------------------------');
            $textYPos +=6;
            $this->_pdf->SetFont('Helvetica','B',3.5);
            $this->_pdf->setX(1);
            $this->_pdf->Cell(2,$textYPos,'#   PRODUCT                   PRICE       DISCOUNT       TOTAL');
            $off = $textYPos+6;

            foreach($data['concepts'] as $product){
                $isCancel   = ($product['status'] == 4 )? "C": "";
                $quantity   = (!$product["quantity"])? 0 : $product["quantity"];
                $products   = (!$product["product"])? "": strtoupper(substr($product["product"], 0,15)) ;
                $price      = (!$product["price"] )? format_currency(0) : ($product['status'] == 4) ? format_currency($product["price"],2,"-$"): format_currency($product["price"]);
                $discount   = (!$product["discount"])? "0%" : $product["discount"]."%";
                $total      = (!$product["total"])? format_currency(0 ): ($product['status'] == 4) ? format_currency($product["total"],2,"-$"): format_currency($product["total"]) ;

                $this->_pdf->setX(1);
                $this->_pdf->Cell(2,$off, $quantity);
                $this->_pdf->setX(4);
                $this->_pdf->Cell(25,$off,  $products );
                $this->_pdf->setX(14);
                $this->_pdf->Cell(10,$off,  $price ,0,0,"R");
                $this->_pdf->setX(20);
                $this->_pdf->Cell(10,$off, $discount ,0,0,"R");
                $this->_pdf->setX(30);
                $this->_pdf->Cell(10,$off,  $total." ".$isCancel,0,0,"R");
                $off+=6;
            }
            $textYPos = $off + 6;
            $this->_pdf->setX(1);
            $this->_pdf->Cell(2,$textYPos,"TOTAL PRODUCTOS: # ".count($data['concepts']),0,0,"L" );
            $this->_pdf->SetFont('Helvetica','B',5);
            $textYPos += 6;
            $this->_pdf->setX(1);
            $this->_pdf->Cell(2,$textYPos,'-----------------------------------------------------------------------');
            $this->_pdf->setX(2);
            $textYPos += 6;
            $this->_pdf->Cell(2,$textYPos,"SUBTOTAL: " );
            $this->_pdf->setX(38);
            $this->_pdf->Cell(2,$textYPos,format_currency($data['subtotal']),0,0,"R");
            $this->_pdf->setX(2);
            $textYPos += 6;
            $this->_pdf->Cell(2,$textYPos,($data['iva'] !== "0.0000") ?"IVA(16%): " : "IVA(0%): ");
            $this->_pdf->setX(38);
            $this->_pdf->Cell(2,$textYPos,format_currency($data['iva']),0,0,"R");
            $this->_pdf->setX(2);
            $textYPos += 6;
            $this->_pdf->Cell(2,$textYPos,"TOTAL: " );
            $this->_pdf->setX(38);
            $this->_pdf->Cell(2,$textYPos,format_currency($data['total']),0,0,"R");
            $this->_pdf->setX(2);
            if ($close){
                $totales = (isset($data['totales']) )? $data['totales'] : 0;
                $extract = (isset($data['extract']) )? $data['extract'] : 0;

                $textYPos += 6;
                $this->_pdf->Cell(2,$textYPos,"MONTO TOTAL : " );
                $this->_pdf->setX(38);
                $this->_pdf->Cell(2,$textYPos,format_currency($totales),0,0,"R");
                $this->_pdf->setX(2);
                $textYPos += 6;
                $this->_pdf->Cell(2,$textYPos,"RETIROS : " );
                $this->_pdf->setX(38);
                $this->_pdf->Cell(2,$textYPos,format_currency($extract,2,'-$'),0,0,"R");
                $this->_pdf->setX(2);
            }
            $textYPos +=12;
            $this->_pdf->SetFont('Helvetica','',5);
            $this->_pdf->setX(1);
            $this->_pdf->Cell(2,$textYPos,'-------------------------------------------------------------------');
            $this->_pdf->SetFont('Helvetica','',4);
            $this->_pdf->Cell(2,$textYPos+4,'GRACIAS POR TU COMPRA, VUELVA PRONTO ');

            $filename= "ticket-".$data['rfc'].( ($close) ? "-cut_{$data['cut']}_box.pdf" : "-".$data['order'].".pdf");
            $dir = "upload_file/ticket/".$this->_today->format("Y_m_d");
            if (!is_dir(public_path()."/".$dir)){
                File::makeDirectory(public_path()."/".$dir,0777,true,true);
            }
            /*I get a purchase ticket */
            $this->_pdf->output(public_path()."/".$dir."/".$filename,"F",true);
            return ['success' => true, "data" => $dir."/".$filename];

        } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getFile()." ".$e->getLine();
            \Log::error($error);
            return ['success' => false, 'mgs' => $error];
        }
    }


}
