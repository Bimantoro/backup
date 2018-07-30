<?php foreach($penelitian as $p){} ?>

<?php 	 $error = $this->session->flashdata('error'); 
	if(isset($error)){?>
	<div class="alert alert-danger">
		<?php 	echo $error;?>
	</div><?php } ?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>

	<div class="form-group">
		<label class="col-md-3 " for="judul_penelitian">Judul Penelitian</label>
		<div class="col-md-6">
			<input required type="text" class="form-control" name="judul_penelitian" id="judul_penelitian" value="<?php echo $p->judul_penelitian?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 " for="bahasa">Bahasa</label>
		<?php $bhs=array('id'=>'Indonesia','en'=>'English','ar'=>'Arabic');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="bahasa" id="bahasa">
				<?php foreach($bhs as $ib=>$bs){
					if($ib==$p->kode_bahasa){
						echo"<option value='".$ib."' selected>".$bs."</option>";
					}else{	
					echo"<option value='".$ib."'>".$bs."</option>";
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 " for="jenis_penelitian">Jenis Penelitian</label>
		<div class="col-md-6">
			<input class="form-control" name="jenis_penelitian" id="jenis_penelitian" type="text" value="<?php echo $p->jenis_penelitian?>"></input>
		</div>
	</div>
	

	<div class="form-group">
		<label class="col-md-3" required for="tahun">Tahun</label>
		<?php for ($i=0; $i < 10; $i++) { $trg[]=date('Y')-$i; }?>
		<div class="col-md-2">			
			<select class="form-control mb-md" name="tahun" id="tahun">
				<?php foreach($trg as $t){?>
					<?php if($t == $p->tahun):?>
					<?php echo "<option value='".$t."' selected>".$t."</option>"?>
					<?php else :?>
					<?php echo "<option value='".$t."'>".$t."</option>"?>
					<?php endif?>
				<?php }
				?>
			</select>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-md-3"  for="url">Alamat Penelitian</label>
		<div class="col-md-6">
			<input type="text" required class="form-control" name="url" id="url" value="<?php echo $p->url?>">
		</div>
	</div>	


	<div class="form-group">
		<label class="col-md-3" for="anggota1" >Anggota Dosen/Staff</label>
		<div class="col-md-6">
			<input type="text" name="anggota1"  id="anggota1" class="form-control"  >	
			<!-- <textarea name="anggota1" id="anggota1"></textarea> -->
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" >Anggota Mahasiswa</label>
		<div class="col-md-6">
			<input type="text" name="anggota2" id="anggota2" class="form-control"/>	
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3"  >Anggota Luar</label>
		<div class="col-md-6">
			<input type="text" name="anggota3"  class="tm-input form-control tm-input-info"/>	
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 " for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>
</form>

	<script type="text/javascript">
		$(".tm-input").tagsManager();
	</script>
	
<style>
		.anggota input:focus{box-shadow:none;}
	</style>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#anggota1").tokenInput("<?php echo base_url('admin/penelitian/get_dosen') ?>",{tokenLimit:"5",
		<?php echo $anggota1; 	if(!empty($anggota1)){
				echo 'prePopulate:[';
					foreach($anggota1 as $key=>$val){
					echo '{id:"'.$key.'", name:"'.$val.'"},';
					}
				echo ']';
				}?> 
			});
		$("#anggota2").tokenInput("<?php echo base_url('admin/penelitian/get_mhs') ?>",{tokenLimit:"10",
		<?php 	if(!empty($anggota2)){
				echo 'prePopulate:[';
					foreach($anggota2 as $key=>$val){
					echo '{id:"'.$key.'", name:"'.$val.'"},';
					}
				echo ']';
				}?> });
	});
</script>



