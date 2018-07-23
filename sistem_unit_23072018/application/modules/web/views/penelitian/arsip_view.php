<?php $lang = $this->page_lib->lang(); ?>
<div  class="article-content">
	<h2 class="mb-xl heading-primary"><?php echo ucwords(dict('Penelitian', $lang))  ?></h2>	
		<div class="clear20"></div>
		<?php $i=0;?>
			<table class="table table-bordered table-hover table-condensed">
			<thead>
				<tr>
					<th style="text-align:center;"><?php echo ucwords(dict('No', $lang)) ?></th>
					<th style="text-align:center;"><?php echo ucwords(dict('Anggota', $lang))  ?></th>
					<th style="text-align:center;"><?php echo ucwords(dict('Judul Penelitian', $lang))  ?></th>
					<th style="text-align:center;"><?php echo ucwords(dict('Jenis', $lang))  ?></th>
					<th style="text-align:center;"><?php echo ucwords(dict('Tahun', $lang))  ?></th>
					<th style="text-align:center;"><?php echo ucwords(dict('Url', $lang))  ?></th>
				</tr>
			</thead>
			<tbody>	
			<?php foreach ($penelitian as $p){ ?>
			<?php $lang =$p['kode_bahasa']; ?>
				<tr>
					<td width="3%" style="text-align:center;"><?php echo ++$i ?></td>
					<td width="25%"><?php echo $p['anggota']; ?></td>
					<td width="25%"><?php echo ucwords(strtolower($p['judul_penelitian']))?></td>
					<td width="5%"><?php echo ucwords(strtolower($p['jenis_penelitian']))?></td>
					<td width="5%" style="text-align:center;"><?php echo $p['tahun']?></td>
					<?php $alamat = str_replace(array('http://','https://'), '', $p['url']); ?>
					<td width="22%" ><a href="<?php echo 'http://'.$alamat;?>" target='_blank'><?php echo ucwords(strtolower($p['url'])) ?></a></td> 

				<?php }
			if($i<=0){
					echo"<tr><td colspan='6' align='center'>".ucfirst(dict('Tidak ada penelitian yang tersedia', $lang))."</td></tr>";
			}?>
			</tbody>
		</table>
		<p class="font-size-xs line-height-xs">* <?php echo ucfirst(dict('Nama yang dicetak tebal adalah Peneliti Utama', $lang)) ?></p>
		<div class="clear20"></div>
		<div class="pagination">
		<?php echo $this->pagination->create_links(); ?>
		</div>
</div>
