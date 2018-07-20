<div  class="article-content">
	
	<div class="blog-posts single-post">

		<article class="post blog-single-post">									
			
			<div class="post-content">

				<h2 class="mb-none"><a href="blog-post.html"><?php echo $d->judul ?></a></h2>

				<div class="post-meta">
					<span><i class="fa fa-calendar"></i> <?php echo tgl_artikel($d->tgl_posting)?></span>
					<span class="pull-right"><?php echo ucfirst(dict('Dilihat', $lang)).' : '.$d->counter.' '.ucfirst(dict('Kali',$lang))?></span>
				</div>
				
				<div style="text-align:justify">
				<?php 
					$isi=preg_replace('/<p align="center">(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",htmlspecialchars_decode($d->isi));
					$isi=preg_replace('/<p>(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",$isi);
					$isi=preg_replace('/(&nbsp;)*/iu',"",$isi);
					echo html_entity_decode($isi);
				?>
				</div>
				<div class="post-share">
					<!-- AddThis Button BEGIN -->
					<div class="addthis_toolbox addthis_default_style ">
						<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
						<a class="addthis_button_tweet"></a>
						<a class="addthis_button_pinterest_pinit"></a>
						<a class="addthis_counter addthis_pill_style"></a>
					</div>
					<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50faf75173aadc53"></script>
					<!-- AddThis Button END -->
				</div>										

			</div>
		</article>

	</div>
	

	
	<div class="mt-lg">
		<div class="col-md-6">
			<h4><?php echo ucwords(dict('Kolom Terkait', $lang)) ?></h4>
			<ul class="list list-icons list-icons-sm">
			<?php foreach($rec as $r):?>
				<li><a href="<?php echo site_url($lang.'/kolom/detail/'.$r->id_kolom.'/'.url_title(strtolower($r->judul))) ?>"><i class="fa fa-caret-right"></i> <?php echo $r->judul?></a>
					<br><span style="font-size:80%"><?php echo tgl_artikel($r->tgl_posting)?></span>
				</li>
			<?php endforeach ?>
			</ul>				
		</div>

		<div class="col-md-6">
			<h4><?php echo ucwords(dict('Kolom Terpopuler', $lang)) ?></h4>
			<ul class="list list-icons list-icons-sm">
			<?php
			foreach($pop as $r){?>
				<li><a href="<?php echo site_url($lang.'/kolom/detail/'.$r->id_kolom.'/'.url_title(strtolower($r->judul))) ?>"><i class="fa fa-caret-right"></i><?php echo $r->judul?></a>
				<br><span style="font-size:80%"><?php echo tgl_artikel($r->tgl_posting)?></span>
				</li>
			<?php } ?>
			</ul>
		</div>
	</div>
</div>

