<div>
	<form class="form-inline">
		<table class="table-snippet">
			<tr>
				<td style="padding: 10px;" class="reg-label" width="20%;">Cek Data</td>
				<td style="padding: 10px;" class="reg-input"><input type="text" name="cek" class="form-control" id="cek"></td>
			</tr>
		</table>
	</form>
</div>

<script type="text/javascript">
	   (function(){

      $( "#cek" ).autocomplete({
         source: "<?php echo base_url().'/skpi/skpi_admin/testing_ac'?>",  
           minLength:2
        });
    })
</script>