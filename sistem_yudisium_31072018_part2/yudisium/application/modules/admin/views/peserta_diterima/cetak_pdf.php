<style type="text/css">
    table { page-break-inside:auto }
    table.print-friend { page-break-inside:avoid; page-break-after: auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
    p {text-align: justify;}
    span {text-align: justify;}

	.rTableRow { display: table-row; }
	.rTableHeading { display: table-header-group; }
	.rTableBody { display: table-row-group; }
	.rTableFoot { display: table-footer-group; }
	.rTableCell, .rTableHead { display: table-cell; }

</style>

<!-- <table>
	<tr>
		<td style="width: 100%;">
			<table style="width: 100%;">
				<?php foreach ($header as $k => $v) { ?>
					<tr><td><b style="font-size: 9px;"><?php echo ucwords($v); ?></b></td></tr>
				<?php } ?>
			</table>
		</td>
	</tr>
</table> -->

<br>
<br>
<br>
<br>

<?php if(!empty($peserta)){ ?>
	<?php $jumlah_kelas = count($peserta); ?>
	<?php $temp_posisi_kelas = 0; ?>
	<?php foreach ($peserta as $p => $v) { ?>
		<?php $temp_posisi_kelas++; ?>
		<table>
			<tr>
				<td style="width: 13%;"><p style="font-size: 9px;"><?php echo ucwords('Program Studi'); ?></p></td>
				<td style="width: 85%;"><p style="font-size: 9px;">: <?php echo ucwords($prodi); ?></p></td>
			</tr>
			<?php if($jumlah_kelas > 1){ ?>
			<tr>
				<td style="width: 13%;"><p style="font-size: 9px;"><?php echo ucwords('Kelas'); ?></p></td>
				<td style="width: 85%;"><p style="font-size: 9px;">: <?php echo ucwords($p); ?></p></td>
			</tr>
		<?php 	} ?>
		</table>
		<br>
		<br>
		<?php if($temp_posisi_kelas == $jumlah_kelas){
			$last_index = count($v) - 1; // minus 1 karena index mulai dari 0
			$jumlah_looping_data = $last_index;
			$last_kelas = $p;
			$sts_ttd = 1;
		}else{
			$jumlah_looping_data = count($v);
			$sts_ttd = 0;
		} ?>

		<table style="border: 0.1px solid #3a3a3a; width: 100%; " cellpadding="5" width="100%;">
			<tr style="background-color: #d4d4d4; vertical-align: middle;">
				<td style="border: 0.1px solid #3a3a3a; width: 6%;" ><span style="font-size: 9px; text-align: center; vertical-align: middle;"><b>No</b></span></td>
				<td style="border: 0.1px solid #3a3a3a; width: 20%;" ><span style="font-size: 9px; text-align: center; vertical-align: middle;"><b>Nomor Peserta</b></span></td>
				<td style="border: 0.1px solid #3a3a3a; width: 74%;" ><span style="font-size: 9px; text-align: center; vertical-align: middle;"><b>Nama Peserta</b></span></td>
			</tr>
			<?php $nomor = 1; ?>
			<?php for ($i=0; $i < $jumlah_looping_data; $i++) { ?>
				<tr style="vertical-align: middle;">
					<td style="border: 0.1px solid #3a3a3a; width: 6%;" ><span style="font-size: 9px; text-align: center; vertical-align: middle;"><?php echo $nomor; $nomor++; ?>.</span></td>
					<td style="border: 0.1px solid #3a3a3a; width: 20%;" ><span style="font-size: 9px; text-align: center; vertical-align: middle;"><?php echo $v[$i]['nomor_peserta']; ?></span></td>
					<td style="border: 0.1px solid #3a3a3a; width: 74%;" ><span style="font-size: 9px; vertical-align: middle;"><?php echo $v[$i]['nama_peserta']; ?></span></td>
				</tr>
			<?php } ?>
		</table>

		<?php if($sts_ttd == 1){ ?>
		<div style="page-break-inside: avoid;">
			<table style="width: 100%; ma rgin: 0px; padding: 0px; page-break-inside: avoid;" class="print-friend">
				<tr style="width: 100%; margin: 0px; padding: 0px; page-break-inside: avoid;">
					<td style="width: 100%; margin: 0px; padding: 0px; page-break-inside: avoid;">
						
						<table style="border: 0.1px solid #3a3a3a; width: 100%; page-break-inside: avoid; " cellpadding="5" width="100%;">
							<tr>
								<td style="border: 0.1px solid #3a3a3a; width: 6%;" ><span style="font-size: 9px; text-align: center; vertical-align: middle;"><?php echo $nomor; ?>.</span></td>
								<td style="border: 0.1px solid #3a3a3a; width: 20%;" ><span style="font-size: 9px; text-align: center; vertical-align: middle;"><?php echo $v[$last_index]['nomor_peserta']; ?></span></td>
								<td style="border: 0.1px solid #3a3a3a; width: 74%;" ><span style="font-size: 9px; vertical-align: middle;"><?php echo $v[$last_index]['nama_peserta']; ?></span></td>
							</tr>
						</table>
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

					</td>
				</tr>
			</table>
		</div>

		<?php } ?>

	<?php } ?>
<?php } ?>
