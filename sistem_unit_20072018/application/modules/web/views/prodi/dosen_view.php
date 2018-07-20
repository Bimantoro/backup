<div class="article-content">
<?php $lang=$this->page_lib->lang(); ?>
	<h2 class="mb-xl heading-primary"><?php echo ucfirst(dict('Dosen', $lang)) ?></h2>
	<div class="clear20"></div>	
	<?php $this->load->view('web/prodi/form_dosen_view');?>
	<?php if($dosen){?>
	<?php $i=0;?>
		<table class="table table-bordered table-hover table-condensed">
			<thead>
				<tr><th  style="text-align: center;">No</th><th  style="text-align: center;"><?php echo ucwords(dict('NIP', $lang)) ?></th><th  style="text-align: center;"><?php echo ucwords(dict('Nama', $lang)) ?></th><th  style="text-align: center;"><?php echo ucwords(dict('Status', $lang)) ?></th></tr>
			</thead>
			<tbody>	
			<?php 
			foreach ($dosen as $j){ ?>
				<?php if((sia_cek_dosenpns($j['KD_DOSEN']) && $jd == 0) || (!sia_cek_dosenpns($j['KD_DOSEN']) && $jd == 1) || $jd == 2){ ?>
				<?php 
						$status_dsn = ' - ';
						if(sia_cek_dosenpns($j['KD_DOSEN'])){
							$status_dsn = "Dosen Tetap PNS";
						}else{
							$status_dsn = "Dosen Luar Biasa";
						}

				 ?>
				<tr><td width="5%" style="text-align: center;"><?php echo ++$i ?></td>
				<td width="25%" style="text-align: center;"><a href="<?php echo site_url($lang.'/page/detil_dosen/'.$j['KD_DOSEN'])?>" ><u><?php echo format_nip($j['KD_DOSEN']) ?></u></a></td>
				<td width="40%" style="text-indent: 10px;"><?php echo $j['NM_DOSEN_F']?></td>
				<td width="40%" style="text-align: center;"><?php echo $status_dsn ?></td>
				<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
</div>
