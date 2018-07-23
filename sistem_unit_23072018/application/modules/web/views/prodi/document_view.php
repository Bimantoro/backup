<div id="content-center">
	<?php
	//echo $doc;
		foreach($doc as $d){
		?>
				<div class="article-title"><?php echo $d->title?></div>
				<div class="cleaner_h20"></div>
			
				<div class="article-content">	
				<object data="<?php echo $d->file; ?>" type="application/pdf" width="100%" height="700">
					<p>Tidak ada data</p>
				</object>
				</div>
	<?php } ?>
	
</div>