
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
				

<div  class="article-content">
	<?php foreach($agenda->result() as $d){?>
						
			<div class="judul-artikel">
			<a href="<?php echo site_url('page/agenda/detail/'.$d->id_agenda.'/'.url_title(strtolower($d->nama_agenda))) ?>"><?php echo $d->nama_agenda ?>
			</div>
			<span class="tgl-post"><?php echo nama_hari($d->tgl_posting).', '.tanggal_indonesia($d->tgl_posting).' '.$d->jam_posting ?> WIB  <span class="page_counter">Dilihat :  <?php echo $d->counter ?> kali</span></span>
			<div class="social-sharing">
				<div class="social-button google">
					<div class="g-plus" data-annotation="bubble" data-action="share"></div>
				</div>
				<div class="social-button facebook">
					<div class="fb-share-button" data-href="<?php echo site_url('page/agenda/detail/'.$d->id_agenda.'/'.url_title(strtolower($d->nama_agenda))) ?>" data-type="button_count"></div>
				</div>
				<div class="social-button twitter">
					<a href="https://twitter.com/share" class="twitter-share-button" data-related="jasoncosta" data-lang="en" data-size="small" data-count="horizontal">Tweet</a>
				</div>	
				<div style="clear:both;"></div>	
			</div>
			
			
			<div class="isi">
			<table>
					<tr><td>Hari</td><td>:</td><td><?php echo nama_hari($d->tgl_mulai); if($d->tgl_selesai!=$d->tgl_mulai and $d->tgl_selesai!="0000-00-00") echo " s.d. ".nama_hari($d->tgl_selesai);?></td></tr>
					<tr><td>Tanggal</td><td>:</td><td><?php echo tanggal_indonesia($d->tgl_mulai); if($d->tgl_selesai!=$d->tgl_mulai and $d->tgl_selesai!="0000-00-00") echo " s.d. ".tanggal_indonesia($d->tgl_selesai); ?></td></tr>
					<tr><td>Jam</td><td>:</td><td><?php echo $d->jam_mulai; if($d->jam_selesai=="00:00:00"){ echo " s.d. 23:59:59";}else{echo " s.d. ".$d->jam_selesai;} ?> WIB</td></tr>
					<tr><td>Tempat</td><td>:</td><td><?php echo $d->tempat ?></td></tr>
					<tr><td valign="top">Deskripsi</td><td valign="top"> : </td><td><?php if($d->topik ==null){ echo "-"; } ?></td></tr>
					<?php
					if($d->topik !=null){ 
						echo"<tr><td colspan='3'>".html_entity_decode($d->topik)."</td></tr>"; 
					}
					?>
					
				</table>
			</div>
			
	<?php } ?>
	
	
			<div class="fb-like" data-href="<?php echo site_url('page/agenda/detail/'.$d->id_agenda.'/'.url_title(strtolower($d->nama_agenda))) ?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
			<div class="related-article left">
				<h4>Agenda Terkait</h4>
				<ul>
				<?php
				foreach($rec as $r){?>
					<li>
					<a href="<?php echo site_url('page/agenda/detail/'.$r->id_agenda.'/'.url_title(strtolower($r->nama_agenda))) ?>">
					<span class="tgl-post"><?php echo nama_hari($r->tgl_posting).', '.tanggal_indonesia($r->tgl_posting).' '.$r->jam_posting ?> WIB</span>
					<?php echo $r->nama_agenda ?></a></li>
				<?php } ?>
				</ul>
			</div>
			<div class="related-article right">
				<h4>Agenda Terpopuler</h4>
				<ul>
				<?php
				foreach($pop as $r){?>
					<li><a href="<?php echo site_url('page/agenda/detail/'.$r->id_agenda.'/'.url_title(strtolower($r->nama_agenda))) ?>">
					<span class="tgl-post"><?php echo nama_hari($r->tgl_posting).', '.tanggal_indonesia($r->tgl_posting).' '.$r->jam_posting ?> WIB</span>
					<?php echo $r->nama_agenda ?></a></li>
				<?php } ?>
				</ul>
			</div>
	
	

</div>

