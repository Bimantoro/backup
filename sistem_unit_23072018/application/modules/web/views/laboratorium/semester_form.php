
			<?php
				$arr_smt = array( 1 => 'SEMESTER GASAL', 2=> 'SEMESTER GENAP', 3 => 'SEMESTER PENDEK');
			?>
				
			<form class="form-horizontal" role="form" id="form" method="post" action="">
			  <div class="form-group">
				<label for="ta" class="col-sm-3 control-label">Tahun Akademik</label>
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
					<label for="smt" class="col-sm-3 control-label">Semester </label>
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
						<button  class="btn-uin btn btn-inverse btn btn-small" type="submit" style="height:25px; margin-left:-20px;" >Tampilkan</button>
					</div>
				</div>
			</form>	
