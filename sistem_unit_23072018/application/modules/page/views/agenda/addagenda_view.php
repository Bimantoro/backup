    <link rel="stylesheet" href="http://adab.uin-suka.ac.id/asset/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
    <link href="http://static.uin-suka.ac.id/plugins/timepicker/css/bootstrap-timepicker.min.css" type="text/css" rel="stylesheet" />

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.2.2/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://static.uin-suka.ac.id/plugins/timepicker/js/bootstrap-timepicker.js"></script>
    <script type="text/javascript">
        $(document).ready(function () { 
            $('#jm,#js').timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false,
                defaultTime: false
            });
        });
    </script>
	<style>
	.day{
		font-size:14px;
	}
	</style>
   <link href="http://static.uin-suka.ac.id/plugins/datepicker/css/datepicker.css" rel="stylesheet">

    <script src="http://static.uin-suka.ac.id/plugins/datepicker/js/bootstrap-datepicker.js"></script>
	<script>

		$(function(){
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#dpd1').datepicker({
			format: 'dd/mm/yyyy',
          onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate());
            checkout.setValue(newDate);
          }
          checkin.hide();
		  
          $('#dpd2')[0].focus();
        }).data('datepicker');
        var checkout = $('#dpd2').datepicker({
			format: 'dd/mm/yyyy',
          onRender: function(date) {
            return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');
		
		$('#ruang').on('change',function(){
			var ruang=$('#ruang option:selected').val();
			if(ruang==""){
				$('#tempat').show();
				$('#tempat').focus();
			}else{
				$('#tempat').val($("#ruang option:selected").text());
				$('#tempat').hide();
			}
		});
		});
		
	</script>
	<style>
		#tempat{
			display:none;
		}
	</style>
	<?php
		if($this->session->userdata("data_agenda")){
			$data_agenda=$this->session->userdata("data_agenda");
			$nama_agenda=$data_agenda['nama_agenda'];
			$kd_ruang=$data_agenda['kd_ruang'];
			$tempat=$data_agenda['tempat'];
			$tgl_mulai=$data_agenda['tgl_mulai'];
			$tgl_selesai=$data_agenda['tgl_selesai'];
			$jam_mulai=$data_agenda['jam_mulai'];
			$jam_selesai=$data_agenda['jam_selesai'];
			$jam_selesai=$data_agenda['jam_selesai'];
			$cp=$data_agenda['cp'];
			$topik=$data_agenda['topik'];
		}else{
			if(isset($page)){
				foreach($page as $p){
					$nama_agenda=$p->nama_agenda;
					$kd_ruang=$p->kd_ruang;
					$tempat=$p->tempat;
					$tgl_mulai=$p->tgl_mulai;
					$tgl_selesai=$p->tgl_selesai;
					$jam_mulai=$p->jam_mulai;
					$jam_selesai=$p->jam_selesai;
					$jam_selesai=$p->jam_selesai;
					$cp=$p->cp;
					$topik=$p->topik;
				}
			}
		}
	?>
    <div style="height: 219px;">
        <form class="form" id="form"   method="post" action="" style=" float:right; font-size: 13px; font-family: Verdana; width: 720px;" enctype="multipart/form-data">
            <div>
                <h2>Agenda </h2>
            </div>
	      <table>
                    <tr>
                        <td>Acara :</td>
                        <td><input name="acara" type="text" id="acara" value="<?php if(isset($nama_agenda)) echo $nama_agenda ?>"style="width:300px;" /></td>
                    </tr>
                    <tr>
                        <td>Tempat :</td>
                        <td><select name="ruang" id="ruang">
						<option value="">--- PILIH RUANG ---</option>
							<?php foreach($ruang as $r){?>
							<?php if(isset($kd_ruang) and $kd_ruang==$r['KD_RUANG']){ ?>
							<option value="<?php echo $r['KD_RUANG'];?>" selected ><?php echo $r['NM_GEDUNG'].' '. $r['NM_RUANG'];?></option>
							<?php }else{?>
							<option value="<?php echo $r['KD_RUANG'];?>"><?php echo $r['NM_GEDUNG'].' '. $r['NM_RUANG'];?></option>
							<?php }?>
							<?php }?>
						<option value="">LAINNYA</option>
						</select>
						<input type="text" id="tempat" name="tempat" value="<?php if(isset($tempat)) echo $tempat ?>" />
						</td>
                    </tr>
                    <tr>
                        <td>Tanggal:</td>
                        <td><input class="span2"  id="dpd1" name="tgl_mulai" value="<?php if(isset($tgl_mulai)) echo jquery_date($tgl_mulai) ?>" type="text">
						 - <input class="span2"  id="dpd2" name="tgl_selesai"  value="<?php if(isset($tgl_selesai)) echo jquery_date($tgl_selesai) ?>"type="text"></td>
                    </tr>
                    <tr>
                        <td>Jam:</td>
                        <td><div class="input-append bootstrap-timepicker">
								<input id="jm" name="jam_mulai" class="input-small" value="<?php if(isset($jam_mulai)){ echo $jam_mulai; }else{ echo "08:00:00"; }?>" type="text"/><span class="add-on"><i class="icon-time"></i></span>
							</div> - <div class="input-append bootstrap-timepicker">
								<input id="js" name="jam_selesai" class="input-small" value="<?php if(isset($jam_selesai)){ echo $jam_selesai; }else{ echo "08:00:00"; }?>"  type="text"/><span class="add-on"><i class="icon-time"></i></span>
							</div>
					</td>
                    </tr>
                    <tr>
                        <td>Sumber:</td>
                        <td><input name="sumber" type="text" id="sumber"  value="<?php if(isset($cp)) echo $cp ?>"/></td>
                    </tr>
					<tr>
						<td colspan="3"><label class='form-label'>Lampiran :</label></td>
					</tr>
					<tr>
						<td colspan="3"><input placeHolder="file" name="lampiran" type="file" id="file" style='width: 100%;' class="text-input" /></td>
					</tr>
                    <tr>
                        <td colspan="2">Deskripsi :</td>
                    </tr>
					<tr>					
					    <td colspan="2"><textarea name="topik" id="topik"><?php if(isset($topik)) echo $topik ?></textarea>	
					<?php echo display_ckeditor($ckeditor); ?>	</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right; padding:20px 5px 0 0;"><input type="submit" value="Simpan" id="sendButton" /></td>
                    </tr>
                </table>
        </form>
        <iframe id="form-iframe" name="form-iframe" class="demo-iframe" frameborder="0"></iframe>
    </div>
	
	
	
	