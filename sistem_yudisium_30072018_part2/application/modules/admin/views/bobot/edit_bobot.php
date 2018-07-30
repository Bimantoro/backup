<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="tahun">tahun</label>
		<div class="col-md-6">
			<select class="form-control" name="tahun" id="tahun" style="pointer-events: none;" readonly>
				<?php foreach ($tahun as $t => $v) {
					if($v == $bobot['tahun']){
						echo "<option value='".$v."' selected> ".$v." </option>";
					}else{
						echo "<option value='".$v."'> ".$v." </option>";
					}
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="jalur">Jalur</label>
		<div class="col-md-6">
			<select class="form-control" name="jalur" id="jalur" style="pointer-events: none;" readonly>
				<?php foreach ($jalur as $d) {
					if($bobot['kode_jalur'] == $d['kode_jalur']){
						echo "<option value='".$d['kode_jalur']."' selected> ".$d['nama_jalur']." </option>";
					}else{
						echo "<option value='".$d['kode_jalur']."'> ".$d['nama_jalur']." </option>";
					}
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="gel">Gelombang</label>
		<div class="col-md-6">
			<select class="form-control" name="gelombang" id="gelombang" style="pointer-events: none;" readonly>
				<?php foreach ($gelombang as $d) {
					if($bobot['kode_gelombang'] == $d['kode_gelombang']){
						echo "<option value='".$d['kode_gelombang']."' selected> ".$d['nama_gelombang']." </option>";
					}else{
						echo "<option value='".$d['kode_gelombang']."'> ".$d['nama_gelombang']." </option>";
					}
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="ujian">Ujian</label>
		<div class="col-md-6">
			<select class="form-control" name="ujian" id="ujian" style="pointer-events: none;" readonly>
				<?php foreach ($ujian as $d) {
					if($bobot['kode_ujian'] == $d['kode_ujian']){
						echo "<option value='".$d['kode_ujian']."' selected > ".$d['nama_ujian']." </option>";
					}else{
						echo "<option value='".$d['kode_ujian']."'> ".$d['nama_ujian']." </option>";
					}
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="bobot">Bobot</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="bobot" id="bobot" required value="<?php echo $bobot['bobot']; ?>">
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>
</form>