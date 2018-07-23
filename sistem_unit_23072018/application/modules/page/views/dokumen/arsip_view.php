
<div  class="article-content">
	<div class="article-title">Dokumen</div>  
		<div class="clear20"></div>
		<?php $i=0;?>
			<table class="table table-bordered table-hover table-condensed">
			<thead>
				<tr><th>No</th><th>Nama Dokumen</th><th>Download</th></tr>
			</thead>
			<tbody>	
			<?php foreach ($dokumen->result() as $page){ ?>
				<tr><td width="5%"><?php echo ++$i ?></td>
				<td width="75%"><?php echo $page->nama ?></td>
				<td align="center">
				<a href="<?php echo base_url('media/dokumen_akademik/'.$page->file_data)?>" class='btn btn-info btn-xs'  role="button" target='_blank'>Download</a></td>
			<?php } ?>
			<?php
			if(count($dokumen)<=0){
			echo"<tr><td colspan='3' align='center'>Tidak ada dokumen yang tersedia</td></tr>";
			}
			?>
			</tbody>
		</table>
		
		<div class="clear20"></div>
		<div class="pagination">
		<?php
		echo $this->pagination->create_links();
		?>
		</div>
</div>
