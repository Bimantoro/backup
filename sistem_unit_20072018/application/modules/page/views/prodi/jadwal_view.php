<div  class="article-content">					
				
			<?php
				$arr_ju = array( 1 => 'UTS', 2 => 'UAS');
				$arr_smt = array( 1 => 'SEMESTER GASAL', 2=> 'SEMESTER GENAP', 3 => 'SEMESTER PENDEK');
			
			?>
				
		<div class="article-title">Jadwal Kuliah <?php echo $arr_smt[$smt] ?> Tahun Akademik <?php echo $tad?></div>
				<div class="clear20"></div>
				
							
			<form class="form-horizontal" role="form" id="form" method="post" action="">
			  <div class="form-group">
				<label for="ta" class="col-sm-3 control-label">Tahun Akademik</label>
				<div class="col-sm-6">
					<select id="ta" name="ta" class="form-control input-sm">
						<?php 
						for($a=$cta; $a>=2006; $a--){
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
						<button  class="btn-uin btn btn-inverse btn btn-small" type="submit" style="height:25px; margin-left:-20px;" >Lihat Jadwal</button>
					</div>
				</div>
			</form>	
			<div class="clear20"></div>	
		<?php 
		$arh=array('1'=>'Minggu','2'=>'Senin','3'=>'Selasa','4'=>'Rabu','5'=>'Kamis','6'=>"Jum'at",'7'=>"Sabtu",'8'=>'Minggu');
			foreach($arj as $hari=>$jadwal){?>
			<h5 style="margin-bottom:5px; color: rgb(164, 136, 74);">Hari : <?php echo $arh[$hari]?></h5>
		<table width="100%" class="table table-bordered table-hover table-condensed">
			<thead>
				<tr>
				<th width="4%">No</th>
				<th width="15%">Jam</th>
				<th width="10%">Ruang</th>
				<th width="30%">Nama Mata Kuliah</th>
				<th width="6%">Kelas</th>
				<th width="35%">Dosen Pengampu</th>
				</tr>
			</thead>
			<tbody>	
			<?php 
		$i=0;
		$jadwal=msort($jadwal,array('jam','ruang'));
			foreach ($jadwal as $j){ ?>
				<tr><td align="right"><?php echo ++$i ?></td>
				<td align="center"><?php echo str_replace(' #','<br>',$j['jam']) ?></td>
				<td><?php echo $j['ruang'] ?></td>
				<td><?php echo $j['mk'] ?></td>
				<td align="center"><?php echo $j['kelas'] ?></td>
				<td>
					<?php 
						$ds=explode("+",$j['tim_ajar']); 
						echo $ds[1]."<br>(<a href='".site_url('page/detil_dosen/'.$ds[0])."'><u>".format_nip($ds[0])."</u></a>)";
						?>
				</td>
				<?php } ?>
			</tbody>
		</table>
		<?php } ?>
</div>
