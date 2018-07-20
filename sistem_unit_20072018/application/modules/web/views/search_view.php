<div  class="article-content">
<?php $lang=$this->page_lib->lang(); ?>	
	<?php foreach($cari->result() as $d){ ?>
		<div class="news-list">
		
		<h4 class="mb-xl heading-primary"><?php echo $d->tipe ?></h4>
		<?php
			$url="";
			switch ($d->tipe) {
				case 'Berita':
					$url=site_url($lang.'/berita/detail/'.$d->id.'/'.url_title(strtolower($d->judul)));
					break;
				case 'Kolom':
					$url=site_url($lang.'/kolom/detail/'.$d->id.'/'.url_title(strtolower($d->judul)));
					break;
				case 'Agenda':
					$url=site_url($lang.'/agenda/detail/'.$d->id.'/'.url_title(strtolower($d->judul)));
					break;
				case 'Pengumuman':
					$url=site_url($lang.'/pengumuman/detail/'.$d->id.'/'.url_title(strtolower($d->judul)));
					break;
			}
			?>
			<div class="mb-none heading-primary">
				<a href="<?php echo $url ?>"><?php echo $d->judul ?></a>
			</div>

				<div class="post-meta mb-xl">
					<span><i class="fa fa-calendar"></i> <?php echo nama_hari($d->tanggal).', '.tanggal_indonesia($d->tanggal)?> WIB
					<span class="page_counter">Dilihat :  <?php echo $d->counter ?> kali</span>
				</div>
			
			</div>
		<?php } ?>
		<div class="cleaner_h20"></div>
		<div class="pagination pull-right">
		<?php
		echo $this->pagination->create_links();
		?>
		</div>
</div>