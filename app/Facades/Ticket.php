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
    private $_connect;
    private $_printer;
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
            $this->_pdf->SetFont('Helvetica', 'B', 8, '', true);
            $this->_pdf->AddPage();
            $textYPos = 5;
            $this->_pdf->setY(2);
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textYPos,$data['social_reason'],false,false,"L");
            $textYPos += 6;
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textYPos,"RFC. ".$data['rfc'],false,false,"L");
            $textYPos += 6;
            $this->_pdf->SetFont('Arial','B',2.5);
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textYPos,utf8_decode($data['address']." ".$data['state'].", ".$data['country'].", C.P: ".$data['postal_code']),false,false,"L" );
            $textYPos += 6;
            $this->_pdf->SetFont('Arial','',5);
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textYPos,'-------------------------------------------------------------------');
            $this->_pdf->SetFont('Arial','',4);
            $textYPos += 4;
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textYPos,"Cajero: ". strtolower($data['cajero']) ,false,false,"L" );
            $textYPos += 4;
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textYPos,"Caja: ". strtolower($data['caja']),false,false,"L" );
            $textYPos += 4;
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textYPos,"Fecha: ". $this->_today->format("Y-m-d h:i:s"),false,false,"L" );
            $textYPos += 4;
            $this->_pdf->setX(2);
            if (!$close){
                $this->_pdf->Cell(5,$textYPos,"No. Orden: ". $data['order'] ,false,false,"L" );
            }else{
                $this->_pdf->Cell(5,$textYPos,"No. Orden: ". "Corte de Caja" ,false,false,"L" );
            }
            $textYPos +=6;
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textYPos,'-------------------------------------------------------------------');
            $textYPos +=6;
            $this->_pdf->SetFont('Arial','',4);
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textYPos,'#    PRODUCT                 PRICE       DISCOUNT     TOTAL');
            $off = $textYPos+6;

            foreach($data['concepts'] as $product){
                $this->_pdf->setX(2);
                $this->_pdf->Cell(5,$off,$product["quality"]);
                $this->_pdf->setX(4);
                $this->_pdf->Cell(35,$off,  strtoupper(substr($product["product"], 0,12)) );
                $this->_pdf->setX(14);
                $this->_pdf->Cell(11,$off,  "$".number_format($product["price"],2,".",",") ,0,0,"R");
                $this->_pdf->setX(20);
                $this->_pdf->Cell(11,$off, $product["discount"]."%" ,0,0,"R");
                $this->_pdf->setX(30);
                $this->_pdf->Cell(11,$off,  "$ ".number_format($product["total"],2,".",",") ,0,0,"R");
                $off+=6;
            }
            $textYPos = $off + 6;
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textYPos,"TOTAL PRODUCTOS: # ".count($data['concepts']),0,0,"L" );
            $this->_pdf->SetFont('Arial','',5);
            $textYPos += 6;
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textYPos,'-------------------------------------------------------------------');
            $this->_pdf->setX(2);
            $textYPos += 6;
            $this->_pdf->Cell(5,$textYPos,"SUBTOTAL: " );
            $this->_pdf->setX(38);
            $this->_pdf->Cell(5,$textYPos,"$ ".$data['subtotal'],0,0,"R");
            $this->_pdf->setX(2);
            $textYPos += 6;
            $this->_pdf->Cell(5,$textYPos,"IVA(16%): " );
            $this->_pdf->setX(38);
            $this->_pdf->Cell(5,$textYPos,"$ ".$data['iva'],0,0,"R");
            $this->_pdf->setX(2);
            $textYPos += 6;
            $this->_pdf->Cell(5,$textYPos,"TOTAL: " );
            $this->_pdf->setX(38);
            $this->_pdf->Cell(5,$textYPos,"$ ".$data['total'],0,0,"R");
            $this->_pdf->setX(2);
            $textYPos +=12;
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textYPos,'-------------------------------------------------------------------');
            $this->_pdf->SetFont('Arial','',4);
            $this->_pdf->Cell(5,$textYPos+6,'GRACIAS POR TU COMPRA, VUELVA PRONTO ');

            $filename= "ticket-".$data['rfc'].( ($close) ? "-Corte_Caja.pdf" : "-".$data['order'].".pdf");
            $dir = "upload_file/ticket/".$this->_today->format("Y_m_d")."/";
            if (!is_dir(public_path()."/".$dir)){
                mkdir($dir,0777);
            }
            $this->_pdf->output(public_path()."/".$dir.$filename,"F",true);
            return ['success' => true, "data" => $dir.$filename];

        } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getFile()." ".$e->getLine();
            \Log::error($error);
            return ['success' => false, 'mgs' => $error];
        }
    }


}
