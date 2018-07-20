
<?php foreach($page as $page){} ?>


    <link rel="stylesheet" href="<?php echo base_url()?>/asset/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url()?>/asset/scripts/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>/asset/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>/asset/jqwidgets/jqxvalidator.js"></script> 
    <script type="text/javascript" src="<?php echo base_url()?>/asset/jqwidgets/jqxbuttons.js"></script> 
    <script type="text/javascript" src="<?php echo base_url()?>/asset/jqwidgets/jqxcheckbox.js"></script> 
    <script type="text/javascript" src="<?php echo base_url()?>/asset/jqwidgets/globalization/globalize.js"></script> 
    <script type="text/javascript" src="<?php echo base_url()?>/asset/jqwidgets/jqxcalendar.js"></script> 
    <script type="text/javascript" src="<?php echo base_url()?>/asset/jqwidgets/jqxdatetimeinput.js"></script> 
    <script type="text/javascript" src="<?php echo base_url()?>/asset/jqwidgets/jqxmaskedinput.js"></script> 
    <script type="text/javascript" src="<?php echo base_url()?>/asset/scripts/gettheme.js"></script> 
    <script type="text/javascript">
	$(document).ready(function () {
		var theme = getDemoTheme();
		$('#sendButton').jqxButton({ width: 60, height: 25, theme: theme });
		

		var date = new Date();
		//date.setFullYear(1985, 0, 1);
		$('#date_input').jqxDateTimeInput({ height:30, value: "<?php echo jquery_date($page->tgl_mulai) ?>" , selectionMode: 'range'});
		$('#date_input').jqxDateTimeInput('setRange', "<?php echo jquery_date($page->tgl_mulai) ?>", "<?php echo jquery_date($page->tgl_selesai) ?>");
		// initialize validator.
		$('#form').jqxValidator({
			rules: [
			{ input: '#acara', message: 'Acara harus diisi', action: 'keyup, blur', rule: 'required' },
			{ input: '#tempat', message: 'Tempat harus diisi', action: 'keyup, blur', rule: 'required' },
			{ input: '#jam_mulai', message: 'Jam Mulai harus diisi', action: 'keyup, blur', rule: 'required' },
			]
		});

		// validate form.
		$("#sendButton").click(function () {
			var validationResult = function (isValid) {
				if (isValid) {
					$("#form").submit();
				}
			}
			$('#form').jqxValidator('validate', validationResult);
		});

		$("#form").on('validationSuccess', function () {
			$("#form-iframe").fadeIn('fast');
		});
	});
    </script>

    <div style="height: 219px;">
        <form class="form" id="form"   method="post" action="" style=" float:right; font-size: 13px; font-family: Verdana; width: 720px;" enctype="multipart/form-data">
            <div>
                <h2>Agenda </h2>
            </div>
	      <table>
                    <tr>
                        <td>Acara :</td>
                        <td><input name="acara" type="text" id="acara" value="<?php echo $page->nama_agenda ?>" style="width:300px;" /></td>
                    </tr>
                    <tr>
                        <td>Tempat :</td>
                        <td><input name="tempat" type="text" id="tempat" value="<?php echo $page->tempat ?>" style="width:300px;" /></td>
                    </tr>
                    <tr>
                        <td>Tanggal:</td>
                        <td><div name="tanggal" id="date_input"></div></td>
                    </tr>
                    <tr>
                        <td>Jam:</td>
                        <td><input type="text" name="jam_mulai" id="jam_mulai" value="<?php echo substr($page->jam_mulai,0,5) ?>"/>
			- <input type="text" name="jam_selesai" style="margin-top:5px;" value="<?php echo substr($page->jam_selesai,0,5) ?>" /></td>
                    </tr>
                    <tr>
                        <td>Sumber:</td>
                        <td><input name="sumber" type="text" id="sumber" value="<?php echo $page->cp ?>" /></td>
                    </tr>
					<tr>
						<td colspan="3">Lampiran :</td>
					</tr>
					<tr>
						<td colspan="3"><input placeHolder="file" name="lampiran" type="file" id="file" style='width: 100%;' class="text-input" /></td>
					</tr>
                    <tr>
                        <td colspan="2">Deskripsi :</td>
                    </tr>
					<tr>					
					    <td colspan="2"><textarea name="topik" id="topik"><?php echo $page->topik ?></textarea>	
					<?php echo display_ckeditor($ckeditor); ?>	</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right; padding:20px 5px 0 0;"><input type="button" value="Simpan" id="sendButton" /></td>
                    </tr>
                </table>
        </form>
        <iframe id="form-iframe" name="form-iframe" class="demo-iframe" frameborder="0"></iframe>
    </div>
	
	
	