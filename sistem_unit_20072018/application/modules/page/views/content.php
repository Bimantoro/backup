
			<div id="app_content">
				<?php echo $this->breadcrumb->output(); ?>
<div class="clear10"></div>
				<div class="app-row">
					<div class="col-med-3">
						<?php $this->load->view('page/left_side');?>
					</div>
					<div class="col-med-6">
						<?php $this->load->view($content);?>
					</div>
					<div class="col-med-3">
						<?php $this->load->view('page/right_side');?>
					</div>
					
				</div>
				<div class="clear20"></div>
			</div>