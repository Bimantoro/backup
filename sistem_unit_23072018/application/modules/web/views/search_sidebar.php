<?php $lang=$this->page_lib->lang(); ?>	
<div class="header-search hidden-xs mb-xlg">
	<form id="searchForm" action="<?php echo site_url($lang.'/page/search')?>" method="post">
		<div class="input-group">
			<input type="text" class="form-control" name="cari" id="cari" placeholder="Search..." required>
			<span class="input-group-btn">
				<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
			</span>
		</div>
	</form>
</div>