<form class="form-horizontal form-bordered" method="post" action="">
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_menu">Nama Menu</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="nama_menu" id="nama_menu" required>
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
		<label class="col-md-3 control-label" for="parent">Parent Menu</label>
		
		<div class="col-md-2">			
			<select class="form-control mb-md" name="parent" id="parent">
				<option value="0"> - </option>
				<?php foreach($parent as $p){
					echo"<option value='".$p->id_menu."'>".$p->nama_menu."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div id="mega_konten">
		<div class="form-group">
			<label class="col-md-3 control-label">Mega Konten</label>
			<div class="col-md-2">			
				<select class="form-control mb-md" name="mega_content" id="mega_content">
					<option value='No'>Tidak</option>
					<option value='Yes'>Ya</option>
				</select>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url">Jenis Link</label>
		<?php $jnl=array('Internal','Eksternal');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="jenis_url" id="jenis_url">
				<option value="">- Pilih Jenis Link -</option>
				<?php foreach($jnl as $j=>$jl){
					echo"<option value='".$jl."'>".$jl."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group" id="div_url">
		<label class="col-md-3 control-label" for="url">URL</label>
		<div class="col-md-6">
			<input class="form-control" name="url" id="url" type="text" value="">
			<label style="color: red; font-size: 12px;">Contoh Link Url : http://www.uin-suka.ac.id</label>
		</div>
	</div>
	<div class="form-group" id="div_halaman">
		<label class="col-md-3 control-label" for="url">Pilih Halaman</label>
		<div class="col-md-6">
			<select class="form-control" id="id_page" name="url">
				
			</select>
		</div>
	</div>
	<!--<div class="form-group">
		<label class="col-md-3 control-label" for="url">Format Url</label>
		<div class="col-md-6">
			<label>Lihat sesuai url yang ada pada side menu</label>
		</div>
	</div>-->
	
	<div class="form-group">
		<label class="col-md-3 control-label" for="target">Target</label>
		<?php $trg=array('_self','_blank','_parent','_top');?>
		<div class="col-md-2">			
			<select class="form-control mb-md" name="target" id="target">
				<?php foreach($trg as $t=>$tg){
					echo"<option value='".$tg."'>".$tg."</option>";
				}
				?>
			</select>
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
	// FAUZI 29-06-18 START
	$("#parent").change(function(){
		var id_menu = $("#parent").val();
		if (id_menu != 0) {
			cek_mega(id_menu);
		} else {
			$("#mega_konten").html(
				'<div class="form-group">'+
					'<label class="col-md-3 control-label">Mega Konten</label>'+
					'<div class="col-md-2">'+
						'<select class="form-control mb-md" name="mega_content" id="mega_content">'+
							'<option value="No">Tidak</option>'+
							'<option value="Yes">Ya</option>'+
						'</select>'+
					'</div>'+
				'</div>');
		}
	})

	function cek_mega(id_menu){
		$.ajax({
			url : '<?php echo(base_url("admin/main/cek_mega")); ?>',
			type : 'POST',
			data : 'id_menu='+id_menu,
			dataType : 'html',
			success: function(response){
				$('#mega_konten').html(response);
			}
		});
	}
	// FAUZI 29-06-18 END
</script>
<script type="text/javascript">
	//TONI EFENDI 10-07-2018
	$(document).ready(function(){
		$("#div_url").hide();
		$("#div_halaman").hide();
		
	});
	$("#jenis_url").on('change', function(e){
		var id_jenis_url = e.target.value;
		var kode_unit = <?php echo $this->session->userdata('kode_unit');?>;
		console.log(id_jenis_url);
		if(id_jenis_url == 'Internal'){
			$("#div_halaman").show();
			$("#div_url").hide();
			
			$.ajax({
				url: '<?php echo base_url('admin/main/get_data_page');?>',
				type: 'post',
				data: 'kode_unit='+kode_unit,
				success:function(response){
					var b = JSON.parse(response);
					//console.log(b);
					var option='';
					var option2='<option value="">-Pilih Halaman-</option>';
					$.each(b, function(value, obj){
						var str = obj.title;
						var ket = str.split(' ').join('-');
      				 	option += '<option value="page/prodi/'+obj.id_page+'-'+ket+'">'+obj.title+'</option>';
      				 });
					var fitur_tambahan = '<option value="dokumen">Dokumen</option><option value="album">Album</option><option value="video">Video</option><option value="penelitian">Penelitian</option>';

					var susun = option2+option+fitur_tambahan;
					$("#id_page").html(susun);
					$("#id_page").select2({
	    			});
				}
			});

		}else if(id_jenis_url == 'Eksternal'){
			$("#div_url").show();
			//$("#div_halaman").empty();
			$("#div_halaman").hide();

		}
	});
	//TONI EFENDI 10-07-2018
</script>