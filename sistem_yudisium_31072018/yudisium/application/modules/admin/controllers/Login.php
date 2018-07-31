<?php

class Login extends CI_Controller {
	
	function index(){
		$data['title']="Login";
		$data['main_content'] = 'login/login_form';
		$this->load->view('login', $data);		
	}
	
	function validate_credentials_2()	{
		//$this->load->library('curl');
		//$this->load->model('admin/page_model');
		$user=$this->input->post('username');
		$pass=$this->input->post('password');
		$akses = 0;

		if($user == 'admin12345' AND $pass = '67890admin'){
				$data = array(
						'username' => $user,
						'level' => 'Y000',
						'is_logged_in' => true
					);

				$this->session->set_userdata($data);

				redirect('index.php/admin/main/dash');

		}else{
			$this->session->set_flashdata('msg', 'Anda tidak memiliki akses di halaman ini.');
			redirect('admin');
		}
		
	}

	function validate_credentials(){
		$this->load->library('curl');
		//$this->load->model('admin/page_model');
		$user=$this->input->post('username');
		$pass=$this->input->post('password');

		$user = filter_var($user, FILTER_SANITIZE_STRING);

		$postorget 	= 'GET';
		$auth_ad_id = '8f304662ebfee3932f2e810aa8fb628739';
		$api_url 	= 'http://service.uin-suka.ac.id/servad/adlogauthgr.php?aud='.$auth_ad_id.'&uss='.$user.'&pss='.$pass;
		$hasil 		= $this->curl->simple_get($api_url);

		$hasil 		= json_decode($hasil, true);

		if($hasil[0]>0){
			
			$user = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_data_akun',
		 	'POST',
		 	array(
		 		'api_search' => array($user)
		 	));

			if(!empty($user)){

				$fak = array();
				$level = 'Y001';

				foreach ($user as $u) {
					if($u['level'] == 'Y000' || $u['level'] == 'Y002'){
						$level = $u['level'];
					}

					$fak[] = $u['kode_fakultas'];
					$id_user = $u['id_user'];
				}

				$data = array(
					'username' => $id_user,
					'level' => $level,
					'kd_fak' => $fak,
					'is_logged_in' => true
				);
				$this->session->set_userdata($data);
			//print_r($db_jabat);
			redirect('admin/main/dash');
			}else{
				$this->session->set_flashdata('msg', 'Anda tidak memiliki akses di halaman ini.');
				redirect('admin/login');
			}
		}else{
			$this->session->set_flashdata('msg', 'Username atau password anda tidak sesuai.');
			//redirect('admin/login');
			$this->logout();
		}
	}

	
	function signup()
	{
		$data['main_content'] = 'signup_form';
		$this->load->view('fishy/content', $data);
	}
	
	function logout()
	{

		$temp = $this->session->flashdata('msg');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('is_logged_in');
		$this->session->unset_userdata('subdomain');
		$this->session->sess_destroy();
		$this->session->set_flashdata('msg', $temp);
		$this->index();
	}	
	
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)		{
			redirect('admin/login');
			die();		
			
		}		
	}
}