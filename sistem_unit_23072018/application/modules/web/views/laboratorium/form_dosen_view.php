
			<?php
				$arr_ad = array( 2 => 'Semua', 0 => 'Dosen Dalam Program Studi', 1 => 'Dosen Luar Program Studi',);
				$arr_jd = array( 2 => 'Semua', 0 => 'Dosen Tetap PNS', 1 => 'Dosen Luar Biasa',);
				$arr_sd = array( 2 => 'Semua', 0 => 'Aktif Mengajar', 1 => 'Tidak Aktif Mengajar',);
			
			?>
	
	<?php $lang=$this->page_lib->lang(); ?>			
<form class="form-horizontal" role="form" id="form" method="post" action="<?php echo site_url($lang.'/page/dosen')?>">
  <div class="form-group">
	<div class="col-sm-3 col-md-2"><strong>Asal Dosen</strong></div>
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
	<div class="col-sm-3 col-md-2"><strong>Jenis Dosen</strong></div>
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
	<div class="col-sm-3 col-md-2"><strong>Status Dosen</strong></div>
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
		<button class="btn btn-primary" type="submit">Lihat Dosen</button>
    </div>
  </div>
  </form>