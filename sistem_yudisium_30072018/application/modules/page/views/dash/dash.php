<div id="system-content">
<br/>		
<?php 
	$m=$this->db->get('admin_menu')->result();
		foreach($m as $m){
			echo"<div style='float:left; width:130px; padding: 15px; text-align:center'>";
			echo"<a href='".site_url('admin/'.$m->url)."'>";
			echo"<img src='".base_url('asset/img/'.$m->image)."' width='90' /><br/>";
			echo "<span syle='display:block'>".$m->menu."</span>";
			echo"</a>";
			echo"</div>";
		}
?>
<div style="clear:both"></div>
</div>