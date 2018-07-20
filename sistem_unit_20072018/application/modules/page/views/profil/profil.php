<div  class="article-content">
	<div class="article-title">Profil</div>
	<div class="clear20"></div>
	<table class="table table-condensed">
		<?php #print_r($nilai); 
		foreach($profil as $p){?>
		<tbody>
			<tr><td>Nama Program Studi</td><td>:</td><td><?php echo $p['JUR_NM_JURUSAN']?></td></tr>
			<tr><td>Fakultas</td><td>:</td><td><?php echo $p['FAK_NM_FAK']?></td></tr>
			<tr><td>Tanggal Berdiri</td><td>:</td><td><?php echo tanggal_indonesia(mysql_date(substr($p['PRO_TGL_BUKA'],0,10)))?></td></tr>
			<tr><td>SK Penyelenggaraan</td><td>:</td><td><?php echo $p['PRO_NO_AKTA']?></td></tr>
			<tr><td>Tanggal SK</td><td>:</td><td><?php echo tanggal_indonesia(mysql_date(substr($p['PRO_TGL_AKTA'],0,10)))?></td></tr>
			<tr><td>Akreditasi</td><td>:</td><td><?php echo $p['PRO_KD_AKREDITASI']?></td></tr>
			<tr><td>SK Akreditasi</td><td>:</td><td><?php echo $p['PRO_SK_AKREDITASI']?></td></tr>
			<tr><td>Lama Studi Ideal</td><td>:</td><td><?php echo $p['PRO_LAMA_STUDI_IDEAL']?> Semester</td></tr>
			<tr><td>Lama Studi Maksimal</td><td>:</td><td><?php echo $p['PRO_LAMA_STUDI_MAX']?> Semester</td></tr>
			<tr><td>Gelar Akademis</td><td>:</td><td><?php echo $p['PRO_NM_GELAR'].' ('.$p['PRO_SKT_GELAR'].')';?></td></tr>
			<tr><td>Jenjang Pendidikan</td><td>:</td><td><?php echo $p['PRO_NM_JENIS']?></td></tr>
			<tr><td>Jenjang Kualifikasi Sesuai KKNI</td><td>:</td><td><?php echo 'Level '.$p['PRO_JENJANG_KKNI']?></td></tr>
			<tr><td>Bahasa Pengantar Kuliah</td><td>:</td><td><?php echo $bahasa?></td></tr>
			<tr><td>Sistem Penilaian</td><td>:</td>
				<td>Skala 1-4 <br><?php 
					foreach($nilai as $n){
					if($n['STATUS']=="AKTIF" and $n['KD_NILAI']!=null){
						echo $n['KD_NILAI']." = ".$n['BOBOT']."<br>";	
						}
					}?>
				</td>
			</tr>
			<tr><td>Syarat Penerimaan</td><td>:</td><td><?php echo $p['PRO_NM_SYARAT_TERIMA']?></td></tr>
			<tr><td>Jenjang Lanjutan</td><td>:</td><td><?php echo $p['PRO_NM_JENJANG_LANJUT']?></td></tr>
		</tbody>
		<?php } ?>
	</table>
	<div class="isi">
	<?php 
	foreach($profil2 as $p){ ?>
		<?php if($p['PROF_INA']){?>
			<?php echo $p['PROF_INA'] ?>
		<?php } ?>		
	<?php } ?>
	</div>
</div>			
		
			
