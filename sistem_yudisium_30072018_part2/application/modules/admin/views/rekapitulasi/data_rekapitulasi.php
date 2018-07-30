<?php 
	$a=$this->session->flashdata('msg');
	if($a!=null):?>
		<div class="alert alert-<?php echo $a[0]?> alert-msg">
			<?php echo $a[1] ?>
		</div>
		
	<?php  endif;?>

<?php foreach ($rekapitulasi as $r) { ?>
	<?php if(!empty($r[0])){ ?>
	<div>
		<h5><?php echo $r['nama_fakultas'] ?></h5>
		<table class="table table-bordered">
			<tr>
				<td align="center" width="5%"><b>No</b></td>
				<td align="center" width="45%"><b>Nama Program Studi</b></td>
				<td align="center" width="25%"><b>Pilihan 1</b></td>
				<td align="center" width="25%"><b>Pilihan 2</b></td>
			</tr>
			<?php $nomor = 1; ?>
			<?php foreach ($r[0] as $f) { ?>
			<tr>
				<td align="center"><?php echo $nomor; $nomor++; ?></td>
				<td><?php echo $f['nama_prodi'];  ?></td>
				<td align="center"><?php echo $f['pilihan1'] ?></td>
				<td align="center"><?php echo $f['pilihan2'] ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
<?php } ?>
<?php } ?>