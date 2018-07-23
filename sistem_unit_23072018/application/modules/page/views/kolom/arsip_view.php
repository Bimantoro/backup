<div  class="article-content">
	<?php foreach($kolom->result() as $b){ ?>
						
		<div class="news-list">
			<div class="judul-artikel">
			<a href="<?php echo site_url('page/kolom/detail/'.$b->id_kolom.'/'.url_title(strtolower($b->tentang))) ?>"><?php echo $b->tentang ?></a>
			</div>
			<span class="tgl-post"><?php echo nama_hari($b->tanggal).', '.tanggal_indonesia($b->tanggal).' '.$b->jam ?> WIB <span class="page_counter">Dilihat :  <?php echo $b->counter ?> kali</span></span>
		
			<div class="isi" style="font-weight:normal">
			<?php 
			$isi=preg_replace('/<p align="center">(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",htmlspecialchars_decode($b->isinya));
			$isi=preg_replace('/<p>(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",$isi);
			$isi=preg_replace('/(&nbsp;)*/iu',"",$isi);
			echo substr(strip_tags(html_entity_decode($isi)),0,300)?>....
			</div>
			<div style="clear:both"></div>
			<a class="btn-uin btn btn-inverse btn btn-small" style="float:right"  href="<?php echo site_url('page/kolom/detail/'.$b->id_kolom.'/'.url_title(strtolower($b->tentang))) ?>"><i class="btn-uin"></i>Selengkapnya >></a> 
			<div style="clear:both"></div>
		</div>
	<?php } ?>

	<div class="pagination">
		<?php
		echo $this->pagination->create_links();
		?>
	</div>
</div>