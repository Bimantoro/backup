<!DOCTYPE html>
<html>
	<head>
		
		<?php
			$lang=$this->page_lib->lang();
			//$lang='id';
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
		


		<?php

		$temp = $unit->nama_unit.' UIN Sunan Kalijaga Yogyakarta';

		if(isset($title)){
			$temp = $title.' ('.$temp.')';
		}else if(isset($page[0])){
				$temp = $page[0]->title.' '.$temp;
		}

		?> 

		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title><?php echo $unit->nama_unit?> UIN Sunan Kalijaga Yogyakarta</title>	


		<meta name="keywords" content="<?php echo $temp; ?>" />
		<meta name="description" content="<?php echo $temp; ?>">
		<meta name="author" content="<?php echo $dom.'.uin-suka.ac.id';?>">

		<meta property="og:image" content="<?php if(isset($icon)){echo $icon;}elseif(isset($gambar)){echo base_url('media/'.$folder.'/'.$gambar);}else{ echo "http://static.uin-suka.ac.id/images/logo.png";};?>"/>
		<meta property="og:title" content="<?php if(isset($title)){ $jml_string = strlen($title);if($jml_string > 0 && $jml_string<=65){$title = $title;}elseif($jml_string>65){$title = substr($title, 0, 65);} echo $title;}else{ echo "UIN Sunan Kalijaga Yogyakarta"; };?>"/>  
		<meta property="og:description" content="<?php if(isset($title)){ $jml_string = strlen($title);if($jml_string > 0 && $jml_string<=155){$title = $title;}elseif($jml_string>155){$title = substr($title, 0, 155);} echo $title;}else{ echo "UIN Sunan Kalijaga Yogyakarta"; };?>"/>

		<!-- Favicon -->
		<link rel="shortcut icon" href="http://static.uin-suka.ac.id/images/favicon.png" type="image/x-icon" />
		<link rel="apple-touch-icon" href="http://static.uin-suka.ac.id/images/favicon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

	
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
		<!-- Current Page CSS -->
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/vendor/rs-plugin/css/settings.css" media="screen">
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/vendor/rs-plugin/css/layers.css" media="screen">
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/vendor/rs-plugin/css/navigation.css" media="screen">
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/vendor/circle-flip-slideshow/css/component.css" media="screen">
		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo base_url()?>asset/porto/css/custom.css">

		<!-- Head Libs -->
		<script src="<?php echo base_url()?>asset/porto/vendor/modernizr/modernizr.min.js"></script>
		<script src="<?php echo base_url()?>asset/porto/vendor/jquery/jquery.min.js"></script>
	
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
									<a href="<?php echo base_url($lang)?>">
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

									<div class="header-search hidden-xs">
										<form class="searchform" action="<?php echo site_url('index.php/'.$lang.'/page/search')?>" method="post">
											<div class="input-group">
												<input type="text" class="form-control" name="cari"  id="cari" placeholder="Search..." required>
												<span class="input-group-btn">
													<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
												</span>
											</div>
										</form>
										<!-- <form class="searchform" action="<?php echo site_url('page/search')?>" method="post">
											<input class="searchfield" type="text" name="cari" value="Kata kunci..." onfocus="if (this.value == 'Kata kunci...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Kata kunci...';}" />
											<button class="searchbutton">Cari</button>
										</form> -->
									</div>
									<!-- <nav class="header-nav-top">
										<ul class="nav nav-pills">
											<li class="hidden-xs">
												<a href=""> > English </a>
											</li>
											<li class="hidden-xs">
												<a href=""> > Arabic </a>
											</li>
										</ul>
									</nav> -->
									<nav class="header-nav-top">
										<ul class="nav nav-pills">
										<?php $bahasa=$this->db->select('*')
												->from('bahasa')
												->where('kode_bahasa !=', $lang)
												->get()->result();
										?>
										<?php foreach($bahasa as $bhs):?>
											<li class="hidden-xs">
												<a href="<?php echo base_url(str_replace('id', '', $bhs->kode_bahasa))?>"><i class="fa fa-angle-right"></i> <?php echo $bhs->nama_bahasa ?></a>
											</li>
										<?php endforeach ?>	
										</ul>
									</nav>
									
									
									<!-- <nav class="header-nav-top">
										<ul class="nav nav-pills">
										<?php $bahasa=$this->db->select('*')
												->from('bahasa')
												->where('kode_bahasa !=', $lang)
												->get()->result();
										?>
										<?php foreach($bahasa as $bhs):?>
											<li class="hidden-xs">
												<a href="<?php echo base_url(str_replace('id', '', $bhs->kode_bahasa))?>"><i class="fa fa-angle-right"></i> <?php echo $bhs->nama_bahasa ?></a>
											</li>
										<?php endforeach ?>	
										</ul>
									</nav> -->
								<div class="header-row">
									<div class="header-nav">
										<button class="btn header-btn-collapse-nav mt-lg" data-toggle="collapse" data-target=".header-nav-main">
											<i class="fa fa-bars"></i>
										</button>
									
										<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1 collapse">
											<nav>
												<ul class="nav nav-pills" id="mainNav">
												<?php
													$menu_parent = $this->db->select('*')
														->from('menu')
														->where(array(
															'parent' => 0,
															'status' => 1,
															'kode_bahasa' => $lang,
															'kode_unit' => $unit->kode_unit ))
														->order_by('menu_order', 'asc')
														->get()
														->result();
													foreach ($menu_parent as $mp) {
														if ($mp->mega_content == 'Yes') {
															$menu_sub = $this->db->select('*')
																->from('menu')
																->where(array(
																	'parent' => $mp->id_menu,
																	'sub_mega_content' => 0,
																	'status' => 1))
																->order_by('menu_order', 'asc')
																->get()
																->result();
												?>
													<li class="dropdown dropdown-mega">
														<a href="<?php echo ($mp->jenis_url == 'Eksternal')? 'http://'.str_replace(array('http://', 'https://'), '', $mp->url):site_url($lang.'/'.$mp->url) ?>" class="<?php echo (!empty($menu_sub))? 'dropdown-toggle':'' ?>" target="<?php echo $mp->target ?>"><?php echo $mp->nama_menu ?></a>
														<ul class="dropdown-menu">
															<li>
																<div class="dropdown-mega-content">
																	<div class="row">
												<?php
															if (!empty($menu_sub)) {
																foreach ($menu_sub as $ms) {
																	echo '
																		<div class="col-md-4">
																			<span class="dropdown-mega-sub-title">'.$ms->nama_menu.'</span>
																			<ul class="dropdown-mega-sub-nav">
																	';
																	$menu_mega = $this->db->select('*')
																		->from('menu')
																		->where(array(
																			'sub_mega_content' => $ms->id_menu,
																			'status' => 1))
																		->order_by('menu_order', 'asc')
																		->get()
																		->result();
																	foreach ($menu_mega as $mm) {
																		$url_m = ($mm->jenis_url == 'Eksternal')? 'http://'.str_replace(array('http://', 'https://'), '', $mm->url):site_url($lang.'/'.$mm->url);
																		echo '<li><a href="'.$url_m.'" target="'.$mm->target.'">'.$mm->nama_menu.'</a></li>';
																	}
																	echo '
																			</ul>
																		</div>
																	';
																}
															}
												?>
																	</div>
																</div>
															</li>
														</ul>
													</li>
												<?php
														}
														else {
															$menu = $this->db->select('*')
																->from('menu')
																->where(array(
																	'parent' => $mp->id_menu,
																	'status' => 1))
																->order_by('menu_order', 'asc')
																->get()
																->result();
												?>
													<li class="dropdown">
														<a href="<?php echo ($mp->jenis_url == 'Eksternal')? 'http://'.str_replace(array('http://', 'https://'), '', $mp->url):site_url($lang.'/'.$mp->url) ?>" class="<?php echo (!empty($menu))? 'dropdown-toggle':'' ?>" target="<?php echo $mp->target ?>"><?php echo $mp->nama_menu ?></a>
												<?php
															if (!empty($menu)) {
																echo '<ul class="dropdown-menu">';
																foreach ($menu as $m) {
																	$url_m = ($m->jenis_url == 'Eksternal')? 'http://'.str_replace(array('http://', 'https://'), '', $m->url):site_url($lang.'/'.$m->url);
																	echo '<li><a href="'.$url_m.'" target="'.$m->target.'">'.$m->nama_menu.'</a></li>';
																}
																echo '</ul>';
															}
												?>
														
													</li>
												<?php
														}
													}
												?>
											</nav>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>