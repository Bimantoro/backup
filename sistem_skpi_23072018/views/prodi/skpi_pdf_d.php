<?php error_reporting(E_ALL);
	$nomerurut = 1;

 ?>
<style type="text/css">
    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
    p {text-align: justify;}
    span {text-align: justify;}
</style>

<!-- top header -->
<table>
	<tr>
		<td style="width: 10%;"><img src="<?php echo $logo; ?>" width="50"></td>
		<td style="width: 90%;">
			<table style="width: 100%;">
				<tr><td><b style="font-size: 9px;"><?php echo strtoupper($KOP_SKPI['IDN']); ?></b></td></tr>
				<tr><td><i style="font-size: 9px;"><?php echo strtoupper($KOP_SKPI['EN']); ?></i></td></tr>
				<tr><td><b style="font-size: 9px;"><?php echo strtoupper($KOP_NM_UNIV['IDN']); ?></b></td></tr>
				<tr><td><i style="font-size: 9px;"><?php echo strtoupper($KOP_NM_UNIV['EN']); ?></i></td></tr>
			</table>
		</td>
	</tr>
	<!-- <tr  style="background-color:yellow;"><td><b style="font-size: 9px;">KEMENTERIAN AGAMA REPUBLIK INDONESIA</b></td></tr>
	<tr  style="background-color:yellow;"><td><i style="font-size: 9px;">MINISTRY OF RELIGIOUS AFFAIRS OF THE REPUBLIC OF INDONESIA</i></td></tr>
	<tr><td><b style="font-size: 9px;"><?php echo strtoupper($KOP_NM_UNIV['IDN']); ?></b></td></tr>
	<tr><td><i style="font-size: 9px;"><?php echo strtoupper($KOP_NM_UNIV['EN']); ?></i></td></tr> -->
</table>

<table style="padding-top: 5px"><tr><td></td></tr></table>


<!-- top title -->
<table>
	<tr align="center"><td><b style="font-size: 11px; padding-top: 10px;"><?php echo strtoupper($header['IDN']); ?></b></td></tr>
	<tr align="center"><td><b><i style="font-size: 11px;"><?php echo strtoupper($header['EN']); ?></i></b></td></tr>
	<tr align="center"><td><p style="font-size: 9px; text-align: center; ">Nomor: <?php echo $NOMOR_SKPI; ?></p></td></tr>
</table>

<!-- konten -->
<?php foreach ($detailheader as $key) { ?>
	<p style="text-align: justify; font-size: 9px"><?php echo $key['IDN']; ?></p>
	<p style="text-align: justify; font-size: 9px"><i><?php echo $key['EN']; ?></i></p>
<?php } ?>

<?php if(strlen($nomerurut)<=1){$nomertampil = '0'.$nomerurut; }else{$nomertampil = $nomerurut;} ?>

<table cellpadding="0" cellspacing="0">
	<tr><td><b style="font-size: 9px;"><?php echo $nomertampil; ?>. <?php echo strtoupper($mahasiswa[0]['idn']); ?> </b>
		<br>
		<b><i style="font-size: 9px;"><?php echo $nomertampil; ?>. <?php echo $mahasiswa[0]['en']; ?></i></b>
	</td></tr>
</table>

<table style="border: 0.1px solid #3a3a3a; width: 100%;" cellpadding="5" width="100%;">
	<?php for ($i=0; $i < count($mahasiswa[1]); $i++) { ?>
		<tr>
			<td style="border: 0.1px solid #3a3a3a; width: 6%;"><span style="font-size: 9px;"><?php echo $nomerurut; ?>.<?php echo $i+1; ?></span></td>
			<td style="border: 0.1px solid #3a3a3a; width: 47%;"><span style="font-size: 9px;"><?php echo $mahasiswa[1][$i]['idn']; ?><br><i><?php echo $mahasiswa[1][$i]['en']; ?></i></span>
			</td>
			<?php if(is_array($mahasiswa[2][$i])){ ?>
			<td style="margin-top: 30px; border: 0.1px solid #3a3a3a; width: 47%;"><span style="font-size: 9px;"><?php echo $mahasiswa[2][$i]['IDN'] ?><br><i><?php echo $mahasiswa[2][$i]['EN'] ?></i></span></td>
			<?php }else{ ?>
				<td style="margin-top: 30px; border: 0.1px solid #3a3a3a; width: 47%;"><span style="font-size: 9px; vertical-align: middle; "><?php echo $mahasiswa[2][$i]; ?></span></td>
			<?php } ?>
		</tr>
	<?php } ?>
</table>

<?php $nomerurut++; ?>



<table style="padding-top: 5px"><tr><td></td></tr></table>


<?php if(strlen($nomerurut)<=1){$nomertampil = '0'.$nomerurut; }else{$nomertampil = $nomerurut;} ?>
<table cellpadding="0" cellspacing="0">
	<tr><td><b style="font-size: 9px;"><?php echo $nomertampil; ?>. <?php echo strtoupper($instansi[0]['idn']); ?> </b>
		<br>
		<b><i style="font-size: 9px;"><?php echo $nomertampil; ?>. <?php echo $instansi[0]['en']; ?></i></b>
	</td></tr>
</table>

<table style="border: 0.1px solid #3a3a3a; width: 100%;" cellpadding="5" width="100%;">
	<?php for ($i=0; $i < count($instansi[1]); $i++) { ?>
		<tr>
			<td style="border: 0.1px solid #3a3a3a; width: 6%;" ><span style="font-size: 9px;"><?php echo $nomerurut; ?>.<?php echo $i+1; ?></span></td>
			<td style="border: 0.1px solid #3a3a3a; width: 47%;"><span style="font-size: 9px;"><?php echo $instansi[1][$i]['idn']; ?><br><i><?php echo $instansi[1][$i]['en']; ?></i></span>
			</td>
			<td style="margin-top: 10%; border: 0.1px solid #3a3a3a; width: 47%;">
				<?php if(is_array($instansi[2][$i])){ ?>
					<span style="font-size: 9px;"><?php echo $instansi[2][$i]['IDN'] ?><br><i><?php echo $instansi[2][$i]['EN'] ?></i></span>
				<?php }else{  ?>
					<span style="font-size: 9px;"><?php echo $instansi[2][$i]; ?></span>
				<?php } ?>

			</td>
		</tr>
	<?php } ?>
</table>

<?php $nomerurut++; ?>
<?php if(isset($capaian[1])){ ?>
	<table style="padding-top: 5px"><tr><td></td></tr></table>
	<?php if(strlen($nomerurut)<=1){$nomertampil = '0'.$nomerurut; }else{$nomertampil = $nomerurut;} ?>
	<table cellpadding="0" cellspacing="0">
		<tr><td><b style="font-size: 9px;"><?php echo $nomertampil; ?>. <?php echo strtoupper($capaian[0]['idn']); ?></b>
			<br>
			<b><i style="font-size: 9px;"><?php echo $nomertampil; ?>. <?php echo $capaian[0]['en']; ?></i></b>
		</td></tr>
	</table>

	<table style="border: 0.1px solid #3a3a3a; width: 100%;" cellpadding="5" width="100%;">
		<?php if(isset($capaian[0]['SUB'])){ ?>
		<tr>
			<td style="border: 0.1px solid #3a3a3a;" colspan="3"><p style="font-size: 9px;"><b><?php echo $capaian[0]['SUB']['IDN']; ?><br><i><?php echo $capaian[0]['SUB']['EN']; ?></i></b></p></td>
		</tr>
		<?php } ?>
					<?php for ($i=0; $i < count($capaian[1]); $i++) { 
							if(isset($capaian[2][$capaian[1][$i]['KODE']])){
								?>

								<tr>
									<td style="border: 0.1px solid #3a3a3a; width: 53%;" colspan="2"><p style="font-size: 9px;"><b><?php echo $capaian[1][$i]['IDN'] ?></b></p></td>
									<td style="border: 0.1px solid #3a3a3a; width: 47%;"><p style="font-size: 9px;"><b><i><?php echo $capaian[1][$i]['EN'] ?></i></b></p></td>
								</tr>

								<?php for ($j=0; $j < count($capaian[2][$capaian[1][$i]['KODE']]); $j++) { 
									?>
										<tr>
											<td style="border: 0.1px solid #3a3a3a; width: 6%;"><p style="font-size: 9px;"><?php echo ($j+1).'.'; ?></p></td>
											<td style="border: 0.1px solid #3a3a3a; width: 47%;"><p style="font-size: 9px;"><?php echo $capaian[2][$capaian[1][$i]['KODE']][$j]['IDN']; ?></p></td>
											<td style="border: 0.1px solid #3a3a3a; width: 47%;"><p style="font-size: 9px;"><i><?php echo $capaian[2][$capaian[1][$i]['KODE']][$j]['EN']; ?></i></p></td>
										</tr>

									<?php
								} ?>

								<?php
							}
						} ?>

	</table>

	<?php $nomerurut++; ?>
<?php } ?>
<table style="padding-top: 5px"><tr><td></td></tr></table>

<?php 
	$jml_data = 0;
	for ($i=0; $i < count($kegiatan[1]) ; $i++) { 
		$jml_data+=count($kegiatan[2][$i]);
	}
?>
<?php if($jml_data>0){ ?>
<?php if(strlen($nomerurut)<=1){$nomertampil = '0'.$nomerurut; }else{$nomertampil = $nomerurut;} ?>

<table cellpadding="0" cellspacing="0">
	<tr><td><b style="font-size: 9px;"><?php echo $nomertampil; ?>. <?php echo strtoupper($kegiatan[0]['idn']); ?> </b>
		<br>
		<b><i style="font-size: 9px;"><?php echo $nomertampil; ?>. <?php echo $kegiatan[0]['en']; ?></i></b>
	</td></tr>
</table>


<?php for($i=0; $i < count($kegiatan[1]); $i++) { ?>
			<?php if(count($kegiatan[2][$i])!=0){ ?>
			<table style="border: 0.1px solid #3a3a3a; width: 100%;" cellpadding="5" width="100%;">
				<tr>
					<td style="border: 0.1px solid #3a3a3a; width: 53%;" colspan="2"><p style="font-size: 9px;"><b><?php echo $kegiatan[1][$i]['idn']; ?></b></p></td>
					<td style="border: 0.1px solid #3a3a3a; width: 47%;"><p style="font-size: 9px;"><b><i><?php echo $kegiatan[1][$i]['en']; ?></i></b></p></td>
				</tr>
				<?php for ($j=0; $j < count($kegiatan[2][$i]); $j++) { ?>
				<tr>
					<td style="border: 0.1px solid #3a3a3a; width: 6%;"><p style="font-size: 9px;"><?php echo ($j+1).'.'; ?></p></td>
					<td style="border: 0.1px solid #3a3a3a; width: 47%;"><p style="font-size: 9px;"><?php echo $kegiatan[2][$i][$j]['IDN']; ?></p></td>
					<td style="border: 0.1px solid #3a3a3a; width: 47%;"><p style="font-size: 9px;"><i><?php echo $kegiatan[2][$i][$j]['EN']; ?></i></p></td>
				</tr>
				<?php } ?>
			</table>
			<table style="padding-top: 5px"><tr><td></td></tr></table>
			<?php } ?>	
<?php } ?>
<?php $nomerurut++; ?>

<table style="padding-top: 5px"><tr><td></td></tr></table>
<?php } ?>
<?php if(strlen($nomerurut)<=1){$nomertampil = '0'.$nomerurut; }else{$nomertampil = $nomerurut;} ?>
<table cellpadding="0" cellspacing="0">
	<tr><td><b style="font-size: 9px;"><?php echo $nomertampil; ?>. <?php echo strtoupper($info_sistem[0]['idn']); ?> </b>
		<br>
		<b><i style="font-size: 9px;"><?php echo $nomertampil; ?>. <?php  echo $info_sistem[0]['en'];?></i></b>
	</td></tr>
</table>

<table style="border: 0.1px solid #3a3a3a; width: 100%;" cellpadding="5" width="100%;">
	<tr>
		<td style="border: 0.1px solid #3a3a3a; width: 50%;" colspan="2"><p style="font-size: 9px;"><b><?php echo $info_sistem[0]['SUB']['IDN']; ?></b></p></td>
		<td style="border: 0.1px solid #3a3a3a; width: 50%;"><p style="font-size: 9px;"><b><i><?php echo $info_sistem[0]['SUB']['EN']; ?></i></b></p></td>
	</tr>
	<?php for ($i=0; $i < count($info_sistem[1]); $i++) { ?>
	
	<tr>
		<td style="border: 0.1px solid #3a3a3a; width: 50%;" colspan="2"><p style="font-size: 9px;"><?php echo $info_sistem[1][$i]['IDN']; ?></p></td>
		<td style="border: 0.1px solid #3a3a3a; width: 50%;"><p style="font-size: 9px;"><i><?php echo $info_sistem[1][$i]['EN']; ?></i></p></td>
	</tr>

	<?php } ?>
</table>

<?php $nomerurut++; ?>

<table style="padding-top: 5px"><tr><td></td></tr></table>

<?php if(strlen($nomerurut)<=1){$nomertampil = '0'.$nomerurut; }else{$nomertampil = $nomerurut;} ?>
<table cellpadding="0" cellspacing="0">
	<tr><td><b style="font-size: 9px;"><?php echo $nomertampil; ?>. <?php echo strtoupper($info_kkni[0]['idn']); ?> </b>
		<br>
		<b><i style="font-size: 9px;"><?php echo $nomertampil; ?>. <?php  echo $info_kkni[0]['en'];?></i></b>
	</td></tr>
</table>

<table style="border: 0.1px solid #3a3a3a; width: 100%;" cellpadding="5" width="100%;">
	<?php for($i=0; $i<count($info_kkni[1]); $i++){ ?>
	<tr>
		<td style="border: 0.1px solid #3a3a3a; width: 50%;" colspan="2"><p style="font-size: 9px;"><?php echo $info_kkni[1][$i]['IDN']; ?></p></td>
		<td style="border: 0.1px solid #3a3a3a; width: 50%;"><p style="font-size: 9px;"><i><?php echo $info_kkni[1][$i]['EN']; ?></i></p></td>
	</tr>
	<?php } ?>
</table>

<table style="padding-top: 5px"><tr><td></td></tr></table>
			
<table cellpadding="0" width="100%;">
	<tr>
		<td style="width: 50%;"></td>
		<td style="width: 50%;">
			<?php $mod=0; ?>
			<?php foreach ($ttd['title'] as $key => $value) { ?>
				<?php if($mod==0 || $mod%2==0){ ?>
					<span style="font-size: 10px;"><?php echo $value; ?></span><br>
				<?php }else{ ?>
					<span style="font-size: 10px;"><i><?php echo $value; ?></i></span><br>
				<?php } $mod++; ?>
			<?php } ?>
<!-- 			<span style="font-size: 10px;">Yogyakarta, 19 Juni 2017</span><br>
			<span style="font-size: 10px;"><i>Yogyakarta, June 19, 2017</i></span><br>
			<span style="font-size: 10px;">Dekan Fakultas Sains dan Teknologi</span><br>
			<span style="font-size: 10px;"><i>Dean of the Faculty of Science and Technology</i></span><br> -->
			<span style="font-size: 10px;"></span><br>
			<span style="font-size: 10px;"></span><br>
			<span style="font-size: 10px;"></span><br>
			<span style="font-size: 10px;"></span><br>
			<span style="font-size: 10px;"></span><br>
			<?php $mod=0; ?>
			<?php foreach ($ttd['contact'] as $key => $value) { ?>
				<?php if($mod==0 || $mod%2!=0){ ?>
					<span style="font-size: 10px;"><?php echo $value; ?></span><br>
				<?php }else{ ?>
					<span style="font-size: 10px;"><i><?php echo $value; ?></i></span><br>
				<?php } $mod++; ?>
			<?php } ?>
<!-- 			<span style="font-size: 10px;">Dr. Murtono, M.Si</span><br>
			<span style="font-size: 10px;">NIP 19691212 200003 1 001</span><br>
			<span style="font-size: 10px;"><i>Employee ID Number</i></span><br> -->

		</td>
	</tr>	
</table>

<table style="padding-top: 5px"><tr><td></td></tr></table>

<table>
	<tr>
		<td>
			<span style="font-size: 10px;"><b><?php echo $footer['IDN']; ?></b></span><br>
			<span style="font-size: 10px;"><i><b><?php echo $footer['EN']; ?></b></i></span><br>
			<span style="font-size: 10px;"></span><br>
			<?php foreach ($alamat as $key => $value) { ?>
				<span style="font-size: 10px;"><b><?php echo $value; ?></b></span><br>
			<?php } ?>
			<span style="font-size: 10px;"></span><br>
			<?php foreach ($contact as $key => $value) { ?>
				<span style="font-size: 10px;"><?php echo $value; ?></span><br>
			<?php } ?>
		</td>
	</tr>
</table>


