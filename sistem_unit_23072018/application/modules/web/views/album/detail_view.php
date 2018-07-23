<div id="content-center">

	<?php foreach($ukm->result() as $d){?>
			<div id="detail-title-news"><?php echo $d->nama_ukm?></div>
			<div class="cleaner_h10"></div>
			<div class="cleaner_h10"></div>
			<div id="news-list-detail">
			<?php if($d->gambar !=null){?>
			<img src="<?php echo base_url().'media/news/'.$d->gambar ?>" />
			<?php } ?>
			<?php 
			$isi=preg_replace('/<p align="center">(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",htmlspecialchars_decode($d->deskripsi));
			$isi=preg_replace('/<p>(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",$isi);
			$isi=preg_replace('/(&nbsp;)*/iu',"",$isi);
			echo html_entity_decode($isi);
			?>
			</div>
		<?php } ?>

</div>
