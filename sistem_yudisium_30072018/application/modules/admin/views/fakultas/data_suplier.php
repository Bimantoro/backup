<script src="<?php echo base_url()?>asset/datatables-bootstrap/js/jquery.min.js"></script>
<script src="<?php echo base_url()?>asset/bootstrap-modal-master/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>asset/datatables-bootstrap/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>asset/datatables-bootstrap/js/datatables.js"></script>

<link rel="stylesheet" href="<?php echo base_url()?>asset/colorbox/css/colorbox.css" />
<script src="<?php echo base_url()?>asset/colorbox/jquery.colorbox.js"></script>

<div class="row">
    <h2><span>Suplier</span></h2>
	<a href="<?php echo site_url('master/suplier/add')?>" class="btn btn-sm btn-default add"> <span class="add-ico">Tambah</span></a>		
	<table width="700" class="datatable table table-striped table-bordered" id="datatable">
	<thead>
	  <tr>
		<th width="40%">Nama</th>
		<th width="10%">Telp</th>
		<th width="10%">Email</th>
		<th width="20%">BBM</th>
		<th width="20%">Action</th>
	  </tr>
	</thead>
	<tbody>
	  <tr>
		<td>loading...</td>
	  </tr>
	</tbody>
	</table>
			
</div>

<script type="text/javascript" charset="utf-8">

	 $('#datatable').dataTable
		({
			'bServerSide'    : true,
			'sAjaxSource'    : "<?php echo $json_url ?>",
			"bFilter": true,
			"bLengthChange": false,
			"sPaginationType": "bs_full",
			'aoColumns': [ 
			{ "mDataProp": "nama_suplier" },
			{ "mDataProp": "telp" },
			{ "mDataProp": "email" },
			{ "mDataProp": "bbm" },
			{ "mDataProp": "action","fnRender": getAction, "sClass": "center" },			
		   ],
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
		 RefreshTable('#datatable', "<?php echo site_url('master/suplier/suplier_json')?>");
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
		$.colorbox({width:450, height:560, iframe:true, href:urld, escKey: false, overlayClose: false,
			onLoad: function() {
			$('#cboxClose').remove();
		}});
	   return false;
	} );
	
	$(document).on('click', '.edit', function () {
		var urld=$(this).attr('href');
		$.colorbox({width:450, height:560, iframe:true, href:urld, 
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
	
	
$(function(){
    $("#myModal").on('hidden.bs.modal', function(){
	
  $(this).removeData('bs.modal');
       alert("Modal window has been completely closed.");
    });
});
$('body').on('hidden.bs.modal', '.modal', function () {
  $(this).removeData('modal');
});	
	function getAction(oObj){
		var id = oObj.aData['action'];  
		var url_edit = "<?php echo site_url('master/suplier/edit')?>/"+id;
		var url_delete = "<?php echo site_url('master/suplier/delete')?>/"+id;
		return "<a href='"+url_edit+"' class='edit' title='Edit'></a><a href='"+url_delete+"' class='delete'></a>";
	}
</script>
				
				
				
