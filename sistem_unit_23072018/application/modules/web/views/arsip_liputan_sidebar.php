<?php $lang=$this->page_lib->lang(); ?>	
<aside class="sidebar">
	<?php
		$arb=array('Bulan','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	?>
	<h4 class="mt-xl heading-primary"><?php echo ucwords(dict('Arsip Liputan', $lang)) ?></h4>
	<?php
		$arsip_liputan=$this->page_model->arsip_liputan();
		$ars_b=array();
		foreach($arsip_liputan as $ab){
			if(!isset($ars_b[$ab->tahun])) {
				$ars_b[$ab->tahun] = array();
			}

			 $ars_b[$ab->tahun][] = $ab;
		}
		
	?>
	<ul class="nav nav-list sort-source" id="accordion3">
	<?php foreach($ars_b as $tahun=>$d_ars):?>
			<li data-option-value=".websites">
				<a aria-expanded="false" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#liputan<?php echo $tahun?>">
					<?php echo $tahun ?>
				</a>
			</li>		
			<div style="height: 0px;" aria-expanded="false" id="liputan<?php echo $tahun?>" class="accordion-body collapse">
				<div class="panel-body">
				<ul class="nav nav-list mb-xl sort-source" data-sort-id="portfolio" data-option-key="filter" data-plugin-options='{"layoutMode": "fitRows", "filter": "*"}'>
					<?php foreach ($d_ars as $ab):?>
					<li><a href="<?php echo site_url($lang.'/liputan/index/0/'.$tahun.'/'.$ab->bulan)?>"><?php echo ucfirst(dict($arb[$ab->bulan], $lang)).' ('.$ab->jumlah.')' ?></a></li>
					<?php endforeach ?>
				</ul>	
				</div>
			</div>	
	<?php endforeach ?>			
	</ul>
</aside>