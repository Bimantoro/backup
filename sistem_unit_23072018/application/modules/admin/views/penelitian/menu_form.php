<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">

<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data' >
	<?php  $spasi ='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';	 
	$error = $this->session->flashdata('error'); 
	if(!empty($error)){?>
	<div class="alert alert-danger">
		<?php 	echo $error;?>
	</div><?php } ?>
	<div class="form-group">
		<label  class="col-md-3 " for="judul_penelitian">Judul Penelitian</label>
		<div class="col-md-6">
			<input required type="text" class="form-control" name="judul_penelitian" id="judul_penelitian">
		</div>
	</div>
	<b>Peneliti Utama</b>
	<div class="form-group" id="futama1">
		<label class="col-md-3" for="utama1" ><?php echo $spasi; ?>- Dosen/Staff</label>
		<div class="col-md-6">
			<input type="text" name="utama1"  id="utama1" class="form-control"/>	
			<!-- <textarea name="anggota1" id="anggota1"></textarea> -->
		</div>
	</div>
	<div class="form-group" id="futama2">
		<label class="col-md-3" ><?php echo $spasi; ?>- Mahasiswa</label>
		<div class="col-md-6">
			<input type="text" name="utama2" id="utama2" class="form-control"/>	
		</div>
	</div>
	<hr><b>Anggota Peneliti</b>
	<div class="form-group">
		<label class="col-md-3" for="anggota1" ><?php echo $spasi; ?>- Dosen/Staff</label>
		<div class="col-md-6">
			<input type="text" name="anggota1"  id="anggota1" class="form-control"/>	
			<!-- <textarea name="anggota1" id="anggota1"></textarea> -->
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" ><?php echo $spasi; ?>- Mahasiswa</label>
		<div class="col-md-6">
			<input type="text" name="anggota2" id="anggota2" class="form-control"/>	
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3"  ><?php echo $spasi; ?>- Luar</label>
		<div class="col-md-6">
			<input type="text" name="anggota3"  class="tm-input form-control tm-input-info"/>	
			<label style="color:grey;font-size: 12px;">*Jika lebih dari 1 anggota, gunakan titik koma ";" untuk memisahkannya. Contoh : Huda; Lidia</label>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-3 " for="bahasa">Bahasa</label>
		<?php $bhs=array('id'=>'Indonesia','en'=>'English','ar'=>'Arabic');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="bahasa" id="bahasa">
				<?php foreach($bhs as $ib=>$bs){
					echo"<option value='".$ib."'>".$bs."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 " for="jenis_penelitian">Jenis Penelitian</label>
		<div class="col-md-6">
			<input class="form-control" name="jenis_penelitian" id="jenis_penelitian" type="text"></input>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" required for="tahun">Tahun</label>
		<?php for ($i=0; $i < 10; $i++) { $trg[]=date('Y')-$i; }?>
		<div class="col-md-2">			
			<select class="form-control mb-md" name="tahun" id="tahun">
				<?php foreach($trg as $t=>$tg){
					echo"<option value='".$tg."'>".$tg."</option>";
				}
				?>
			</select>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-md-3"  for="url">URL</label>
		<div class="col-md-6">
			<input type="text" required class="form-control" name="url" id="url">
			<!-- <label style="color:grey;" class="ml-xl">Contoh : https://www.uin-suka.ac.id</label> -->

		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 " for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>

</form>


<style>
	.anggota input:focus{box-shadow:none;}
</style>
<script type="text/javascript">
	function masukan(){
		var temp1 = $("#utama1").val();
		var temp2 = $("#utama2").val();
		var pjg1 = temp1.length;
		var pjg2 = temp2.length;
		if (pjg1 == 0 && pjg2 == 0) {
			//console.log("HARUSNYA BISA SEMUA");
			$("#futama1").attr('hidden', false);
			$("#futama2").attr('hidden', false);
		}else if( pjg1 > 0){
			//console.log("HARUSNYA UTAMA 2 DISABLED");
			$('#futama2').attr('hidden', true);
		}else if(pjg2 >0){
			//console.log("HARUSNYA UTAMA 1 DISABLED");
			$('#futama1').attr('hidden', true);
		}
	}
	$(document).ready(function(){
		$("#anggota1").tokenInput("<?php echo base_url('admin/penelitian/get_dosen') ?>",{tokenLimit:"5",
		<?php 	if(!empty($anggota1)){
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
		$("#utama1").tokenInput("<?php echo base_url('admin/penelitian/get_dosen') ?>",{tokenLimit:"1",
		<?php 	if(!empty($utama1)){
				echo 'prePopulate:[';
					foreach($utama1 as $key=>$val){
					echo '{id:"'.$key.'", name:"'.$val.'"},';
					}
				echo ']';
				}?> 
			});
		$("#utama2").tokenInput("<?php echo base_url('admin/penelitian/get_mhs') ?>",{tokenLimit:"1",
		<?php 	if(!empty($utama2)){
				echo 'prePopulate:[';
					foreach($utama2 as $key=>$val){
					echo '{id:"'.$key.'", name:"'.$val.'"},';
					}
				echo ']';
				}?> });
		$("#utama1").on('change',function(){masukan(); });
		$("#utama2").on('change',function(){masukan(); });
	});

</script>


