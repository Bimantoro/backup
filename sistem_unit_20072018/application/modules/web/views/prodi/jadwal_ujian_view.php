<?php $lang = $this->page_lib->lang(); ?>
<div  class="article-content">
	<?php
		$arr_ju = array( 1 => ucwords(dict('UTS', $lang)), 2 => ucwords(dict('UAS', $lang)));
		$arr_smt = array( 1 => ucwords(dict('SEMESTER GASAL', $lang)), 2=> ucwords(dict('SEMESTER GENAP', $lang)), 3 => ucwords(dict('SEMESTER PENDEK', $lang)));
		$lang=$this->page_lib->lang();
	
	?>
	<h2 class="mb-xl heading-primary"><?php echo ucwords(dict('Jadwal Ujian', $lang)) ?> <?php echo $arr_smt[$smt] ?> <?php echo ucwords(dict('Tahun Akademik', $lang)) ?> <?php echo $tad?></h2>		
			<div class="clear20"></div>
					
				
<form class="form-horizontal" role="form" id="form" method="post" action="">
  <div class="form-group">
	<div class="col-sm-3 col-md-2"><strong><?php echo ucwords(dict('Tahun Akademik', $lang)) ?></strong></div>
    <div class="col-sm-6 col-md-4">
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
	</div>
	<div class="form-group">
		<div class="col-sm-3 col-md-2"><strong><?php echo ucwords(dict('Jenis Ujian', $lang)) ?></strong></div>
		<div class="col-sm-6 col-md-4">
			<select id="ju" name="ju" class="form-control input-sm">
				<?php 
				foreach($arr_ju as $a=>$val){
					if($a==$ju){
						echo"<option value='".$a."' selected>".$val."</option>";
					}else{
						echo"<option value='".$a."'>".$val."</option>";
					}
				}
				?>
			</select>
		</div>
		<div class="col-sm-1">
			<button class="btn btn-primary" type="submit"><?php echo ucwords(dict('Lihat Jadwal', $lang)) ?></button>
		</div>
	</div>
</form>			
	<div class="clear20"></div>		
					
	<?php 
	$arh=array('1'=>'Minggu','2'=>'Senin','3'=>'Selasa','4'=>'Rabu','5'=>'Kamis','6'=>"Jum'at",'7'=>"Sabtu");
	if(isset($arj) and $arj!=null){
		foreach($arj as $hari=>$jadwal){?>
			
			<h4 class="mt-xl heading-primary"><?php echo nama_hari($hari).', '.tanggal_indonesia($hari); ?></h4>
			<table width="100%" class="table table-bordered table-hover table-condensed">
				<thead>
					<tr>
					<th width="4%"><?php echo ucwords(dict('No', $lang)) ?></th>
					<th width="15%"><?php echo ucwords(dict('Jam', $lang)) ?></th>
					<th width="10%"><?php echo ucwords(dict('Ruang', $lang)) ?></th>
					<th width="30%"><?php echo ucwords(dict('Nama Mata Kuliah', $lang)) ?></th>
					<th width="6%"><?php echo ucwords(dict('Kelas', $lang)) ?></th>
					<th width="35%"><?php echo ucwords(dict('Dosen Pengampu', $lang)) ?></th>
					</tr>
				</thead>
				<tbody>	
				<?php 
			$i=0;
			$jadwal=msort($jadwal,array('jam','ruang'));
				foreach ($jadwal as $j){ ?>
					<tr><td><?php echo ++$i."." ?></td>
					<td align="center"><?php echo str_replace(' #','<br>',$j['jam']) ?></td>
					<td><?php echo $j['ruang'] ?></td>
					<td><?php echo $j['mk'] ?></td>
					<td align="center"><?php echo $j['kelas'] ?></td>
					<td>
						<?php 
							$ds=explode("+",$j['tim_ajar']); 
							echo $ds[1]."<br>(<a href='".site_url($lang.'/page/detil_dosen/'.$ds[0])."'><u>".format_nip($ds[0])."</u></a>)";
							?>
					</td>
					<?php } ?>
				</tbody>
			</table>
		<?php } ?>
	<?php }else{?>
	
	<div class="clear20"></div>
	<div style="text-align:center">
		<span class="tgl-post"><?php echo ucfirst(dict('Belum ada jadwal', $lang)) ?>.</span>
	</div>
	<?php } ?>
</div>
