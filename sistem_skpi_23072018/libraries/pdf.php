<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdf extends TCPDF {
    function __construct() {
        parent::__construct();
    }

    protected $processId = 0;
    protected $header = '';
    protected $footer = '';
    static $errorMsg = '';
    public $page_counter = 1;
    public $isLastPage = false;

    private $namapemegang = '';
    /**
     * This method is used to override the parent class method.
     * */
    public function Header() {
        // Position at 15 mm from bottom
        $this->SetY(-500);
        // Set font
        $this->SetFont('helvetica', 'B', 10);

    }

    public function lastPage($resetmargins = false) {
        $this->setPage($this->getNumPages(), $resetmargins);
        $this->isLastPage = true;
    }

    public function SetPemegang($name){
    		$this->namapemegang = $name;
    }

    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-20);
        // Set font
        $this->SetFont('helvetica', 'I', 9);

        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
         $this->ln(5);
         $this->SetTextColor(0,148,255);
         $this->Cell(0, 10, $this->namapemegang, 0, false, 'L', 0, '', 0, false, 'T', 'M');

    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */