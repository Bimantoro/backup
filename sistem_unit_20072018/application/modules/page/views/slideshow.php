
	<!-- sliderman.js -->
	<script type="text/javascript" src="<?php echo base_url()?>asset/sliderman/js/sliderman.1.3.7.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/sliderman/css/sliderman.css" />

		<div id="examples_outer">
			
			<div id="slider_container_1">

				<div id="SliderName">
					<?php
						$slide=$this->db->query("SELECT * from slide where active='Y' order by id_slide desc")->result();
						foreach($slide as $s){
							echo"<img src='".base_url()."media/slide/".$s->image."' title='".$s->judul."' />";
							echo"<div class='SliderNameDescription'>";
							if($s->url !=null){
								echo"<strong><a href='".$s->url."'>".$s->judul."</a></strong><br />".$s->deskripsi."</div>";
							}else{
								echo"<strong>".$s->judul."</strong><br />".$s->deskripsi."</div>";
							}
						}
					?>
				</div>
				<div class="c"></div>
				
				<div class="c"></div>

				<script type="text/javascript">

					// we created new effect and called it 'demo01'. We use this name later.
					Sliderman.effect({name: 'demo01', cols: 10, rows: 5, delay: 10, fade: true, order: 'straight_stairs'});

					var demoSlider = Sliderman.slider({container: 'SliderName', width: 720, height: 360, effects: 'demo01',
					display: {
						pause: true, // slider pauses on mouseover
						autoplay: 10000, // 3 seconds slideshow
						always_show_loading: 200, // testing loading mode
						description: {background: '#ffffff', opacity: 0.5, height: 50, position: 'bottom'}, // image description box settings
						loading: {background: '#000000', opacity: 0.2, image: 'img/loading.gif'}, // loading box settings
						buttons: {opacity: 1, prev: {className: 'SliderNamePrev', label: ''}, next: {className: 'SliderNameNext', label: ''}}, // Next/Prev buttons settings
						//navigation: {container: 'SliderNameNavigation', label: '&nbsp;'} // navigation (pages) settings
					}});

				</script>

				<div class="c"></div>
			</div>
			<div class="c"></div>
		</div>

	