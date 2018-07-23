<?php 
	$a=$this->session->flashdata('msg');
	if($a!=null):?>
		<div class="alert alert-<?php echo $a[0]?> alert-msg">
			<?php echo $a[1] ?>
		</div>
		
	<?php  endif;?>
<a href="<?php echo site_url('admin/prodi/add_prodi')?>" class="btn btn-default add"> <i class="fa fa-plus"></i> Tambah</a>		
<table class="datatable table table-striped table-bordered" id="datatable">
<thead>
  <tr>
	<th width="5%">No</th>
	<th width="20%">Nama Unit</th>
	<th width="10%">Subdomain</th>
	<th width="10%">telp</th>
	<th width="10%">email</th>
	<th width="10%">Sidebar</th>
	<th width="5%">Slider</th>
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
			{ "mDataProp": "id","bSortable":false },
			{ "mDataProp": "nama_unit"},
			{ "mDataProp": "subdomain"},
			{ "mDataProp": "telp"},
			{ "mDataProp": "email"},
			{ "mDataProp": "nama_sidebar_unit"},
			{ "mDataProp": "status_slider_bar"},
			{ "mDataProp": "action","fnRender": getAction, "sClass": "center" },
		   ]
		});
		
		$('.datatable').each(function(){
			var datatable = $(this);
			var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
			search_input.attr('placeholder', 'Search');
			search_input.addClass('form-control input-sm');
			var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
			length_sel.addClass('form-control input-sm');
		});

	function reloadTable() {
		 RefreshTable('#datatable', "<?php echo site_url('master/barang/barang_json')?>");
		 $.colorbox.close();
	 }
	 
	function RefreshTable(tableId, urlData){
	  $.getJSON(urlData, null, function( json ){
		table = $(tableId).dataTable();
		oSettings = table.fnSettings();
		
		table.fnClearTable(this);

		oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
		table.fnDraw();
	  });
	}
	
	$('.add').on('click', function () {
		var urld=$(this).attr('href');
		$.colorbox({width:450, height:570, iframe:true, href:urld, escKey: false, overlayClose: false,
			onLoad: function() {
			$('#cboxClose').remove();
		}});
	   return false;
	} );
	
	$(document).on('click', '.edit', function () {
		var urld=$(this).attr('href');
		$.colorbox({width:450, height:570, iframe:true, href:urld, escKey: false, overlayClose: false, 
			onLoad: function() {
			$('#cboxClose').remove();
		}});
	   return false;
	} );
	
	$(document).on('click', '.delete', function () {
	var urld=$(this).attr('href');
	$.colorbox({width:480, height:280, iframe:true, href:urld, 
			onLoad: function() {
			$('#cboxClose').remove();
		}});
	   return false;
	} );
	
	$(document).on('click', '.picture', function () {
	var urld=$(this).attr('href');
	$.colorbox({width:360, height:560, iframe:true, href:urld,
			onLoad: function() {
			$('#cboxClose').remove();
		} });
	   return false;
	} );

	function getJqDate(oObj){
		var sValue = oObj.aData['tgl_jual']; 
		var tgl = new Array();
		tgl=sValue.split('-');
		return tgl[2] + "/" +tgl[1] + "/" + tgl[0];
	}
	
	function setLinkDetail(oObj){
		var id = oObj.aData['id_menu'];  
		var url_data = "<?php echo site_url('transaction/penjualan/detail')?>/"+id;
		return "<a href='"+url_data+"' title='Detail'>a"+id+"</a>";
	}
	function getAction(oObj){
		var id = oObj.aData['id'];  
		var url_edit = "<?php echo site_url('admin/prodi/edit')?>/"+id;
		var url_delete = "<?php echo site_url('admin/prodi/delete')?>/"+id;
		return "<a href='"+url_edit+"' class='edit btn btn-sm btn-primary btn-icon pr-none mr-md' title='Edit'><i class='fa fa-pencil'></i></a><a href='"+url_delete+"' class='delete btn btn-sm btn-danger btn-icon pr-none' title='Hapus'><i class='fa fa-trash'></i></a>";
	}
	
</script>
				
				
				
