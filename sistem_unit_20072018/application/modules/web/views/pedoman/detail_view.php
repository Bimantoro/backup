<?php $lang=$this->page_lib->lang(); ?>	
<div  class="article-content">

	<div class="blog-posts single-post">

		<article class="post blog-single-post">	
		
			
	<?php foreach($dokumen as $d){?>
	
	<div class="post-content">
				<h2 class="mb-none"><a><?php echo ucwords(dict($d->nama_dokumen, $lang))?></a></h2>
				<div class="post-meta">
					<span><i class="fa fa-calendar"></i> <?php echo tgl_artikel($d->tgl_posting)?></span>
					
				</div>
				<div style="clear:both;"></div>	
				</div>
			<?php if(isset($d) and $d !=null){?>
					<iframe width="100%" height="500" src="<?php echo base_url().'media/dokumen_akademik/'.$d->nama_file ?>" ></iframe> 
				 <?php }else{ ?>

				 <img style="display:block; margin:auto;" src="http://static.uin-suka.ac.id/images/logo.png" />
				  <br>
				 <!-- <p style="text-align:center">File pengumuman bertipe <?php echo $filetype ?>.<br> Silakan klik tombol download untuk mengunduh file pengumuman tersebut.</p>   -->
				 <div class="clear10"></div>
				<?php } ?>
				<div class="col-md-12">
					<div class="row mb-xl pull-right">
						<a class="btn btn-primary"  href="<?php echo site_url($lang.'/page/pedoman_akademik/'.$d->id_dokumen) ?>"><i class="fa fa-arrow-circle-o-down"></i> <?php echo ucwords(dict('Unduh', $lang)) ?></a> 
					</div>
				</div>
			<!-- <a class="btn-uin btn btn-inverse btn btn-small" style="float:right"  href="<?php echo site_url('web/pengumuman/download/'.$d->id_pengumuman.'/'.url_title(strtolower($d->nama_pengumuman))) ?>"><i class="btn-uin"></i>Download</a>  -->
	<?php } ?>
	
				 <div class="clear10"></div>
			<!-- <div class="fb-like" data-href="<?php echo site_url('web/pengumuman/detail/'.$d->id_pengumuman.'/'.url_title(strtolower($d->judul))) ?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div> -->
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
		</article>
	</div>
	

