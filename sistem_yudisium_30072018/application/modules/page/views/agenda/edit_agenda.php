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
	<?php if($p->kode_ruang!=null):?>
	<script>
		$('#tempat').show();
	</script>
	<?php endif?>
	<style>
		#tempat{
			display:none;
		}
	</style>
	
<?php 
	$a=$this->session->flashdata('msg');
	if($a!=null):?>
		<div class="alert alert-<?php echo $a[0]?> alert-msg">
			<?php echo $a[1] ?>
		</div>
		
	<?php  endif;?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3" for="nama_menu">Nama Agenda</label>
		<div class="col-md-6">
			<input required type="text" class="form-control" name="nama_agenda" id="nama_agenda" value="<?php echo $p->nama_agenda?>" >
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="bahasa">Bahasa</label>
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
		<label class="col-md-3" for="url">Deskripsi</label>
		<div class="col-md-6">
			<input class="form-control" name="deskripsi" id="deskripsi" type="text" value="<?php echo $p->deskripsi?>">
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-3" for="url">Tempat</label>
		<div class="col-md-6">
			<select name="ruang" id="ruang" class="form-control">
				<option value="">--- PILIH RUANG ---</option>
					<?php foreach($ruang as $r){?>
					<?php if(isset($p->kode_ruang) and $p->kode_ruang==$r['KD_RUANG']){ ?>
					<option value="<?php echo $r['KD_RUANG'];?>" selected ><?php echo $r['NM_GEDUNG'].' '. $r['NM_RUANG'];?></option>
					<?php }else{?>
					<option value="<?php echo $r['KD_RUANG'];?>"><?php echo $r['NM_GEDUNG'].' '. $r['NM_RUANG'];?></option>
					<?php }?>
					<?php }?>
				<option value="">LAINNYA</option>
			</select>
			
		<input type="text" id="tempat" class="form-control" name="tempat" <?php if($p->kode_ruang==null) echo "style = 'display: inline;'"?> value="<?php if(isset($p->tempat)) echo $p->tempat ?>" />		
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="tgl_posting">Tanggal Posting</label>
		<div class="col-md-6">
			<input class="form-control" name="tgl_posting" id="tgl_posting" type="date" value="<?php echo substr($p->tgl_posting,0,10)?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="tgl_mulai">Tanggal Mulai</label>
		<div class="col-md-6">
			<input class="form-control" name="tgl_mulai" id="tgl_mulai" type="date" value="<?php echo substr($p->tgl_mulai,0,10)?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="tgl_selesai">Tanggal Selesai</label>
		<div class="col-md-6">
			<input class="form-control" name="tgl_selesai" id="tgl_selesai" type="date"  value="<?php echo substr($p->tgl_selesai,0,10)?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="jam_mulai">Jam</label>
		<div class="col-md-6 input-append bootstrap-timepicker">
			<input id="jam_mulai" name="jam_mulai" class="input-small" value="<?php if(isset($p->tgl_mulai)){ echo substr($p->tgl_mulai, 11,8); }else{ echo "08:00:00"; }?>" type="time"/><span class="add-on"><i class="icon-time"></i></span> - 
			<input id="jam_selesai" name="jam_selesai" class="input-small" value="<?php if(isset($p->tgl_selesai)){ echo substr($p->tgl_selesai, 11,8); }else{ echo "08:00:00"; }?>"  type="time"/><span class="add-on"><i class="icon-time"></i></span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="nama_file">Lampiran</label>
		<div class="col-md-6">
			<input class="" name="nama_file" id="nama_file" type="file">
			<label style="color:red;" class="ml-xl">File gambar yang disarankan berekstensi .jpg/.jpeg</label>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="jenis_url"></label>
		<div class="col-md-12">			
			<button type="submit" class="btn btn-primary pull-right">Simpan</button>
		</div>
	</div>

</form>