<?php foreach($menu as $p){} ?>
<form class="form-horizontal form-bordered" method="post" action="">
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_menu">Nama Menu</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="nama_menu" id="nama_menu" value="<?php echo $p->nama_menu?>">
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
	
	<!-- <div class="form-group">
		<label class="col-md-3 control-label" for="parent">Parent Menu</label>
		
		<div class="col-md-2">			
			<select class="form-control mb-md" name="parent" id="parent" >
				<option value="0"> - </option>
				<?php foreach($parent as $q){?>
					<?php if($q->id_menu == $p->parent) :?>
					<?php echo"<option value='".$q->id_menu."' selected>".$q->nama_menu."</option>";?>
					<?php else :?>
					<?php echo"<option value='".$q->id_menu."'>".$q->nama_menu."</option>";?>
					<?php endif?>
				<?php }
				?>
			</select>
		</div>
	</div> -->
	
	<div class="form-group" id="div_jenis_url">
		<label class="col-md-3 control-label" for="jenis_url">Jenis Link</label>
		<?php $jnl=array('Internal','Eksternal');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="jenis_url" id="jenis_url">
				<option value="">- Pilih Jenis Link -</option>
				<?php foreach($jnl as $j){?>
					<?php if($j == $jenisurl):?>
					<?php echo "<option value='".$j."' selected>".$j."</option>"?>
					<?php else :?>
					<?php echo "<option value='".$j."'>".$j."</option>"?>
					<?php endif?>
				<?php }
				?>
			</select>
		</div>
	</div>
	<div class="form-group" id="div_url">
		<!-- <label class="col-md-3 control-label" for="url">URL</label>
		<div class="col-md-6">
			<input class="form-control" name="url" id="url" type="text" value="<?php echo $p->url?>" >
			<label style="color: red; font-size: 12px;">Contoh Link Url : http://www.uin-suka.ac.id</label>
		</div> -->
	</div>
	<!-- <div class="form-group" id="div_halaman">
		<label class="col-md-3 control-label" for="url">Pilih Halaman</label>
		<div class="col-md-6">
			<select class="form-control" id="id_page" name="url">
				
			</select>
		</div>
	</div> -->
	<div class="form-group">
		<label class="col-md-3 control-label" for="target">Target</label>
		<?php $trg=array('_self','_blank','_parent','_top');?>
		<div class="col-md-2">			
			<select class="form-control mb-md" name="target" id="target">
				<?php foreach($trg as $t){?>
					<?php if($t == $target):?>
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
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>

</form>
<script type="text/javascript">
	$(document).ready(function(){
		/*$("#div_halaman").hide();
		$("#div_url").hide();*/
		var id_page = <?php echo $this->uri->segment(4);?>;
		var kode_unit = <?php echo $this->session->userdata('kode_unit')?>;
		$.ajax({
			url: '<?php echo base_url('admin/main/get_data_page_by_id')?>',
			type: 'post',
			data: 'id_page='+id_page,
			success:function(result){
				var d = JSON.parse(result);
				console.log(d);
				if(d.jenis_url == 'Internal'){
					var html = '<label class="col-md-3 control-label" for="url">Pilih Halaman</label><div class="col-md-6"><select class="form-control" id="id_page" name="url"></select></div>';
					$("#div_url").html(html);
				}else if(d.jenis_url == 'Eksternal'){
					var html = '<label class="col-md-3 control-label" for="url">URL</label><div class="col-md-6"><input class="form-control" name="url" id="url" type="text" value="<?php echo $p->url?>" ><label style="color: red; font-size: 12px;">Contoh Link Url : http://www.uin-suka.ac.id</label></div>';
					$("#div_url").html(html);
				}
				$.ajax({
				url: '<?php echo base_url('admin/main/get_data_page')?>',
				type: 'post',
				data: 'kode_unit='+kode_unit,
				success:function(response){
					var b = JSON.parse(response);
					console.log(b);
					var d = JSON.parse(result);
					var url = d.url;
					var pecah = url.split('/');
					console.log(pecah);
					var jml = pecah.length;
					console.log(jml	);
					if(jml > 1){
						var id_menu = pecah[2];
						console.log(id_menu);
						var pecah2 = id_menu.split('-');
						var id_page = pecah2[0];
						console.log(id_page);
						//console.log(d.id_menu);
						var option='';
						var option3;
						var option2='<option value="">-Pilih Halaman-</option>';
						$.each(b, function(value, obj){
							var str = obj.title;
							var ket = str.split(' ').join('-');
							if(obj.id_page == id_page){
								option += '<option value="page/universitas/'+obj.id_page+'-'+ket+'" selected>'+obj.title+'</option>';
							}else{
								option += '<option value="page/universitas/'+obj.id_page+'-'+ket+'">'+obj.title+'</option>';
							}
	      				 	/*option += option3;*/
	      				 });
						var fitur_tambahan = '<option value="dokumen">Dokumen</option><option value="album">Album</option><option value="video">Video</option><option value="penelitian">Penelitian</option>';
						var susun = option2+option+fitur_tambahan;
						$("#id_page").html(susun);
					}else{
						$("#div_url").hide();
						$("#div_jenis_url").hide();
						//console.log(pecah.toString());
						/*var nilai = pecah.toString();
						$("#id_page").val(nilai);*/
					}
					$("#id_page").select2({
	    			});
				}
			});
			}
		});
		
	});
	$("#jenis_url").on('change', function(e){
		var kode_unit = <?php echo $this->session->userdata('kode_unit')?>;
		var id_jenis_url = e.target.value;
		console.log(id_jenis_url);
		if(id_jenis_url == 'Internal'){
			var html = '<label class="col-md-3 control-label" for="url">Pilih Halaman</label><div class="col-md-6"><select class="form-control" id="id_page" name="url"></select></div>';
			$("#div_url").html(html);
			$.ajax({
				url: '<?php echo base_url('admin/main/get_data_page')?>',
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
      				 	option += '<option value="page/universitas/'+obj.id_page+'-'+ket+'">'+obj.title+'</option>';
      				 });
					var susun = option2+option;
					$("#id_page").html(susun);
					$("#id_page").select2({
	    			});
				}
			});

		}else if(id_jenis_url == 'Eksternal'){
			var html = '<label class="col-md-3 control-label" for="url">URL</label><div class="col-md-6"><input class="form-control" name="url" id="url" type="text" value="" ><label style="color: red; font-size: 12px;">Contoh Link Url : http://www.uin-suka.ac.id</label></div>';
			$("#div_url").html(html);

		}
	});
</script>