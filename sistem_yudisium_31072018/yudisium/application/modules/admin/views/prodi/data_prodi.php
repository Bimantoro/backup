<?php 
	$a=$this->session->flashdata('msg');
	if($a!=null):?>
		<div class="alert alert-<?php echo $a[0]?> alert-msg">
			<?php echo $a[1] ?>
		</div>
		
	<?php  endif;?>
<a href="<?php echo site_url('admin/prodi/add_prodi')?>" class="btn btn-default add"> <i class="fa fa-plus"></i> Tambah</a>
<br>
<br>

<table class="table table-striped table-bordered" id="datatable">
<thead>
  <tr>
	<td width="5%" align="center"><b>No</b></td>
	<td width="35%" align="center"><b>Nama Fakultas</b></td>
	<td width="5%" align="center"><b>Kode Prodi</b></td>
	<td width="30%" align="center"><b>Nama Prodi</b></td>
	<td width="10%" align="center"><b>Jenjang</b></td>
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
						row += "<td>"+val.nama_fakultas+"</td>";
						row += "<td align='center'>"+val.kode_prodi+"</td>";
						row += "<td>"+val.nama_prodi+"</td>";
						row += "<td align='center'>"+val.nama_jenjang+"</td>";
						row += "<td class='center'>";
							row += "<a href='<?php echo base_url(); ?>admin/prodi/edit/"+val.kode_prodi+"' class='edit btn btn-sm btn-primary btn-icon pr-none mr-md' title='Edit'><i class='fa fa-pencil'></i></a><a href='<?php echo base_url(); ?>admin/prodi/delete/"+val.kode_prodi+"' class='delete btn btn-sm btn-danger btn-icon pr-none' title='Hapus'><i class='fa fa-trash'></i></a>"
						row += "</td>"
						row += "</tr>";

						$('#data-json').append(row);
						nomor++;
						row = "";
					});
				}else{
					$('#data-json').append("<tr><td colspan='9' align='center'>Tidak ada data untuk ditampilkan !</tr>");
				}
				
			}
		});
	}

	fill_data();
</script>

				
				
