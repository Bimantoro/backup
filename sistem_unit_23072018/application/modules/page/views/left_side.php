<div id="content-left">
<div class="bg-sidebar">
	<div class="head-sidebar">Info Jurusan / Program Studi</div>
	<nav class="accordion">
		<ul>
		<?php
		$menu=$this->page_model->get_side_menu();
		?>
		<?php foreach($menu as $d){ ?>
		<li><a class='item' href="<?php echo site_url($d->url) ?>"><?php echo $d->title ?></a></li>
		<?php } ?>
		</ul>
	</nav>	
	<div class="clear10"></div>	
</div>
<div class="clear10"></div>	

<div class="bg-sidebar">
<div class="head-sidebar">Fasilitas</div>
<nav class="accordion">
	<ul>
	<?php
	
	$f = $this->page_model->select_fasilitas();
	foreach($f as $f){
	echo"<li><a class='item' href='".$f->url."' title='".$f->nama_fasilitas."' target='_self'>".$f->nama_fasilitas."</a></li>";
	}
	?>
		</ul>
	</nav>	
	<div class="clear10"></div>	
</div>
<div class="clear10"></div>	

<div class="bg-sidebar">
<div class="head-sidebar">Unit</div>
<nav class="accordion">
<ul>
	<?php
	
	$up = $this->page_model->get_units();
	foreach($up as $up){
		if($up->menu_url !=null){
			echo"<li><a class='item' href='".site_url($up->menu_url)."' title='".$up->nama_unit."'>".$up->nama_unit."</a></li>";
		}else{
			echo"<li><a class='item' href='".site_url('page/unit/'.$up->id_unit.'-'.url_title($up->nama_unit))."' title='".$up->nama_unit."'>".$up->nama_unit."</a></li>";
		}
	}
	?>
		</ul>
	</nav>	
	<div class="clear10"></div>	
</div>
<div class="clear10"></div>	

</div>