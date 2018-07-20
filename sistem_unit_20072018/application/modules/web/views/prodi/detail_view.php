<div id="content-center">

	<?php foreach($page as $d){?>
				<h2 class="mb-xl heading-primary"><?php echo $d->title?></h2>
				<div class="cleaner_h20"></div>
				<?php if($d->foto !=null){?>	
				<div class="post-image">
					<div class="owl-carousel owl-theme" data-plugin-options='{"items":1}'>
						<div>
							<div class="img-thumbnail" style="width: 100%;">
								<img src="<?php  echo base_url('media/gambar/'.$d->foto);?>" alt="">
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="article-content">					
					<?php 
					$isi=preg_replace('/<p align="center">(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",htmlspecialchars_decode($d->content));
					$isi=preg_replace('/<p>(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",$isi);
					$isi=preg_replace('/(&nbsp;)*/iu',"",$isi);
					echo html_entity_decode($d->content);
					?>
				</div>	
	<?php } ?>

</div>
