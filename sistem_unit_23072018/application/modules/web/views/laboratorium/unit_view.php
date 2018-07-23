<div  class="article-content">
	
	<div class="blog-posts single-post">

		<article class="post blog-single-post">									
			
			<div class="post-content">

				<h2 class="mb-xl"><a href="blog-post.html"><?php echo $d->nama_lab ?></a></h2>

				
				<?php if($d->foto !=null){?>	
				<div class="post-image">
					<div class="owl-carousel owl-theme" data-plugin-options='{"items":1}'>
						<div>
							<div class="img-thumbnail">
								<img src="<?php  echo base_url('media/gambar/'.$d->foto);?>" alt="">
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<div style="text-align:justify">
				<?php 
					$isi=preg_replace('/<p align="center">(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",htmlspecialchars_decode($d->deskripsi));
					$isi=preg_replace('/<p>(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",$isi);
					$isi=preg_replace('/(&nbsp;)*/iu',"",$isi);
					echo html_entity_decode($isi);
				?>
				</div>
													

			</div>
		</article>

	</div>
	

	
	
</div>

