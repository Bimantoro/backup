<div id="content-center">
	<?php foreach($berita->result() as $b){ ?>
		<div id="news-list">
			<h1 class="judul"><a href="<?php echo site_url('page/berita/detail/'.$b->id_berita.'/'.url_title(strtolower($b->judul))) ?>"><?php echo $b->judul ?></a></h1>
			<h4><?php echo nama_hari($b->tanggal).', '.tanggal_indonesia($b->tanggal).' '.substr($b->jam,0,5) ?> WIB</h4>
			<?php if($b->gambar !=null){?>
			<img src="<?php echo base_url().'asset/images/berita/'.$b->gambar ?>" />
			<?php } ?>
			<p class="isi" style="font-weight:normal">
			<?php 
			$isi=preg_replace('/<p align="center">(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",htmlspecialchars_decode($b->isi_berita));
			$isi=preg_replace('/<p>(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",$isi);
			$isi=preg_replace('/(&nbsp;)*/iu',"",$isi);
			echo substr(strip_tags(html_entity_decode($isi)),0,300)?>....
			
			</p>
			<div style="clear:both"></div>
			<a class="btn-uin btn btn-inverse btn btn-small" style="float:right" href="<?php echo site_url('page/berita/detail/'.$b->id_berita.'/'.url_title(strtolower($b->judul))) ?>"><i class="btn-uin"></i>Selengkapnya>></a> 
			<div style="clear:both"></div>
			</div>
		<?php } ?>
		<div class="cleaner_h20"></div>
		<div class="pagination">
		<?php
		echo $this->pagination->create_links();
		?>
		</div>
</div>