<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->helper('auth');
		//$this->load->library(array('Datatables'));
		$this->load->helper('ckeditor');
		$this->load->helper('format_tanggal');
		is_logged_in();
		$this->data['ckeditor'] = array(
			'id' 	=> 	'isi1',
			'path'	=>	'asset/ckeditor',
			'config' => array(
				'toolbar' 	=> 	"Full", 	//Using the Full toolbar
				'width' 	=> 	"100%",	//Setting a custom width
				'height' 	=> 	'300px',	//Setting a custom height
			),	
		);
    }
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)		{
			redirect('login');
			die();		
			
		}		
	}
	function menu()	{		 
		$data['title']="Menu";
		$data['json_url']=site_url('admin/main/menu_json');
		$data['main_view']="admin/main/data_menu";
		$this->load->view('admin/content',$data);
	}
	function dash()
	{
		
		$data['title']="Dashboard";
		//$data['json_url']=site_url('admin/main/menu_json');
		$data['main_view']="admin/dash/dash";
		$this->load->view('admin/content',$data);
	}

}

/* End of file penjualan.php */
/* Location: ./application/modules/transaction/controllers/penjualan.php */
