<div  class="article-content">
	
	<div class="blog-posts single-post">

		<article class="post blog-single-post">									
			
			<div class="post-content">

				<h2 class="mb-none"><a href="blog-post.html"><?php echo $d->nama_agenda ?></a></h2>

				<div class="post-meta">
					<span><i class="fa fa-calendar"></i> <?php echo tgl_artikel($d->tgl_posting)?></span>
					<span class="pull-right"><?php echo ucfirst(dict('Dilihat', $lang)).' : '.$d->counter.' '.ucfirst(dict('Kali',$lang))?></span>
				</div>
				<?php
					$tgl_mulai = $d->tgl_mulai;
					$tgl_selesai = $d->tgl_selesai;
					$datetime = explode(" ", $tgl_mulai);
					$datetime2 = explode(" ", $tgl_selesai);
					$date = $datetime[0];
					$jam_mulai = $datetime[1];
					$jam_selesai = $datetime2[1];
				?>
				<table class="table">
					<tr><td><?php echo ucfirst(dict('Hari', $lang)) ?></td><td>:</td><td><?php echo nama_hari($d->tgl_mulai); if($d->tgl_selesai!=$d->tgl_mulai and $d->tgl_selesai!="0000-00-00") echo " ".separator()." ".nama_hari($d->tgl_selesai);?></td></tr>
					<tr><td><?php echo ucfirst(dict('Tanggal', $lang)) ?></td><td>:</td><td><?php echo tanggal_indonesia($d->tgl_mulai); if($d->tgl_selesai!=$d->tgl_mulai and $d->tgl_selesai!="0000-00-00") echo " ".separator()." ".tanggal_indonesia($d->tgl_selesai); ?></td></tr>
					<tr><td><?php echo ucfirst(dict('Jam', $lang)) ?></td><td>:</td><td><?php echo $jam_mulai; if($jam_selesai=="00:00:00"){ echo " ".separator()." 23:59:59";}else{echo " ".separator()." ".$jam_selesai;} ?> WIB</td></tr>
					<tr><td><?php echo ucfirst(dict('Tempat', $lang)) ?></td><td>:</td><td><?php echo $d->tempat ?></td></tr>
					<tr><td valign="top"><?php echo ucfirst(dict('Deskripsi', $lang)) ?></td><td valign="top"> : </td><td>
					<?php 
						if($d->deskripsi ==null){
							echo "-";
							}else{
								echo html_entity_decode($d->deskripsi);
						}?>
					</td></tr>
					
					<?php
					if($d->lampiran !=null){ ?>
					
<!-- 					<tr><td colspan='3'>
					<?php 
					if(isset($ext)){
					if($ext=='jpg' or $ext=='png'){?>
					<img class="img-thumbnail" src="<?php echo base_url().'media/gambar/'.$d->lampiran ?>" />
					<?php }else { ?>
				 <iframe width="100%" height="500" src="<?php echo base_url().'media/gambar/'.$d->lampiran ?>" ></iframe> 
				 <?php } }?>
				 </td></tr>
					<?php } 
					?> -->

					<?php
					if($d->lampiran !=null){ ?>
					
					<tr><td colspan='3'>
					<?php if(isset($ext) and $ext !=null){?>
					  <iframe width="100%" height="500" src="<?php echo base_url().'media/gambar/'.$d->lampiran ?>" ></iframe>  
					 <?php }else{ ?>

					 <img style="display:block; margin:auto;" src="http://static.uin-suka.ac.id/images/logo.png" />
					  <br>
					 <!-- <p style="text-align:center">File pengumuman bertipe <?php echo $filetype ?>.<br> Silakan klik tombol download untuk mengunduh file pengumuman tersebut.</p>   -->
					 <div class="clear10"></div>
					<?php } ?>
					<div class="col-md-12">
						<div class="row mb-xl pull-right">
							<a class="btn btn-primary"  href="<?php echo site_url('web/agenda/download/'.$d->id_agenda.'/'.url_title(strtolower($d->nama_agenda))) ?>"><i class="fa fa-arrow-circle-o-down"></i> <?php 	echo ucfirst(dict('Unduh', $lang)) ?></a> 
						</div>
					</div>
				 </td></tr>
					<?php } 
					?>
					
				</table>
			</div>
		</article>
		<div class="post-share">
			<!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox addthis_default_style ">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				<a class="addthis_button_tweet"></a>
				<a class="addthis_button_pinterest_pinit"></a>
				<a class="addthis_counter addthis_pill_style"></a>
			</div>
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50faf75173aadc53"></script>
			<!-- AddThis Button END -->
		</div>										

	</div>
	
	<div class="mt-lg">
		<div class="col-md-6">
			<h4><?php echo ucwords(dict('Agenda Terkait', $lang)) ?></h4>
			<ul class="list list-icons list-icons-sm">
			<?php foreach($rec as $r):?>
				<li><a href="<?php echo site_url($lang.'/agenda/detail/'.$r->id_agenda.'/'.url_title(strtolower($r->nama_agenda))) ?>"><i class="fa fa-caret-right"></i> <?php echo $r->nama_agenda ?></a></li>
			<?php endforeach ?>
			</ul>				
		</div>

		<div class="col-md-6">
			<h4><?php echo ucwords(dict('Agenda Terpopuler', $lang)) ?></h4>
			<ul class="list list-icons list-icons-sm">
			<?php
			foreach($pop as $r){?>
				<li><a href="<?php echo site_url($lang.'/agenda/detail/'.$r->id_agenda.'/'.url_title(strtolower($r->nama_agenda))) ?>"><i class="fa fa-caret-right"></i><?php echo $r->nama_agenda ?></a>
				<br><span style="font-size:80%"><?php echo tgl_artikel($d->tgl_posting)?></span>
				</li>
			<?php } ?>
			</ul>
		</div>
	</div>
</div>

