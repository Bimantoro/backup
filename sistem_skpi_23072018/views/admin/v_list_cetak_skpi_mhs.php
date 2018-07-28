<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.noborder tr, .noborder td{
			border: none;
			padding-left: 20px;
		}

		.loader3:before,
		.loader3:after,
		.loader3 {
		  border-radius: 50%;
		  width: 2.5em;
		  height: 2.5em;
		  -webkit-animation-fill-mode: both;
		  animation-fill-mode: both;
		  -webkit-animation: load7 1.8s infinite ease-in-out;
		  animation: load7 1.8s infinite ease-in-out;
		}
		.loader3 {
		  font-size: 5px;
		  margin: 30px auto;
		  position: relative;
		  text-indent: -9999em;
		  -webkit-transform: translateZ(0);
		  -ms-transform: translateZ(0);
		  transform: translateZ(0);
		  -webkit-animation-delay: -0.16s;
		  animation-delay: -0.16s;
		}
		.loader3:before {
		  left: -3.5em;
		  -webkit-animation-delay: -0.32s;
		  animation-delay: -0.32s;
		}
		.loader3:after {
		  left: 3.5em;
		}
		.loader3:before,
		.loader3:after {
		  content: '';
		  position: absolute;
		  top: 0;
		}
		@-webkit-keyframes load7 {
		  0%,
		  80%,
		  100% {
			box-shadow: 0 2.5em 0 -1.3em #000000;
		  }
		  40% {
			box-shadow: 0 2.5em 0 0 #000000;
		  }
		}
		@keyframes load7 {
		  0%,
		  80%,
		  100% {
			box-shadow: 0 2.5em 0 -1.3em #000000;
		  }
		  40% {
			box-shadow: 0 2.5em 0 0 #000000;
		  }
		}
	</style>

	<script>

		var fak = '';
		var ta = '';


		var akses = "<?php echo $this->session->userdata('skpi_lvl'); ?>";

		function fill_fakultas(){
			$.ajax({
				url 	: 'fill_form_fakultas',
				type 	: 'GET',

				success : function(result){
					var fk = JSON.parse(result);
					$('#fak').empty();
					if(fk.length > 0){
						$('#fak').append("<option value='X0X'> -- Pilih -- </option>");
						$.each(fk, function(index, value){
							$('#fak').append("<option value='"+value.KD_FAK+"'> "+value.NM_FAK+" </option>");
						});
					}else{
						$('#fak').append("<option value='X0X'> -- Pilih -- </option>");
					}
				}
			});
		}

		function fill_fakultas_s(kd_fak, kd_prodi){
			$.ajax({
				url 	: 'fill_form_fakultas',
				type 	: 'GET',

				success : function(result){
					var fk = JSON.parse(result);
					$('#fak').empty();
					if(fk.length > 0){
						$('#fak').append("<option value='X0X'> -- Pilih -- </option>");
						$.each(fk, function(index, value){
							if(kd_fak == value.KD_FAK){
								
								$('#fak').append("<option value='"+value.KD_FAK+"' selected> "+value.NM_FAK+" </option>");
								fak = value.KD_FAK;
								fill_prodi_s(kd_fak, kd_prodi);
							}else{
								$('#fak').append("<option value='"+value.KD_FAK+"'> "+value.NM_FAK+" </option>");
							}
							
						});
					}else{
						$('#fak').append("<option value='X0X'> -- Pilih -- </option>");
					}
				}

			});
		}

		fill_fakultas();

		function fill_prodi(){
			var fak = $('#fak').val();
			$.ajax({
				url 	: 'fill_form_prodi',
				type 	: 'POST',
				data 	: 'fak='+fak,

				success : function(result){
					var pr = JSON.parse(result);
					$('#prod').empty();
					if(pr.length > 0){
						$('#prod').append("<option value='X0X'> -- Pilih -- </option>");
						$.each(pr, function(index, value){
							$('#prod').append("<option value='"+value.KD_PRODI+"'> "+value.NM_PRODI+" </option>");
						});
					}else{
						$('#prod').append("<option value='X0X'> -- Pilih -- </option>");
					}
				}
			});
		}

		function fill_prodi_s(kd_fak, kd_prodi){
			var fak = kd_fak;
			$.ajax({
				url 	: 'fill_form_prodi',
				type 	: 'POST',
				data 	: 'fak='+fak,

				success : function(result){
					var pr = JSON.parse(result);
					$('#prod').empty();
					if(pr.length > 0){
						$('#prod').append("<option value='X0X'> -- Pilih -- </option>");
						$.each(pr, function(index, value){
							if(kd_prodi == value.KD_PRODI){
								$('#prod').append("<option value='"+value.KD_PRODI+"' selected> "+value.NM_PRODI+" </option>");
							}else{
								$('#prod').append("<option value='"+value.KD_PRODI+"'> "+value.NM_PRODI+" </option>");
							}
							
						});
					}else{
						$('#prod').append("<option value='X0X'> -- Pilih -- </option>");
					}
				}
			});
		}

		function fill_ta(){
			$.ajax({
				url 	: 'fill_form_tahunajaran',
				type 	: 'GET',

				success : function(result){
					var ta = JSON.parse(result);
					$('#ta').empty();
					//console.log(ta);
					if(ta.length > 0){
						$('#ta').append("<option value='X0X'> -- Pilih -- </option>");
						$.each(ta, function(index, value){
							$('#ta').append("<option value='"+value.TA_ID+"'> "+value.TA_AJAR+" </option>");
						});
					}else{
						$('#ta').append("<option value='X0X'> -- Pilih -- </option>");
					}
				}
			});
		}

		function fill_ta_s(ta_id, per_id){
			$.ajax({
				url 	: 'fill_form_tahunajaran',
				type 	: 'GET',

				success : function(result){
					var ta = JSON.parse(result);
					$('#ta').empty();
					//console.log(ta);
					if(ta.length > 0){
						$('#ta').append("<option value='X0X'> -- Pilih -- </option>");
						$.each(ta, function(index, value){
							if(ta_id == value.TA_ID){
								$('#ta').append("<option value='"+value.TA_ID+"' selected> "+value.TA_AJAR+" </option>");
								ta = value.TA_ID;
								fill_periode_s(ta_id, per_id);
							}else{
								$('#ta').append("<option value='"+value.TA_ID+"'> "+value.TA_AJAR+" </option>");
							}
							
						});
					}else{
						$('#ta').append("<option value='X0X'> -- Pilih -- </option>");
					}
				}
			});
		}

		fill_ta();

		function fill_periode(){
			var ta = $('#ta').val();
			$.ajax({
				url 	: 'fill_form_periodewisuda',
				type 	: 'POST',
				data 	: 'ta='+ta,

				success : function(result){
					var pr = JSON.parse(result);
					$('#periode').empty();
					//console.log(pr);
					if(pr != null){
						if(pr.length > 0){
							$('#periode').append("<option value='X0X'> -- Pilih -- </option>");
							$.each(pr, function(index, value){
								$('#periode').append("<option value='"+value.PER_ID+"'> "+value.PER_BULAN+" </option>");
							});
						}else{
							$('#periode').append("<option value='X0X'> -- Pilih -- </option>");
						}
					}else{
						$('#periode').append("<option value='X0X'> -- Pilih -- </option>");
					}
					
				}
			});
		}

		function fill_periode_s(ta_id, per_id){
			var ta = ta_id;
			//console.log(ta);
			$.ajax({
				url 	: 'fill_form_periodewisuda',
				type 	: 'POST',
				data 	: 'ta='+ta,

				success : function(result){
					var pr = JSON.parse(result);
					$('#periode').empty();
					//console.log(pr);
					if(pr.length > 0){
						$('#periode').append("<option value='X0X'> -- Pilih -- </option>");
						$.each(pr, function(index, value){
							if(per_id == value.PER_ID){
								$('#periode').append("<option value='"+value.PER_ID+"' selected> "+value.PER_BULAN+" </option>");
							}else{
								$('#periode').append("<option value='"+value.PER_ID+"'> "+value.PER_BULAN+" </option>");
							}
						});
					}else{
						$('#periode').append("<option value='X0X'> -- Pilih -- </option>");
					}
				}
			});
		}

		function get_all_data(){
			var prodi 	= $('#prod').val();
			var periode = $('#periode').val();
			$('#data-mhs').empty();

			if(periode != 'X0X' && prodi != 'X0X'){
				$.ajax({
					url 	: 'fill_peserta_wisuda',
					type    : 'POST',
					data    : 'prodi='+prodi+'&periode='+periode,

					beforeSend : function(){
						loading();
					},

					success : function(result){
						var mhs = JSON.parse(result);
						//console.log(mhs);
						
						if(mhs.length > 0){
								var nomor = 1;
								var row = '';
								$.each(mhs, function(index, value){

									row += "<tr>";
									row += "<td style='vertical-align: middle; text-align: center;'>"+nomor+".</td>";
									row += "<td style='vertical-align: middle;'>"+value.NIM+"</td>";
									row += "<td style='vertical-align: middle;'>"+value.NAMA+"</td>";
									row += "<td align='center' style='width: 5%;' style='margin: 0px; padding: 0px; vertical-align: middle;'><input type='text' name='noseri' class='form-control' style='margin: 0px; max-width: 120px; text-align: center' value='"+value.SERI+"'></td>";

									row += "<td class='tac' align='center' style='vertical-align: middle;'><span class='badge badge-success'><i class='icon-white icon-ok'></i></span></td>";
									row += "<td>";
											row += "<button class='btn-uin btn btn-small btn btn-inverse' type='submit' name='nim' value="+value.NIM+">Cetak</button>";
										row += "</td>"													
									row += "</tr>";
									
									$('#data-mhs').append(row);
									nomor++;
									row = '';
									

									// fill_tahun_s(value.TAHUN);
									// fill_bulan_s(value.BULAN);

								});

							}else{
								$('#nim').val('');
								$('#data-mhs').append("<td align='center' colspan='7'> Tidak ada data untuk ditampilkan !</td>");
							}

						unloading();
						$('#nim').val('');

					}
				});
			}else{

				$('#data-mhs').append("<td align='center' colspan='7'> Tidak ada data untuk ditampilkan !</td>");
			}
		}

		function get_nim(){
			var nim = $('#nimx').val();
			if(nim == ''){
				$("#notice").show();
				$("#notice-field").attr('class', 'alert alert-danger');
				$("#notice-txt").html('Masukkan NIM !');
				$("#notice").fadeOut(5000);
			}else{
				$('#data-mhs').empty();
				$.ajax({
					url 	: 'fill_peserta_wisuda_by_nim',
					type 	: 'POST',
					data 	: 'nim='+nim,

					beforeSend : function(){
						loading();
					},

					success : function(result){
						var dt = JSON.parse(result);
						//console.log(dt);
						if(dt.MAHASISWA == 1 && dt.SKPI == 1 && dt.WISUDA == 1){
							var mhs = dt.PESERTA;
							
							if(mhs.length > 0){
									var nomor = 1;
									var row = '';
									$.each(mhs, function(index, value){

										row += "<tr>";
										row += "<td style='vertical-align: middle; text-align: center;'>"+nomor+".</td>";
										row += "<td style='vertical-align: middle;'>"+value.NIM+"</td>";
										row += "<td style='vertical-align: middle;'>"+value.NAMA+"</td>";
										row += "<td align='center' style='width: 5%;' style='margin: 0px; padding: 0px; vertical-align: middle;'><input type='text' name='noseri' class='form-control' style='margin: 0px; max-width: 120px; text-align: center' value='"+value.SERI+"'></td>";

										row += "<td class='tac' align='center' style='vertical-align: middle;'><span class='badge badge-success'><i class='icon-white icon-ok'></i></span></td>";
										row += "<td>";
												row += "<button class='btn-uin btn btn-small btn btn-inverse' type='submit' name='nim' value="+value.NIM+">Cetak</button>";
											row += "</td>"													
										row += "</tr>";
										
										$('#data-mhs').append(row);
										nomor++;
										row = '';
										

										// fill_tahun_s(value.TAHUN);
										// fill_bulan_s(value.BULAN);

									});

								}else{
									$('#nim').val('');
									$('#data-mhs').append("<td align='center' colspan='7'> Tidak ada data untuk ditampilkan !</td>");
								}

								fill_fakultas_s(dt.KD_FAK, dt.KD_PRODI);
								fill_ta_s(dt.TA_ID, dt.PER_ID);

							
						}else{
							fill_fakultas();
							fill_ta();
							fill_prodi();
							fill_periode();
							$('#data-mhs').append("<td align='center' colspan='7'> Tidak ada data untuk ditampilkan !</td>");
						}
						unloading();
					}
				});
			}
		}

		function cetak_skpi(nim){
			$.ajax({
				url 	: 'cetak_skpi',
				type  	: 'POST',
				target  : '_blank',
				data   	: 'nim='+nim,

				success : function(){

				}
			});
		}


		function loading(){
			$('#loading').show();
			$('#konten').hide();
		}

		function unloading(){
			$('#loading').hide();
			$('#konten').show();
		}

		function hide_all(){
			$('#loading').hide();
			$('#konten').hide();
		}



	$( document ).ready(function() {
    	$('#fak').on('change', function(){
    		fill_prodi();
    	});

    	$('#ta').on('change', function(){
    		fill_periode();
    	});

    	$('#cek_tampil').on('click', function(){
    		$('#nimx').val('');
    		get_all_data();
    	});

    	$('#ceknim').on('click', function(){
    		get_nim();
    	});
	});

	</script>
</head>
<body>
	<br>	

<div>		
	<ul id="crumbs">
		<li><a href="<?php echo base_url('skpi/skpi_admin'); ?>" title="Beranda">Beranda</a></li>
		<li>Cetak Dokumen <?php echo $string_skpi[0]; ?></li>
	</ul>
</div>


<br>
<?php if(isset($status_label)){ ?>
<?php if($status_label==0){ ?>
	<div>
		<div class="bs-callout bs-callout-error">Tidak Ada Label SKPI yang Berstatus Aktif !</div>
	</div>
<?php } ?>
<?php } ?>
<!-- 	<table class="table-snippet">
		<tbody>
			<tr>
				<td style="padding: 10px;" class="reg-label" width="20%;">Tahun</td>
				<td style="padding: 10px;" class="reg-input" width="10%;">
					<select name="tahun" id="tahun" class="form-control">
						<option value="X0X"> -- Pilih --</option>
			      </select>
				</td>
			</tr>
			<tr>
				<td style="padding: 10px;" class="reg-label" width="20%;">Bulan</td>
				<td style="padding: 10px;" class="reg-input">
					<select name="bulan" id="bulan" class="form-control">
						<option value="X0X"> -- Pilih --</option>
			      </select>
				</td>
				<td>
					<button class="btn-uin btn btn-inverse btn btn-small" name="cek_tampil" id="cek_tampil">Tampil</button>
				</td>
			</tr> -->

<!-- <form class="form-inline" action="<?php echo base_url(); ?>skpi/skpi_admin/skpi_mhs" method="POST"> -->
<!-- 			<tr>
				<td style="padding: 10px;" class="reg-label">NIM</td>
				<td style="padding: 10px;" class="reg-label">
					<input type="text" name="nim" value="<?php echo (isset($nim))?$nim:''; ?>" required>
				</td>
				<td><button class="btn-uin btn btn-inverse btn btn-small" name="cek_nim" onclick="loading_on();">Cek NIM</button></td>
			</tr>
		</tbody>
	</table> -->
<!-- </form> -->
	<table class="table noborder">
		<tr>
			<td width="100px">Fakultas</td>
			<td width="220px">
				<select name="fak" id="fak">
					<option value="X0X"> -- Pilih --</option>
			    </select>
			</td>
		</tr>

		<tr>
			<td width="100px">Prodi</td>
			<td width="220px">
				<select name="prod" id="prod">
					<option value="X0X"> -- Pilih --</option>
			    </select>
			</td>
		</tr>

		<tr>
			<td width="100px">Tahun Akademik</td>
			<td width="220px">
				<select name="ta" id="ta">
					<option value="X0X"> -- Pilih --</option>
			    </select>
			</td>
		</tr>

		<tr>
			<td width="100px">Periode</td>
			<td width="220px">
				<select name="periode" id="periode">
					<option value="X0X"> -- Pilih --</option>
			    </select>
			</td>
			<td>
				<button class="btn-uin btn btn-inverse btn btn-small" name="cek_tampil" id="cek_tampil">Tampil</button>
			</td>
		</tr>
<!-- 		<tr>
			<td width="100px">Tahun</td>
			<td width="220px">
				<select name="tahun" id="tahun">
					<option value="X0X"> -- Pilih --</option>
			    </select>
			</td>
		</tr>
		<tr>
			<td>Bulan</td>
			<td>
				<select name="bulan" id="bulan">
					<option value="X0X"> -- Pilih --</option>
			    </select>
			</td>
		</tr> -->
		<tr style="padding-top: 2px; padding-bottom: 2px;">
			<td style="padding-top: 2px; padding-bottom: 2px;"></td><td style="padding-top: 2px; padding-bottom: 2px;">
				<div class="container" id="notice" hidden>
					<div id="notice-field"><p id="notice-txt"></p></div>
				</div>
			</td><td style="padding-top: 2px; padding-bottom: 2px;"></td>
		</tr>
		<tr>
			<td>NIM</td>
			<td>
				<input type="text" name="nimx" id="nimx">
			</td>
			<td>
				<button class="btn-uin btn btn-inverse btn btn-small" name="ceknim" id="ceknim">Cek NIM</button>
			</td>
		</tr>

	</table>

<div class="container" id="notice-btl" hidden>
	<div id="notice-field-btl"><p id="notice-txt-btl"></p></div>
</div>

<div id="loading" hidden>
	<!-- <div class="loader3">Loading...</div> -->
	<div align="center">
		<br>
		<br>
		<img src="http://static.uin-suka.ac.id/images/loading.gif">
		<p style="text-align: center;">Harap Menunggu ...</p>
	</div>
</div>

<div id="konten" hidden>
	<h3>Data Surat Ket. Pendamping Ijazah</h3>

		<div id="notice" hidden>
			<div class="bs-callout bs-callout-error">
				<p id="notice-text"></p>
			</div>
		</div>
	<form action="<?php echo base_url(); ?>skpi/skpi_admin/cetak_skpi" method="POST" target='_blank'>
	<table class="table table-bordered">
			
			<thead>
			<tr>
					<th>No.</th>
					<th>NIM</th>
					<th>Nama</th>
					<th>No. Seri</th>
					<th>Status</th>
					<th width="5%;">Proses</th>
				</tr>
			</thead>
			<form action="<?php echo base_url(); ?>skpi/skpi_admin/cetak_skpi" method="POST" target='_blank'>
				<tbody id="data-mhs"></tbody>
			</form>
	</table>
	</form>
	<div>
		<strong>Keterangan</strong> :
		<table class="table noborder">
			<tr>
				<td width="5%;">
					<span class="badge badge-success">
							<i class="icon-white icon-ok"></i>
					</span>
				</td>
				<td> : Sudah Verifikasi</td>
			</tr>
<!-- 			<tr>
				<td width="5%;">
					<span class="badge badge-important">
							<i class="icon-white icon-remove"></i>
					</span>
				</td>
				<td> : Belum Verifikasi</td>
			</tr>
			<tr>
				<td width="5%;">
					<span class="badge badge-error" style="background: #a90b0b; ">
							<i class="icon-white icon-share-alt"></i>
					</span>
				</td>
				<td> : Pendaftaran Verifikasi dibatalkan</td>
			</tr> -->
		</table>
	</div>
</div>

</body>
</html>
