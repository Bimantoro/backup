<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function index()	{
		/* $data['fakultas'] = $this->page_model->get_fakultas();
		$data['pengumuman'] = $this->page_model->get_pengumuman(1,4);
		$data['kolom'] = $this->page_model->get_recent_column();
		$data['berita2'] = $this->page_model->get_recent_news(1,4);
		$data['agenda'] = $this->page_model->get_recent_agenda(1,4);
		 */
		 
		$data['main_view']="page/stars";
       $this->load->view('content2',$data);
		/* $this->load->view('page/header',$data);
		$this->load->view('page/home');
		$this->load->view('page/footer'); */
	}
}
