<div  class="article-content">
	<?php $lang = $this->page_lib->lang(); ?>
	<h2 class="mb-xl heading-primary"><?php echo ucwords(dict('Album', $lang)) ?></h2>	
	<div class="clear20"></div>

		<div class="row">
			<ul class="portfolio-list sort-destination" data-sort-id="portfolio">
				<?php
				if (!empty($album)) {
					foreach ($album as $key) {
						$judul = $key['judul'];
						if (strlen($judul) > 17) {
							$judul = substr($judul, 0, 17)." ...";
						}
				?>
				<li class="col-md-4 isotope-item brands">
					<div class="portfolio-item">
						<span class="thumb-info thumb-info-lighten">
							<a href="<?php echo(base_url($lang.'/foto/daftar/'.$key['id_album'])) ?>">
								<span class="thumb-info-wrapper">
									<img src="<?php echo(base_url('asset/img/')) ?>folder_icon_blue.png" class="img-responsive" alt="">
									<span class="thumb-info-title">
										<span class="thumb-info-inner"><?php echo($judul); ?></span>
										<span class="thumb-info-type"><?php echo(tgl_artikel($key['tgl_posting'])); ?></span>
									</span>
									<span class="thumb-info-action">
										<span class="thumb-info-action-icon"><i class="fa fa-link"></i></span>
									</span>
								</span>
							</a>
							<span class="thumb-info-caption">
								<span class="thumb-info-caption-text">
									<?php
										$ringkasan = preg_replace('/<p align="center">(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",htmlspecialchars_decode($key['ringkasan']));
										$ringkasan = preg_replace('/<p>(&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]+)*<\/p>/iu',"",$ringkasan);
										$ringkasan = preg_replace('/(&nbsp;)*/iu',"",$ringkasan);
										$ringkasan = strip_tags(html_entity_decode($ringkasan));
										if (strlen($ringkasan) > 28) {
											$ringkasan = substr($ringkasan, 0, 28)." ...";
										}
										echo $ringkasan;
									?>
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
	
	<div class="clear20"></div>
	<div class="pagination">
		<?php echo $this->pagination->create_links(); ?>
	</div>
</div>
