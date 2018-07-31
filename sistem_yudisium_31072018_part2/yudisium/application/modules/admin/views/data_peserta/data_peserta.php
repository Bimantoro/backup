<?php 
	$a=$this->session->flashdata('msg');
	if($a!=null):?>
		<div class="alert alert-<?php echo $a[0]?> alert-msg">
			<?php echo $a[1] ?>
		</div>
		
	<?php  endif;?>

<form class="form-horizontal form-bordered">
	<?php if($level == 'Y000' || $level == 'Y002'){ ?>
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
<div id="loading" hidden>
	<!-- <div class="loader3">Loading...</div> -->
	<div align="center">
		<br>
		<br>
		<img src="http://static.uin-suka.ac.id/images/loading.gif">
		<p style="text-align: center;">Harap Menunggu ...</p>
	</div>
</div>


<div id="ctn-yudisium" hidden>
	<table class="table table-striped table-bordered" id="datatable">
	<thead>
	  <tr>
		<td width="5%" align="center"><b>No</b></td>
		<td width="30%" align="center"><b>Peserta</b></td>
		<td width="50%" align="center"><b>Keterangan</b></td>
		<td width="10%" align="center"><b>Nilai</b></td>
		<td width="5%" align="center"><b>Kelas</b></td>
	  </tr>
	</thead>
	<tbody id="data-json">
		<tr>
			<td colspan='9' align='center'>Tidak ada data untuk ditampilkan !</td>
		</tr>
	</tbody>
	</table>
</div>

<!-- Modal -->
<div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="labelModalKu">Detail Nilai Ujian Peserta</h5>
            </div>
            <div id="detail-nilai-loading" hidden>
            	<div align="center">
					<br>
					<br>
					<img src="http://static.uin-suka.ac.id/images/loading.gif">
					<p style="text-align: center;">Harap Menunggu ...</p>
				</div>
            </div>

            <div id="detail-nilai-failed" hidden>
            	<div align="center">
					<br>
					<br>
					<p style="text-align: center;">DATA TIDAK DITEMUKAN !</p>
					<br>
					<br>
				</div>
            </div>

            <div id="detail-nilai-konten" hidden>
            	<div class="modal-body">
	                <div>
	                	<h5>Data Peserta :</h5>
	                	<table class="table">
	                		<tbody id='profile-peserta'>
	                			<tr>
	                				<td style="width: 150px;">Nomor Peserta</td>
	                				<td>: xxxxxxxxxx</td>
	                			</tr>
	                			<tr>
	                				<td>Nama</td>
	                				<td>: Mr. Tester</td>
	                			</tr>
	                			<tr>
	                				<td>Asal Sekolah</td>
	                				<td>: SMK N 1 Tester</td>
	                			</tr>
	                		</tbody>
	                	</table>
	                </div>

	                 <div>
	                	<h5>Nilai Ujian :</h5>
	                	<table class="table table-bordered">
	                		<tr>
	                			<td align="center" width="5%">No</td>
	                			<td align="center" width="70%"><b>Mata Ujian</b></td>
	                			<td align="center" width="25%"><b>Nilai</b></td>
	                		</tr>

	                		<tbody id="nilai-peserta">
	                			<tr>
	                				<td colspan="3" align="center">Tidak Ada Nilai !</td>
	                			</tr>
	                		</tbody>
	                	</table>
	                </div>

	            </div>
            </div>
            

            <!-- Modal Footer -->
        </div>
    </div>
</div>

<script>


	var pilihan_aktif = '-';
	var prodi_aktif = '-';
	var tahun_aktif = '-';
	var gelombang_aktif = '-';
	var jalur_aktif = '-';
	var kelas_aktif = '-';

	// var jumlah_diterima = 0;

	function fill_kelas(){

		$.ajax({
			url 	: '<?php echo $json_url_kelas ?>',
			type 	: 'GET',
			data 	: '',

			success : function(result){
				if(result != '0'){
					var p = JSON.parse(result);
					$('#kelas').empty();
					$('#kelas').append("<option value='X0X'> -- Pilih --</option>");
					$.each(p, function(index, value){
						$('#kelas').append("<option value='"+value.kode_kelas+"'>"+value.nama_kelas+" ("+value.kode_kelas+")</option>");
					});
				}else{
					$('#kelas').append("<option value='X0X'></option>");
				}
			}
		});
	}

	function fill_detail_nilai_peserta(nomor_peserta){
		$('#detail-nilai-loading').show()
		$('#detail-nilai-konten').hide()
		$('#detail-nilai-failed').hide()

		$.ajax({
			url 	: '<?php echo $json_url_detail_nilai ?>',
			type 	: 'POST',
			data 	: 'peserta='+nomor_peserta,

			success : function(result){
				if(result != '0'){
					var d = JSON.parse(result);
					var nomor = '-';
					var row = '';
					var sq = 1;
					var kosong = 0;

					$('#profile-peserta').empty();
					$('#nilai-peserta').empty();
					$.each(d, function(idx, val){
						if(nomor != val.nomor_peserta){
							$('#profile-peserta').append("<tr><td style='width: 150px;'>Nomor Peserta</td><td>: <b>"+val.nomor_peserta+"</b></td></tr>");
							$('#profile-peserta').append("<tr><td>Nama</td><td>: "+val.nama_peserta+"</td></tr>");
							$('#profile-peserta').append("<tr><td>Asal Sekolah</td><td>: "+val.asal_sekolah+"</td></tr>");
							$('#profile-peserta').append("<tr><td>Pilihan 1 </td><td>: "+val.pilihan1+"</td></tr>");
							$('#profile-peserta').append("<tr><td>Pilihan 2</td><td>: "+val.pilihan2+"</td></tr>");

							nomor = nomor_peserta;
						}

						if(val.nilai == 'X0X'){
							kosong = 1;
						}

						if(kosong == 0){
							row += "<tr>";
							row += "<td align='center'>"+sq+"</td>";
							row += "<td>"+val.nama_ujian+"</td>";
							row += "<td align='center'>"+val.nilai+"</td>";
							row += "</tr>";

							$('#nilai-peserta').append(row);
							sq++;
							row = '';
						}
						

					});

					if(kosong == 1){
						row += "<tr><td colspan=3 align='center'>Data nilai tidak ditemukan !</td></tr>"
						$('#nilai-peserta').append(row);
					}

					$('#detail-nilai-konten').show()
					$('#detail-nilai-loading').hide()
					$('#detail-nilai-failed').hide()

				}else{
					$('#detail-nilai-konten').hide()
					$('#detail-nilai-loading').hide()
					$('#detail-nilai-failed').show()
				}
			}
		});
	}

	function fill_data(){
		var prodi = $('#prodi').val();
		prodi_aktif = prodi;
		var tahun = tahun_aktif;
		var gelombang = gelombang_aktif;
		var jalur = $('#jalur').val();
		var pilihan = pilihan_aktif;
		//var kelas = $('#kelas').val();
		// kelas_aktif = kelas;

		$.ajax({
			url  : '<?php echo $json_url_peserta2 ?>',
			type : 'POST',
			data : 'prodi='+prodi+'&tahun='+tahun+'&gelombang='+gelombang+'&jalur='+jalur,

			beforeSend :function(){
				$('#loading').show(); $('#ctn-yudisium').hide();

				$('#data-json').empty();
				$('#data-json').append("<tr><td colspan='9' align='center'><img src='http://static.uin-suka.ac.id/images/loading.gif'><p style='text-align: center;'>Harap Menunggu ...</p></tr>");
			},

			success : function(result){
				$('#data-json').empty();

				if(result != '0'){
					var u = JSON.parse(result);
					var nomor = 1;
					var row = '';
					var tmp_diterima = 0;
					var tmp_jml_data = 0;
			
					$.each(u, function(idx, val){
						var kab = '-';
						if(val.kabupaten != null){
							kab = val.kabupaten;
						}

						var cek = '';
						if(val.status == '1'){
							cek = 'checked';
							tmp_diterima++;
						}
						tmp_jml_data++;

						var event = "sv_diterima('"+val.nomor_peserta+"')";
						var detailnilai = "fill_detail_nilai_peserta('"+val.nomor_peserta+"')";

						row += "<tr>";
						row += "<td align='center'>"+nomor+"</td>";
						row += "<td>No : <b>"+val.nomor_peserta+"</b></br>Nama : "+val.nama_peserta+"</br>Usia : "+val.usia+"</br></td>";
						row += "<td>Sekolah : <b>"+val.asal_sekolah+"</b></br>Kabupaten : "+kab+"</br>Jurusan : "+val.jurusan+"</br>Nilai STTB : "+val.nilai_sttb+"</br><button class='btn btn-small btn-success' data-toggle='modal' data-target='#modalForm' onclick="+detailnilai+">Detail Nilai Ujian</button></td>";
						row += "<td align='center'>"+val.nilai_total+"</td>";
						row += "<td align='center'>"+val.kode_kelas+"</td>";
						row += "</tr>";

						$('#data-json').append(row);
						nomor++;
						row = "";
					});

					$('#f-diterima').html(tmp_diterima);
					if(tmp_diterima == tmp_jml_data){
						$('#in-all')[0].checked = true;
					}
					//console.log(tmp_diterima);

				}else{
					$('#data-json').append("<tr><td colspan='9' align='center'>Tidak ada data untuk ditampilkan !</td></tr>");
				}
				
				$('#loading').hide(); $('#ctn-yudisium').show();
			}
		});
		//counter();
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
		gelombang_aktif = '-';
		tahun_aktif = '-';

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
							gelombang_aktif = value.kode_gelombang;
							tahun_aktif = value.tahun;
						});
					}else{
						$('#p-aktif').html('-');
						pilihan_aktif = '-';
						gelombang_aktif = '-';
						tahun_aktif = '-';
					}
				}
			});
		}else{
			$('#p-aktif').html('-');
			pilihan_aktif = '-';
			gelombang_aktif = '-';
			tahun_aktif = '-';
		}

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
		});


	});
</script>

				
				
