
			<nav class="accordion">
			<?php $level=$this->session->userdata('level');?>
				<ol>				
					<div id="separate"></div>
					<div id="separate"></div>
					<div id="separate"></div>					
					<li>
						<a class="item" href="<?php echo site_url('admin/logout');?>">
							<span>Logout<span><div class="underline-menu"></div></a>
					</li>
					<div id="separate"></div>
					<div id="separate"></div>
					<?php  if($level==1){?>
					<li>
						<a class="item" href="<?php echo site_url('yudisium/pembobotan');?>">
							<span>Pembobotan<span><div class="underline-menu"></div></a>
					</li>
					<li>
						<a class="item" href="<?php echo site_url('yudisium/accepted');?>">
							<span>Siswa Diterima<span><div class="underline-menu"></div></a>
					</li>
					<li></li>
					<li>
						<a class="item" href="<?php echo site_url('yudisium/rekap/nilai');?>">
							<span>Rata-rata Nilai<span><div class="underline-menu"></div></a>
					</li>
					<li>
						<a class="item" href="<?php echo site_url('yudisium/rekap/diterima');?>">
							<span>Rekap Peserta Diterima<span><div class="underline-menu"></div></a>
					</li>
					<?php }else if($level==2){ ?>
					<li>
						<a class="item" href="<?php echo site_url('yudisium/accepted');?>">
							<span>Siswa Diterima<span><div class="underline-menu"></div></a>
					</li>
					<?php }else if($level==3){ ?>						
					<li>
						<a class="item" href="<?php echo site_url('yudisium/index');?>">
							<span>Nilai Siswa<span><div class="underline-menu"></div></a>
					</li>
					<?php } ?>
				</ol>
			</nav>		