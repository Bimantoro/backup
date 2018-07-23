
		<link rel="stylesheet" href="<?php echo base_url()?>/asset/colorbox/colorbox.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="<?php echo base_url()?>/asset/colorbox/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				$(".group4").colorbox({rel:'group4', slideshow:true, opacity:0.5, photo:true });
				
			});
		</script>
<div  class="article-content">
	<div class="judul-artikel">Album</div><br>
<?php
if( count($pictures)==0){
echo"<center>Belum ada album yang tersedia.</center>";
}else{
?>
<?php $i=0;?>
<table width="400" id="product-table">
<tr>
		<?php foreach ($pictures as $photo): ?>
			
			<td valign="top" align="center" style="width:180px; margin:3px;">
				<a class="group4"  href="<?php echo base_url();?>media/gallery/<?php echo $id_album ?>/<?php echo $photo ?>" > 
					<img src="<?php echo base_url();?>media/gallery/<?php echo $id_album ?>/<?php echo $photo ?>" width="217" />
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
<?php
}
?>

</div>