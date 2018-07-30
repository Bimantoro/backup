<?php 
	$a=$this->session->flashdata('msg');
	if($a!=null):?>
		<div class="alert alert-<?php echo $a[0]?> alert-msg">
			<?php echo $a[1] ?>
		</div>
		
	<?php  endif;?>

<form class="form-horizontal form-bordered">
	<?php if($level == 'Y000'){ ?>
		<div class="form-group">
			<label class="col-md-3 control-label" for="fak">Fakultas</label>
			<div class="col-md-6">
				<select class="form-control" name="fak" id="fak">
					<option value="X0X"> -- Pilih --</option>
				<?php foreach($fakultas as $f){
						echo "<option value='".$f['kode_fakultas']."' >".ucwords(strtolower($f['nama_fakultas']))."</option>";				
				} ?>
				</select>
			</div>
		</div>
	<?php }else{ ?>
		<div class="form-group" hidden>
			<label class="col-md-3 control-label" for="fak">Fakultas</label>
			<div class="col-md-6">
				<select class="form-control" name="fak" id="fak">
				<?php foreach($fakultas as $f){
						if($f['kode_fakultas'] == $akses_fakultas){
							echo "<option value='".$f['kode_fakultas']."' >".ucwords(strtolower($f['nama_fakultas']))."</option>";
						}				
				} ?>
				</select>
			</div>
		</div>
	<?php }  ?>


	<div class="form-group">
		<label class="col-md-3 control-label" for="jalur">Jalur</label>
		<div class="col-md-6">
			<select class="form-control" name="jalur" id="jalur">
				<option value="X0X"> -- Pilih --</option>
				<?php foreach($jalur as $f){
					echo "<option value='".$f['kode_jalur']."' >".$f['nama_jalur']."</option>";				
			} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="prodi">Program Studi</label>
		<div class="col-md-6">
			<select class="form-control" name="prodi" id="prodi"">
				<option value="X0X"></option>
			</select>
		</div>
	</div>

	<div class="form-group" align="right">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="button" class="btn btn-primary" id="btn-show">Tampilkan Data</button>
		</div>
	</div>
</form>

<br>
<br>

<table class="table table-striped table-bordered" id="datatable">
<thead>
  <tr>
	<td width="5%" align="center"><b>No</b></td>
	<td width="15%" align="center"><b>Nomor Peserta</b></td>
	<td width="70%" align="center"><b>Nama Peserta</b></td>
	<td width="10%" align="center"><b>Pilihan</b></td>
  </tr>
</thead>
<tbody id="data-json">
	<tr>
		<td colspan='9' align='center'>Tidak ada data untuk ditampilkan !</td>
	</tr>
</tbody>
</table>
	
<script>
	function fill_data(){
		var prodi = $('#prodi').val();
		$.ajax({
			url  : '<?php echo $json_url_peserta ?>',
			type : 'POST',
			data : 'prodi='+prodi,

			beforeSend :function(){
				$('#data-json').empty();
				$('#data-json').append("<tr><td colspan='9' align='center'><img src='http://static.uin-suka.ac.id/images/loading.gif'><p style='text-align: center;'>Harap Menunggu ...</p></tr>");
			},

			success : function(result){
				$('#data-json').empty();

				if(result != '0'){
					var u = JSON.parse(result);
					var nomor = 1;
					var row = '';
			
					$.each(u, function(idx, val){
						row += "<tr>";
						row += "<td align='center'>"+nomor+"</td>";
						row += "<td align='center' >"+val.nomor_peserta+"</td>";
						row += "<td>"+val.nama_peserta+"</td>";
						row += "<td align='center'>"+val.pilihan+"</td>";
						row += "</tr>";

						$('#data-json').append(row);
						nomor++;
						row = "";
					});
				}else{
					$('#data-json').append("<tr><td colspan='9' align='center'>Tidak ada data untuk ditampilkan !</td></tr>");
				}
				
			}
		});
	}

	function fill_prodi(){
		var fak = $('#fak').val();
		var jalur = $('#jalur').val();
		$('#prodi').empty();

		if(fak != 'X0X' && jalur != 'X0X'){

			$.ajax({
				url		: '<?php echo $json_url_prodi ?>',
				type 	: 'POST',
				data 	: 'fak='+fak+'&jalur='+jalur,

				success	: function(result){
					if(result != '0'){
						var p = JSON.parse(result);
						$.each(p, function(index, value){
							$('#prodi').append("<option value='"+value.kode_prodi+"'>"+value.nama_prodi+" ("+value.nama_jenjang+")</option>");
						});
					}else{
						$('#prodi').append("<option value='X0X'></option>");
					}
				}
			});
		}else{
			$('#prodi').append("<option value='X0X'></option>");
		}
	}

	$(document).ready(function(){
		$("#fak").on('change', function(){
			fill_prodi();
		});

		$("#btn-show").on('click', function(){
			fill_data();
		});

		$("#jalur").on('change', function(){
			fill_prodi();
		});

		fill_prodi();
	});
</script>

				
				
