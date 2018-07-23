
			<?php
			$lang = $this->page_lib->lang();
				$arr_smt = array( 1 => strtoupper(dict('SEMESTER GASAL', $lang)), 2=> strtoupper(dict('SEMESTER GENAP', $lang)), 3 => strtoupper(dict('SEMESTER PENDEK', $lang)));
			?>
			<form class="form-horizontal" role="form" id="form" method="post" action="">
			  <div class="form-group">
				<label for="ta" class="col-sm-3 control-label"><?php echo ucwords(dict('Tahun Akademik', $lang)) ?></label>
				<div class="col-sm-6">
					<select id="ta" name="ta" class="form-control input-sm">
						<?php 
						for($a=$cta; $a>=2006; $a--){
							if($a==$ta){
								echo"<option value='".$a."' selected>".$a."/".($a+1)."</option>";
							}else{
								echo"<option value='".$a."'>".$a."/".($a+1)."</option>";
							}
						}
						?>
					</select>
				</div>
			  </div>
				<div class="form-group">
					<label for="smt" class="col-sm-3 control-label"><?php echo ucwords(dict('Semester', $lang)) ?> </label>
					<div class="col-sm-6">
						<select id="smt" name="smt" class="form-control input-sm">
									<?php 
									foreach($arr_smt as $a=>$val){
										if($a==$smt){
											echo"<option value='".$a."' selected>".$val."</option>";
										}else{
											echo"<option value='".$a."'>".$val."</option>";
										}
									}
									?>
						</select>
					</div>
					<div class="col-sm-1">      	
						<button  class="btn btn-primary" type="submit"><?php echo ucwords(dict('Tampilkan', $lang)) ?></button>
						<!-- <button  class="btn btn-primary" type="submit" style="height:30px; margin-left:-20px; background: #222222; border-color: #111111;">Tampilkan</button> -->
						<!-- <button  class="btn-uin btn btn-inverse btn btn-small" type="submit" style="height:25px; margin-left:-20px;">Tampilkan</button> -->
					</div>
				</div>
			</form>	
