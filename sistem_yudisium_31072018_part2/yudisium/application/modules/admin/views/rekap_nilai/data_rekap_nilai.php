<form class="form-horizontal form-bordered">
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
	<div class="form-group" align="right">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="button" class="btn btn-primary" id="btn-show">Tampilkan Rekap Nilai</button>
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

<div id="ctn-rekap" hidden>
	<table class="table table-striped table-bordered" id="datatable">
	<thead>
	  <tr>
		<td width="5%" align="center"><b>No</b></td>
		<td width="47%" align="center"><b>Mata Ujian</b></td>
		<td width="12%" align="center"><b>MIN</b></td>
		<td width="12%" align="center"><b>MAX</b></td>
		<td width="12%" align="center"><b>Rata-Rata</b></td>
		<td width="12%" align="center"><b>SD</b></td>
	  </tr>
	</thead>
	<tbody id="data-json">
		<tr>
			<td colspan='9' align='center'>Tidak ada data untuk ditampilkan !</td>
		</tr>
	</tbody>
	</table>
</div>

<script type="text/javascript">
	function fill_data(){
		var jalur = $('#jalur').val();

		$('#loading').show();
		$('#ctn-rekap').hide();

		$.ajax({
			url 	: '<?php echo $json_url ?>',
			type 	: 'POST',
			data 	: 'jalur='+jalur,

			success : function(result){
				$('#data-json').empty();

				if(result != '0'){
					var u = JSON.parse(result);
					var nomor = 1;
					var row = '';
			
					$.each(u, function(idx, val){
						row += "<tr>";
						row += "<td align='center'>"+nomor+"</td>";
						row += "<td>"+val.nama_ujian+"</td>";
						row += "<td align='center'>"+val.min+"</td>";
						row += "<td align='center'>"+val.max+"</td>";
						row += "<td align='center'>"+val.average+"</td>";
						row += "<td align='center'>"+val.std+"</td>";
						row += "</tr>";

						$('#data-json').append(row);
						nomor++;
						row = "";
					});
				}else{
					$('#data-json').append("<tr><td colspan='9' align='center'>Tidak ada data untuk ditampilkan !</td></tr>");
				}
				
				$('#loading').hide();
				$('#ctn-rekap').show();
			}
		});
	}


	$(document).ready(function(){

		$("#btn-show").on('click', function(){
			fill_data();
		});

	});


</script>