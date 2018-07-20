<div  class="article-content">
	<h2 class="mb-xl heading-primary"><?php echo $album['judul'];?></h2>	
	
	<div class="clear20"></div>
					<?php
						if(!empty($foto)){?>
		<div class="row">

				<ul class="image-gallery sort-destination lightbox" data-sort-id="portfolio" data-plugin-options='{"delegate": "a.lightbox-portfolio", "type": "image", "gallery": {"enabled": true}}'>
							<?php foreach ($foto as $key) {?>
								<li class="col-md-4 col-sm-6 col-xs-12 isotope-item websites">
								<div class="image-gallery-item">
									<a href="<?php echo base_url('media/foto/'.$key['nama_file']);?>" class="lightbox-portfolio">
										<span class="thumb-info">
											<span class="thumb-info-wrapper">
												<img src="<?php echo base_url('media/foto/'.$key['nama_file']);?>" class="img-responsive" alt="" style="height: 200px;">
												<!-- <span class="thumb-info-title">
													<span class="thumb-info-inner">Project Title</span>
													<span class="thumb-info-type">Project Type</span>
												</span> -->
												<span class="thumb-info-action">
													<span class="thumb-info-action-icon"><i class="fa fa-link"></i></span>
												</span>
											</span>
										</span>
									</a>
								</div>
							</li>
							<?php }
					?>
				</ul>
			</div>
						<?php }else{
							echo "<p>Tidak ada koleksi foto</p>";
						}?>
	
	<div class="clear20"></div>
	<?php echo html_entity_decode($album['ringkasan']);?>
	
	<div class="clear20"></div>
	<div class="pagination">
		<?php echo $this->pagination->create_links(); ?>
	</div>
</div>
