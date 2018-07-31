<?php 
	$a=$this->session->flashdata('msg');
	if($a!=null):?>
		<div class="alert alert-<?php echo $a[0]?> alert-msg">
			<?php echo $a[1] ?>
		</div>
		
	<?php  endif;?>
<a href="<?php echo site_url('admin/pilihan/add_pilihan')?>" class="btn btn-default add"> <i class="fa fa-plus"></i> Tambah</a>
<br>
<br>

<table class="table table-bordered" id="datatable">
<thead>
  <tr>
	<td width="5%" align="center"><b>No</b></td>
	<td width="20%" align="center"><b>PMB</b></td>
	<td width="5%" align="center"><b>Pilihan</b></td>
	<td width="10%" align="center"><b>Tanggal Mulai</b></td>
	<td width="10%" align="center"><b>Tanggal Selesai</b></td>
	<td width="20%" align="center"><b>Info Yudisium</b></td>
	<td width="15%" align="center"><b>Action</b></td>
  </tr>
</thead>
<tbody id="data-json">
  <tr>
	<td>loading...</td>
  </tr>
</tbody>
</table>
	
<script>
	function fill_data(){
		$.ajax({
			url  : '<?php echo $json_url ?>',
			type : 'POST',
			data : '',

			success : function(result){
				$('#data-json').empty();

				if(result != '0'){
					var u = JSON.parse(result);
					var nomor = 1;
					var row = '';
			
					$.each(u, function(idx, val){	
						row += "<tr>";
						row += "<td align='center'>"+nomor+"</td>";
						row += "<td>Tahun : "+val.tahun+"<br>Kode Jalur : "+val.nama_jalur+"<br>Gelombang : "+val.kode_gelombang+"<br>Kelas : "+val.kode_kelas+"</td>";
						row += "<td align='center'>"+val.pilihan+"</td>";
						row += "<td align='center'>"+val.tgl_mulai+"</td>";
						row += "<td align='center'>"+val.tgl_selesai+"</td>";
						row += "<td>NO : "+val.no_yudisium+"<br>Ketua : "+val.ketua_yudisium+"<br>Tempat : "+val.tempat_yudisium+"<br>Tanggal : "+val.tgl_yudisium+"<br>Status : <b>"+val.status+"</b></td>";
						row += "<td class='center'>";
							row += "<a href='<?php echo base_url(); ?>admin/pilihan/edit/"+val.tahun+"/"+val.kode_jalur+"/"+val.kode_gelombang+"/"+val.kode_kelas+"/"+val.pilihan+"' class='edit btn btn-sm btn-primary btn-icon pr-none mr-md' title='Edit'><i class='fa fa-pencil'></i></a><a href='<?php echo base_url(); ?>admin/pilihan/delete/"+val.tahun+"/"+val.kode_jalur+"/"+val.kode_gelombang+"/"+val.kode_kelas+"/"+val.pilihan+"' class='delete btn btn-sm btn-danger btn-icon pr-none' title='Hapus'><i class='fa fa-trash'></i></a>";
						row += "</td>";
						row += "</tr>";

						$('#data-json').append(row);
						row = "";
						nomor++;
					});

				}else{
					$('#data-json').append("<tr><td colspan='7' align='center'>Tidak ada data untuk ditampilkan !</tr>");
				}
				
			}
		});
	}

	fill_data();
</script>

				
				
