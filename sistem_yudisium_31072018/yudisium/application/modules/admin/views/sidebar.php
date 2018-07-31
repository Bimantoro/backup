<div class="col-md-3">
	<aside class="sidebar">
		<h4 class="heading-primary">Daftar Menu</h4>
		<ul class="nav nav-list mb-xlg sort-source" data-sort-id="portfolio" data-option-key="filter" data-plugin-options='{"layoutMode": "fitRows", "filter": "*"}'>
			<?php if($this->session->userdata('level')=='Y000'){?>

			<li data-option-value="*"><a href="<?php echo site_url('admin/jalur')?>">Master jalur</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/ujian')?>">Master Ujian</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/gelombang')?>">Master Gelombang</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/kelas')?>">Master Kelas</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/fakultas')?>">Master Fakultas</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/prodi')?>">Master Prodi</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/akun')?>">Master Akun</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/bobot')?>">Pengaturan Bobot Nilai</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/pilihan')?>">Pengaturan Pilihan</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/peserta')?>">Data Peserta</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/yudisium')?>">Yudisium</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/rekapitulasi')?>">Rekapitulasi</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/peserta_diterima')?>">Data Peserta Diterima</a></li>

			<?php } else if($this->session->userdata('level')=='Y002'){ ?>

			<li data-option-value="*"><a href="<?php echo site_url('admin/bobot')?>">Pengaturan Bobot Nilai</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/pilihan')?>">Pengaturan Pilihan</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/peserta')?>">Data Peserta</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/rekapitulasi')?>">Rekapitulasi</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/peserta_diterima')?>">Data Peserta Diterima</a></li>


			<?php }else{?>

			<li data-option-value="*"><a href="<?php echo site_url('admin/peserta')?>">Data Peserta</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/yudisium')?>">Yudisium</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/rekapitulasi')?>">Rekapitulasi</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/peserta_diterima')?>">Data Peserta Diterima</a></li>

			<?php } ?>

			<li data-option-value=".medias"><a href="<?php echo site_url('admin/login/logout')?>">Logout</a></li>
		</ul>

		<hr class="invisible mt-xl mb-sm">

		<!-- <h4 class="heading-primary">Contact <strong>Us</strong></h4>
		<p>Contact us or give us a call to discover how we can help.</p>

		<form id="contactForm" action="php/contact-form.php" method="POST">
			<div class="row">
				<div class="form-group">
					<div class="col-md-12">
						<label>Your name *</label>
						<input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" id="name" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<div class="col-md-12">
						<label>Your email address *</label>
						<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" id="email" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<div class="col-md-12">
						<label>Subject</label>
						<input type="text" value="" data-msg-required="Please enter the subject." maxlength="100" class="form-control" name="subject" id="subject" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<div class="col-md-12">
						<label>Message *</label>
						<textarea maxlength="5000" data-msg-required="Please enter your message." rows="3" class="form-control" name="message" id="message" required></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<input type="submit" value="Send Message" class="btn btn-primary mb-xl" data-loading-text="Loading...">
				</div>
				<div class="col-md-8">
					<div class="alert alert-success hidden" id="contactSuccess">
						Message has been sent to us.
					</div>

					<div class="alert alert-danger hidden" id="contactError">
						Error sending your message.
					</div>
				</div>
			</div>
		</form> -->

		<!-- <ul class="list list-icons list-icons-style-3 mt-xlg">
			<li><i class="fa fa-map-marker"></i> <strong>Address:</strong> 1234 Street Name, City Name, United States</li>
			<li><i class="fa fa-phone"></i> <strong>Phone:</strong> (123) 456-789</li>
			<li><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:mail@example.com">mail@example.com</a></li>
		</ul> -->

	</aside>
</div>