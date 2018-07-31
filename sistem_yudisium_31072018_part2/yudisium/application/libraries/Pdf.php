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
    private $nomor = '';
    private $tanggal = '';
    private $jalur = '';
    private $gelombang = '';
    private $tahun = '';
    /**
     * This method is used to override the parent class method.
     * */
    public function Header() {
        // Position at 15 mm from bottom
        // $this->SetY(-100);
        // Set font
        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(0, 10, 'Lampiran :', 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->ln(4.5);
        $this->Cell(0, 10, 'Surat Keputusan Dewan Yudisium', 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->ln(4.5);
        $this->Cell(0, 10, 'Nomor '.$this->nomor.' Tanggal '.$this->tanggal, 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->ln(4.5);
        $this->Cell(0, 10, 'Tentang Penerimaan Mahasiswa Baru UIN Sunan Kalijaga Yogyakarta', 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->ln(4.5);
        $this->Cell(0, 10, 'Jalur '.$this->jalur.' Gelombang '.$this->gelombang.' Tahun '.$this->tahun, 0, false, 'L', 0, '', 0, false, 'T', 'M');

    }

    public function lastPage($resetmargins = false) {
        $this->setPage($this->getNumPages(), $resetmargins);
        $this->isLastPage = true;
    }

    public function SetPemegang($name){
    		$this->namapemegang = $name;
    }

    public function InfoYudisium($nomor, $tanggal, $tahun, $gelombang, $jalur){
        $this->nomor = $nomor;
        $this->tanggal = $tanggal;
        $this->tahun = $tahun;
        $this->gelombang =$gelombang;
        $this->jalur = $jalur;
    }


    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-20);
        // Set font
        $this->SetFont('helvetica', 'I', 9);

        $this->Cell(0, 10, 'Halaman '.$this->getAliasNumPage().' dari '.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
         // $this->ln(5);
         // $this->SetTextColor(0,148,255);
         // $this->Cell(0, 10, $this->namapemegang, 0, false, 'L', 0, '', 0, false, 'T', 'M');

    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */