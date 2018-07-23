<?php $lang=$this->page_lib->lang(); ?>	
<?php
	$arr_ad = array( 2 => ucwords(dict('Semua', $lang)), 0 => ucwords(dict('Dosen Dalam Program Studi', $lang)), 1 => ucwords(dict('Dosen Luar Program Studi', $lang)));
	$arr_jd = array( 2 => ucwords(dict('Semua', $lang)), 0 => ucwords(dict('Dosen Tetap PNS', $lang)), 1 => ucwords(dict('Dosen Luar Biasa', $lang)));
	$arr_sd = array( 2 => ucwords(dict('Semua', $lang)), 0 => ucwords(dict('Aktif Mengajar', $lang)), 1 => ucwords(dict('Tidak Aktif Mengajar', $lang)));

?>	
		
<form class="form-horizontal" role="form" id="form" method="post" action="<?php echo site_url($lang.'/page/dosen')?>">
  <div class="form-group">
	<div class="col-sm-3 col-md-2"><strong><?php echo ucwords(dict('Asal Dosen', $lang)) ?></strong></div>
    <div class="col-sm-6 col-md-4">
      	<select id="asal_dosen" name="asal_dosen" class="form-control input-sm">
					<?php 
					foreach($arr_ad as $a=>$val){
						if($a==$asal_dosen){
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
	<div class="col-sm-3 col-md-2"><strong><?php echo ucwords(dict('Jenis Dosen', $lang)) ?></strong></div>
    <div class="col-sm-6 col-md-4">
      	<select id="jenis_dosen" name="jenis_dosen" class="form-control input-sm">
			<?php 
			foreach($arr_jd as $a=>$val){
				if($a==$jd){
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
	<div class="col-sm-3 col-md-2"><strong><?php echo ucwords(dict('Status Dosen', $lang)) ?></strong></div>
    <div class="col-sm-6 col-md-4">
      	<select id="status_dosen" name="status_dosen" class="form-control input-sm">
			<?php 
			foreach($arr_sd as $a=>$val){
				if($a==$sd){
					echo"<option value='".$a."' selected>".$val."</option>";
				}else{
					echo"<option value='".$a."'>".$val."</option>";
				}
			}
			?>
		</select>
    </div>
    <div class="col-sm-1">      	
		<button class="btn btn-primary" type="submit"><?php echo ucwords(dict('Lihat Dosen', $lang)) ?></button>
    </div>
  </div>
  </form>