<script>
$(document).ready(function(){

	$('#kurikulum').on('change',  function() {
		$("#form").submit(); 
	}); 
}); 
</script>
<div class="article-content">	
		<div class="article-title">Kurikulum</div>
		<div class="clear20"></div>
		<?php if($kurikulum){ ?>
			<form id="form" method="post" action="">
			  <div class="form-group">
				<label for="kurikulum" class="col-xs-3 control-label" style="margin-top:5px">Kurikulum </label>
				<div class="col-sm-8">
					<select id="kurikulum" name="kurikulum" class="form-control input-sm">
						<?php 
						foreach($kurikulum as $k){
							if($k['KD_KUR']==$kd_kur){
							echo"<option value='".$k['KD_KUR']."' selected>".$k['NM_KUR']."</option>";
							}else{
							echo"<option value='".$k['KD_KUR']."'>".$k['NM_KUR']."</option>";
							}
						}
						?>
					</select>
				</div>
			  </div>				
			</form>
			<div class="clear20"></div>
				
			<?php foreach($armk as $smt=>$mk){?>
			<h3 style="margin-bottom:5px; font-size: 16px; color: rgb(164, 136, 74);">Semester Paket <?php echo $smt ?></h3>
			<table class="table table-bordered table-hover table-condensed">
			<thead>
				<tr><th>No</th><th>Kode MK</th><th>Nama Mata Kuliah</th><th>SKS</th><th>Jenis MK</th></tr>
			</thead>
			<tbody>	<?php $j=0;?>
				<?php foreach ($mk as $m){ ?>
					<tr><td width="5%" style="text-align:center"><?php echo ++$j ?></td>
					<td width="15%"><u><a href="<?php echo site_url('page/mata_kuliah/'.$m->kd_kur.'/'.$m->kd_mk)?>"><?php echo $m->kd_mk ?></a></u></td>
					<td width="55%"><?php echo $m->nm_mk ?></td>
					<td style="text-align:center" width="10%"><?php echo $m->sks_mk ?></td>
					<td style="text-align:center" width="10%"><?php echo $m->jenis_mk?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
			<?php } ?>
	<?php } ?>
			
</div>
