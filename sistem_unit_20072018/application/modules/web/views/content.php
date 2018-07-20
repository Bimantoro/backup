<?php $this->load->view('web/header')?>
<?php $lang=$this->page_lib->lang(); ?>	
			<div role="main" class="main">
				<section class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
							<?php echo $this->breadcrumb->output(); ?>
							</div>
						</div>
					</div>
				</section>
				<div class="container">
					<div class="row">
						<div class="col-md-9">
							<?php $this->load->view($main_view);?>
						</div>
						<div class="col-md-3">
							<?php /* $this->load->view('arsip_berita_sidebar');?>
							<?php $this->load->view('arsip_liputan_sidebar');?>
							<?php $this->load->view('arsip_kolom_sidebar');?>
							<?php $this->load->view('arsip_pengumuman_sidebar');?>
							<?php $this->load->view('arsip_agenda_sidebar'); */?>	
							<?php
							 if(isset($sidebar) and !empty($sidebar)){
								foreach($sidebar as $sb){
									$this->load->view($sb);									
								} 
							 }else{
								$this->load->view('search_sidebar');
								$this->load->view('arsip_berita_sidebar');
								$this->load->view('arsip_liputan_sidebar');
								$this->load->view('arsip_kolom_sidebar');
								$this->load->view('arsip_pengumuman_sidebar');
								$this->load->view('arsip_agenda_sidebar');
							 }
							?>
						</div>
					</div>

				</div>

			</div>

	
<?php $this->load->view('web/footer'); ?>