<div  class="article-content">
	<div class="article-title">Kompetensi dan Capaian</div>
	<div class="isi">
	<?php 
	foreach($profil as $p){ ?>
			<?php if($p['KOMP_INA']){?>
				<div class="judul-artikel">Kompetensi</div>
				<div class="clear5"></div>
				<?php echo $p['KOMP_INA'] ?>
			<?php } ?>
			<?php if($p['CAPA_INA']){?>
				<div class="judul-artikel">Capaian</div>
				<div class="clear5"></div>
				<?php echo $p['CAPA_INA'] ?>
			<?php } ?>
	<?php } ?>
	</div>
</div>			
		
			
