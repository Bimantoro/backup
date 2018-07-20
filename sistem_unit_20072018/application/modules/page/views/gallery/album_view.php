<div  class="article-content">
<div class="judul-artikel">Galeri</div>
<br/>
<?php 
if( count($album)==0){
echo"<center>Belum ada album yang tersedia.</center>";
}else{
?>
<?php $i=0;?>
<table width="400" id="product-table">
<tr>
		<?php foreach ($album as $f): ?>
			
			<td valign="top" align="center" style="width:180px; margin:3px;">
				<a class="album" href="<?php echo site_url('page/gallery/pictures/'.$f->id_album) ?>" >
				<img src="<?php echo base_url();?>media/gallery/<?php echo $f->image ?>" width="217" />
				<br/><?php echo $f->nama_album ?>
				</a>
				<br/>
				<br/>
			</td>
		<?php 
		++$i;
		if($i%2==0){echo"</tr><tr>";}
		?>
		<?php endforeach ?>
</tr>
</table>
<div class="cleaner_h20"></div>
	<div class="pagination">
	<?php
	echo $this->pagination->create_links();
	?>
</div>
<?php
}
?>
</div>