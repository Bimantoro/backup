<?php $lang = $this->page_lib->lang(); ?>

<div  class="article-content">
	
	<div class="blog-posts single-post">

		<article class="post blog-single-post">									
			
			<div class="post-content">

				<h2 class="mb-none"><a href="blog-post.html"><?php echo $d->judul ?></a></h2>

				<div class="post-meta">
					<span><i class="fa fa-calendar"></i> <?php echo tgl_artikel($d->tgl_posting)?></span>
					<?php 	
					parse_str( parse_url( $d->url, PHP_URL_QUERY ), $id_vid );
					 $json = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=".$id_vid['v']."&key=AIzaSyD_MM45Ahr113vqsJcGdjXy2OWgXiyfgOQ");
					 $jsonData = json_decode($json);
					 $views = $jsonData->items[0]->statistics->viewCount;
					 ?>
					<span class="pull-right"><?php echo ucfirst(dict('Dilihat', $lang)) ?> : <?php echo(number_format($views));?> <?php echo ucfirst(dict('kali', $lang)) ?></span>
				</div>
				<div class="post-image">
					<div class="owl-carousel owl-theme" data-plugin-options='{"items":1}'>
						<iframe style="width: 100%; height: 400px; " src="<?php echo "https://www.youtube.com/embed/".$id_vid['v']; ?>" allowfullscreen></iframe> 
					</div>
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
</div>

