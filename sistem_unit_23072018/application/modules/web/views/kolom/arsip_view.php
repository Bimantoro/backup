<?php $lang=$this->page_lib->lang(); ?>	
<div class="blog-posts">
	<?php foreach($kolom as $d): ?>
	<article class="post post-medium">
		<div class="row">
		
		
			<div class="col-md-12">

				<div class="post-content">
					<h4 class="mb-none"><a href="<?php echo site_url($lang.'/kolom/detail/'.$d->id_kolom.'/'.url_title(strtolower($d->judul)))?>"><?php echo $d->judul?></a></h4>
					<div class="post-meta">
						<span><i class="fa fa-calendar"></i> <?php echo tgl_artikel($d->tgl_posting)?></span>
						<span class="pull-right"><?php echo ucfirst(dict('Dilihat', $lang)).' : '.$d->counter.' '.ucfirst(dict('Kali',$lang))?></span>
					</div>
					<div style="text-align:justify">
					<?php 
						$isi=preg_replace('/<p align="center">(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",htmlspecialchars_decode($d->ringkasan));
						$isi=preg_replace('/<p>(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",$isi);
						$isi=preg_replace('/(&nbsp;)*/iu',"",$isi);
						echo substr(strip_tags(html_entity_decode($isi)),0,400)
					?>....
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="post-meta pull-right">
					<a href="<?php echo site_url($lang.'/kolom/detail/'.$d->id_kolom.'/'.url_title(strtolower($d->judul))) ?>" class="read-more"> <?php echo ucfirst(dict('selengkapnya',$lang))?> <i class="fa fa-angle-right"></i></a>
				</div>
			</div>
		</div>

	</article>
	<?php endforeach ?>
	<div class="pull-right">
	<?php echo $this->pagination->create_links();?>
	</div>
</div>


