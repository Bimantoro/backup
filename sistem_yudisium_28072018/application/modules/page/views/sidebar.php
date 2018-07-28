<div class="col-md-3">
	<aside class="sidebar">
		<?php $d=explode('.',str_replace('http://','',base_url()));
		$dom=$d[0];?>
		
		<?php
			$unit=$this->db->get_where('unit',array('subdomain'=>$dom))->row();
			if (empty($unit)) {
				$unit=$this->db->get_where('unit',array('subdomain'=>$this->session->userdata('subdomain')))->row();
			}
		?>
		<h4 class="heading-primary">Daftar Menu</h4>
		<ul class="nav nav-list mb-xlg sort-source" data-sort-id="portfolio" data-option-key="filter" data-plugin-options='{"layoutMode": "fitRows", "filter": "*"}'>
			<li data-option-value="*"><a href="<?php echo site_url('admin/main/page')?>">Halaman</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/main/menu')?>">Menu</a></li>
			<?php if($this->session->userdata('level')=='WPR001'){?>
			<li data-option-value="*"><a href="<?php echo site_url('admin/sidemenu')?>">Side Menu</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/prodi')?>">Pengaturan Unit</a></li>
			<li data-option-value="*"><a href="<?php echo site_url('admin/user')?>">Pengaturan User</a></li>
			<?php }?>
			<?php if($unit->kode_unit==41){?>
			<li data-option-value="*"><a href="<?php echo site_url('admin/main/laboratorium')?>">Laboratorium</a></li>
			<?php }?>
			<li data-option-value=".websites"><a href="<?php echo site_url('admin/berita')?>">Berita</a></li>
			<li data-option-value=".medias"><a href="<?php echo site_url('admin/pengumuman')?>">Pengumuman</a></li>
			<li data-option-value=".medias"><a href="<?php echo site_url('admin/agenda')?>">Agenda</a></li>
			<li data-option-value=".medias"><a href="<?php echo site_url('admin/liputan')?>">Liputan</a></li>
			<li data-option-value=".medias"><a href="<?php echo site_url('admin/kolom')?>">Kolom</a></li>
			<li data-option-value=".medias"><a href="<?php echo site_url('admin/dokumen')?>">Dokumen</a></li>
			<li data-option-value=".medias"><a href="<?php echo site_url('admin/slide')?>">Slide</a></li>
			<li data-option-value=".medias"><a href="<?php echo site_url('admin/album')?>">Album</a></li>
			<?php
				/*$album = $this->db->get_where('album', array('kode_unit' => $this->session->userdata('kode_unit')))->result_array();
				if (!empty($album)) {
					foreach ($album as $key) {
						echo '
							<ul>
								<li><a href="'.site_url('admin/foto/').$key['id_album'].'">'.$key['judul'].'</a></li>
							</ul>
						';
					}
				}*/
			?>
			<li data-option-value=".medias"><a href="<?php echo site_url('admin/video')?>">Video</a></li>
			<!-- <li data-option-value=".medias"><a href="<?php /*echo site_url('admin/main/panduan')*/ ?>">Panduan</a></li> -->
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