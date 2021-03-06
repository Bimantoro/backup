<?php

class Login extends CI_Controller {
	
	function index(){
		$data['title']="Login";
		$data['main_content'] = 'login/login_form';
		$this->load->view('login', $data);		
	}
	
	function validate_credentials()	{
		//$this->load->library('curl');
		//$this->load->model('admin/page_model');
		$user=$this->input->post('username');
		$pass=$this->input->post('password');

		$query = "SELECT * FROM user JOIN unit ON user.kode_unit=unit.kode_unit WHERE username = '$user'";
		$sql = $this->db->query($query);
		$cek_user = $sql->row_array();
		//$cek_user = $this->Page_model->cek_user_univ($user);
		if(!empty($cek_user)){
			$data = array(
						'username' => $cek_user['username'],
						'kode_unit' => $cek_user['kode_unit'],
						'level' => $cek_user['level'],
						'subdomain' => $cek_user['subdomain'],
						'is_logged_in' => true
					);
					$this->session->set_userdata($data);
			redirect('index.php/admin/main/dash');
		}else{
			$this->session->set_flashdata('msg', 'Anda tidak memiliki akses di halaman ini.');
			redirect('admin');
		}
		
	}

	/*function validate_credentials()	{
	$this->load->library('curl');
	$user=$this->input->post('username');
	$pass=$this->input->post('password');
		$postorget 	= 'GET';
		$auth_ad_id = '8f304662ebfee3932f2e810aa8fb628726';
		$api_url 	= 'http://service.uin-suka.ac.id/servad/adlogauthgr.php?aud='.$auth_ad_id.'&uss='.$user.'&pss='.$pass;
		$hasil 		= $this->curl->simple_get($api_url);
		
		$hasil 		= json_decode($hasil, true);
		//$hasil=$jabatan = $this->parse_ad_jabatan($hasil);
		//print_r($hasil);die();
		
		if($hasil[0]>0){
				$d=explode('.',str_replace('http://','',base_url()));
				$dom=$d[0];
				$user=$this->db->select('user.*')
				->from('user')
				->join('unit', 'unit.kode_unit = user.kode_unit', 'left')
				->where(array('username'=>$hasil[0]['NamaPengguna'], 'unit.subdomain'=>$dom))
				->get()->row();
				
				print_r($user);
				if(!empty($user)){
					$data = array(
						'username' => $hasil[0]['NamaPengguna'],
						'kode_unit' => $user->kode_unit,
						'level' => $user->level,
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
			$this->logout();
		}
		
	}	*/
	
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