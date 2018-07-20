<div id="content-center">
	<script type="text/javascript">
		//GOOGLE
		  (function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = '<?php echo base_url()?>asset/social-media/google-platform.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
	</script>
	<script>
		//TWITTER
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="<?php echo base_url()?>asset/social-media/twitter-platform.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
	</script>
	<script>
		//FACEBOOK
		window.fbAsyncInit = function() {
			FB.init({
				  appId      : 'YOUR_APP_ID',                        // App ID from the app dashboard
				  status     : true,                                 // Check Facebook Login status
				  xfbml      : true                                  // Look for social plugins on the page
			});
		};
	  (function(){
		 // If we've already installed the SDK, we're done
		 if (document.getElementById('facebook-jssdk')) {return;}
		 // Get the first script element, which we'll use to find the parent node
		 var firstScriptElement = document.getElementsByTagName('script')[0];
		 // Create a new script element and set its id
		 var facebookJS = document.createElement('script'); 
		 facebookJS.id = 'facebook-jssdk';
		 // Set the new script's source to the source of the Facebook JS SDK
		 facebookJS.src = '<?php echo base_url()?>asset/social-media/facebook-platform.js';
		 // Insert the Facebook JS SDK into the DOM
		 firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);
	   }());
	  
	</script>
							
	<?php foreach($pengumuman as $d){?>
				<div class="article-title"><?php echo $d->judul?></div>
				<div class="tgl-post">
					<?php echo nama_hari($d->tgl_posting).', '.tanggal_indonesia($d->tgl_posting).' '.$d->jam_posting ?> WIB 
					<div class="page_counter">Dilihat : <?php echo $d->counter ?> kali</div>
				</div>
				<div class="social-sharing">
				<div class="social-button google">
					<div class="g-plus" data-annotation="bubble" data-action="share"></div>
				</div>
				<div class="social-button facebook">
					<div class="fb-share-button" data-href="<?php echo site_url('page/pengumuman/detail/'.$d->id_pengumuman.'/'.url_title(strtolower($d->judul))) ?>" data-type="button_count"></div>
				</div>
				<div class="social-button twitter">
					<a href="https://twitter.com/share" class="twitter-share-button" data-related="jasoncosta" data-lang="en" data-size="small" data-count="horizontal">Tweet</a>
				</div>	
				<div style="clear:both;"></div>	
				</div>
			<?php if(isset($ext) and $ext !=null){?>
				 <iframe width="100%" height="500" src="<?php echo base_url().'media/pengumuman/'.$d->nama_file ?>" ></iframe> 
				 <?php }else{ ?>

				 <img style="display:block; margin:auto;" src="http://static.uin-suka.ac.id/images/logo.png" />
				  <br>
				 <p style="text-align:center">File pengumuman bertipe <?php echo $filetype ?>.<br> Silakan klik tombol download untuk mengunduh file pengumuman tersebut.</p>  
				 <div class="clear10"></div>
				<?php } ?>
			<a class="btn-uin btn btn-inverse btn btn-small" style="float:right"  href="<?php echo site_url('page/pengumuman/download/'.$d->id_pengumuman.'/'.url_title(strtolower($d->judul))) ?>"><i class="btn-uin"></i>Download</a> 
	<?php } ?>
	
				 <div class="clear10"></div>
			<div class="fb-like" data-href="<?php echo site_url('page/pengumuman/detail/'.$d->id_pengumuman.'/'.url_title(strtolower($d->judul))) ?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
			
				<div class="related-article left">
				<h4>Pengumuman Terkait</h4>
				<ul>
				<?php
				foreach($rec as $r){?>
					<li>
					<a href="<?php echo site_url('page/pengumuman/detail/'.$r->id_pengumuman.'/'.url_title(strtolower($r->judul))) ?>">
					<span class="tgl-post"><?php echo nama_hari($r->tgl_posting).', '.tanggal_indonesia($r->tgl_posting).' '.$r->jam_posting ?> WIB</span>
					<?php echo $r->judul ?></a></li>
				<?php } ?>
				</ul>
			</div>
			<div class="related-article right">
				<h4>Pengumuman Terpopuler</h4>
				<ul>
				<?php
				foreach($pop as $r){?>
					<li><a href="<?php echo site_url('page/pengumuman/detail/'.$r->id_pengumuman.'/'.url_title(strtolower($r->judul))) ?>">
					<span class="tgl-post"><?php echo nama_hari($r->tgl_posting).', '.tanggal_indonesia($r->tgl_posting).' '.$r->jam_posting ?> WIB</span>
					<?php echo $r->judul ?></a></li>
				<?php } ?>
				</ul>
			</div>
	
</div>

