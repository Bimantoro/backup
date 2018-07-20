<div class="article-content">	
		<div class="article-title">Mata Kuliah</div>
				<div class="clear20"></div>
				
		
		<h3 style="margin-bottom:5px; color: rgb(164, 136, 74);">A. Informasi Umum</h3>
		<?php foreach ($mk as $m){ ?>
		<table class="table table-bordered table-hover table-condensed">
			<tbody>	
				<tr><td width="35%"><b>Nama Mata Kuliah</b></td>
				<td width="65%"><?php if($m->NM_MK)echo $m->NM_MK; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b>Nama Asing</b></td>
				<td width="65%"><?php if($m->NM_MK_ASING)echo $m->NM_MK_ASING; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b>Program Studi</b></td>
				<td width="65%"><?php if($m->NM_PRODI)echo $m->NM_PRODI; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b>Kurikulum</b></td>
				<td width="65%"><?php if($m->NM_KUR)echo $m->NM_KUR; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b>Muatan Mata Kuliah</b></td>
				<td width="65%"><?php if($m->MUATAN_MK_F)echo $m->MUATAN_MK_F; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b>Kelompok Mata Kuliah</b></td>
				<td width="65%"><?php if($m->NM_KEL_MK)echo $m->NM_KEL_MK; else echo"-"; ?></td></tr>
			</tbody>
		</table>
		<table class="table table-bordered table-hover table-condensed">
			<tbody>	
				<tr><td width="35%"><b>Jenis Mata Kuliah</b></td>
				<td width="65%"><?php if($m->JENIS_MK_F)echo $m->JENIS_MK_F; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b>Jumlah SKS</b></td>
				<td width="65%"><?php if($m->SKS)echo $m->SKS; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b>Semester Paket</b></td>
				<td width="65%"><?php if($m->SEMESTER_PAKET)echo $m->SEMESTER_PAKET; else echo"-"; ?></td></tr>
			</tbody>
		</table>
		<?php } ?>
		
		<h3 style="margin-bottom:5px; color: rgb(164, 136, 74);">B. Mata Kuliah Prasyarat</h3>
		<?php if (count($mkps)){?>
		<table class="table table-bordered table-hover table-condensed">
			<thead>	
				<tr>
				<th width="5%">No</th>
				<th width="10%">Kode MK</th>
				<th width="45%">Nama Mata Kuliah</th>
				<th width="10%">Jenis MK</th>
				<th width="20%">Syarat</th>
				</tr>
			</thead>

		<?php $i=0;?>
		<?php $ars=array('A'=>'PERNAH','L'=>'SUDAH');?>
		<?php	foreach ($mkps as $mp){ ?>
			<tbody>	
				<tr>
					<td><?php echo ++$i.'.'; ?></td>
					<td><a href="<?php echo site_url('page/mata_kuliah/'.$mp->KD_KUR.'/'.$mp->KD_MK_PRASYARAT)?>"><u><?php echo $mp->KD_MK ?></u></a></td>
					<td><?php echo $mp->NM_MK ?></td>
					<td><?php echo $mp->NM_JENIS_MK ?></td>
					<td style="text-align:center"><?php echo $ars[$mp->SYARAT]." ".$mp->NM_SYARAT ?></td>
				</tr>
			</tbody>
		<?php } ?>
		</table>
		<?php }else{?>
			<p>Mata Kuliah ini tidak memerlukan prasyarat ambil atau lulus.</p>
		<?php } ?>
		
		<h3 style="margin-bottom:5px; color: rgb(164, 136, 74);">C. Mata Kuliah Setara</h3>
		<?php if (count($mks)){?>
		<table class="table table-bordered table-hover table-condensed">
			<thead>	
				<tr>
				<th width="5%">No</th>
				<th width="35%">Kurikulum Lama</th>
				<th width="15%">Kode MK Lama</th>
				<th width="35%">Nama Mata Kuliah Lama</th>
				</tr>
			</thead>

		<?php $i=0;?>
		<?php	foreach ($mks as $m){ ?>
			<tbody>	
				<tr>
					<td><?php echo ++$i.'.'; ?></td>
					<td><?php echo $m->NM_KUR_LAMA ?></td>
					<td><a href="<?php echo site_url('page/mata_kuliah/'.$m->KD_KUR_LAMA.'/'.$m->KD_MK_LAMA)?>"><u><?php echo $m->KD_MK_LAMA ?></u></a></td>
					<td><?php echo $m->NM_MK_LAMA ?></td>
				</tr>
			</tbody>
		<?php } ?>
		</table>
		<?php }else{?>
			<p>Mata Kuliah ini tidak memiliki kesetaraan dengan mata kuliah di kurikulum terdahulu.</p>
		<?php } ?>
		
		<h3 style="margin-bottom:5px; color: rgb(164, 136, 74);">D. Daftar Kelas Mata Kuliah</h3>
		<?php if (count($mkk)){?>
		<table class="table table-bordered table-hover table-condensed">
			<thead>	
				<tr>
				<th width="5%">No</th>
				<th width="15%">TA</th>
				<th width="25%">Semester</th>
				<th width="10%">Kelas</th>
				<th width="45%">Dosen</th>
				</tr>
			</thead>

		<?php $i=0;?>
		<?php	foreach ($mkk as $m){ ?>
			<tbody>	
				<tr>
					<td style="text-align:center"><?php echo ++$i.'.'; ?></td>
					<td style="text-align:center"><?php echo $m->TA ?></td>
					<td style="text-align:center"><?php echo $m->NM_SMT ?></td>
					<td style="text-align:center"><?php echo $m->KELAS_PARAREL ?></td>
					<td>
						<?php 
						$ds=explode("+",$m->TIM_AJAR); 
						echo $ds[1]."<br>(<a href='".site_url('page/detil_dosen/'.$ds[0])."'><u>".format_nip($ds[0])."</u></a>)";
						?></td>
				</tr>
			</tbody>
		<?php } ?>
		</table>
		<?php } ?>
</div>
