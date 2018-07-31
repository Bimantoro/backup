<?php $this->load->view('admin/header')?>

			<div role="main" class="main">

				<section class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="<?php echo site_url("admin/main/dash")?>">Beranda</a></li>
									<li class="active"><?php echo $title?></li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1><?php echo $title?></h1>
							</div>
						</div>
					</div>
				</section>

				<div class="container">

					<div class="row">
						<?php $this->load->view('admin/sidebar'); ?>
						<div class="col-md-9">

							<div class="row">

								<?php $this->load->view($main_view);?>
							</div>

						</div>
					</div>

				</div>

			</div>

			<?php $this->load->view('admin/footer'); ?>
		</div>
