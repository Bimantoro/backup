<div class="article-content">	
	<div class="article-title">Dosen</div>
		<div class="clear20"></div>		
		<?php foreach($dosen as $d){?>
		<img src="http://static.uin-suka.ac.id/foto/pgw/990/<?php echo $foto.'.jpg';?>" />
		
				<div class="clear20"></div>
		
		<table width="100%">
			<tr><td width="17%"><b>Nama</b></td><td width="3%"><b>:</b></td><td width="80%"><?php echo $d['NM_DOSEN_F']?></td></tr>
			<tr><td><b>NIP</b></td><td><b>:</b></td><td><?php if(strlen($d['NIP'])!=18){ echo $d['NIP']; }else{  echo substr_replace(substr_replace(substr_replace($d['NIP'], ' ', 8, 0),' ',15,0),' ',17,0); } ?></td></tr>
			<tr><td><b>Email</b></td><td><b>:</b></td><td><?php echo $email?></td></tr>
		</table>
		<div class="clear20"></div>
		<table width="100%">	
			<tr><td valign="top" width="17%"><b>Pendidikan</b></td><td valign="top" width="3%"><b>:</b></td>
				<td width="80%">
					<ul style="margin-left:10px;">
						<?php 
						if(!empty($pendidikan)){
							foreach($pendidikan as $p){
								echo"<li>".$p->JENJANG." ".$p->NM_PRODI." (".$p->NM_PT.")</li>";
							}
						}	
						?>
					</ul>
				</td>
			</tr>
			<tr><td valign="top"><b>Publikasi</b></td><td valign="top"><b>:</b></td>
				<td>
					<ul style="margin-left:10px;">
						<?php 
						if(!empty($publikasi)){
							foreach($publikasi as $p){
								echo'<li>"'.$p->JUDUL_PUBLIKASI.'", terbit di: '.$p->PADA.', penerbit: '.$p->PENERBIT.', '.get_year('d/m/Y',$p->TANGGAL_PUB).'</li>';
							}
						}	
						?>
					</ul>
				</td>
			</tr>
		</table>	
		<?php } ?>
				
		<h3><a class='item' href="<?php echo site_url('page/detil_dosen/'.$d['KD_DOSEN'].'/mengajar')?>" title="Pengalaman Mengajar" target='_self'><u>Pengalaman Mengajar</u></a></h3>
		<?php 
			if(isset($amk) and !empty($amk)){	
			$this->load->view('page/prodi/semester_form');
			
			$arr_smt = array( 1 => 'Semester Gasal', 2=> 'Semester Genap', 3 => 'Semester Pendek');
			
		?>	
				<div class="clear20"></div>
				<h5 style="margin-bottom:5px; color: rgb(164, 136, 74);">Kelas Mata Kuliah yang Diampu Oleh  <?php echo $nm_dosen?> di <?php echo $arr_smt[$smt]; ?> TA <?php echo $ta."/".($ta+1)?></h5>
				<div class="clear10"></div>
					
		<?php if($amk==1){?>
			<div style="text-align:center">
				<span class="tgl-post">Belum ada kelas.</span>
			</div>
		<?php	}else{ ?>
			
			<table class="table table-bordered table-hover table-condensed">
			<thead>
				<tr><th>No</th><th>Nama Mata Kuliah</th><th>SKS</th><th>Jenis MK</th><th>Kelas</th><th>Jadwal</th></tr>
			</thead>
			<tbody>	
			<?php 
			$i=0;
			foreach ($amk as $m){ ?>
				<tr><td width="4%"><?php echo ++$i.'.' ?></td>
				<td width="40%"><a href="<?php echo site_url('page/mata_kuliah/'.$m->kd_kur.'/'.$m->kd_mk)?>"><u><?php echo $m->mk ?></u></a></td>
				<td style="text-align:center" width="5%"><?php echo $m->sks ?></td>
				<td style="text-align:center" width="10%"><?php echo $m->jenis_mk ?></td>
				<td style="text-align:center" width="6%"><?php echo $m->kelas ?></td>
				<td width="35%"><?php echo str_replace(' #','<br>',$m->jadwal)?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
				<div class="clear20"></div>
		<?php } }?>
		<h3><a class='item' href="<?php echo site_url('page/detil_dosen/'.$d['KD_DOSEN'].'/penelitian')?>" title="Pengalaman Penelitian" target='_self'><u>Pengalaman Penelitian</u></a></h3>
		<?php if(isset($penelitian) and !empty($penelitian)){	?>
			<ul>
			<?php foreach($penelitian as $p){ 
				$tahun1= get_year('d/m/Y',$p->BT_MULAI);
				$tahun2= get_year('d/m/Y',$p->BT_SELESAI);
				if($tahun1==$tahun2){
					$tahun=$tahun1;
				}else{
					$tahun=$tahun1." - ".$tahun2;
				}	
			?>
				<li><?php echo $p->JUDUL_PENELITIAN." (".$tahun.")"; ?>
			<?php } ?>
			</ul>
		<?php } ?>
		<?php if(isset($pel) and $pel==1){?>
			<div style="text-align:center">
				<span class="tgl-post">Belum ada data.</span>
			</div>
		<?php	}?>
		<h3><a class='item' href="<?php echo site_url('page/detil_dosen/'.$d['KD_DOSEN'].'/pengabdian')?>" title="Pengalaman Pengabdian Masyarakat" target='_self'><u>Pengalaman Pengabdian Masyarakat</u></a></h3>
		<?php if(isset($pengabdian) and !empty($pengabdian)){	?>
			<ul>
			<?php foreach($pengabdian as $p){ 
				$tahun1= get_year('d/m/Y',$p['BT_MULAI']);
				$tahun2= get_year('d/m/Y',$p['BT_SELESAI']);
				if($tahun1==$tahun2){
					$tahun=$tahun1;
				}else{
					$tahun=$tahun1." - ".$tahun2;
				}	
			?>
				<li><?php echo $p['JUDUL_PENGABDIAN']." (".$tahun.")"; ?>
			<?php } ?>
			</ul>	
		<?php } ?>	
		<?php if(isset($ampm) and $ampm==1){?>
			<div style="text-align:center">
				<span class="tgl-post">Belum ada data.</span>
			</div>
		<?php	}?>
		<h3><a class='item' href="<?php echo site_url('page/detil_dosen/'.$d['KD_DOSEN'].'/tugas')?>" title="Pengalaman Tugas Penunjang" target='_self'><u>Pengalaman Tugas Penunjang</u></a></h3>
		<?php if(isset($tugas) and !empty($tugas)){	?>
			<ul>
			<?php foreach($tugas as $jk=>$p){ 
					if($p['TA_MULAI']==$p['TA_SELESAI']){
						$tahun=$p['TA_MULAI'];
					}else{
						$tahun=$p['TA_MULAI']." - ".$p['TA_SELESAI'];
					}
			?>
				<li><?php echo $p['JENIS_KEGIATAN']." (".$tahun.")" ?>
			<?php } ?>
			</ul>
		<?php } ?>
		<?php if(isset($tug) and $tug==1){?>
			<div style="text-align:center">
				<span class="tgl-post">Belum ada data.</span>
			</div>
		<?php	}?>
</div>
