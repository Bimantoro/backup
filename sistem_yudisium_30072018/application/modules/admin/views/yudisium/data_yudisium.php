<?php 
	$a=$this->session->flashdata('msg');
	if($a!=null):?>
		<div class="alert alert-<?php echo $a[0]?> alert-msg">
			<?php echo $a[1] ?>
		</div>
		
	<?php  endif;?>

<form class="form-horizontal form-bordered">
	<div class="form-group">
		<label class="col-md-3 control-label" for="fah">Fakultas</label>
		<div class="col-md-6">
			<select class="form-control" name="fak" id="fak">
				<option value="X0X"> -- Pilih --</option>
			<?php foreach($fakultas as $f){
					echo "<option value='".$f['kode_fakultas']."' >".ucwords(strtolower($f['nama_fakultas']))."</option>";				
			} ?>
			</select>
		</div>
	</div>

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
<div class="row">
	<div class="col-md-3"> Pilihan : <b id="p-aktif">-</b></div>
</div><div class="row">
	<div class="col-md-3"> Total diterima : <b id="f-diterima">-</b></div>
	<div class="col-md-6"></div>
	<div class="col-md-3" align="right"> <input type="checkbox" name="in-all" id="in-all"> Pilih Semua</div>
</div>
<table class="table table-striped table-bordered" id="datatable">
<thead>
  <tr>
	<td width="5%" align="center"><b>No</b></td>
	<td width="30%" align="center"><b>Peserta</b></td>
	<td width="50%" align="center"><b>Keterangan</b></td>
	<td width="10%" align="center"><b>Nilai</b></td>
	<td width="5%" align="center"><b>Diterima</b></td>
  </tr>
</thead>
<tbody id="data-json">
	<tr>
		<td colspan='9' align='center'>Tidak ada data untuk ditampilkan !</td>
	</tr>
</tbody>
</table>
	
<script>


	var pilihan_aktif = '-';


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
						var kab = '-';
						if(val.kabupaten != null){
							kab = val.kabupaten;
						}

						var cek = '';
						if(val.status == '1'){
							cek = 'checked';
						}

						var event = "sv_diterima('"+val.nomor_peserta+"')";

						row += "<tr>";
						row += "<td align='center'>"+nomor+"</td>";
						row += "<td>No : <b>"+val.nomor_peserta+"</b></br>Nama : "+val.nama_peserta+"</br>Usia : "+val.usia+"</br></td>";
						row += "<td>Sekolah : <b>"+val.asal_sekolah+"</b></br>Kabupaten : "+kab+"</br>Jurusan : "+val.jurusan+"</br>Nilai STTB : "+val.nilai_sttb+"</br></td>";
						row += "<td align='center'>"+val.pilihan+"</td>";
						row += "<td align='center'><input class='diterima' type='checkbox' name=test[] onchange="+event+" "+cek+"></td>";
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
		counter();
	}

	function fill_prodi(){
		var fak = $('#fak').val();
		$('#prodi').empty();

		if(fak != 'X0X'){

			$.ajax({
				url		: '<?php echo $json_url_prodi ?>',
				type 	: 'POST',
				data 	: 'fak='+fak,

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

	function fill_prodi2(){
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
						$('#p-aktif').html('-');
					}
				}
			});
		}else{
			$('#prodi').append("<option value='X0X'></option>");
		}
	}

	function fill_pilihan_aktif(){
		var fak = $('#fak').val();
		var jalur = $('#jalur').val();
		$('#p-aktif').html('-');
		pilihan_aktif = '-';

		if(fak != 'X0X' && jalur != 'X0X'){

			$.ajax({
				url		: '<?php echo $json_url_pilihan ?>',
				type 	: 'POST',
				data 	: 'fak='+fak+'&jalur='+jalur,

				success	: function(result){
					if(result != '0'){
						var p = JSON.parse(result);
						$.each(p, function(index, value){
							$('#p-aktif').html(value.pilihan);
							pilihan_aktif = value.pilihan;
						});
					}else{
						$('#p-aktif').html('-');
						pilihan_aktif = '-';
					}
				}
			});
		}else{
			$('#p-aktif').html('-');
			pilihan_aktif = '-';
		}

	}

	function counter(){
		var diterima = $('.diterima:checked').length;
		var total = $('.diterima').length;

		if(diterima == total && total != 0){
			$('#in-all')[0].checked = true;
		}else{
			$('#in-all')[0].checked = false;
		}
		$('#f-diterima').html(diterima);



	}

	counter();

	function sv_diterima(nomor_peserta){
		console.log(nomor_peserta);
		var peserta = nomor_peserta;
		var pilihan = pilihan_aktif;

		$.ajax({
			url 	: '<?php echo $json_url_diterima ?>',
			type 	: 'POST',
			data 	: 'peserta='+peserta+'&pilihan='+pilihan,

			success : function(result){
				if(result != '0'){
					console.log('tersimpan');
				}else{
					console.log('gagal');
				}
			}
		});
		counter();
	}

	$(document).ready(function(){
		$("#fak").on('change', function(){
			fill_pilihan_aktif();
			fill_prodi2();
		});

		$("#jalur").on('change', function(){
			fill_pilihan_aktif();
			fill_prodi2();
		});

		$("#btn-show").on('click', function(){
			fill_data();
			counter();
		});

		$("#in-all").on('change', function(){
		var status = this.checked;
		$(".diterima").each(function(){
			this.checked = status;
		})
		
		counter();
	});
	});
</script>

				
				
