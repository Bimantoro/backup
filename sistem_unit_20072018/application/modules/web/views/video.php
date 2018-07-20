		<?php 
    	$path='http://localhost/TOSHIBA/Stars/';
    	print_r($v);
    	?>
			


<div class="row">
	<div class="col-md-12">
	
			<div class="embed-responsive embed-responsive-16by9">
					<video controls poster="<?php echo $path.$v->star_name.'/Videos/'.$v->title.'/Poster.jpg'?>">
					  <source  src="<?php echo $path.$v->star_name.'/Videos/'.$v->title.'/'.$v->title.'.'.strtolower($v->format)?>" type="video/mp4">
					Your browser does not support the video tag.
					</video>
				</div>
		

		</div>
		
	</div>

	<div class="col-md-12">
	
		<div class="row">
			<h4 class="mb-md text-uppercase">Screens</h4>
			<div class="owl-carousel owl-theme" data-plugin-options='{"items": 1, "margin": 10, "animateOut": "fadeOut", "autoplay": true, "autoplayTimeout": 3000}'>
				<div class="image-gallery-item">
					<a href="<?php echo $path.$v->star_name.'/Videos/'.$v->title.'/Screens.jpg'?>" target="_blank">
						<span class="thumb-info">
							<span class="thumb-info-wrapper">
								<img alt="" class="img-responsive" src="<?php echo $path.$v->star_name.'/Videos/'.$v->title.'/Thumbs.jpg'?>">
							</span>
						</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
