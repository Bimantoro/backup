
<div id="content-admin">
	<h2>Agenda</h2>


 
 <div class="msg_alert error">
  
   <p>Ruangan ini akan digunakan oleh <?php echo $gr['NAMA']?> (<?php echo $gr['INSTITUSI']?>) untuk <?php echo $gr['KEPERLUAN']?>
   pada tanggal <?php echo $gr['TGL_MULAI']?> WIB sampai <?php echo $gr['TGL_SELESAI']?> WIB</p>
   <p>Apakah anda tetapa akan memproses agenda ini?</p><br>
		
	<?php if(isset($id_agenda)){?>
		<a href="<?php echo site_url('admin/agenda/edit_proc/'.$id_agenda)?>" class="btn">Ya</a> <a href="<?php echo site_url('admin/agenda/add')?>" class="btn">Tidak</a>
	<?php }else{ ?>	
		<a href="<?php echo site_url('admin/agenda/add_proc')?>" class="btn">Ya</a> <a href="<?php echo site_url('admin/agenda/add')?>" class="btn">Tidak</a>
	<?php } ?>	
    </div>
</div>