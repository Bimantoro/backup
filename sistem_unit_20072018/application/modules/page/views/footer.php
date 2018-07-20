
			<div class="clear5"></div>
			<div class="footer-underline">
				<div class="center">
					<div class="app-row">
						<div class="col-med-3">
							<a href="http://www.uin-suka.ac.id" target="_blank"><img src="http://static.uin-suka.ac.id/images/logo-white.png"/></a>
						</div>
						<div class="col-med-3">
							<div style="float:left" class="alamat">
								Jl. Marsda Adisucipto Yogyakarta 55281<br>
								 Telp. +62-274-512474, +62-274-589621<br>
								 Fax. +62-274-586117 <br>
								 Email. humas@uin-suka.ac.id
							</div>
						</div>
						<div class="col-med-3">
							<div class="sitemap" >
								<a href="">Peta Situs</a>
								&nbsp;&nbsp;|&nbsp;&nbsp;
								<a href="">Privasi & Kebijakan</a>
							</div>
						</div>
						<div class="col-med-3">	
							<div class="social-media">
								<a style="margin-left:6px; display:inline;" title="Google Plus"  href="http://gplus.to/uinsk" target="_blank"><img src="http://static.uin-suka.ac.id/images/icons/gplus.png" width="30" height="30"/></a>
								<a style="margin-left:7px; display:inline;" title="Facebook"  href="https://www.facebook.com/UINSK" target="_blank"><img src="http://static.uin-suka.ac.id/images/icons/facebook.png" width="30" height="30"/></a>
								<a style="margin-left:6px; display:inline;" title="Twitter" href="https://twitter.com/uinsk" target="_blank"><img src="http://static.uin-suka.ac.id/images/icons/twitter.png" width="30" height="30"/></a>
								<a style="margin-left:6px; display:inline;" title="Youtube" href="http://www.youtube.com/user/UINSK" target="_blank"><img src="http://static.uin-suka.ac.id/images/icons/youtube.png" width="30" height="30"/></a>
								<a style="margin-left:6px; display:inline;" title="Instagram" href="http://www.instagram.com/uinsk" target="_blank"><img src="http://static.uin-suka.ac.id/images/icons/instagram.png" width="30" height="30"/></a>
								<a style="margin-left:6px; display:inline;" title="Foursquare" href="http://foursquare.com/uinsk" target="_blank"><img src="http://static.uin-suka.ac.id/images/icons/foursquare.png" width="30" height="30"/></a>
							</div>
						</div>
					</div>	
					<div class="clear20"></div><?php
		 $data=file_get_contents("http://www.uin-suka.ac.id/index.php/service/footer2");
		 $data=json_decode($data);
		 echo $data->content;
	
	?>