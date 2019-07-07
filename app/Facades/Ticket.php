<?php
/**
 * Created by PHP Storm
 * User : jmartinez
 * Date : 3/07/19
 * Time : 11:30 PM
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class Ticket extends Facade
{
    private $_printerName;
    private $_connect;
    private $_printer;
    private $_today;

    /**
     * Ticket constructor.
     * @param string|$namePrinter
     * @throws \Exception
     */
    public function __construct(string $namePrinter = null)
    {
        $this->_printerName = $namePrinter;
        $this->_today = new \DateTime("now");
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
     * This method is used for print ticket
     * @param array $data
     * @param bool $close
     * @return array
     */
    public function printer(array $data = [], bool $close = false)
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
