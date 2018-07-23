<div class="modal-body">
  <?php
	if(isset($delete_confirm)){
		echo $delete_confirm;
	}
  ?>
</div>
<div class="modal-footer"> 
	<form method="post">
	  <button onclick="parent.$.colorbox.close()" class="btn btn-default">Tidak</button>
	  <button type="submit"name="submit" class="btn btn-primary btn-ok">Ya</button>
	</form> 
</div>