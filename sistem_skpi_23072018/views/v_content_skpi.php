<?php 
$buka = '';
//AMBIL JABATAN
//$this->load->library('skpi_lib_basic','','lib_basic');
$string_skpi = array(
				'Surat Keterangan Pendamping Ijazah',
				'Surat Ket. Pendamping Ijazah',
				'SKPI'
			);

if($this->session->userdata('status')=='mhs')
{
	if($this->session->userdata('id_user')){
		if($this->session->userdata('app') == 'skpi_03') { $buka = 'buka'; }
		else { $buka = ''; } 
?>

		<li id="li-skpi-mhs" class="item">
			<a href="<?php echo site_url('skpi/skpi_mhs'); ?>" class="item" name="ul-sub1-c"><span><?php echo $string_skpi[1]; ?></span>
			</a>
			<div class="underline-menu"></div>
			<ol id="ol-skpi" class="<?php echo $buka?>">
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_mhs/daftar_skpi'); ?>"><span>Daftar Verifikasi</span></a></li>				
			</ol>
		</li>
<?php


	}
}else{
	$sess = $this->session->userdata('jabatan');
	$stts = explode('#', $sess);

	$is_adm_root = 0;
	$is_adm_akdm = 0;
	$is_adm_laporan = 0;
	$is_ptg_fak = 0;
	$is_ptg_pro = 0;

	for ($i=0; $i < count($stts); $i++) { 
		if(substr($stts[$i], 0, 4) == 'SKPI'){
			if(substr($stts[$i], 4, 1) == '0'){
				if(substr($stts[$i], -3)=='000'){
					$is_adm_root++;
					$array = array(
						'skpi_lvl' => 'root'
					);
					
					$this->session->set_userdata($array);
				}else if(substr($stts[$i], -3)=='001'){
					$is_adm_akdm++;
					$array = array(
						'skpi_lvl' => 'admin'
					);
					
					$this->session->set_userdata($array);
				}else{
					$is_adm_laporan++;
					$array = array(
						'skpi_lvl' => 'laporan'
					);
					
					$this->session->set_userdata($array);
				}
			}else if(substr($stts[$i], 4, 1) == '1'){
				$is_ptg_fak++;
				//$is_adm_laporan++;
					$array = array(
						'skpi_lvl' => 'fak'
					);
					
					$this->session->set_userdata($array);
				//untuk petugas fakultas
			}else if(substr($stts[$i], 4, 1) == '2'){
				$is_ptg_pro++;
				//$is_adm_laporan++;
					$array = array(
						'skpi_lvl' => 'prodi/all'
					);
					
					$this->session->set_userdata($array);
				//untuk petugas prodi
			}else if(substr($stts[$i], 4, 1) == '3'){
				$is_ptg_pro++;
				//$is_adm_laporan++;
					$array = array(
						'skpi_lvl' => 'prodi/dokumen'
					);
					
					$this->session->set_userdata($array);
				//untuk petugas prodi khusus dokumen
			}else if(substr($stts[$i], 4, 1) == '4'){
				$is_ptg_pro++;
				//$is_adm_laporan++;
					$array = array(
						'skpi_lvl' => 'prodi/bahasa'
					);
					
					$this->session->set_userdata($array);
				//untuk petugas prodi khusus bahasa penulisan data
			}
		}
	}

	if($is_adm_root!=0){
		if($this->session->userdata('id_user')){
			if($this->session->userdata('app') == 'skpi_00') { $buka = 'buka'; }
				else { $buka = ''; }
?>
		<li id="li-skpi-root" class="item">
			<a href="<?php echo site_url('skpi/skpi_admin/'); ?>" class="item" name="ul-sub1-c"><span><?php echo $string_skpi[1]; ?></span>
			</a>
			<div class="underline-menu"></div>
			<ol id="ol-skpi-root" class="<?php echo $buka?>">
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/label_skpi'); ?>"><span>Label <?php echo $string_skpi[1]; ?></span></a></li>				
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/pengaturan_label'); ?>"><span>Pengaturan Label</span></a></li>				
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/pengaturan_penulisan_sertifikasi'); ?>"><span>Penulisan Sertifikasi UIN</span></a></li>
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/verifikasi_skpi_mhs'); ?>"><span>Verifikasi <?php echo $string_skpi[2]; ?></span></a></li>		
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/list_pembatalan_pendaftaran_skpi'); ?>"><span>Data Pendaftar Verifikasi</span></a></li>					
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/status_verifikasi_skpi_mhs'); ?>"><span>Data Verifikasi</span></a></li>					
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/list_cetak_skpi_mhs'); ?>"><span>Cetak <?php echo $string_skpi[1]; ?></span></a></li>				
				<!-- <li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/status_skpi_mhs'); ?>"><span>Status SKPI</span></a></li>	 -->				
			</ol>
		</li>
<?php


		}
	}

	if($is_adm_akdm!=0){
		if($this->session->userdata('id_user')){
			if($this->session->userdata('app') == 'skpi_00') { $buka = 'buka'; }
				else { $buka = ''; }
?>
		<li id="li-skpi-akdm" class="item">
			<a href="<?php echo site_url('skpi/skpi_admin/'); ?>" class="item" name="ul-sub1-c"><span><?php echo $string_skpi[1]; ?></span>
			</a>
			<div class="underline-menu"></div>
			<ol id="ol-skpi-akdm" class="<?php echo $buka?>">
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/label_skpi'); ?>"><span>Label <?php echo $string_skpi[1]; ?></span></a></li>				
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/list_pembatalan_pendaftaran_skpi'); ?>"><span>Data Pendaftar Verifikasi</span></a></li>
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/status_verifikasi_skpi_mhs'); ?>"><span>Data Verifikasi</span></a></li>						
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/list_cetak_skpi_mhs'); ?>"><span>Cetak <?php echo $string_skpi[1]; ?></span></a></li>
				<!-- <li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/status_skpi_mhs'); ?>"><span>Status SKPI</span></a></li>	 -->					
			</ol>
		</li>
<?php


		}
	}

	if($is_adm_laporan!=0){
		if($this->session->userdata('id_user')){
			if($this->session->userdata('app') == 'skpi_00') { $buka = 'buka'; }
				else { $buka = ''; }
?>
		<li id="li-skpi-lap" class="item">
			<a href="<?php echo site_url('skpi/skpi_admin/'); ?>" class="item" name="ul-sub1-c"><span><?php echo $string_skpi[1]; ?></span>
			</a>
			<div class="underline-menu"></div>
			<ol id="ol-skpi-lap" class="<?php echo $buka?>">
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/label_skpi'); ?>"><span>Label <?php echo $string_skpi[1]; ?></span></a></li>				
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_admin/list_cetak_skpi_mhs'); ?>"><span>Cetak <?php echo $string_skpi[1]; ?></span></a></li>					
			</ol>
		</li>
<?php


		}
	}

	if($is_ptg_fak!=0 || $this->session->userdata('id_user') == 'PKSI100'){
		if($this->session->userdata('id_user')){
			if($this->session->userdata('app') == 'skpi_01') { $buka = 'buka'; }
				else { $buka = ''; }
?>
		<li id="li-skpi-lap" class="item">
			<a href="<?php echo site_url('skpi/skpi_fakultas/'); ?>" class="item" name="ul-sub1-c"><span><?php echo $string_skpi[1]; ?></span>  <!-- Fakultas -->
			</a>
			<div class="underline-menu"></div>
			<ol id="ol-skpi-lap" class="<?php echo $buka?>">		
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_fakultas/list_verifikasi_mhs'); ?>"><span>Data Pendaftar <?php echo $string_skpi[2]; ?></span></a></li>					
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_fakultas/list_cetak_skpi_mhs'); ?>"><span>Cetak <?php echo $string_skpi[1]; ?></span></a></li>					
			</ol>
		</li>
<?php


		}
	}

	if($is_ptg_pro!=0){
		if($this->session->userdata('id_user')){
			if($this->session->userdata('app') == 'skpi_02') { $buka = 'buka'; }
				else { $buka = ''; }
?>
		<li id="li-skpi-lap" class="item">
			<a href="<?php echo site_url('skpi/skpi_prodi/'); ?>" class="item" name="ul-sub1-c"><span><?php echo $string_skpi[1]; ?></span> <!-- Prodi -->
			</a>
			<div class="underline-menu"></div>
			<ol id="ol-skpi-lap" class="<?php echo $buka?>">
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_prodi/list_pembatalan_pendaftaran_skpi'); ?>"><span>Data Pendaftar Verifikasi</span></a></li>			
				<li class="submenu"><a href="<?php echo site_url('skpi/skpi_prodi/list_verifikasi_mhs'); ?>"><span>Verifikasi Data <?php echo $string_skpi[2]; ?></span></a></li>			
			</ol>
		</li>
<?php


		}
	}



}
