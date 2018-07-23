<?php 
	$a=$this->session->flashdata('msg');
	if($a!=null):?>
		<div class="alert alert-<?php echo $a[0]?> alert-msg">
			<?php echo $a[1] ?>
		</div>
		
	<?php  endif;?>
<a href="<?php echo site_url('admin/main/add_halaman')?>" class="btn btn-default add"> <i class="fa fa-plus"></i> Tambah</a>		
<table class="datatable table table-striped table-bordered" id="datatable">
<thead>
  <tr>
	<th width="5%">No</th>
	<th>Url</th>
	<th width="30%">Nama Halaman</th>
	<th width="35">Foto</th>
	<!-- <th width="35%">Konten</th>-->
	<th width="30%">Action</th>
  </tr>
</thead>
<tbody>
  <tr>
	<td>loading...</td>
  </tr>
</tbody>
</table>
	

<script type="text/javascript" charset="utf-8">

	 $('#datatable').dataTable
		({
			'bServerSide'    : true,
			'sAjaxSource'    : "<?php echo $json_url ?>",
			"bFilter": true,
			"bLengthChange": false,
			"aaSorting": [[1,'asc'],[0,'desc']],
			"fnDrawCallback": function ( oSettings ) {
				for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
				{
					$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1+oSettings._iDisplayStart);
				}
			},
			'aoColumns': [ 			
			{ "mDataProp": "id_page","bSortable":false },
			{ "mDataProp": "id_page","fnRender": setLink},
			{ "mDataProp": "title"},
			{ "mDataProp": "foto"},
			/* { "mDataProp": "content" }, */
			{ "mDataProp": "action","fnRender": getAction, "sClass": "center" },
		   ]
		});
		
		$('#datatable').each(function(){
			var datatable = $(this);
			var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
			search_input.attr('placeholder', 'Search');
			search_input.addClass('form-control input-sm');
			var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
			length_sel.addClass('form-control input-sm');
		});


	function setLink(oObj){
		var id = oObj.aData['id_page'];
		return "page/prodi/"+id;
	}
	function setUrl(oObj){
		var id = oObj.aData['id_page'];
		var url_data = id;
		return url_data;
	}
	function setLinkDetail(oObj){
		var id = oObj.aData['id_page'];  
		var url_data = "<?php echo site_url('transaction/penjualan/detail')?>/"+id;
		return "<a href='"+url_data+"' title='Detail'>a"+id+"</a>";
	}
	function getAction(oObj){
		var id = oObj.aData['id_page'];
		var pecah = id.split("/");
		var id_saja = pecah[2];
		var url_edit = "<?php echo site_url('admin/main/edit_page')?>/"+id_saja;
		var url_delete = "<?php echo site_url('admin/main/delete_page')?>/"+id_saja;
		return "<a href='"+url_edit+"' class='edit btn btn-sm btn-primary btn-icon pr-none mr-md' title='Edit'><i class='fa fa-pencil'></i></a><a href='"+url_delete+"' class='delete btn btn-sm btn-danger btn-icon pr-none' title='Hapus'><i class='fa fa-trash'></i></a>";
	}
	
</script>
				
				
				
