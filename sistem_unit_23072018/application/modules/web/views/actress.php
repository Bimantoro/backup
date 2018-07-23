		<?php 
    	print_r($act);
    	$path='http://localhost/TOSHIBA/Stars/';
    	?>
		<div class="row">
						<div class="col-md-12">
							<div class="portfolio-title">
								<div class="row">
									<div class="portfolio-nav-all col-md-1">
										<a href="portfolio-single-small-slider.html" data-tooltip data-original-title="Back to list"><i class="fa fa-th"></i></a>
									</div>
									<div class="col-md-10 center">
										<h2 class="mb-none"><?php echo $act->star_name?></h2>
									</div>
									<div class="portfolio-nav col-md-1">
										<a href="portfolio-single-small-slider.html" class="portfolio-nav-prev" data-tooltip data-original-title="Previous"><i class="fa fa-chevron-left"></i></a>
										<a href="portfolio-single-small-slider.html" class="portfolio-nav-next" data-tooltip data-original-title="Next"><i class="fa fa-chevron-right"></i></a>
									</div>
								</div>
							</div>

							<hr class="tall">
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">

							<div class="owl-carousel owl-theme" data-plugin-options='{"items": 1, "margin": 10, "animateOut": "fadeOut", "autoplay": true, "autoplayTimeout": 3000}'>
								<div>
									<span class="img-thumbnail">
										<img alt="" class="img-responsive" src="<?php echo $path.'/'.$act->star_name.'/Profile/P1.jpg'?>">
									</span>
								</div>
								<div>
									<span class="img-thumbnail">
										<img alt="" class="img-responsive" src="<?php echo $path.'/'.$act->star_name.'/Profile/P2.jpg'?>">
									</span>
								</div>
							</div>

						</div>

						<div class="col-md-8">

							<div class="portfolio-info">
								<div class="row">
									<div class="col-md-12 center">
										<ul>
											<li>
												<a href="#" data-tooltip data-original-title="Like"><i class="fa fa-heart"></i>14</a>
											</li>
											<li>
												<i class="fa fa-calendar"></i> 01 January 2016
											</li>
											<li>
												<i class="fa fa-tags"></i> <a href="#">Brand</a>, <a href="#">Design</a>
											</li>
										</ul>
									</div>
								</div>
							</div>

							<h5 class="mt-sm">Project Description</h5>
							<p class="mt-xlg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus nibh sed elimttis adipiscing. Fusce in hendrerit purus. Suspendisse potenti. Proin quis eros odio, dapibus dictum mauris. Donec nisi libero, adipiscing id pretium eget, consectetur sit amet leo. Nam at eros quis mi egestas fringilla non nec purus.</p>

							<a href="#" class="btn btn-primary btn-icon"><i class="fa fa-external-link"></i>Live Preview</a> <span class="arrow hlb appear-animation" data-appear-animation="rotateInUpLeft" data-appear-animation-delay="800"></span>

							<ul class="portfolio-details">
								<li>
									<h5 class="mt-sm mb-xs">Fact</h5>

									<table class="table">
										<tr><td width="15%">Birth </td><td width="1%"> : </td><td> <?php echo $act->birth?></td></tr>
										<tr><td>Home Town </td><td> : </td> <td><?php echo $act->home_town?></td></tr>
										<tr><td>Measurements</td><td> : </td> <td><?php echo $act->measurements?></td></tr>
										<tr><td>Boobs</td><td> : </td> <td><?php echo $act->boobs?></td></tr>
										<tr><td>Body Type</td><td> : </td> <td><?php echo $act->body_type?></td></tr>
										<tr><td>Height</td><td> : </td> <td><?php echo $act->height?></td></tr>
										<tr><td>Hair</td><td> : </td> <td><?php echo $act->hair?></td></tr>
										<tr><td>Eye</td><td> : </td> <td><?php echo $act->eye?></td></tr>
										<tr><td>Ethnicity</td><td> : </td> <td><?php echo $act->ethnicity?></td></tr>
										<tr><td>Origin</td><td> : </td> <td><?php echo $act->origin?></td></tr>
									</table>
								</li>
								<li>
									<h5 class="mt-sm mb-xs">Client</h5>
									<p>Okler Themes</p>
								</li>
							</ul>

						</div>
					</div>

					<div class="row">
						<div class="col-md-12">

							<h4 class="mb-md text-uppercase">Pictures <strong>(<?php echo $pc ?>)</strong></h4>
								
							<div class="row">

								<ul class="portfolio-list">
								<?php if(!empty($pic1)):?>
								<?php foreach($pic1 as $p):?>
									<li class="col-md-3 col-sm-6 col-xs-12">
										<div class="portfolio-item">
											<a href="portfolio-single-small-slider.html">
												<span class="thumb-info thumb-info-lighten">
													<span class="thumb-info-wrapper">
														<img src="<?php echo $path.'/'.$act->star_name.'/Pictures/'.$p->studio.'/'.$p->title.'/P1.jpg'?>" class="img-responsive" alt="">
														<span class="thumb-info-title">
															<span class="thumb-info-inner"><?php echo $p->studio?></span>
															<span class="thumb-info-type"><?php echo $p->title?></span>
														</span>
														<span class="thumb-info-action">
															<span class="thumb-info-action-icon"><i class="fa fa-link"></i></span>
														</span>
													</span>
												</span>
											</a>
										</div>
									</li>
									<?php endforeach ?>
									<?php endif ?>
								</ul>

							</div>
							
							
							<hr class="tall">
							
							<div class="row">
								<div class="col-md-12">

								<h4 class="mb-md text-uppercase">Videos <strong>(<?php echo $vc ?>)</strong></h4>

									<ul class="nav nav-pills sort-source" data-sort-id="portfolio" data-option-key="filter">
										<li data-option-value="*" class="active"><a href="#">Show All</a></li>
										<li data-option-value=".Solo"><a href="#">Solo</a></li>
										<li data-option-value=".Straight"><a href="#">Straight</a></li>
										<li data-option-value=".Lesbi"><a href="#">Lesbi</a></li>
									</ul>

									<hr>

									<div class="row">

										<ul class="image-gallery sort-destination lightbox" data-sort-id="portfolio" data-plugin-options='{"delegate": "a.lightbox-portfolio", "type": "image", "gallery": {"enabled": true}}'>
											
										<?php if(!empty($vid)):?>
										<?php foreach($vid as $v):?>
											<li class="col-md-6 col-sm-12 col-xs-12 isotope-item <?php echo $v->genre?>">
												<div class="image-gallery-item">
													<a href="<?php echo site_url('stars/video/'.$v->video_id)?>" >
														<span class="thumb-info">
															<span class="thumb-info-wrapper">
																<img src="<?php echo $path.'/'.$act->star_name.'/Videos/'.$v->title.'/Poster.jpg'?>" class="img-responsive" alt="">
																<span class="thumb-info-title">
																	<span class="thumb-info-inner"><?php echo $v->studio?></span>
																	<span class="thumb-info-type"><?php echo $v->title?></span>
																</span>
																<span class="thumb-info-action">
																	<span class="thumb-info-action-icon"><i class="fa fa-link"></i></span>
																</span>
															</span>
														</span>
													</a>
												</div>
											</li>
											<?php endforeach ?>
											<?php endif ?>
										</ul>
									</div>
								</div>
							</div>

							
							
						</div>
					</div>