<?php
$buka='';
if($this->session->userdata('status') == 'wali'){
    $nama_menu="Lihat Data Pribadi Mahasiswa";
}elseif($this->session->userdata('status') == 'mhs'){
    $nama_menu="Isi Data Pribadi Mahasiswa";
}
if($this->session->userdata('status') == 'mhs' or $this->session->userdata('status') == 'wali'):
if($this->session->userdata('id_user')){
	$this->load->library('registrasi/lib_reg_fungsi');	
	if ($this->session->userdata('app') == 'registrasi') { $buka = 'buka'; 
	} 
	else { $buka = ''; }
	?>
	<li id="li-registrasi" class="item">
		<a href="<?php echo site_url('data_pribadi_mahasiswa'); ?>" class="item" name="ul-sub1-c"><span>Data Pribadi Mahasiswa</span>
		</a>
		<div class="underline-menu"></div>
		<ol id="ol-registrasi" class="<?php echo $buka?>">				
				<li class="submenu"><a title="Pengisian Data Pribadi Mahasiswa untuk <?php echo $this->session->userdata('mhs_nama') ?>" href="<?php echo site_url("data_pribadi_mahasiswa/cek") ?>"><?php echo $nama_menu ?></a></li>
		</ol>
	</li>
	<?php
}
endif;
//sidebar