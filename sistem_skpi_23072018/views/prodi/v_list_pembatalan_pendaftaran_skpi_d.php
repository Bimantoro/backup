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

		var tahun = '';
		var bulan = '';


		var akses = "<?php echo $this->session->userdata('skpi_lvl'); ?>";
		var sts_lbl = "<?php echo $status_label; ?>";


		function get_date(){
			$.ajax({
				url  : 'get_tanggal_daftar_verifikasi',
				type : 'GET',

				success : function(result){
					var temp = JSON.parse(result);
					bulan = temp.BULAN;
					tahun = temp.TAHUN;

					//console.log(bulan);
					fill_tahun();
					fill_bulan();

					//SET DI FUNGSI FILL TAHUN

				}
			});

		}

		get_date();

		function fill_tahun(){
			if(tahun != ''){
				var nomor = 0;
				$('#tahun').empty();
				$.each(tahun, function(index, value){

					if(nomor == 0){
						$('#tahun').append("<option value='"+value+"' selected>"+value+"</option>");
					}else{
						$('#tahun').append("<option value='"+value+"'>"+value+"</option>");
					}
					
					nomor++;
					
				});
			}
		}

		function fill_bulan(){
			if(bulan != ''){
				var thn = $('#tahun').val();
				$.each(bulan, function(index, value){
					if(index == thn){
						var nomor = 0;
						$('#bulan').empty();
						$.each(value, function(idx, val){
							if(nomor == 0){
								$('#bulan').append("<option value='ALL' selected> -- Semua Bulan -- </option>");
							}
							
							$('#bulan').append("<option value='"+val.KD_BULAN+"'>"+val.NM_BULAN+"</option>");
							
					
							nomor++;
						});
					}
				});
			}
		}

		function fill_tahun_s(sel){
			if(tahun != ''){
				$('#tahun').empty();
				//console.log(sel);
				$.each(tahun, function(index, value){
					if(sel == value){
						$('#tahun').append("<option value='"+value+"' selected>"+value+"</option>");
					}else{
						$('#tahun').append("<option value='"+value+"'>"+value+"</option>");
					}					
				});
			}
		}

		function fill_bulan_s(sel){
			if(bulan != ''){
				var thn = $('#tahun').val();
				$.each(bulan, function(index, value){
					if(index == thn){
						$('#bulan').empty();
						$('#bulan').append("<option value='ALL'> -- Semua Bulan -- </option>");
						$.each(value, function(idx, val){
							if(parseInt(sel) == parseInt(val.KD_BULAN)){

								$('#bulan').append("<option value='"+val.KD_BULAN+"' selected>"+val.NM_BULAN+"</option>");
							}else{
								$('#bulan').append("<option value='"+val.KD_BULAN+"'>"+val.NM_BULAN+"</option>");
							}
						});
					}
				});
			}
		}

		function get_all_data(){
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			$.ajax({
				url 	: 'get_all_data_verifikasi_mahasiswa',
				type    : 'POST',
				data    : 'bulan='+bulan+'&tahun='+tahun,

				beforeSend : function(){
					loading();
				},

				success : function(result){
					var mhs = JSON.parse(result);
					$('#data-mhs').empty();
					if(mhs.length > 0){
							var nomor = 1;
							var row = '';
							$.each(mhs, function(index, value){
								row += "<tr>";
								row += "<td style='vertical-align: middle; text-align: center;'>"+nomor+".</td>";
								row += "<td style='vertical-align: middle;'>"+value.NIM+"</td>";
								row += "<td style='vertical-align: middle;'>"+value.NAMA+"</td>";
								row += "<td style='vertical-align: middle;'>"+value.PRODI+"</td>";
								row += "<td style='vertical-align: middle; text-align: center;'>"+value.TGL+"</td>";

								if(value.STATUS == 1){
									row += "<td class='tac' align='center' style='vertical-align: middle;'><span class='badge badge-success'><i class='icon-white icon-ok'></i></span></td>";
									row += "<td align='center'> - </td>";
								}else{
									if(value.BATAL == 0){
										row += "<td class='tac' align='center' style='vertical-align: middle;'><span class='badge badge-important'><i class='icon-white icon-remove'></i></span></td>";									
										row += "<td>";
											row += "<button class='btn-uin btn-inverse btn-small' type='submit' name='btn_valid' value='"+value.NIM+"' data-toggle='modal' data-target='#modalForm' onclick='fill_form_pembatalan("+value.NIM+")'>Batal</button>";
										row += "</td>";
									}else{
										row += "<td class='tac' align='center' style='vertical-align: middle;' ><span class='badge badge-error' style='background: #a90b0b;'><i class='icon-white icon-share-alt'></i></span></td>";
										row += "<td align='center'> - </td>";
									}
								}						
								row += "</tr>";
								
								$('#data-mhs').append(row);
								nomor++;
								row = '';

								// fill_tahun_s(value.TAHUN);
								// fill_bulan_s(value.BULAN);

							});

						}else{
							$('#nim').val('');
							$('#data-mhs').append("<td align='center' colspan='7'> Tidak ada data untuk ditampilkan !</td>")
						}

					unloading();
					$('#nim').val('');

				}
			});
		}

		function get_nim(){
			var nim = $('#nim').val();
			if(nim == ''){
				$("#notice").show();
				$("#notice-field").attr('class', 'alert alert-danger');
				$("#notice-txt").html('Masukkan NIM !');
				$("#notice").fadeOut(5000);
			}else{
				$.ajax({
					url 	: 'get_data_verifikasi_mhs_by_nim',
					type 	: 'POST',
					data 	: 'nim='+nim,

					beforeSend : function(){
						loading();
					},

					success : function(result){
						var mhs = JSON.parse(result);
						// console.log(mhs);
						$('#data-mhs').empty();
						if(mhs.length > 0){
							var nomor = 1;
							var row = '';
							$.each(mhs, function(index, value){
								if(value.NIM == '13651068'){
									console.log(value);
								}
								row += "<tr>";
								row += "<td style='vertical-align: middle; text-align: center;'>"+nomor+".</td>";
								row += "<td style='vertical-align: middle;'>"+value.NIM+"</td>";
								row += "<td style='vertical-align: middle;'>"+value.NAMA+"</td>";
								row += "<td style='vertical-align: middle;'>"+value.PRODI+"</td>";
								row += "<td style='vertical-align: middle; text-align: center;'>"+value.TGL+"</td>";

								if(value.STATUS == 1){
									row += "<td class='tac' align='center' style='vertical-align: middle;'><span class='badge badge-success'><i class='icon-white icon-ok'></i></span></td>";
									row += "<td align='center'> - </td>";
								}else{

									if(value.BATAL == 0){
										row += "<td class='tac' align='center' style='vertical-align: middle;'><span class='badge badge-important'><i class='icon-white icon-remove'></i></span></td>";									
										row += "<td>";
											row += "<button class='btn-uin btn-inverse btn-small' type='submit' name='btn_valid' value='"+value.NIM+"' data-toggle='modal' data-target='#modalForm' onclick='fill_form_pembatalan("+value.NIM+")'>Batal</button>";
										row += "</td>";
									}else{
										row += "<td class='tac' align='center' style='vertical-align: middle;' ><span class='badge badge-error' style='background: #a90b0b;'><i class='icon-white icon-share-alt'></i></span></td>";
										row += "<td align='center'> - </td>";
									}
									
									
								}						
								row += "</tr>";
								
								$('#data-mhs').append(row);
								nomor++;
								row = '';

								fill_tahun_s(value.TAHUN);
								fill_bulan_s(value.BULAN);

							});

						}else{
							$('#nim').val('');
							$('#data-mhs').append("<td align='center' colspan='7'> Tidak ada data untuk ditampilkan !</td>")
						}

						unloading();
					}
				});
			}
		}

		function fill_form_pembatalan(nim){
			$('#skpi-mhs').empty();
			$.ajax({
				url 	: 'fill_form_pembatalan',
				type 	: 'POST',
				data 	: 'nim='+nim,

				success : function(result){
					var mhs = JSON.parse(result);
					//console.log(mhs);
					
					$('#btn-batal').val(mhs.NIM);
					$('#pesan-txt').val('');
					$('#skpi-mhs').append("<tr><td width='100px'>NIM</td><td>: "+mhs.NIM+"</td></tr>");
					$('#skpi-mhs').append("<tr><td width='100px'>Nama</td><td>: "+mhs.NAMA+"</td></tr>");
					$('#skpi-mhs').append("<tr><td width='100px'>Prodi</td><td>: "+mhs.PRODI+"</td></tr>");
					$('#skpi-mhs').append("<tr><td width='100px'>tanggal Daftar</td><td>: "+mhs.TGL+"</td></tr>");
				}
			});
		}

		function batal_pendaftaran_verifikasi(){
			var nim = $('#btn-batal').val();
			var ket = $('#pesan-txt').val();
			//alert(nim);
			$.ajax({
				url 	: 'proses_batal_pendaftaran_verifikasi',
				type 	: 'POST',
				data 	: 'nim='+nim+'&ket='+ket,

				success : function(result){
					if(result == 1){
						//console.log('pembatalan pendaftaran sukses !');
						if($('#nim').val() == nim){
							get_nim();
						}else{
							get_all_data();
						}

						$("#notice-btl").show();
						$("#notice-field-btl").attr('class', 'alert alert-success');
						$("#notice-txt-btl").html('Pembatalan Pendaftaran Verifikasi Surat Ket. Pendamping Ijazah untuk NIM '+nim+' Sukses');
						$("#notice-btl").fadeOut(3000);
						
					}else{
						//console.log('pembatalan pendaftaran gagal !');
						$("#notice-btl").show();
						$("#notice-field-btl").attr('class', 'alert alert-danger');
						$("#notice-txt-btl").html('Pembatalan Pendaftaran Verifikasi Surat Ket. Pendamping Ijazah untuk NIM '+nim+' Gagal !');
						$("#notice-btl").fadeOut(5000);
					}
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
    	$('#tahun').on('change', function(){
    		fill_bulan();
    	});

    	$('#cek_tampil').on('click', function(){
    		get_all_data();
    	});

    	$('#ceknim').on('click', function(){
    		get_nim();
    	});
	});

	</script>

	<script src="http://akademik.uin-suka.ac.id/asset/js/bootstrap.min.js"></script>
</head>
<body>
	<br>	

<div>		
	<ul id="crumbs">
		<li><a href="<?php echo base_url('skpi/skpi_admin'); ?>" title="Beranda">Beranda</a></li>
		<li>Data Pendaftaran Verifikasi <?php echo $string_skpi[0]; ?></li>
	</ul>
</div>


<br>
<?php if(1==0){ ?>
	<div>
		<div class="bs-callout bs-callout-error">Tidak Ada Label SKPI yang Berstatus Aktif !</div>
	</div>
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
			<td width="50px">Tahun</td>
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
			<td>
				<button class="btn-uin btn btn-inverse btn btn-small" name="cek_tampil" id="cek_tampil">Tampil</button>
			</td>
		</tr>
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
				<input type="text" name="nim" id="nim">
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
	<h3>Data Pendaftaran Verifikasi <?php echo $string_skpi[0]; ?></h3>

		<div id="notice" hidden>
			<div class="bs-callout bs-callout-error">
				<p id="notice-text"></p>
			</div>
		</div>

	<form action="<?php echo base_url(); ?>skpi/skpi_admin/verifikasi_data_mhs" method="POST">
	<table class="table table-bordered">
		<thead>
		<tr>
			<th>No.</th>
			<th>NIM</th>
			<th>Nama</th>
			<th>Program Studi</th>
			<th width="100px">Tanggal Daftar</th>
			<th>Status</th>
			<th width="5%;">Proses</th>
		</tr>
		</thead>

		<tbody id="data-mhs"></tbody>
		<!-- <?php
		$i=1;

		foreach ($mhs as $key) { ?>
			<tr>
				<td style="vertical-align: middle; text-align: center;"><?php echo $i; $i++; ?>.</td>
				<td style="vertical-align: middle;"><?php echo $key['NIM']; ?></td>
				<td style="vertical-align: middle;"><?php echo $key['NAMA']; ?></td>
				<?php if($key['STATUS']){ ?>
					<td class="tac" align="center" style="vertical-align: middle;">
						<span class="badge badge-success">
							<i class="icon-white icon-ok"></i>
						</span>
					</td>
					<td align="center" style="vertical-align: middle;">
						-
					</td>
				<?php }else{ ?>
					<td class="tac" align="center" style="vertical-align: middle;">
						<span class="badge badge-important">
							<i class="icon-white icon-remove"></i>
						</span>
					</td>
					<td align="center" style="vertical-align: middle;">
						<?php if($this->session->userdata('skpi_lvl')!='laporan' && $this->session->userdata('skpi_lvl')!='admin' && $status_label==1){ ?>
							<button class="btn-uin btn-inverse btn-small" type="submit" name="btn_valid" value="<?php echo $key['NIM']; ?>">validasi</button>
						<?php }else{ ?>
							-
						<?php } ?>
					</td>
				<?php } ?>
			</tr>
		<?php
			
		 } ?> -->
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
			<tr>
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
			</tr>
		</table>

	</div>
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
                <h4 class="modal-title" id="labelModalKu">Formulir Pembatalan Pendaftaran Verifikasi SKPI</h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- <p class="statusMsg"></p>
                <form role="form">
                    <div class="form-group">
                        <label for="masukkanNama">Nama</label>
                        <input type="text" class="form-control" id="masukkanNama" placeholder="Masukkan nama Anda"/>
                    </div>
                    <div class="form-group">
                        <label for="masukkanEmail">Email</label>
                        <input type="email" class="form-control" id="masukkanEmail" placeholder="Masukkan email Anda"/>
                    </div>
                    <div class="form-group">
                        <label for="masukkanPesan">Pesan</label>
                        <textarea class="form-control" id="masukkanPesan" placeholder="Masukkan pesan Anda"></textarea>
                    </div>
                </form> -->
                <div>
                	<h4>Data Pendaftar Verifikasi SKPI :</h4>
                	<br>
                	<table class="table noborder">
                		<tbody id='skpi-mhs'></tbody>
                		<!-- <tr>
                			<td width="100px">NIM</td>
                			<td>: 13651060 [sample]</td>
                		</tr>
                		<tr>
                			<td>Nama</td>
                			<td>: Danang Aji Bimantoro</td>
                		</tr>
                		<tr>
                			<td>Prodi</td>
                			<td>: Teknik Informatika (S1)</td>
                		</tr>
                		<tr>
                			<td>Tanggal Daftar</td>
                			<td>: 09 April 2018</td>
                		</tr> -->
                	</table>
                </div>

                 <div>
                	<h4>Keterangan Pembatalan Pendaftaran Verifikasi :</h4>
                	<br>
                	<div class="form-group">
                        <textarea class="form-control" id="pesan-txt" placeholder="Masukkan Keterangan" style="margin: 0px 0px 10px; width: 515px; height: 57px;"></textarea>
                    </div>

                </div>

<!--                 <div>
                	<p>
						<div class="jumbotron" style="background-color: #ffc9b8; border-radius: 5px; padding: 10px;">
							<table class="table table-bordered" style="border: 0px solid black; margin: 0px;">
								<tr>
									<td style="border: 1px; vertical-align: middle; text-align: center; width: 30px;">
										<input type="checkbox" name="cekbox" required onchange="enable_button();">
									</td>
									<td style="border: 1px;"><b>Lanjutkan</b> proses pembatalan pendaftaran verifikasi Surat Ket. Pendamping Ijazah</td>
								</tr>
							</table>
						</div>
					</p>
                </div> -->
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn-uin btn btn-small btn-inverse" id="btn-batal" onclick="batal_pendaftaran_verifikasi($(this).val());">Batalkan Pendaftaran Verifikasi</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
