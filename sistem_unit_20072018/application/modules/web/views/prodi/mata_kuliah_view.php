<?php $lang=$this->page_lib->lang(); ?>
<div class="article-content">	
		<!-- <div class="article-title">Mata Kuliah</div> -->
		<h2 class="mt-sm heading-primary"><?php echo ucwords(dict('Mata Kuliah', $lang)) ?></h2>
				<div class="clear20"></div>
				
		
		<!-- <h3 style="margin-bottom:5px; color: rgb(164, 136, 74);">A. Informasi Umum</h3> -->
		<h4 class="mt-sm heading-primary">A. <?php echo ucwords(dict('Informasi Umum', $lang)) ?></h4>
		<?php foreach ($mk as $m){ ?>
		<table class="table table-bordered table-hover table-condensed">
			<tbody>	
				<tr><td width="35%"><b><?php echo ucwords(dict('Nama Mata Kuliah', $lang)) ?></b></td>
				<td width="65%"><?php if($m->NM_MK)echo $m->NM_MK; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b><?php echo ucwords(dict('Nama Asing', $lang)) ?></b></td>
				<td width="65%"><?php if($m->NM_MK_ASING)echo $m->NM_MK_ASING; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b><?php echo ucwords(dict('Program Studi', $lang)) ?></b></td>
				<td width="65%"><?php if($m->NM_PRODI)echo $m->NM_PRODI; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b><?php echo ucwords(dict('Kurikulum', $lang)) ?></b></td>
				<td width="65%"><?php if($m->NM_KUR)echo $m->NM_KUR; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b><?php echo ucwords(dict('Muatan Mata Kuliah', $lang)) ?></b></td>
				<td width="65%"><?php if($m->MUATAN_MK_F)echo $m->MUATAN_MK_F; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b><?php echo ucwords(dict('Kelompok Mata Kuliah', $lang)) ?></b></td>
				<td width="65%"><?php if($m->NM_KEL_MK)echo $m->NM_KEL_MK; else echo"-"; ?></td></tr>
			</tbody>
		</table>
		<table class="table table-bordered table-hover table-condensed">
			<tbody>	
				<tr><td width="35%"><b><?php echo ucwords(dict('Jenis Mata Kuliah', $lang)) ?></b></td>
				<td width="65%"><?php if($m->JENIS_MK_F)echo strtoupper(dict($m->JENIS_MK_F, $lang)); else echo"-"; ?></td></tr>
				<tr><td width="35%"><b><?php echo ucwords(dict('Jumlah SKS', $lang)) ?></b></td>
				<td width="65%"><?php if($m->SKS)echo $m->SKS; else echo"-"; ?></td></tr>
				<tr><td width="35%"><b><?php echo ucwords(dict('Semester Paket', $lang)) ?></b></td>
				<td width="65%"><?php if($m->SEMESTER_PAKET)echo $m->SEMESTER_PAKET; else echo"-"; ?></td></tr>
			</tbody>
		</table>
		<?php } ?>
		
		<h4 class="mt-sm heading-primary">B. <?php echo ucwords(dict('Mata Kuliah Prasyarat', $lang)) ?></h4>
		<?php if (count($mkps)){?>
		<table class="table table-bordered table-hover table-condensed">
			<thead>	
				<tr>
				<th width="5%">No</th>
				<th width="10%"><?php echo ucwords(dict('Kode MK', $lang)) ?></th>
				<th width="45%"><?php echo ucwords(dict('Nama Mata Kuliah', $lang)) ?></th>
				<th width="10%"><?php echo ucwords(dict('Jenis MK', $lang)) ?></th>
				<th width="20%"><?php echo ucwords(dict('Syarat', $lang)) ?></th>
				</tr>
			</thead>

		<?php $i=0;?>
		<?php $ars=array('A'=> strtoupper(dict('PERNAH', $lang)),'L'=> strtoupper(dict('SUDAH', $lang)));?>
		<?php	foreach ($mkps as $mp){ ?>
			<tbody>	
				<tr>
					<td><?php echo ++$i.'.'; ?></td>
					<td><a href="<?php echo site_url($lang.'/page/mata_kuliah/'.$mp->KD_KUR.'/'.$mp->KD_MK_PRASYARAT)?>"><u><?php echo $mp->KD_MK ?></u></a></td>
					<td><?php echo $mp->NM_MK ?></td>
					<td><?php echo ucwords(dict($mp->NM_JENIS_MK, $lang)) ?></td>
					<td style="text-align:center"><?php echo $ars[$mp->SYARAT]." ".$mp->NM_SYARAT ?></td>
				</tr>
			</tbody>
		<?php } ?>
		</table>
		<?php }else{?>
			<p><?php echo ucfirst(dict('Mata Kuliah ini tidak memerlukan prasyarat ambil atau lulus', $lang)) ?>.</p>
		<?php } ?>
		
		<h4 class="mt-sm heading-primary">C. <?php echo ucwords(dict('Mata Kuliah Setara', $lang)) ?></h4>
		<?php if (count($mks)){?>
		<table class="table table-bordered table-hover table-condensed">
			<thead>	
				<tr>
				<th width="5%"><?php echo ucwords(dict('No', $lang)) ?></th>
				<th width="35%"><?php echo ucwords(dict('Kurikulum Lama', $lang)) ?></th>
				<th width="15%"><?php echo ucwords(dict('Kode MK Lama', $lang)) ?></th>
				<th width="35%"><?php echo ucwords(dict('Nama Mata Kuliah Lama', $lang)) ?></th>
				</tr>
			</thead>

		<?php $i=0;?>
		<?php	foreach ($mks as $m){ ?>
			<tbody>	
				<tr>
					<td><?php echo ++$i.'.'; ?></td>
					<td><?php echo $m->NM_KUR_LAMA ?></td>
					<td><a href="<?php echo site_url($lang.'/page/mata_kuliah/'.$m->KD_KUR_LAMA.'/'.$m->KD_MK_LAMA)?>"><u><?php echo $m->KD_MK_LAMA ?></u></a></td>
					<td><?php echo $m->NM_MK_LAMA ?></td>
				</tr>
			</tbody>
		<?php } ?>
		</table>
		<?php }else{?>
			<p><?php echo ucfirst(dict('Mata Kuliah ini tidak memiliki kesetaraan dengan mata kuliah di kurikulum terdahulu', $lang)) ?>.</p>
		<?php } ?>
		
		<h4 class="mt-sm heading-primary">D. <?php echo ucwords(dict('Daftar Kelas Mata Kuliah', $lang)) ?></h4>
		<?php if (count($mkk)){?>
		<table class="table table-bordered table-hover table-condensed">
			<thead>	
				<tr>
				<th width="5%"><?php echo ucwords(dict('No', $lang)) ?></th>
				<th width="15%"><?php echo ucwords(dict('TA', $lang)) ?></th>
				<th width="25%"><?php echo ucwords(dict('Semester', $lang)) ?></th>
				<th width="10%"><?php echo ucwords(dict('Kelas', $lang)) ?></th>
				<th width="45%"><?php echo ucwords(dict('Dosen', $lang)) ?></th>
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
						echo $ds[1]."<br>(<a href='".site_url($lang.'/page/detil_dosen/'.$ds[0])."'><u>".format_nip($ds[0])."</u></a>)";
						?></td>
				</tr>
			</tbody>
		<?php } ?>
		</table>
		<?php } ?>
</div>
