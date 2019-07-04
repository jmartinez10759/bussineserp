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
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class Ticket extends Facade
{
    private $_printerName;
    private $_connect;
    private $_printer;

    /**
     * Ticket constructor.
     * @param string|$namePrinter
     */
    public function __construct(string $namePrinter)
    {
        $this->_printerName = $namePrinter;
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




}
