<div  class="article-content">					
				
			<?php
				$arr_ju = array( 1 => 'UTS', 2 => 'UAS');
				$arr_smt = array( 1 => 'SEMESTER GASAL', 2=> 'SEMESTER GENAP', 3 => 'SEMESTER PENDEK');
			
			?>
				
	<div class="article-title">Kalender Akademik <?php echo $arr_smt[$smt] ?> Tahun Akademik <?php echo $tad?></div>
		<div class="clear20"></div>
			<form class="form-horizontal" role="form" id="form" method="post" action="">
			  <div class="form-group">
				<label for="ta" class="col-sm-3 control-label">Tahun Akademik</label>
				<div class="col-sm-6">
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
					<label for="smt" class="col-sm-3 control-label">Semester </label>
					<div class="col-sm-6">
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
						<button  class="btn-uin btn btn-inverse btn btn-small" type="submit" style="height:25px; margin-left:-20px;" >Tampilkan</button>
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
				<th width="5" align="right">No</th>
				<th width="55%">Kegiatan</th>
				<th width="40%">Tanggal</th>
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
