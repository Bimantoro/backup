<style type="text/css">
    table { page-break-inside:auto }
    table.print-friend { page-break-inside:avoid; page-break-after: auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
    p {text-align: justify;}
    span {text-align: justify;}

</style>
<?php if(!empty($peserta)){
	$jumlah_kelas = count($peserta);
	?>

	<?php foreach ($peserta as $kelas => $value) { ?>
		<?php $jml_page = count($value); ?>
		<?php $curr_page = 0; ?>
		<?php $nomor = 1; ?>
		<?php foreach ($value as $cluster => $val) { ?>
			<?php $curr_page++; ?>
			<br>	
			<br>	
			<br>		
			<br>		
			<div style="page-break-inside: avoid; page-break-after: auto;">
				<table>
					<?php if($curr_page == 1){ ?>
					<tr>
						<td style="width: 13%;"><p style="font-size: 9px;"><?php echo ucwords('Program Studi'); ?></p></td>
						<td style="width: 85%;"><p style="font-size: 9px;">: <?php echo ucwords($prodi); ?></p></td>
					</tr>
					<?php } ?>
					<?php if($jumlah_kelas > 1){ ?>
					<tr>
						<td style="width: 13%;"><p style="font-size: 9px;"><?php echo ucwords('Kelas'); ?></p></td>
						<td style="width: 85%;"><p style="font-size: 9px;">: <?php echo ucwords($p); ?></p></td>
					</tr>
				<?php 	} ?>
				</table>

				<?php if($curr_page == 1){ ?>
				<br>
				<br>
				<?php } ?>

				<table style="border: 0.1px solid #3a3a3a; width: 100%; " cellpadding="5" width="100%;">
					<tr style="background-color: #d4d4d4; vertical-align: middle;">
						<td style="border: 0.1px solid #3a3a3a; width: 6%;" ><span style="font-size: 9px; text-align: center; vertical-align: middle;"><b>No</b></span></td>
						<td style="border: 0.1px solid #3a3a3a; width: 20%;" ><span style="font-size: 9px; text-align: center; vertical-align: middle;"><b>Nomor Peserta</b></span></td>
						<td style="border: 0.1px solid #3a3a3a; width: 74%;" ><span style="font-size: 9px; text-align: center; vertical-align: middle;"><b>Nama Peserta</b></span></td>
					</tr>
					<?php for ($i=0; $i < count($val); $i++) { ?>
						<tr style="vertical-align: middle;">
							<td style="border: 0.1px solid #3a3a3a; width: 6%;" ><span style="font-size: 9px; text-align: center; vertical-align: middle;"><?php echo $nomor; $nomor++; ?>.</span></td>
							<td style="border: 0.1px solid #3a3a3a; width: 20%;" ><span style="font-size: 9px; text-align: center; vertical-align: middle;"><?php echo $val[$i]['nomor_peserta']; ?></span></td>
							<td style="border: 0.1px solid #3a3a3a; width: 74%;" ><span style="font-size: 9px; vertical-align: middle;"><?php echo $val[$i]['nama_peserta']; ?></span></td>
						</tr>
					<?php } ?>
				</table>

				<?php if($curr_page == $jml_page){ ?>
					<br>
					<br>
					<br>
					<table>
						<tr>
							<td style="width: 70%;"></td>
							<td style="width: 30%;">
								<span style="font-size: 9px;"><?php echo $ttd['tempat']; ?></span><br>
								<span style="font-size: 9px;">Ketua</span><br>
								<span style="font-size: 9px;"></span><br>
								<span style="font-size: 9px;"></span><br>
								<span style="font-size: 9px;"></span><br>
								<span style="font-size: 9px;"><?php echo $ttd['ketua']; ?></span><br>
							</td>
						</tr>
					</table>
				<?php }else{ ?>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<?php if($curr_page > 1){ ?>
							<br>
							<br>
							<br>
						<?php } ?>
				<?php } ?>


			</div>
		<?php } ?>

	<?php } ?>


<?php } ?>



