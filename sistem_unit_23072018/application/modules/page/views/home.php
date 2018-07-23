			<div id="app_content">
				<div class="app-row">
					<div class="col-med-4">
						<div class="fakultas-menu">
							<h2>Info Jurusan / Program Studi</h2>
							<div class="menu dcjq-vertical-mega-menu">	

								<ul id="mega-1" class="menu">
									
								
									
					<?php foreach($menu as $d){?>
						<li><a href="<?php echo site_url($d->url) ?>"><?php echo $d->title ?></a></li>
				
								
								</li>
									<?php } ?>
									<div id="separate" ></div>
								</ul>				
							</div>		
						</div>
					</div>
					<div class="col-med-8">
						<script type="text/javascript" src="http://static.uin-suka.ac.id/plugins/sliderman/js/sliderman.1.3.7.js"></script>
						<link rel="stylesheet" type="text/css" href="http://static.uin-suka.ac.id/plugins/sliderman/css/sliderman.css" />
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

				</div>

				<script type="text/javascript">

					// we created new effect and called it 'demo01'. We use this name later.
					Sliderman.effect({name: 'demo01', cols: 10, rows: 5, delay: 10, fade: true, order: 'straight_stairs'});

					var demoSlider = Sliderman.slider({container: 'SliderName', width: 636, height: 373, effects: 'demo01',
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
			</div>						
		
				
					
				  
					</div>
				</div>
				<div class="clear20"></div>
				<div class="app-row">
					<div class="col-med-3">
						<div class="dis">
						
							<div class="judul-kolom">
								<a class="rss" href="<?php echo site_url('page/pengumuman/feed') ?>" target="_blank">&nbsp;</a>
								Pengumuman
							</div>
							<?php
								if(count($pengumuman	) > 0){
								?>
									<div class="list-artikel">
										<ul>
											<?php	
											foreach($pengumuman as $p){ 
												$length=62;
											if(strlen(strip_tags($p->judul))<=$length){
												$judul=$p->judul;
											}else{
												$judul=substr($p->judul,0,$length).' ...';
											}
											?>
											<li>
												<a href="<?php echo site_url('page/pengumuman/detail/'.$p->id_pengumuman.'/'.url_title(strtolower($p->judul))) ?>">
													<?php echo $judul?>
												</a>		
											</li>		
											<?php } ?>
										</ul>
									</div>
								<?php 
								}else{
									echo"<span class='tgl-post'>Belum ada pengumuman.</span>";
									echo"<div class='cleaner_h10'></div>";
								}
								?>	
			
									
						</div>	
						<a class="btn-uin btn btn-inverse btn btn-small" style="float:right" href="<?php echo site_url('page/pengumuman')?>"><i class="btn-uin"></i>Lainnya >></a> 
					</div>
					<div class="col-med-3">
						<div class="dis">
							<div class="judul-kolom">
								<a class="rss" href="<?php echo site_url('page/berita/feed') ?>" target="_blank">&nbsp;</a>
								Berita
							</div>
							<?php 
							if(count($berita) > 0){
								foreach($berita as $b){ ?>
									<div class="judul-artikel">
										<a href="<?php echo site_url('page/berita/detail/'.$b->id_berita.'/'.url_title(strtolower($b->judul))) ?>"><?php echo $b->judul ?></a>
									</div>
									<span class="tgl-post"><?php echo nama_hari($b->tanggal).', '.tanggal_indonesia($b->tanggal).' '.$b->jam ?> WIB</span>
							<?php 
								$char=200;
								if($b->gambar !=null){
									$char=160;
								?>
									<img style="width:90px;float:left;margin:15px 7px 7px 0;" src="<?php echo base_url().'media/news/'.$b->gambar ?>" />
							<?php } ?>
								<p class="isi">
									<?php 
									$isi=preg_replace('/<p align="center">(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",htmlspecialchars_decode($b->isi_berita));
									$isi=preg_replace('/<p>(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",$isi);
									$isi=preg_replace('/(&nbsp;)*/iu',"",$isi);
									echo substr(strip_tags(html_entity_decode($isi)),0,$char)?>.... 
									<a href="<?php echo site_url('page/berita/detail/'.$b->id_berita.'/'.url_title(strtolower($b->judul))) ?>"><b>(Selengkapnya)</b></a>
								</p>	
							<?php }?>
							<?php
								}else{
									echo"<span class='tgl-post'>Belum ada berita.</span>";
								}
							?>	
						</div>
						<a class="btn-uin btn btn-inverse btn btn-small" style="float:right" href="<?php echo site_url('page/berita')?>"><i class="btn-uin"></i>Lainnya >></a> 
					</div>
					<div class="col-med-3">
						<div class="dis">	
							<div class="judul-kolom">
								<a class="rss" href="<?php echo site_url('page/agenda/feed') ?>" target="_blank">&nbsp;</a>
								Agenda
							</div>
							<div id="daftar-event">
								<?php 
								if(count($agenda)>0){
									foreach($agenda as $a){
								?>
									<div class="dateblock">
										<div class="day"><?php echo tgl_get_date($a->tgl_mulai) ?></div>
										<div class="month"><?php echo substr(tgl_get_month($a->tgl_mulai),0,3); ?></div>
									</div>
									<div class="datetext">
										<p class="col-title"><a href="<?php echo site_url('page/agenda/detail/'.$a->id_agenda.'/'.url_title(strtolower($a->nama_agenda))) ?>">
											<?php echo $a->nama_agenda ?></a></p>
									</div>
									<div class="underline-menu"></div>
								<?php 
									}
								}else{
									echo"<span class='tgl-post'>Belum ada agenda.</span>";
								}
								?>	
							
							</div>
						</div>	
						<a class="btn-uin btn btn-inverse btn btn-small" style="float:right" href="<?php echo site_url('page/agenda')?>"><i class="btn-uin"></i>Lainnya >></a> 
					</div>
					<div class="col-med-3">
						<div class="dis">
							<div class="judul-kolom">
								<a class="rss" href="<?php echo site_url('page/kolom/feed') ?>" target="_blank">&nbsp;</a>
								Kolom
							</div>	
							<?php 
							if(count($kolom)>0){		
								foreach($kolom as $k){?>
									<div class="judul-artikel">
										<a href="<?php echo site_url('page/kolom/detail/'.$k->id_kolom.'/'.url_title(strtolower($k->tentang))) ?>"><?php echo $k->tentang ?></a>
									</div>
									<span class="tgl-post"><?php echo nama_hari($k->tanggal).', '.tanggal_indonesia($k->tanggal).' '.$k->jam ?> WIB</span>
									<p class="isi">
									<?php 
									$isi=preg_replace('/<p align="center">(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",htmlspecialchars_decode($k->isinya));
									$isi=preg_replace('/<p>(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",$isi);
									$isi=preg_replace('/(&nbsp;)*/iu',"",$isi);
									echo substr(strip_tags(html_entity_decode($isi)),0,290)?>.... 
									<a href="<?php echo site_url('page/kolom/detail/'.$k->id_kolom.'/'.url_title(strtolower($k->tentang))) ?>"><b>(Selengkapnya)</b></a>
									</p>
								<?php } ?>
							<?php 
							}else{
								echo"<span class='tgl-post'>Belum ada kolom.</span>";
								echo"<div class='cleaner_h10'></div>";
							}
							?>							
						</div>
						<a class="btn-uin btn btn-inverse btn btn-small" style="float:right" href="<?php echo site_url('page/kolom')?>"><i class="btn-uin"></i>Lainnya >></a> 
					
					</div>
				</div>
			</div>