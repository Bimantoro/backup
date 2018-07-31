<?php foreach($menu as $p){} ?>
<form class="form-horizontal form-bordered" method="post" action="">
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_menu">Nama Menu</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="nama_menu" id="nama_menu" value="<?php echo $p->nama_menu?>" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="bahasa">Bahasa</label>
		<?php $bhs=array('id'=>'Indonesia','en'=>'English','ar'=>'Arabic');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="bahasa" id="bahasa">
				<?php foreach($bhs as $ib=>$bs){
					echo"<option value='".$ib."'>".$bs."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="url">URL</label>
		<div class="col-md-6">
			<input class="form-control" name="url" id="url" type="text" value="<?php echo $p->url?>" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="parent">Parent Menu</label>
		
		<div class="col-md-2">			
			<select class="form-control mb-md" name="parent" id="parent" >
				<option value="0"> - </option>
				<?php foreach($parent as $q){?>
					<?php if($q->id_menu == $p->parent) :?>
					<?php echo"<option value='".$q->id_menu."' selected>".$q->nama_menu."</option>";?>
					<?php else :?>
					<?php echo"<option value='".$q->id_menu."'>".$q->nama_menu."</option>";?>
					<?php endif?>
				<?php }
				?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-3 control-label" for="target">Target</label>
		<?php $trg=array('_self','_blank','_parent','_top');?>
		<div class="col-md-2">			
			<select class="form-control mb-md" name="target" id="target">
				<?php
					foreach ($trg as $tg) {
						if($target['target'] == $tg){?>
							<option value="<?php echo $target['target'];?>" selected><?php echo $target['target'];?></option>
						<?php }else{?>
							<option value="<?php echo $tg;?>"><?php echo $tg;?></option>
						<?php }
					}
				?>
			</select>

		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url">Jenis Link</label>
		<?php $jnl=array('Internal','Eksternal');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="jenis_url" id="jenis_url">
				<?php foreach($jenisurl as $j){?>
					<?php if($j->jenis_url == $p->jenis_url):?>
					<?php echo "<option value='".$j->jenis_url."' selected>".$j->jenis_url."</option>"?>
					<?php else :?>
					<?php echo "<option value='".$j->jenis_url."'>".$j->jenis_url."</option>"?>
					<?php endif?>
				<?php }
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>

</form>