<!DOCTYPE html>
<html>
	<head>
		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title>UIN Sunan Kalijaga</title>	

		<meta name="keywords" content="HTML5 Template" />
		<meta name="description" content="Porto - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

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
		<script src="<?php echo base_url()?>asset/porto/vendor/modernizr/modernizr.min.js"></script>
		
		<!-- Datatables -->
		<script src="<?php echo base_url()?>asset/datatables-bootstrap/js/jquery.min.js"></script>
		 <script type="text/javascript" src="<?php echo base_url()?>/asset/scripts/jquery-1.10.1.min.js"></script>
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
							<ul class="header-social-icons social-icons hidden-xs">
								<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
								<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
								<li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
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
										<h3 class="mt-lg mb-md">UIN Sunan Kalijaga</h3>
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
												<!--
													
													-->
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

			<div role="main" class="main">

				<section class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="<?php echo base_url();?>">Home</a></li>
									<li class="active"><?php echo $title?></li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1><?php echo $title?></h1>
							</div>
						</div>
					</div>
				</section>

				<div class="container">

					<div class="row">
						<div class="col-md-12">

							<div class="featured-boxes">
								<div class="row">
									<div class="col-sm-6">
										<div class="featured-box featured-box-primary align-left mt-xlg">
											<div class="box-content">
												<form  id="frmSignIn" method="post" action="<?php echo base_url('index.php/admin/login/validate_credentials/'); ?>">
													<div class="row">
														<div class="form-group">
															<div class="col-md-12">
																<input type="text" value="" class="form-control input-lg" placeholder="Username" name="username">
																<span style="color:red;"><?php /* echo  form_error('username') */  ?></span>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="form-group">
															<div class="col-md-12">
																<input type="password" value="" class="form-control input-lg" placeholder="Password" name="password">
																<span style="color:red;"><?php /* echo form_error('password') */ ?></span>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="form-group">
															<div class="col-md-12">
																<span style="color:red;"><?php echo $pesan; ?></span>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 pull-right">
															<input type="submit" value="Login" class="btn btn-primary pull-right mb-xl" data-loading-text="Loading...">
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>

				</div>

			</div>

			<?php $this->load->view('admin/footer'); ?>
		</div>

		<!-- Vendor -->
		<script src="<?php echo base_url()?>asset/porto/vendor/jquery/jquery.min.js"></script>
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
		<script src="<?php echo base_url()?>asset/porto/js/views/view.contact.js"></script>
		
		<!-- Theme Custom -->
		<script src="<?php echo base_url()?>asset/porto/js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?php echo base_url()?>asset/porto/js/theme.init.js"></script>

		<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
			ga('create', 'UA-12345678-1', 'auto');
			ga('send', 'pageview');
		</script>
		 -->

	</body>
</html>
