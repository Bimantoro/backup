<div class="article-content">	

	<?php foreach($page as $d){?>
				
				<h2 class="mb-xl heading-primary"><?php echo $d->nama_pusat_studi?></h2>
					<div class="clear20"></div>	
			<?php 
			$isi=preg_replace('/<p align="center">(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",htmlspecialchars_decode($d->deskripsi));
			$isi=preg_replace('/<p>(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",$isi);
			$isi=preg_replace('/(&nbsp;)*/iu',"",$isi);
			echo html_entity_decode($isi);
			?>
		<?php } ?>

</div>