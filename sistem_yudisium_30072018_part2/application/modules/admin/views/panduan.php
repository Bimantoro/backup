<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th width="5%">No</th>
			<th width="95%">Fitur</th>
		</tr>
	</thead>
	<tbody>
		<?php $n = 1; ?>
		<tr>
			<td><?php echo($n++) ?></td>
			<td>Dokumen <a href='<?php echo site_url('admin/dokumen/panduan')?>'><i class='fa fa-link'></i></a></td>
		</tr>
		<tr>
			<td><?php echo($n++) ?></td>
			<td>Album dan Foto <a href='<?php echo site_url('admin/album/panduan')?>'><i class='fa fa-link'></i></a></td>
		</tr>
		<tr>
			<td><?php echo($n++) ?></td>
			<td>Video <a href='<?php echo site_url('admin/video/panduan')?>'><i class='fa fa-link'></i></a></td>
		</tr>
	</tbody>
</table>