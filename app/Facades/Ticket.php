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
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
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
        $this->_configuration();
    }

    /**
     *This method is used in the configuration ticket
     */
    private function _configuration()
    {
        if ($this->_printerName){
            $this->_connect = new WindowsPrintConnector($this->_printerName);
            $this->_printer = new Printer($this->_connect);
        }
    }

    /**
     * This method is used generate pdf and print for ticket
     * @param array $data
     * @param bool $close
     * @return array
     */
    public function printer(array $data = [], bool $close = null )
    {
        #\Log::debug($data);
        try {
            $this->_pdf->Company = $data['rfc']."-".$data['social_reason'];
            $this->_pdf->SetAuthor('Jorge Martinez Quezada');
            $this->_pdf->SetTitle("Sales of ticket");
            $this->_pdf->NomDocumento='BOLETA ELECTRÓNICA';
            $this->_pdf->SetFont('Helvetica', '', 12, '', true);
            $this->_pdf->AddPage();

            $this->_pdf->SetFont('Helvetica','B',8);
            $this->_pdf->SetXY(2,24);
            $this->_pdf->Cell(2, 48, "Razon Social:",0,0,'L');
            $this->_pdf->SetFont('Helvetica','',8);
            $this->_pdf->SetXY(20,24);
            $this->_pdf->Cell(20, 48, $data['rfc']."-".$data['social_reason'] ,0,0,'L');
            $this->_pdf->SetFont('Helvetica','B',10);

            $this->_pdf->SetFont('Helvetica','B',8);
            $this->_pdf->Ln(7);
            $this->_pdf->SetXY(2,28);
            $this->_pdf->Cell(17, 48, "Cliente:",0,0,'L');
            $this->_pdf->SetFont('Helvetica','',8);
            $this->_pdf->SetXY(20,28);
            $this->_pdf->Cell(17, 48, "Publico",0,0,'L');
            $this->_pdf->SetFont('Helvetica','B',8);
            $this->_pdf->SetXY(2,36);
            $this->_pdf->Cell(30, 48, "Fecha de Emisión:",0,0,'L');
            $this->_pdf->SetFont('Helvetica','',8);
            $this->_pdf->SetXY(30,36);
            $this->_pdf->Cell(30, 48, $this->_today->format("Y-m-d"),0,0,'L');
            $this->_pdf->SetFont('Helvetica','B',8);
            $this->_pdf->SetXY(2,40);
            $this->_pdf->Cell(30, 48, "Moneda:",0,0,'L');
            $this->_pdf->SetFont('Helvetica','',8);
            $this->_pdf->SetXY(30,40);
            $this->_pdf->Cell(30, 48, 'Pesos',0,0,'L');
            $this->_pdf->Ln(4);
            $this->_pdf->SetX(1);
            $this->_pdf->Cell(100,52,"------------------------------------------------------------------------------------",0,0,'L');
            $this->_pdf->Ln();
            $w = [8,50,60];
            $this->_pdf->SetFont('Helvetica','B',8);
            $header = ['CANT.','ARTICULO','TOTAL' ];
            $this->_pdf->SetXY(2,69);
            for($i=0;$i<count($header);$i++)
                $this->_pdf->Cell($w[$i],7,$header[$i],0,0,'L',0);




            /*$textypos = 5;
            $this->_pdf->setY(2);
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textypos,$data['rfc']."-".$data['social_reason'] );
            $this->_pdf->setX(10);
            $this->_pdf->Cell(5,$textypos,$data['address']  );
            $this->_pdf->setX(15);
            $this->_pdf->Cell(5,$textypos,$data['state'].",".$data['country']." ".$data['postal_code'] );
            $this->_pdf->setX(20);
            if (!$close){
                $this->_pdf->Cell(5,$textypos,$this->_today->format("Y-M-d H:i:s")." CHECK NO: ".$data['order'] );
            }else{
                $this->_pdf->Cell(5,$textypos,$this->_today->format("Y-M-d H:i:s") );
            }
            $this->_pdf->SetFont('Arial','',5);    //Letra Arial, negrita (Bold), tam. 20
            $textypos+=6;
            $this->_pdf->setX(25);
            $this->_pdf->Cell(5,$textypos,'-------------------------------------------------------------------');
            $textypos+=6;
            $this->_pdf->setX(35);
            $this->_pdf->Cell(5,$textypos,'CANTIDAD       ARTICULO                       TOTAL');
            $off = $textypos+6;

            foreach($data["concepts"] as $concept){
                $this->_pdf->setX(2);
                $this->_pdf->Cell(5,$off,$concept['quality']);
                $this->_pdf->setX(6);
                $this->_pdf->Cell(35,$off,  strtoupper(substr($concept['code']." ".$concept['product'], 0,12)) );
                /*$this->_pdf->setX(20);
                $this->_pdf->Cell(11,$off,  "$".number_format($pro["price"],2,".",",") ,0,0,"R");
                $this->_pdf->setX(32);
                $this->_pdf->Cell(11,$off,  "$ ".number_format($concept['total'],2,".",",") ,0,0,"R");
                $off+=6;
            }
            $textypos=$off+6;
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textypos,"TOTAL: " );
            $this->_pdf->setX(38);
            $this->_pdf->Cell(5,$textypos,"$ ".number_format($data["total"],2,".",","),0,0,"R");
            $this->_pdf->setX(2);
            $this->_pdf->Cell(5,$textypos+6,'THANK YOU FOR DINING WITH US!!! ');*/

            $filename= "ticket-".$data['rfc'].".pdf";
            $dir = public_path()."/upload_file/ticket/";
            $this->_pdf->output($dir.$filename,"F",true);
        } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getFile()." ".$e->getLine();
            \Log::error($error);
            return ['success' => false, 'mgs' => $error];
        }
    }

    /**
     * This method is used for print ticket
     * @param array $data
     * @param bool $close
     * @return array
     */
    public function printers(array $data = [], bool $close = false)
    {
        try {
            $this->_printer->setJustification(Printer::JUSTIFY_CENTER);
            #$avatar = EscposImage::load(domain().$data['logo'], false);
            #$this->_printer->bitImage($avatar);

            $this->_printer->text($data['rfc']."-".$data['social_reason'] . "\n");
            $this->_printer->text($data['address'] . "\n");
            $this->_printer->text($data['state'].",".$data['country']." ".$data['postal_code'] . "\n");
            $this->_printer->text("" . "\n");
            $this->_printer->text("" . "\n");
            $this->_printer->text("------------------------------------------------" . "\n");
            if (!$close){
                $this->_printer->text($this->_today->format("Y-M-d H:i:s")." CHECK NO: ".$data['order']."\n");
            }else{
                $this->_printer->text($this->_today->format("Y-M-d H:i:s")." \n");
            }
            $this->_printer->text("------------------------------------------------" . "\n");
            $this->_printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->_printer->text("" . "\n");
            foreach ($data["concepts"] as $concept){
                $this->_printer->setJustification(Printer::JUSTIFY_LEFT);
                $this->_printer->text($concept['quality']. "            " . $concept['product']." ".$concept['description']."             ".'$'.$concept['total']. "\n");
                $this->_printer->setJustification(Printer::JUSTIFY_RIGHT);
                $this->_printer->text( "\n");
            }
            $this->_printer->text("         \n");
            $this->_printer->text("Subtotal: $". $data["subtotal"] ."\n");
            $this->_printer->text("Iva   $". $data["iva"]."\n");
            $this->_printer->text("Pay this Amount $". $data["total"]."\n");
            $this->_printer->text("\n");
            #$this->_printer->text("CASH: $".$dinero.".00"."\n");
            if (!$close){
                $this->_printer->text("CHANGE: $".$data["swap"]."\n");
            }
            $this->_printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->_printer->text("\n");
            $this->_printer->text("\n");
            $this->_printer->text("THANK YOU FOR DINING WITH US!!!");
            $this->_printer->text("\n");
            $this->_printer->feed(3);
            $this->_printer->cut();
            $this->_printer->pulse();
            $this->_printer->close();

        } catch ( \Exception $e ) {
            $error = $e->getMessage()." ".$e->getFile()." ".$e->getLine();
            \Log::error($error);
            return ['success' => false, 'mgs' => $error];

        }

    }




}
