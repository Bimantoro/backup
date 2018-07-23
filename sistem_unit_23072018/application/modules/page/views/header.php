<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		  <?php 
		if(isset($title)){
			echo "<title>".$title."</title>";
			echo"<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
			echo" <meta content='".$title."' name='description'/>";
		}else{
			echo"<title>".get_nm_prodi()." UIN Sunan Kalijaga</title>";
			echo" <meta content='UIN Sunan Kalijaga' name='description'/>";
		}
		?>
		<link href="http://static.uin-suka.ac.id/images/favicon.png" type="image/x-icon" rel="shortcut icon">
		<link href="http://static.uin-suka.ac.id/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="http://static.uin-suka.ac.id/css/style_global.css" rel="stylesheet" type="text/css"/>
		<link href="http://static.uin-suka.ac.id/css/style_layout.css" rel="stylesheet" type="text/css"/>
		<link href="http://static.uin-suka.ac.id/css/docs.css" rel="stylesheet" type="text/css"/>
		
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro">

		<script src="http://static.uin-suka.ac.id/js/jquery-1.8.1.js"></script>
		<link href="http://static.uin-suka.ac.id/css/web_menu.css" rel="stylesheet" type="text/css"/>
		<link href="http://static.uin-suka.ac.id/css/web_style.css" rel="stylesheet" type="text/css"/>

	<!--BREADCRUMB-->
		<link href="http://static.uin-suka.ac.id/css/breadcrumb.css" rel="stylesheet" type="text/css"/>
	<!--=====-->
				
	</head>
    <body>
		<div class="app_header-top"></div>
		<div class="app_main">
			<div class="app_header">
				<div class="center">
					<div class="app_uin_id">
						<a href="<?php echo base_url()?>" ></a>
					</div>
					<div class="app_header_right">
						<div style="text-align:right; margin-top:-15px;">
							<div>
								<div class="app_system_id"><?php echo get_nm_prodi()?></div>
							</div>
							<div class="clear5"></div>
							<div>
							<form class="searchform" action="<?php echo site_url('page/search')?>" method="post">
								<input class="searchfield" type="text" name="cari" value="Kata kunci..." onfocus="if (this.value == 'Kata kunci...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Kata kunci...';}" />
								<button class="searchbutton">Cari</button>
							</form>
							</div>
									
							<div class="menutama-button">
								
						
		
		<ul id="menu">
			<?php
				$mm=$this->db->where(array('active'=>'Y','parent_id'=>0))->order_by('menu_order','asc')->GET('page_menu')->result();
				$i=0;
				foreach($mm as $mm){
					++$i;
						if($i==4){
							$sm=$this->db->query("SELECT id_unit,nama_unit,menu_url FROM unit  order by unit_order asc" )->result();
							
							echo"<li><a href='".site_url($mm->url)."' class='drop'>".$mm->title."</a>";  
							echo"<div class='dropdown_2columns align_right'>";	
							echo" <ul>";
							$j=0;
							foreach($sm as $sm){
							++$j;
								if($sm->menu_url != null){
									echo"<li><a href='".$sm->menu_url."' target='_blank'>".$sm->nama_unit."</a></li>";
								}else{
									echo"<li><a href='".site_url('page/unit/'.$sm->id_unit.'-'.url_title($sm->nama_unit))."'>".$sm->nama_unit."</a></li>";
								}	
								if($j%9==0){
									echo"</ul></div><div class='col'><ul>";
								}
								
							}
							echo"</ul>";
							echo"</div>";
							echo"</li>";
						}else if($i==3){
							$sm=$this->db->query("SELECT id_fasilitas,nama_fasilitas,url FROM fasilitas" )->result();
							
							echo"<li><a href='".site_url($mm->url)."' class='drop'>".$mm->title."</a>";  
							echo"<div class='dropdown_2columns'>";	
							echo" <ul>";
							$j=0;
							foreach($sm as $sm){
							++$j;
								if($sm->url != null){
									echo"<li><a href='".$sm->url."' target='_blank'>".$sm->nama_fasilitas."</a></li>";
								}	
								if($j%9==0){
									echo"</ul></div><div class='col'><ul>";
								}
								
							}
							echo"</ul>";
							echo"</div>";
							echo"</li>";
						}else{
							$sm=$this->db->query("SELECT * FROM page_menu where active='Y' and parent_id='".$mm->id_menu."' order by menu_order asc" )->result();
							if(count($sm)>0){
								echo"<li><a href='".site_url($mm->url)."' class='drop'>".$mm->title."</a>"; 
											echo"<div class='dropdown_2columns'>";	
								echo" <ul>";
								$j=0;
								foreach($sm as $sm){
								++$j;
									if($sm->external == 1){
										echo"<li><a href='".$sm->url."' target='_blank'>".$sm->title."</a></li>";
									}else{
										echo"<li><a href='".site_url($sm->url)."'>".$sm->title."</a></li>";
									}	
									if($j%9==0){
										echo"</ul></div><div class='col'><ul>";
									}
									
								}
								echo"</ul>";
								echo"</div>";
								echo"</li>";
							}else{
								echo"<li><a href='".site_url($mm->url)."' class='drop'>".$mm->title."</a></li>";    
							}
					}
			?>  					
				

	  <?php } ?>
			</ul>
								</div>
						</div>
					</div>
				<div class="clear"></div>
		
				
				</div>
			</div>
					