<script src="http://static.uin-suka.ac.id/plugins/dynatree/jquery/jquery-ui.custom.js" type="text/javascript"></script>
<script src="http://static.uin-suka.ac.id/plugins/dynatree/jquery/jquery.cookie.js" type="text/javascript"></script>
<link href="http://static.uin-suka.ac.id/plugins/dynatree/src/skin-vista/ui.dynatree.css" rel="stylesheet" type="text/css">
<script src="http://static.uin-suka.ac.id/plugins/dynatree/src/jquery.dynatree.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){

		// ARSIP PENGUMUMAN
		$("#arsip_pengumuman").dynatree({
			autoFocus: false, icon:false,
			initAjax: {
				url: "<?php echo site_url('page/arsip_pengumuman_json')?>"
				},

			onActivate: function(node) {
			node.find('li').attr('data',"icon: false");
			node.find('span').remove();
				if(node.data.find('a').attr('href')){
					window.open(node.data.href, node.data.target);
				}
				$("#echoActive").text("" + node + " (" + node.getKeyPath()+ ")");
			},

			onLazyRead: function(node){
			var key =node.getKeyPath().split('/');
				node.appendAjax({
					url: "<?php echo site_url('page/pengumuman_bulan_json')?>/"+key[2]+"/"+key[3],
					debugLazyDelay: 250
				});
			}
		});
		// ARSIP BERITA
		$("#arsip_berita").dynatree({
			autoFocus: false, icon:false,
			initAjax: {
				url: "<?php echo site_url('page/arsip_berita_json')?>"
				},

			onActivate: function(node) {
			node.find('li').attr('data',"addClass: 'ws-wrap'");
				if(node.data.find('a').attr('href')){
					window.open(node.data.href, node.data.target);
				}
				$("#echoActive").text("" + node + " (" + node.getKeyPath()+ ")");
			},

			onLazyRead: function(node){
			var key =node.getKeyPath().split('/');
				node.appendAjax({
					url: "<?php echo site_url('page/berita_bulan_json')?>/"+key[2]+"/"+key[3],
					debugLazyDelay: 250
				});
			}
		});
		// ARSIP AGENDA
		$("#arsip_agenda").dynatree({
			autoFocus: false, icon:false,
			initAjax: {
				url: "<?php echo site_url('page/arsip_agenda_json')?>"
				},

			onActivate: function(node) {
			node.find('li').attr('data',"addClass: 'ws-wrap'");
				if(node.data.find('a').attr('href')){
					window.open(node.data.href, node.data.target);
				}
				$("#echoActive").text("" + node + " (" + node.getKeyPath()+ ")");
			},

			onLazyRead: function(node){
			var key =node.getKeyPath().split('/');
				node.appendAjax({
					url: "<?php echo site_url('page/agenda_bulan_json')?>/"+key[2]+"/"+key[3],
					debugLazyDelay: 250
				});
			}
		});
		// ARSIP KOLOM
		$("#arsip_kolom").dynatree({
			autoFocus: false, icon:false,
			initAjax: {
				url: "<?php echo site_url('page/arsip_kolom_json')?>"
				},

			onActivate: function(node) {
			node.find('li').attr('data',"addClass: 'ws-wrap'");
				if(node.data.find('a').attr('href')){
					window.open(node.data.href, node.data.target);
				}
				$("#echoActive").text("" + node + " (" + node.getKeyPath()+ ")");
			},

			onLazyRead: function(node){
			var key =node.getKeyPath().split('/');
				node.appendAjax({
					url: "<?php echo site_url('page/kolom_bulan_json')?>/"+key[2]+"/"+key[3],
					debugLazyDelay: 250
				});
			}
		});
		// ARSIP LIPUTAN
		$("#arsip_liputan").dynatree({
			autoFocus: false, icon:false,
			initAjax: {
				url: "<?php echo site_url('page/arsip_liputan_json')?>"
				},

			onActivate: function(node) {
			node.find('li').attr('data',"addClass: 'ws-wrap'");
				if(node.data.find('a').attr('href')){
					window.open(node.data.href, node.data.target);
				}
				$("#echoActive").text("" + node + " (" + node.getKeyPath()+ ")");
			},

			onLazyRead: function(node){
			var key =node.getKeyPath().split('/');
				node.appendAjax({
					url: "<?php echo site_url('page/liputan_bulan_json')?>/"+key[2]+"/"+key[3],
					debugLazyDelay: 250
				});
			}
		});
	$(".dynatree-icon").remove();
	});
</script>

<div id="content-right">
	
	<div class="bg-sidebar">
		<div class="head-sidebar">Arsip Pengumuman</div>
			<div id="arsip_pengumuman"></div>
		<div class="cleaner_h10"></div>	
	</div>
	<div class="clear5"></div>	
	
	<div class="bg-sidebar">
		<div class="head-sidebar">Arsip Berita</div>
			<div id="arsip_berita"></div>
		<div class="cleaner_h10"></div>	
	</div>
	<div class="clear5"></div>	
	
	<div class="bg-sidebar">
		<div class="head-sidebar">Arsip Agenda</div>
			<div id="arsip_agenda"></div>
		<div class="cleaner_h10"></div>	
	</div>
	<div class="clear5"></div>	
	
	<div class="bg-sidebar">
		<div class="head-sidebar">Arsip Kolom</div>
			<div id="arsip_kolom"></div>
		<div class="cleaner_h10"></div>	
	</div>
	<div class="clear5"></div>	
	
	








</div>

<div class="clear5"></div>
</div>
<div class="cleaner_h0"></div>	
</div>