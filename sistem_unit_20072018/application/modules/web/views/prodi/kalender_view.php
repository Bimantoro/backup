<div  class="article-content">					
<?php $lang = $this->page_lib->lang(); ?>				
			<?php
				$arr_ju = array( 1 => ucwords(dict('UTS', $lang)), 2 => ucwords(dict('UAS', $lang)));
				$arr_smt = array( 1 => ucwords(dict('SEMESTER GASAL', $lang)), 2=> ucwords(dict('SEMESTER GENAP', $lang)), 3 => ucwords(dict('SEMESTER PENDEK', $lang)));
			
			?>
	<h2 class="mb-xl heading-primary"><?php echo ucwords(dict('Kalender Akademik', $lang)) ?> <?php echo $arr_smt[$smt] ?> <?php echo ucwords(dict('Tahun Akademik', $lang)) ?> <?php echo $tad?></h2>	
		<div class="clear20"></div>
			<form class="form-horizontal" role="form" id="form" method="post" action="">
			  <div class="form-group">
				
				<div class="col-sm-3 col-md-2"><strong><?php echo ucwords(dict('Tahun Akademik', $lang)) ?></strong></div>
				<div class="col-sm-6 col-md-4">
					<select id="ta" name="ta" class="form-control input-sm">
						<?php 
						for($a=$cta; $a>=2005; $a--){
							if($a==$ta){
								echo"<option value='".$a."' selected>".$a."/".($a+1)."</option>";
							}else{
								echo"<option value='".$a."'>".$a."/".($a+1)."</option>";
							}
						}
						?>
					</select>
				</div>
			  </div>
				<div class="form-group">
					<div class="col-sm-3 col-md-2"><strong><?php echo ucwords(dict('Semester', $lang)) ?></strong></div>
					<div class="col-sm-6 col-md-4">
						<select id="smt" name="smt" class="form-control input-sm">
									<?php 
									foreach($arr_smt as $a=>$val){
										if($a==$smt){
											echo"<option value='".$a."' selected>".$val."</option>";
										}else{
											echo"<option value='".$a."'>".$val."</option>";
										}
									}
									?>
						</select>
					</div>
					<div class="col-sm-1">
						<button class="btn btn-primary" type="submit"><?php echo ucwords(dict('Tampilkan', $lang)) ?></button>
					</div>
				</div>
			</form>	
			<div class="clear20"></div>	
		<?php 
		$arh=array('1'=>'Minggu','2'=>'Senin','3'=>'Selasa','4'=>'Rabu','5'=>'Kamis','6'=>"Jum'at",'7'=>"Sabtu",'8'=>'Minggu');
		//print_r($kalender);
		?>
		<table width="100%" class="table table-bordered table-hover table-condensed">
			<thead>
				<tr>
				<th width="5" align="right"><?php echo ucwords(dict('No', $lang)) ?></th>
				<th width="55%"><?php echo ucwords(dict('Kegiatan', $lang)) ?></th>
				<th width="40%"><?php echo ucwords(dict('Tanggal', $lang)) ?></th>
				</tr>
			</thead>
			<tbody>	
				<?php $i=0; ?>
				<?php foreach($dk as $d){ ?>
					<tr><td><?php echo ++$i ?></td><td><?php echo $d->kegiatan ?></td><td><?php echo tgl_periode($d->tgl_mulai, $d->tgl_selesai); ?></td></tr>
				<?php } ?>
			</tbody>
		</table>
</div>
