<div  class="article-content">
	<div class="article-title">Visi - Misi - Tujuan</div>
	<div class="clear10"></div>
	<div class="isi">
	<?php 
	foreach($profil as $p){ ?>
		<?php if($p['VISI_INA']){?>
			<div style="font-size:14px; font-weight:bold;">VISI</div>
			<?php echo $p['VISI_INA'] ?>
		<?php } ?>
		<?php if($p['MISI_INA']){?>
			<div style="font-size:14px; font-weight:bold;">MISI</div>
			<?php echo $p['MISI_INA'] ?>
		<?php } ?>
		<?php if($p['TUJU_INA']){?>
			<div style="font-size:14px; font-weight:bold;">TUJUAN</div>
			<?php echo $p['TUJU_INA'] ?>
		<?php } ?>
	<?php } ?>
	</div>
</div>			
		
			
