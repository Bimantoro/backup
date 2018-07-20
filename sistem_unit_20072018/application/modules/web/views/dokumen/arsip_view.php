<?php if($dokumen){
	$dok_page = $dokumen->result();
} ?>

<?php $lang = $this->page_lib->lang(); ?>
<div  class="article-content">
	<h2 class="mb-xl heading-primary"><?php echo ucfirst(dict('Dokumen', $lang)) ?></h2>	
		<div class="clear20"></div>
		<?php $i=0;?>
			<table class="table table-bordered table-hover table-condensed">
			<thead>
				<tr class="info"><th style="text-align:center;">No</th><th style="text-align:center;"><?php echo ucwords(dict('Nama Dokumen', $lang)) ?></th><th style="text-align:center;"><?php echo ucfirst(dict('Unduhan', $lang)) ?></th></tr>
			</thead>
			<tbody>

			<?php
			if(!is_array($dok_page) || (is_array($dok_page) && empty($dok_page))){
				echo"<tr><td colspan='3' align='center'>".ucwords(dict('Tidak ada dokumen yang tersedia', $lang))."</td></tr>";
			}else{
			?>
			<?php 
				foreach ($dok_page as $page){ ?>
					<?php if($page->id_dokumen!=2){?>
					<tr><td width="5%" style="text-align:center;"><?php echo ++$i ?></td>
					<td width="75%"><?php echo $page->nama_dokumen?></td>
					<td align="center">
					<a href="<?php echo base_url('media/dokumen_akademik/'.$page->nama_file)?>" class='btn btn-success btn-xs'  role="button" target='_blank'><i class="fa fa-arrow-circle-o-down"></i> <?php echo ucfirst(dict('Unduh', $lang)) ?></a></td>
				
					<?php }}
			} ?>
			</tbody>
		</table>
		
		<div class="clear20"></div>
		<div class="pagination">
		<?php
		echo $this->pagination->create_links();
		?>
		</div>
</div>
