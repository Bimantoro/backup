<div class="article-content">
	<div class="article-title">Dosen</div>
	<div class="clear20"></div>	
	<?php $this->load->view('page/prodi/form_dosen_view');?>
	<?php if($dosen){?>
	<?php $i=0;?>
		<table class="table table-bordered table-hover table-condensed">
			<thead>
				<tr><th>No</th><th>NIP</th><th>Nama</th></tr>
			</thead>
			<tbody>	
			<?php 
			foreach ($dosen as $j){ ?>
				<tr><td width="5%"><?php echo ++$i ?></td>
				<td width="25%"><a href="<?php echo site_url('page/detil_dosen/'.$j->kd_dosen)?>" ><u><?php echo format_nip($j->kd_dosen) ?></u></a></td>
				<td width="40%"><?php echo $j->nm_dosen?></td>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
</div>
