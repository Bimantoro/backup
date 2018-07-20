<?php
	$lang=$this->page_lib->lang();
	$lang='id';
?>
		<?php
			$d=explode('.',str_replace('http://','',base_url()));
			$dom=$d[0];
			//$dom=$this->session->userdata('subdomain');
		?>
		<?php $unit=$this->db->get_where('unit',array('subdomain'=>$dom, 'kode_bahasa' => $lang))->row();

			if(empty($unit)){
				$unit=$this->db->get_where('unit',array('subdomain'=>$dom, 'kode_bahasa' => 'id'))->row();

				if(empty($unit)){
					$unit=$this->db->get_where('unit',array('subdomain'=>$dom))->row();
				}
			}

			//get data and set default social media :
			$social = array(
				'facebook' 	=> 'http://www.facebook.com/uinsk',
				'twitter'	=> 'http://www.twitter.com/uinsk',
				'instagram' => 'http://www.instagram.com/uinsk',
				'youtube' 	=> 'http://www.youtube.com/uinsk'
			);

			$tmp_social = $this->page_model->get_social_media($unit->id);

			foreach ($tmp_social as $s) {
				$social[$s->jenis] = $s->url;
			}

		?>
	
		<footer id="footer">
				<div class="container">
					<div class="row">
						<div class="col-md-3">
								<img src="<?php echo base_url('asset/images/logo-white.png')?>">									
						</div>
						<div class="col-md-4">
							<div class="contact-details">
								<h4>Contact Us</h4>
								<ul class="contact">
									<li><p><i class="fa fa-map-marker"></i> <?php echo $unit->alamat?></p></li>
									<li><p><i class="fa fa-phone"></i> <strong>Phone:</strong> <?php echo $unit->telp?></p></li>
									<li><p><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:mail@example.com"> <?php echo $unit->email?></a></p></li>
								</ul>
							</div>
						</div>
						<div class="col-md-3">
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2034.440039984545!2d110.39352316745081!3d-7.7848429796579754!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59db2dacb069%3A0x7f35156a4aeb645a!2sUIN+Sunan+Kalijaga+Yogyakarta!5e0!3m2!1sen!2sid!4v1475046208066"
							width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
						
						</div>
						<div class="col-md-2">
							<h4></h4>
							<ul class="social-icons">
								<li class="social-icons-facebook"><a href="<?php echo $social['facebook'] ?>" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
								<li class="social-icons-twitter"><a href="<?php echo $social['twitter'] ?>" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
								<li class="social-icons-instagram"><a href="<?php echo $social['instagram'] ?>" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a></li>
								<li class="social-icons-youtube"><a href="<?php echo $social['youtube'] ?>" target="_blank" title="Youtube"><i class="fa fa-youtube"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="footer-copyright">
					<div class="container">
						<div class="row">
							<div class="col-md-8">
								<p>© <?php echo(date("Y")) ?> - Pusat Teknologi Informasi dan Pangkalan Data UIN Sunan Kalijaga.</p>
							</div>
							<div class="col-md-4">
								<nav id="sub-menu">
									<ul>
										<li><a href="page-faq.html">FAQ's</a></li>
										<li><a href="sitemap.html">Peta Situs</a></li>
										<li><a href="contact-us.html">Privasi & Kebijakan</a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

		<!-- Vendor -->
		<script src="<?php echo base_url()?>asset/porto/vendor/jquery.appear/jquery.appear.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/jquery.easing/jquery.easing.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/jquery-cookie/jquery-cookie.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/common/common.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/jquery.validation/jquery.validation.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/jquery.stellar/jquery.stellar.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/jquery.gmap/jquery.gmap.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/isotope/jquery.isotope.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/owl.carousel/owl.carousel.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/vide/vide.min.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo base_url()?>asset/porto/js/theme.js"></script>
		
		<!-- Current Page Vendor and Views -->
		<script src="<?php echo base_url()?>asset/porto/vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/circle-flip-slideshow/js/jquery.flipshow.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/js/views/view.home.js"></script>
		
		<!-- Theme Custom -->
		<script src="<?php echo base_url()?>asset/porto/js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?php echo base_url()?>asset/porto/js/theme.init.js"></script>

		<script type="text/javascript" charset="utf-8">
			$(function(){
				setTimeout('closing_msg()', 5000)
			})

			function closing_msg(){
				$(".alert-msg").slideUp();
			}
		</script>

	</body>
</html>