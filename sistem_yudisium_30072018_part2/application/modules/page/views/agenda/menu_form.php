<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js3/jquery.timepicker.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js3/jquery.timepicker.min.css') ?>">

	<script>

		$(function(){
	
		$('#ruang').on('change',function(){
			
			var ruang=$('#ruang option:selected').val();
			if(ruang==""){
				$('#tempat').show();
				$('#tempat').focus();
			}else{
				$('#tempat').val($("#ruang option:selected").text());
				$('#tempat').hide();
			}
		});
		});
		
	</script>
	<style>
		#tempat{
			display:none;
		}
	</style>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_agenda">Nama Agenda</label>
		<div class="col-md-6">
			<input required type="text" class="form-control" name="nama_agenda" id="nama_agenda">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="bahasa">Bahasa</label>
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
		<label class="col-md-3 control-label" for="url">Deskripsi</label>
		<div class="col-md-6">
			<input class="form-control" name="deskripsi" id="deskripsi" type="text">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="url">Tempat</label>
		<div class="col-md-6">
			<select name="ruang" id="ruang" class="form-control">
				<option value="">--- PILIH RUANG ---</option>
					<?php foreach($ruang as $r){?>
					<?php if(isset($kd_ruang) and $kd_ruang==$r['KD_RUANG']){ ?>
					<option value="<?php echo $r['KD_RUANG'];?>" selected ><?php echo $r['NM_GEDUNG'].' '. $r['NM_RUANG'];?></option>
					<?php }else{?>
					<option value="<?php echo $r['KD_RUANG'];?>"><?php echo $r['NM_GEDUNG'].' '. $r['NM_RUANG'];?></option>
					<?php }?>
					<?php }?>
				<option value="">LAINNYA</option>
			</select>
		<input type="text" id="tempat" class="form-control" name="tempat" value="<?php if(isset($tempat)) echo $tempat ?>" />		
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="tgl_posting">Tanggal Posting</label>
		<div class="col-md-6">
			<input class="form-control" name="tgl_posting" id="tgl_posting" type="text" >
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="tgl_mulai">Tanggal Mulai</label>
		<div class="col-md-6">
			<input class="form-control" name="tgl_mulai" id="tgl_mulai" type="text" >
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="tgl_selesai">Tanggal Selesai</label>
		<div class="col-md-6">
			<input class="form-control" name="tgl_selesai" id="tgl_selesai" type="text">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="jam_mulai">Jam</label>
		<div class="col-md-6 input-append bootstrap-timepicker">
			<input id="jam_mulai" name="jam_mulai" class="input-small" style="width: 100px; text-align: center;" value="<?php if(isset($jam_mulai)){ echo $jam_mulai; }else{ echo "08:00"; }?>" type="text"/><span class="add-on"><i class="icon-time"></i></span> - 
			<input id="jam_selesai" name="jam_selesai" class="input-small" style="width: 100px; text-align: center;" value="<?php if(isset($jam_selesai)){ echo $jam_selesai; }else{ echo "08:00"; }?>"  type="text"/><span class="add-on"><i class="icon-time"></i></span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_file">Lampiran</label>
		<div class="col-md-6">
			<input class="" name="nama_file" id="nama_file" type="file">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>

</form>

<script type="text/javascript">
	$('#tgl_posting').datepicker({
	dateFormat : 'dd/mm/yy'
	});

	$('#tgl_mulai').datepicker({
		dateFormat : 'dd/mm/yy'
	});

	$('#tgl_selesai').datepicker({
		dateFormat : 'dd/mm/yy'
	});

	$('#jam_mulai').timepicker({
		timeFormat : 'HH:mm'
	});
	$('#jam_selesai').timepicker({
		timeFormat : 'HH:mm'
	});


</script>