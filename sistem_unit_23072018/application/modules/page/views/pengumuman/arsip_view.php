
<div  class="article-content">
	<?php foreach($pengumuman->result() as $p){ ?>
		<div class="news-list">
			<div class="judul-artikel">
			<?php
				if($p->nama_file!=null){
					echo"<a href='".base_url('page/pengumuman/detail/'.$p->id_pengumuman.'/'.url_title(strtolower($p->judul)))."'>".$p->judul."</a>";
				}else{						
					echo"<a href='".$p->url."' target='_blank'>".$p->judul."</a>";
				}
			  
			 ?>
				 
			</div>
			<span class="tgl-post"><?php echo nama_hari($p->tgl_posting).', '.tanggal_indonesia($p->tgl_posting).' '.$p->jam_posting ?> WIB <span class="page_counter">Dilihat :  <?php echo $p->counter ?> kali</span></span>
			<div class="clear10"></div>
			
		</div>
		<?php } ?>
	<div class="pagination">
		<?php
		echo $this->pagination->create_links();
		?>
	</div>
</div>