<?php
$this->load->view('web/header');?>
<?php
	$lang=$this->page_lib->lang();
	//$lang='id';
?>	
		<?php
			$d=explode('.',str_replace('http://','',base_url()));
			$dom=$d[0];
			//$dom=$this->session->userdata('subdomain');
		?>
		<?php
			$query = $this->db->query("select status_slider_bar from unit where status_slider_bar = 1")->result();
		?>
		
		<?php $unit=$this->db->get_where('unit',array('subdomain'=>$dom, 'kode_bahasa' => $lang))->row();

			if(empty($unit)){
				$unit=$this->db->get_where('unit',array('subdomain'=>$dom, 'kode_bahasa' => 'id'))->row();

				if(empty($unit)){
					$unit=$this->db->get_where('unit',array('subdomain'=>$dom))->row();
				}
			}

		?>
			<div role="main" class="main">
			<?php
				if($unit->status_slider_bar==1){?>
					<div class="slider-container rev_slider_wrapper">
					<div id="revolutionSlider" class="slider rev_slider" data-plugin-revolution-slider data-plugin-options='{"delay": 15000, "gridwidth": 1170, "gridheight": 487}'>
						<ul>
						<?php if(isset($slide) and !empty($slide)):?>
						<?php foreach($slide as $s):?>
						<?php if($s->url!=null):?>
							<li data-transition="fade" data-link="<?php echo $lang.'/'.$s->url ?>"  data-target="_blank">
						<?php else:	?>
							<li data-transition="fade">
						<?php endif ?>	
								<img src="<?php echo base_url('media/slide/'.$s->picture)?>"  
									alt=""
									style="background-color:<?php echo $s->background?>"
									data-bgposition="center center" 
									data-bgfit="contain" 
									data-bgrepeat="no-repeat" 
									class="rev-slidebg">

									<!--style="background-color:#173F3F"-->
								<div class="tp-caption"
									data-x="177"
									data-y="180"
									data-start="1000"
									data-transform_in="x:[-300%];opacity:0;s:500;"></div>

								<div class="tp-caption top-label"
									data-x="227"
									data-y="180"
									data-start="1500"
									data-transform_in="y:[-300%];opacity:0;s:500;"></div>

								<div class="tp-caption"
									data-x="480"
									data-y="180"
									data-start="1000"
									data-transform_in="x:[300%];opacity:0;s:500;"></div>

								<div class="tp-caption top-label"
									data-x="75"
									data-y="140"
									data-start="500"
									data-whitespace="nowrap"						 
									data-transform_in="y:[100%];s:500;"
									data-transform_out="opacity:0;s:500;"
									data-mask_in="x:0px;y:0px;"></div>

								<div class="tp-caption bottom-label"
									data-x="185"
									data-y="280"
									data-start="2000"
									data-transform_in="y:[100%];opacity:0;s:500;"></div>
								
							</li>
						<?php endforeach ?>	
						<?php endif ?>
							<!--
							<li data-transition="fade">

								<img src="img/slides/slide-corporate-4.jpg"  
									alt=""
									data-bgposition="center center" 
									data-bgfit="cover" 
									data-bgrepeat="no-repeat" 
									class="rev-slidebg">

								<div class="tp-caption featured-label"
									data-x="center"
									data-y="210"
									data-start="500"
									style="z-index: 5"
									data-transform_in="y:[100%];s:500;"
									data-transform_out="opacity:0;s:500;">WELCOME TO PORTO</div>

								<div class="tp-caption bottom-label"
									data-x="center"
									data-y="270"
									data-start="1000"
									data-transform_idle="o:1;"
									data-transform_in="y:[100%];z:0;rZ:-35deg;sX:1;sY:1;skX:0;skY:0;s:600;e:Power4.easeInOut;"
									data-transform_out="opacity:0;s:500;"
									data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
									data-splitin="chars" 
									data-splitout="none" 
									data-responsive_offset="on"
									style="font-size: 23px; line-height: 30px;"
									data-elementdelay="0.05">The #1 Selling HTML Site Template on ThemeForest</div>

							</li>-->
						</ul>
					</div>
				</div>
				<?php }
				else{?>
				<div class="home-intro" id="home-intro">
					<div class="container">				
						<?php if($status_sidemenu == 1){ ?>				
							<div class="col-md-8">
						<?php }else{ ?>
							<div class="col-md-12">
						<?php } ?>
								<?php if(isset($berita1)):?>
								<?php foreach($berita1 as $b1):?>
								<h4 class="mb-xl heading-primary">
								<?php echo $b1->judul ?>
								</h4>
								<div class="row col-md-12 mb-lg">
									<div class="post-meta pl-none" style="">
										<span style="color:#ffffff"><i class="fa fa-calendar"></i> <?php echo tgl_artikel($b1->tgl_posting)?></span>
										<span style="color:#ffffff" class="pull-right"><?php echo ucfirst(dict('Dilihat', $lang)) ?> : <?php echo $b1->counter?> <?php echo ucfirst(dict('Kali', $lang)) ?></span>
									</div>
								</div>
								<div class="row col-md-12 mb-lg">
									<div style="font-size:14px; text-align:justify; color: white;">
									<span class="img-thumbnail mr-lg" style="display:inline-block; float:left;">
										<!-- <img width="350" src="<?php  //echo base_url('media/berita/67/'.$b1->foto);//?>"/>-->
										<img width="350" src="<?php  echo base_url('media/gambar/'.$b1->foto);?>"/>
									</span>									
										<?php echo $b1->ringkasan ?>
									</div>
								</div>
								<div class="row col-md-12 mb-lg"><a href="<?php echo site_url($lang.'/berita/detail/'.$b1->id_berita.'/'.url_title(strtolower($b1->judul)))?>" class="btn btn-primary btn-icon pull-right"><i class="fa fa-external-link"></i><?php echo ucfirst(dict('Selengkapnya',$lang));?></a></div>
								<?php endforeach ?>
								<?php endif ?>
							</div>

							<?php if($status_sidemenu == 1){ ?>
								<div class="col-md-4">
									<div class="featured-boxes mt-none mb-none">
										<div class="featured-box featured-box-primary mt-xl" style="text-align:left">
											<div class="box-content">
												
												
												<h4 class="mt-none"><?php echo $unit->nama_sidebar_unit?></h4>
												<ul class="simple-post-list">
												<?php 
												/* $menu=$this->db->select('menu.*')
												->from('menu')
												->where(array('parent'=>5,'status'=>1))
												->order_by('menu_order','asc')
												->get()->result(); */
												?>
												<?php if(isset($side) and !empty($side)):?>
												<?php foreach($side as $s):?>
													<li>
														<div class="post-info">
															<a href="<?php echo site_url($lang.'/'.$s->url);?>"><?php echo $s->nama_menu?></a>
														</div>
													</li>
												<?php endforeach ?>	
												<?php endif ?>
														
												</ul>
											</div>
										</div>
									</div>
								</div> 
							<?php } ?>
				
					</div>
				</div>
				<?php }?>
				<div class="container">
				
					<div class="row">
						<div class="col-md-8 recent-posts">
							<?php if(isset($berita2)and !empty($berita2)):?>
								<h2 class="mt-sm heading-primary"><i class="icon-layers icons"> </i><?php echo ucfirst(dict('Berita',$lang));?></h2>	
							
							<div class="row">

							<?php foreach($berita2 as $b2):?>
										<div class="col-md-6 mr-none">
											<article class="post" style="text-align:justify">
												<div class="post-image single mb-lg">
													<!--<img class="img-thumbnail" src="<?php  //echo base_url('media/berita/67/'.$b2->foto);//?>" alt="">-->
													<img class="img-thumbnail" src="<?php  echo base_url('media/gambar/'.$b2->foto);?>" alt="">
												</div>
												<?php if (strlen($b2->judul)>65) $b2->judul=substr($b2->judul,0,64)." ...";?>
												<h4><a href="<?php echo site_url($lang.'/berita/detail/'.$b2->id_berita.'/'.url_title(strtolower($b2->judul)))?>"><?php echo $b2->judul; ?></a></h4>
												<div class="post-meta pl-none">
													<span><i class="fa fa-calendar"></i> <?php echo tgl_artikel($b2->tgl_posting)?></span>
													<span class="pull-right"><?php echo ucfirst(dict('Dilihat', $lang)) ?> : <?php echo $b2->counter?> <?php echo ucfirst(dict('Kali', $lang)) ?></span>
												</div>
												<?php if (strlen($b2->ringkasan)>250) $b2->ringkasan=substr($b2->ringkasan,0,250)."...";?>
												<p><?php echo $b2->ringkasan?> <a href="<?php echo site_url($lang.'/berita/detail/'.$b2->id_berita.'/'.url_title(strtolower($b2->judul)))?>" class="read-more"><?php echo ucfirst(dict('Selengkapnya',$lang));?> <i class="fa fa-angle-right"></i></a></p>
											</article>
										</div>								
								<?php endforeach?>
								<div class="col-md-12 pull-right">
									<div class="pull-right">
										<a href="<?php echo site_url($lang.'/berita/') ?>" class="btn btn-primary mr-xs mb-sm"><?php echo ucfirst(dict('Lainnya',$lang));?> <i class="fa fa-arrow-circle-right"></i></a></p>
									</div>
								</div>
							</div>
							<?php endif ?>

							<?php if(isset($liputan)AND !empty($liputan)):?>
							<h2 class="mt-lg heading-primary"><i class="icon-layers icons"></i> <?php echo ucfirst(dict('Liputan',$lang));?></h2>
							
							<div class="row">
							<?php foreach($liputan as $b2):?>
										<div class="col-md-6 mr-none">
											<article class="post" style="text-align:justify">
												<?php if (!empty($b2->foto)) { ?>
												<div class="post-image single mb-lg">
													<!-- <img class="img-thumbnail" src="<?php  echo base_url('media/liputan/67/'.$b2->foto);?>" alt="">-->
													<img class="img-thumbnail" src="<?php  echo base_url('media/gambar/'.$b2->foto);?>" alt="">
												</div>
												<?php } if (strlen($b2->judul)>65) $b2->judul=substr($b2->judul,0,64)." ...";?>
												<h4><a href="<?php echo site_url($lang.'/liputan/detail/'.$b2->id_liputan.'/'.url_title(strtolower($b2->judul)))?>"><?php echo $b2->judul; ?></a></h4>
												<div class="post-meta pl-none">
													<span><i class="fa fa-calendar"></i> <?php echo tgl_artikel($b2->tgl_posting)?></span>
													<span class="pull-right"><?php echo ucfirst(dict('Dilihat', $lang)) ?> : <?php echo $b2->counter?> <?php echo ucfirst(dict('Kali', $lang)) ?></span>
												</div>
												<?php if (strlen($b2->ringkasan)>250) $b2->ringkasan=substr($b2->ringkasan,0,250)."...";?>
												<p><?php echo $b2->ringkasan?> <a href="<?php echo site_url($lang.'/liputan/detail/'.$b2->id_liputan.'/'.url_title(strtolower($b2->judul)))?>" class="read-more"><?php echo ucfirst(dict('Selengkapnya',$lang));?> <i class="fa fa-angle-right"></i></a></p>
											</article>
										</div>								
								<?php endforeach?>
								<div class="col-md-12 pull-right">
									<div class="pull-right">
										<a href="<?php echo site_url($lang.'/liputan/') ?>" class="btn btn-primary mr-xs mb-sm"><?php echo ucfirst(dict('Lainnya',$lang));?> <i class="fa fa-arrow-circle-right"></i></a></p>
									</div>
								</div>
							</div>
							<?php endif ?>


							<?php if(isset($kolom)AND !empty($kolom)):?>
							<h2 class="mt-lg mb-none heading-primary"><i class="icon-layers icons"></i> <?php echo ucfirst(dict('Kolom',$lang));?></h2>
							<div class="row">
							<?php foreach($kolom as $b2):?>
										<div class="col-md-6 mr-none">
											<article class="post" style="text-align:justify">
												
												<?php if (strlen($b2->judul)>65) $b2->judul=substr($b2->judul,0,65)." ...";?>
												<h4><a href="<?php echo site_url($lang.'/kolom/detail/'.$b2->id_kolom.'/'.url_title(strtolower($b2->judul)))?>"><?php echo $b2->judul; ?></a></h4>
												<div class="post-meta pl-none">
													<span><i class="fa fa-calendar"></i> <?php echo tgl_artikel($b2->tgl_posting)?></span>
													<span class="pull-right"><?php echo ucfirst(dict('Dilihat', $lang)) ?> : <?php echo $b2->counter?> <?php echo ucfirst(dict('Kali', $lang)) ?></span>
												</div>
												<?php if (strlen($b2->ringkasan)>250) $b2->ringkasan=substr($b2->ringkasan,0,250)."...";?>
												<p><?php echo $b2->ringkasan?> <a href="<?php echo site_url($lang.'/kolom/detail/'.$b2->id_kolom.'/'.url_title(strtolower($b2->judul)))?>" class="read-more"><?php echo ucfirst(dict('Selengkapnya',$lang));?>  <i class="fa fa-angle-right"></i></a></p>
											</article>
										</div>								
								<?php endforeach?>
								<div class="col-md-12 pull-right">
									<div class="pull-right">
										<a href="<?php echo site_url($lang.'/kolom/') ?>" class="btn btn-primary mr-xs mb-sm"><?php echo ucfirst(dict('Lainnya',$lang));?> <i class="fa fa-arrow-circle-right"></i></a></p>
									</div>
								</div>
							</div>
							<?php endif ?>

						</div>
						<div class="col-md-4">

							<!-- ini untuk menu sidebar -->
							<?php if($status_slider == 1 && $status_sidemenu == 1){ ?>
							<div class="featured-boxes mt-none mb-none">
										<div class="featured-box featured-box-primary mt-xl" style="text-align:left">
											<div class="box-content">											
												
												<h4 class="mt-none"><?php echo $unit->nama_sidebar_unit?></h4>
												<ul class="simple-post-list">
												<?php 
												/* $menu=$this->db->select('menu.*')
												->from('menu')
												->where(array('parent'=>5,'status'=>1))
												->order_by('menu_order','asc')
												->get()->result(); */
												?>
												<?php if(isset($side) and !empty($side)):?>
												<?php foreach($side as $s):?>
													<li>
														<div class="post-info">
															<a href="<?php echo site_url($lang.'/'.$s->url);?>"><?php echo $s->nama_menu?></a>
														</div>
													</li>
												<?php endforeach ?>	
												<?php endif ?>
														
												</ul>
											</div>
										</div>
									</div>
								<?php } ?>
							<!-- ini untuk menu sidebar -->

							<?php if(isset($pengumuman) AND !empty($pengumuman)):?>
								<h4 class="mt-xl heading-primary"><i class="fa fa-bullhorn"></i> <?php echo ucfirst(dict('Pengumuman',$lang));?></h4>
								<ul class="nav nav-list mb-xlg" data-sort-id="portfolio" data-option-key="filter" data-plugin-options='{"layoutMode": "fitRows", "filter": "*"}'>
								<?php foreach($pengumuman as $p):?>
									<?php if (strlen($p->nama_pengumuman)>65) $p->nama_pengumuman=substr($p->nama_pengumuman,0,64)." ...";?>
									<li><a href="<?php echo site_url($lang.'/pengumuman/detail/'.$p->id_pengumuman.'/'.url_title(strtolower($p->nama_pengumuman)))?>"><?php echo $p->nama_pengumuman?></a></li>
									
								<?php endforeach ?>	
								</ul>
								<div class="col-md-12 pull-right">
									<div class="pull-right">
										<a href="<?php echo site_url($lang.'/pengumuman/') ?>" class="btn btn-primary mr-xs mb-sm"><?php echo ucfirst(dict('lainnya',$lang));?> <i class="fa fa-arrow-circle-right"></i></a></p>
									</div>
								</div>
							<?php endif?>
							
							<?php if(isset($agenda)AND !empty($agenda)):?>
								<h4 class="mt-xl heading-primary"><i class="fa fa-calendar-check-o"></i> <?php echo ucfirst(dict('Agenda',$lang));?></h4>
								<div class="panel-group mb-xl" id="accordion">	
									<?php foreach($agenda as $a):?>
									<div class="panel panel-default">
										<div class="panel-heading pl-sm">
											<h4 class="panel-title ">
												<div class="recent-posts m-none">								
													<article>
														<div class="date mt-none">
														<?php
															$tgl_mulai = $a->tgl_mulai;
															$tgl_selesai = $a->tgl_selesai;
															$datetime = explode(" ", $tgl_mulai);
															$datetime2 = explode(" ", $tgl_selesai);
															$date = $datetime[0];
															$jam_mulai = $datetime[1];
															$jam_selesai = $datetime2[1];
														?>
															<span class="day"><?php echo tgl_get_date($date) ?></span>
															<span class="month"><?php echo substr(tgl_get_month($a->tgl_mulai),0,3); ?></span>
														</div>
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $a->id_agenda?>" style="min-height:75px"><?php echo $a->nama_agenda?></a>
													</article>													
												</div>
											</h4>
										</div>
										<div id="collapse<?php echo $a->id_agenda?>" class="accordion-body collapse">
											<div class="panel-body">
												<strong><?php echo ucfirst(dict('Hari', $lang)) ?></strong><br>
												<?php echo nama_hari($a->tgl_mulai); if($a->tgl_selesai!=$a->tgl_mulai and $a->tgl_selesai!="0000-00-00") echo " ".separator()." ".nama_hari($a->tgl_selesai);?><br>
												<strong><?php echo ucfirst(dict('Tanggal', $lang)) ?></strong><br>
												<?php echo tanggal_indonesia($a->tgl_mulai); if($a->tgl_selesai!=$a->tgl_mulai and $a->tgl_selesai!="0000-00-00") echo " ".separator()." ".tanggal_indonesia($a->tgl_selesai); ?><br>
												<strong><?php echo ucfirst(dict('Jam', $lang)) ?></strong><br>
												<?php echo $jam_mulai; if($jam_selesai=="00:00:00"){ echo " s.d. 23:59:59";}else{echo " ".separator()." ".$jam_selesai;} ?> WIB <br>
												<strong><?php echo ucfirst(dict('Tempat', $lang)) ?></strong><br>
												<?php echo $a->tempat ?><br><br>
												<?php if (strlen($a->nama_agenda)>65) $a->nama_agenda=substr($a->nama_agenda,0,64)." ...";?>
												<a href="<?php echo site_url($lang.'/agenda/detail/'.$a->id_agenda.'/'.url_title(strtolower($a->nama_agenda))) ?>" class="read-more"><?php echo ucfirst(dict('selengkapnya',$a->nama_agenda));?> <i class="fa fa-angle-right"></i></a></p>
											</div>
										</div>
									
								</div>
							<?php endforeach?>
							</div>
								<div class="col-md-12 pull-right">
									<div class="pull-right">
										<a href="<?php echo site_url($lang.'/agenda/') ?>" class="btn btn-primary mr-xs mb-sm"><?php echo ucfirst(dict('lainnya',$lang));?> <i class="fa fa-arrow-circle-right"></i></a></p>
									</div>
								</div>
							<?php endif?>
						</div>
					</div>
				
				
				</div>
			</div>
<?php $this->load->view('web/footer'); ?>