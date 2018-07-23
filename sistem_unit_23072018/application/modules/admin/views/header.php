<?php $this->load->model('admin/page_model'); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			$kode_unit = $this->session->userdata('kode_unit');
			$unit = $this->db->get_where('unit', array('kode_unit'=>$kode_unit, 'kode_bahasa' => 'id'))->row();
			if(empty($unit)){
				$unit = $this->db->get_where('unit', array('kode_unit'=>$kode_unit))->row();
			}

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
		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title><?php echo $unit->nama_unit?> UIN Sunan Kalijaga</title>	

		<meta name="keywords" content="HTML5 Template" />
		<meta name="description" content="Porto - Responsive HTML5 Template">
		<!-- <meta name="author" content="okler.net"> -->

		<!-- Favicon -->
		<link rel="shortcut icon" href="http://static.uin-suka.ac.id/images/favicon.png" type="image/x-icon" />
		<link rel="apple-touch-icon" href="http://static.uin-suka.ac.id/images/favicon.png">
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/vendor/magnific-popup/magnific-popup.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/css/theme.css">
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/css/theme-elements.css">
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/css/theme-blog.css">
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/css/theme-shop.css">
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/css/theme-animate.css">
	
		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/css/custom.css">

		
		<!-- Head Libs -->
		<!--<script src="<?php echo base_url()?>asset/porto/vendor/modernizr/modernizr.min.js"></script>-->
		
		<!-- Datatables -->
		<script src="<?php echo base_url()?>asset/datatables-bootstrap/js/jquery.min.js"></script>
		 <!-- <script type="text/javascript" src="<?php echo base_url()?>asset/scripts/jquery-1.10.1.min.js"></script> -->
		<script src="<?php echo base_url()?>asset/bootstrap-modal-master/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url()?>asset/datatables-bootstrap/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url()?>asset/datatables-bootstrap/js/datatables.js"></script>

	</head>
	<body>

		<div class="body">
			<header id="header" class="header-mobile-nav-only" data-plugin-options='{"stickyEnabled": true, "stickyEnableOnBoxed": true, "stickyEnableOnMobile": true, "stickyStartAt": 115, "stickySetTop": "-115px", "stickyChangeLogo": true}'>
				<div class="header-body">
					<div class="header-top">
						<div class="container">
							<p>
								<span class="ml-xs"><i class="fa fa-phone"></i> <?php echo $unit->telp?></span><span class="hidden-xs"> | <a href="#"><?php echo $unit->email?></a></span>
							</p>
							<ul class="header-social-icons social-icons hidden-xs">
								<li class="social-icons-facebook"><a href="<?php echo $social['facebook'] ?>" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
								<li class="social-icons-twitter"><a href="<?php echo $social['twitter'] ?>" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
								<li class="social-icons-instagram"><a href="<?php echo $social['instagram'] ?>" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a></li>
								<li class="social-icons-youtube"><a href="<?php echo $social['youtube'] ?>" target="_blank" title="Youtube"><i class="fa fa-youtube"></i></a></li>
							</ul>
						</div>
					</div>
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-logo">
									<a href="<?php echo base_url()?>">
										<img alt="Porto2" width="246"  height="54" data-sticky-width="165" data-sticky-height="40" data-sticky-top="43" src="<?php echo base_url('asset/images/logo-uin.png')?>">
									</a>
								</div>
							</div>
							<div class="header-column">
								<div class="header-row ">
									<div class="heading heading-middle-border-reverse">
									
										<h3 class="mt-lg mb-md"><?php echo $unit->nama_unit?></h3>
									</div>	
								</div>
								<div class="header-row">
									
								<div class="header-row">
									<div class="header-nav">
										<button class="btn header-btn-collapse-nav mt-lg" data-toggle="collapse" data-target=".header-nav-main">
											<i class="fa fa-bars"></i>
										</button>
									
										<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1 collapse">
											
											<nav>
												<ul class="nav nav-pills" id="mainNav">
													<li>
														<div class="header-search hidden-xs">
														</div>
													</li>
												</ul>
											</nav>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>