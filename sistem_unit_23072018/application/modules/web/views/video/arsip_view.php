<?php $lang=$this->page_lib->lang(); ?>	
<h2 class="mb-xl heading-primary"><?php echo ucwords(dict('Video', $lang)) ?></h2>	
<div class="blog-posts">
	<!-- <article class="post post-medium"> -->
		<div class="row">
			<ul class="portfolio-list sort-destination" data-sort-id="portfolio">
				<?php
				if (!empty($video)) {
					foreach ($video as $d) {
						$judul = $d->judul;
						if (strlen($judul) > 35) {
							$judul = substr($judul, 0, 35)."..";
						}
						parse_str( parse_url( $d->url, PHP_URL_QUERY ), $id_vid );
				?>
				<li class="col-md-4 isotope-item brands">
					<div class="portfolio-item">
						<span class="thumb-info thumb-info-lighten">
							 <a href="<?php echo site_url($lang.'/video/detail/'.$d->id_video.'/'.url_title(strtolower($d->judul))); ?>"> 
								<span class="thumb-info-wrapper">
									<iframe style="width: 100%; height: auto;" src="<?php echo "https://www.youtube.com/embed/".$id_vid['v']; ?>" frameborder="0" allowfullscreen></iframe> 
								</span>
								<span class="thumb-info-caption">
									<span class="thumb-info-caption-text"><b><?php echo $judul?></b><br>
									<i class="fa fa-calendar"></i> <?php echo tgl_artikel($d->tgl_posting)?>
									</span>
								</span>
							</a>
							<span class="thumb-info-caption">
								<span class="thumb-info-caption-text"><?php echo(substr($d->ringkasan,0, 130).".."); ?>
								<a href="<?php echo site_url($lang.'/video/detail/'.$d->id_video.'/'.url_title(strtolower($d->judul))) ?>" class="read-more"> <?php echo ucfirst(dict('selengkapnya',$lang))?> <i class="fa fa-angle-right"></i></a>
								</span>
							</span>
						</span>
					</div>
				</li>
				<?php }
				}
				?>
											
			</ul>
		</div>
	<!-- </article> -->
	<div class="pull-right">
	<?php echo $this->pagination->create_links();?>
	</div>
</div>
