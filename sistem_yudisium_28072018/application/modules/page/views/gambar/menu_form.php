<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/select2/select2.min.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/select2/select2.min.css') ?>">

<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="id_album">id_album</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="id_album" id="id_album" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_unit">Foto</label>
		<div class="col-md-6">	
			<input id="file" name="photos" type="file" /> 
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_unit">Preview</label>
		<div id="galery"></div>
	</div>
	
	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>

</form>

 <script>  
 $(document).ready(function(){  
      $('#file').on('change', function(e){ 
      	var foto = $('#file').val();
      	console.log(foto);
           e.preventDefault();  
           $.ajax({  
                url: "get_preview",  
                type: "POST",  
                data: 'photos='+$('#file').val(),  
                contentType: false,  
                processData:false,  
                success: function(data)  
                {  
                     $("#galery").html(data);  
                     alert("Image Uploaded");  
                }  
           });  
      });  
 });  
 </script>  

