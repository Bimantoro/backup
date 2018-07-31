<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Yud_basic extends CI_Model {

	function __construct(){
		$this->yud = $this->load->database('yudisium2', TRUE);
	}
	

	//MASTER JALUR

	function in_master_jalur($kode, $nama){
		return $q = $this->yud->query("INSERT INTO tb_master_jalur VALUES ('$kode', '$nama')");
	}

	function up_master_jalur($kode, $nama){
		return $q = $this->yud->query("UPDATE tb_master_jalur SET nama_jalur = '$nama' WHERE kode_jalur = '$kode'");
	}

	function del_master_jalur($kode){
		return $q = $this->yud->query("DELETE FROM tb_master_jalur WHERE kode_jalur = '$kode'");
	}

	function get_master_jalur($kode){
		return $q = $this->yud->query("SELECT * FROM tb_master_jalur WHERE kode_jalur = '$kode'")->row_array();
	}

	function get_all_master_jalur(){
		return $q = $this->yud->query("SELECT * FROM tb_master_jalur ORDER BY kode_jalur ASC")->result_array();
	}

	function get_available_jalur($tahun){
		//cek apakah sudah ada data pada tahun yang dimaksud :
		$jalur = $this->yud->query("SELECT * FROM tb_master_jalur")->result_array();

		$q = $this->yud->query("SELECT * FROM tb_config_bobot WHERE tahun = '$tahun'")->result_array();
		if(empty($q) && count($q) == 0){
			return $jalur;
		}else{
			$temp_jalur = array();
			foreach ($jalur as $j) {
				$sts = 1;

				foreach ($q as $c) {
					if($j['kode_jalur'] == $c['kode_jalur']){
						$sts == 0;
					}
				}

				if($sts == 1){
					$temp_jalur[] = $j;
				}
			}

			return $temp_jalur;
		}
	}

	//MASTER UJIAN

	function in_master_ujian($kode, $nama){
		return $q = $this->yud->query("INSERT INTO tb_master_ujian VALUES ('$kode', '$nama')");
	}

	function up_master_ujian($kode, $nama){
		return $q = $this->yud->query("UPDATE tb_master_ujian SET nama_ujian = '$nama' WHERE kode_ujian = '$kode'");
	}

	function del_master_ujian($kode){
		return $q = $this->yud->query("DELETE FROM tb_master_ujian WHERE kode_ujian = '$kode'");
	}

	function get_master_ujian($kode){
		return $q = $this->yud->query("SELECT * FROM tb_master_ujian WHERE kode_ujian = '$kode'")->row_array();
	}

	function get_all_master_ujian(){
		return $q = $this->yud->query("SELECT * FROM tb_master_ujian ORDER BY kode_ujian ASC")->result_array();
	}


	function get_available_ujian($tahun, $jalur, $gelombang){
		//cek apakah sudah ada data pada tahun yang dimaksud :
		$ujian = $this->yud->query("SELECT * FROM tb_master_ujian")->result_array();

		$q = $this->yud->query("SELECT * FROM tb_config_bobot WHERE tahun = '$tahun' AND kode_jalur = '$jalur' AND kode_gelombang = '$gelombang'")->result_array();
		if(empty($q)){
			return $ujian;
		}else{
			$temp_ujian = array();
			foreach ($ujian as $j) {
				$sts = 1;

				foreach ($q as $c) {
					if($j['kode_ujian'] == $c['kode_ujian']){
						$sts == 0;
					}
				}

				if($sts == 1){
					$temp_ujian[] = $j;
				}
			}

			return $temp_ujian;
		}
	}

	//MASTER KELAS

	function in_master_kelas($kode, $nama){
		return $q = $this->yud->query("INSERT INTO tb_master_kelas VALUES ('$kode', '$nama')");
	}

	function up_master_kelas($kode, $nama){
		return $q = $this->yud->query("UPDATE tb_master_kelas SET nama_kelas = '$nama' WHERE kode_kelas = '$kode'");
	}

	function del_master_kelas($kode){
		return $q = $this->yud->query("DELETE FROM tb_master_kelas WHERE kode_kelas = '$kode'");
	}

	function get_master_kelas($kode){
		return $q = $this->yud->query("SELECT * FROM tb_master_kelas WHERE kode_kelas = '$kode'")->row_array();
	}

	function get_all_master_kelas(){
		return $q = $this->yud->query("SELECT * FROM tb_master_kelas")->result_array();
	}

	//MASTER FAKULTAS

	function in_master_fakultas($kode, $nama){
		return $q = $this->yud->query("INSERT INTO tb_master_fakultas VALUES ('$kode', '$nama')");
	}

	function up_master_fakultas($kode, $nama){
		return $q = $this->yud->query("UPDATE tb_master_fakultas SET nama_fakultas = '$nama' WHERE kode_fakultas = '$kode'");
	}

	function del_master_fakultas($kode){
		return $q = $this->yud->query("DELETE FROM tb_master_fakultas WHERE kode_fakultas = '$kode'");
	}

	function get_master_fakultas($kode){
		return $q = $this->yud->query("SELECT * FROM tb_master_fakultas WHERE kode_fakultas = '$kode'")->row_array();
	}

	function get_all_master_fakultas(){
		return $q = $this->yud->query("SELECT * FROM tb_master_fakultas")->result_array();
	}

	//MASTER PRODI

	function in_master_prodi($kode, $fak, $nama, $jenjang){
		return $q = $this->yud->query("INSERT INTO tb_master_prodi VALUES ('$kode', '$fak', '$nama', ".$jenjang.")");
	}

	function up_master_prodi($kode, $nama, $jenjang){
		return $q = $this->yud->query("UPDATE tb_master_prodi SET nama_prodi = '$nama', kode_jenjang = ".$jenjang." WHERE kode_prodi = '$kode'");
	}

	function del_master_prodi($kode){
		return $q = $this->yud->query("DELETE FROM tb_master_prodi WHERE kode_prodi = '$kode'");
	}

	function get_master_prodi($kode){
		return $q = $this->yud->query("SELECT t1.*, t2.nama_fakultas as nama_fakultas FROM tb_master_prodi t1 JOIN tb_master_fakultas t2 ON t1.kode_fakultas = t2.kode_fakultas WHERE t1.kode_prodi = '$kode'")->row_array();
	}

	function get_master_prodi_by_fak($kd_fak){
		return $q = $this->yud->query("SELECT t1.*, t2.nama_fakultas as nama_fakultas, t3.nama_jenjang as nama_jenjang FROM tb_master_prodi t1 JOIN tb_master_fakultas t2 ON t1.kode_fakultas = t2.kode_fakultas JOIN tb_master_jenjang t3 ON t1.kode_jenjang = t3.kode_jenjang WHERE t1.kode_fakultas = '$kd_fak' ORDER BY t1.kode_fakultas ASC, t1.kode_jenjang ASC")->result_array();

	}

	function get_master_prodi_fak_jalur($kd_fak, $jalur){
		return $q = $this->yud->query("SELECT t1.kode_prodi as kode_prodi ,t2.nama_prodi as nama_prodi, t3.nama_jenjang as nama_jenjang FROM (SELECT s1.kode_prodi as kode_prodi FROM tb_yudisium s1 JOIN tb_master_prodi s2 ON s1.kode_prodi = s2.kode_prodi WHERE s2.kode_fakultas = '$kd_fak' AND s1.kode_jalur = '$jalur' GROUP BY s1.kode_prodi) t1 JOIN tb_master_prodi t2 ON t1.kode_prodi = t2.kode_prodi JOIN tb_master_jenjang t3 ON t2.kode_jenjang = t3.kode_jenjang ORDER BY t2.kode_jenjang")->result_array();
	}

	function get_master_prodi_multifak_jalur($fak, $jalur){
		$kd_fak = implode("','", $fak);
   		$kd_fak = "'".$kd_fak."'";
		$sql = "SELECT t1.kode_prodi as kode_prodi ,t2.nama_prodi as nama_prodi, t3.nama_jenjang as nama_jenjang 
				FROM (SELECT s1.kode_prodi as kode_prodi FROM tb_yudisium s1 JOIN tb_master_prodi s2 ON s1.kode_prodi = s2.kode_prodi WHERE s2.kode_fakultas IN (".$kd_fak.") 
				AND s1.kode_jalur = '$jalur' GROUP BY s1.kode_prodi) t1 JOIN tb_master_prodi t2 ON t1.kode_prodi = t2.kode_prodi JOIN tb_master_jenjang t3 ON t2.kode_jenjang = t3.kode_jenjang ORDER BY t2.kode_jenjang";

		// return $w = array($sql); 
		return $q = $this->yud->query($sql)->result_array();
	}


	function get_all_master_prodi(){
		return $q = $this->yud->query("SELECT t1.*, t2.nama_fakultas as nama_fakultas, t3.nama_jenjang as nama_jenjang FROM tb_master_prodi t1 JOIN tb_master_fakultas t2 ON t1.kode_fakultas = t2.kode_fakultas JOIN tb_master_jenjang t3 ON t1.kode_jenjang = t3.kode_jenjang ORDER BY t1.kode_fakultas ASC, t1.kode_jenjang ASC")->result_array();
	}

	//MASTER AKUN

	function in_data_akun($id, $fak, $level){
		return $q = $this->yud->query("INSERT INTO tb_data_akun VALUES ('$id', '$fak', '$level')");
	}

	function up_data_akun($id, $level){
		return $q = $this->yud->query("UPDATE tb_data_akun SET level = '$level' WHERE id_user = '$id'");
	}

	function del_data_akun($id){
		return $q = $this->yud->query("DELETE FROM tb_data_akun WHERE id_user = '$id'");
	}

	function get_data_akun($id){
		return $q = $this->yud->query("SELECT t1.*, t2.nama_fakultas as nama_fakultas FROM tb_data_akun t1 JOIN tb_master_fakultas t2 ON t1.kode_fakultas = t2.kode_fakultas WHERE t1.id_user = '$id'")->result_array();
	}

	function get_data_akun2($id){
		return $q = $this->yud->query("SELECT t1.*, t2.nama_fakultas as nama_fakultas FROM tb_data_akun t1 JOIN tb_master_fakultas t2 ON t1.kode_fakultas = t2.kode_fakultas WHERE t1.id_user = '$id'")->row_array();
	}

	function get_all_data_akun(){
		return $q = $this->yud->query("SELECT t1.*, t2.nama_fakultas as nama_fakultas FROM tb_data_akun t1 JOIN tb_master_fakultas t2 ON t1.kode_fakultas = t2.kode_fakultas")->result_array();
	}


	//MASTER GELOMBANG

	function in_master_gelombang($kode, $nama){
		return $q = $this->yud->query("INSERT INTO tb_master_gelombang VALUES ('$kode', '$nama')");
	}

	function up_master_gelombang($kode, $nama){
		return $q = $this->yud->query("UPDATE tb_master_gelombang SET nama_gelombang = '$nama' WHERE kode_gelombang = '$kode'");
	}

	function del_master_gelombang($kode){
		return $q = $this->yud->query("DELETE FROM tb_master_gelombang WHERE kode_gelombang = '$kode'");
	}

	function get_master_gelombang($kode){
		return $q = $this->yud->query("SELECT * FROM tb_master_gelombang WHERE kode_gelombang = '$kode'")->row_array();
	}

	function get_all_master_gelombang(){
		return $q = $this->yud->query("SELECT * FROM tb_master_gelombang")->result_array();
	}

	function get_available_gelombang($tahun, $jalur){
		//cek apakah sudah ada data pada tahun yang dimaksud :
		$gel = $this->yud->query("SELECT * FROM tb_master_gelombang")->result_array();

		$q = $this->yud->query("SELECT * FROM tb_config_bobot WHERE tahun = '$tahun' AND kode_jalur = '$jalur'")->result_array();
		if(empty($q)){
			return $gel;
		}else{
			$temp_gel = array();
			foreach ($gel as $j) {
				$sts = 1;

				foreach ($q as $c) {
					if($j['kode_gelombang'] == $c['kode_gelombang']){
						$sts == 0;
					}
				}

				if($sts == 1){
					$temp_gel[] = $j;
				}
			}

			return $temp_gel;
		}
	}

	//MASTER JENJANG

	function in_master_jenjang($kode, $nama){
		return $q = $this->yud->query("INSERT INTO tb_master_jenjang VALUES (".$kode.", '$nama')");
	}

	function up_master_jenjang($kode, $nama){
		return $q = $this->yud->query("UPDATE tb_master_jenjang SET nama_jenjang = '$nama' WHERE kode_jenjang = ".$kode."");
	}

	function del_master_jenjang($kode){
		return $q = $this->yud->query("DELETE FROM tb_master_jenjang WHERE kode_jenjang = ".$kode."");
	}

	function get_master_jenjang($kode){
		return $q = $this->yud->query("SELECT * FROM tb_master_jenjang WHERE kode_jenjang = ".$kode."")->row_array();
	}

	function get_all_master_jenjang(){
		return $q = $this->yud->query("SELECT * FROM tb_master_jenjang ORDER BY kode_jenjang ASC")->result_array();
	}

	//CONFIG BOBOT

	function in_cfg_bobot($tahun, $jalur, $gel, $ujian, $bobot){
		return $q = $this->yud->query("INSERT INTO tb_config_bobot VALUES ('$tahun', '$jalur', '$gel', '$ujian', ".$bobot." )");
	}

	function up_cfg_bobot($tahun, $jalur, $gel, $ujian, $bobot){
		return $q = $this->yud->query("UPDATE tb_config_bobot SET bobot = ".$bobot." WHERE tahun = '$tahun' AND kode_jalur = '$jalur' AND kode_gelombang = '$gel' AND kode_ujian = '$ujian' ");
	}

	function del_cfg_bobot($tahun, $jalur, $gel, $ujian){
		return $q = $this->yud->query("DELETE FROM tb_config_bobot WHERE tahun = '$tahun' AND kode_jalur = '$jalur' AND kode_gelombang = '$gel' AND kode_ujian = '$ujian' ");
	}

	function get_cfg_bobot($tahun, $jalur, $gel, $ujian){
		return $q = $this->yud->query("SELECT * FROM tb_config_bobot WHERE tahun = '$tahun' AND kode_jalur = '$jalur' AND kode_gelombang = '$gel'  AND kode_ujian = '$ujian' ")->row_array();
	}

	function get_all_cfg_bobot(){
		return $q = $this->yud->query("SELECT t1.*, t2.nama_jalur as nama_jalur, t3.nama_gelombang as nama_gelombang, t4.nama_ujian as nama_ujian FROM tb_config_bobot t1 JOIN tb_master_jalur t2 ON t1.kode_jalur = t2.kode_jalur JOIN tb_master_gelombang t3 ON t3.kode_gelombang = t1.kode_gelombang JOIN tb_master_ujian t4 ON t1.kode_ujian = t4.kode_ujian")->result_array();
	}

	//CONFIG PILIHAN

	function in_cfg_pilihan($tahun, $jalur, $gel, $kelas, $pilihan, $mulai, $selesai, $no, $ketua, $tgl, $tempat){
		return $q = $this->yud->query("INSERT INTO tb_config_pilihan VALUES ('$tahun', '$jalur', '$gel', '$kelas', '$pilihan', '$mulai', '$selesai', '$no', '$ketua', '$tgl', '$tempat')");
	}

	function up_cfg_pilihan($tahun, $jalur, $gel, $kelas, $pilihan, $mulai, $selesai, $no, $ketua, $tgl, $tempat){
		return $q = $this->yud->query("UPDATE tb_config_pilihan SET tgl_mulai = '$mulai', tgl_selesai = '$selesai', ketua_yudisium = '$ketua', tgl_yudisium = '$tgl', no_yudisium = '$no', kode_kelas = '$kelas', pilihan = '$pilihan', tempat_yudisium = '$tempat' WHERE tahun = '$tahun' AND kode_jalur = '$jalur' AND kode_gelombang = '$gel'");
	}

	function del_cfg_pilihan($tahun, $jalur, $gel, $kelas, $pilihan){
		return $q = $this->yud->query("DELETE FROM tb_config_pilihan WHERE tahun = '$tahun' AND kode_jalur = '$jalur' AND kode_gelombang = '$gel' AND pilihan = '$pilihan' AND kode_kelas = '$kelas' ");
	}

	function get_cfg_pilihan($tahun, $jalur, $gel){
		return $q = $this->yud->query("SELECT t1.*, t2.nama_jalur as nama_jalur FROM tb_config_pilihan t1 LEFT JOIN tb_master_jalur t2 ON t1.kode_jalur = t2.kode_jalur WHERE t1.tahun = '$tahun' AND t1.kode_jalur = '$jalur' AND t1.kode_gelombang = '$gel'")->row_array();
	}

	function get_all_cfg_pilihan(){
		return $q = $this->yud->query("SELECT t1.*, t2.nama_jalur as nama_jalur FROM tb_config_pilihan t1 LEFT JOIN tb_master_jalur t2 ON t1.kode_jalur = t2.kode_jalur ORDER BY t1.tahun DESC, t1.kode_gelombang ASC, t1.kode_jalur ASC")->result_array();
	}

	function get_cfg_pilihan_by_date($tanggal = ''){
		if($tanggal == ''){
			$tanggal = date('Y-m-d');
		}
		return $q = $this->yud->query("SELECT * FROM tb_config_pilihan WHERE tgl_mulai <= '$tanggal' AND '$tanggal' <= tgl_selesai")->result_array();
	}

	function get_cfg_pilihan_aktif($jalur){
		$tanggal = date('Y-m-d');
		return $q = $this->yud->query("SELECT * FROM tb_config_pilihan WHERE tgl_mulai <= '$tanggal' AND '$tanggal' <= tgl_selesai AND kode_jalur = '$jalur'")->result_array();
	}

	//ini function untuk listing data peserta :
	function get_data_peserta_prodi($prodi){
		$sql = "SELECT t1.nomor_peserta as nomor_peserta, t2.nama_peserta as nama_peserta, t1.pilihan as pilihan FROM tb_yudisium t1 JOIN tb_data_peserta t2 ON t1.nomor_peserta = t2.nomor_peserta WHERE t1.kode_prodi = '$prodi' ORDER BY t1.pilihan ASC, t1.nomor_peserta ASC";

		return $q = $this->yud->query($sql)->result_array();
	}

	function get_data_peserta_prodi2($tahun, $gelombang, $prodi){
		$sql = "SELECT t1.nomor_peserta as nomor_peserta, t2.nama_peserta as nama_peserta, t1.pilihan as pilihan, t1.kode_kelas as kode_kelas FROM tb_yudisium t1 JOIN tb_data_peserta t2 ON t1.nomor_peserta = t2.nomor_peserta WHERE t1.kode_prodi = '$prodi' AND t1.tahun = '$tahun' AND t1.kode_gelombang = '$gelombang' ORDER BY t1.pilihan ASC, t1.nomor_peserta ASC";

		return $q = $this->yud->query($sql)->result_array();
	}

	function get_data_yudisium($prodi, $pilihan){
		if($pilihan == '1'){
			$oposite = '2';
		}else{
			$oposite = '1';
		}


		$sql = "SELECT t1.*, t2.*, EXTRACT (YEAR FROM CURRENT_DATE) - EXTRACT (YEAR FROM t2.tgl_lahir) AS usia FROM tb_yudisium t1 JOIN tb_data_peserta t2 ON t1.nomor_peserta = t2.nomor_peserta WHERE t1.kode_prodi = '$prodi' AND t1.pilihan = '$pilihan' AND t1.nomor_peserta NOT IN (SELECT nomor_peserta FROM tb_yudisium WHERE pilihan = '$oposite' AND status = '1')";

		return $q = $this->yud->query($sql)->result_array();
	}

	function get_data_yudisium2($prodi, $tahun, $gelombang, $jalur, $pilihan, $kelas){
		if($pilihan == '1'){
			$oposite = '2';
		}else{
			$oposite = '1';
		}


		$sql = "SELECT t1.*, t2.*, EXTRACT (YEAR FROM CURRENT_DATE) - EXTRACT (YEAR FROM t2.tgl_lahir) AS usia, ROUND(COALESCE(t3.nilai_total, 0),2) AS nilai_total 
		FROM tb_yudisium t1 JOIN tb_data_peserta t2 ON t1.nomor_peserta = t2.nomor_peserta 
		LEFT JOIN (SELECT s1.nomor_peserta AS nomor_peserta, SUM(nilai*bobot)/100 AS nilai_total FROM (
		SELECT ss1.nomor_peserta AS nomor_peserta, ss2.kode_ujian, ss1.nilai, ss2.bobot FROM tb_nilai ss1 RIGHT JOIN tb_config_bobot ss2 ON ss1.kode_ujian = ss2.kode_ujian
		WHERE ss2.kode_jalur = '$jalur' AND ss2.tahun = '$tahun' AND kode_gelombang = '$gelombang' ORDER BY ss1.nomor_peserta, ss1.kode_ujian
		) s1 GROUP BY s1.nomor_peserta
		) t3 ON t1.nomor_peserta = t3.nomor_peserta WHERE t1.kode_prodi = '$prodi' AND t1.tahun = '$tahun' AND t1.kode_gelombang = '$gelombang' AND t1.kode_jalur = '$jalur' AND t1.pilihan = '$pilihan' AND kode_kelas = '$kelas' AND t1.nomor_peserta NOT IN (SELECT nomor_peserta FROM tb_yudisium WHERE pilihan = '$oposite' AND status = '1') ORDER BY COALESCE(t3.nilai_total,0) DESC";

		return $q = $this->yud->query($sql)->result_array();
	}


	function get_data_peserta2($prodi, $tahun, $gelombang, $jalur){

		$sql = "SELECT t1.*, t2.*, EXTRACT (YEAR FROM CURRENT_DATE) - EXTRACT (YEAR FROM t2.tgl_lahir) AS usia, ROUND(COALESCE(t3.nilai_total, 0),2) AS nilai_total 
		FROM tb_yudisium t1 JOIN tb_data_peserta t2 ON t1.nomor_peserta = t2.nomor_peserta 
		LEFT JOIN (SELECT s1.nomor_peserta AS nomor_peserta, SUM(nilai*bobot)/100 AS nilai_total FROM (
		SELECT ss1.nomor_peserta AS nomor_peserta, ss2.kode_ujian, ss1.nilai, ss2.bobot FROM tb_nilai ss1 RIGHT JOIN tb_config_bobot ss2 ON ss1.kode_ujian = ss2.kode_ujian
		WHERE ss2.kode_jalur = '$jalur' AND ss2.tahun = '$tahun' AND kode_gelombang = '$gelombang' ORDER BY ss1.nomor_peserta, ss1.kode_ujian
		) s1 GROUP BY s1.nomor_peserta
		) t3 ON t1.nomor_peserta = t3.nomor_peserta WHERE t1.kode_prodi = '$prodi' AND t1.tahun = '$tahun' AND t1.kode_gelombang = '$gelombang' AND t1.kode_jalur = '$jalur' ORDER BY COALESCE(t3.nilai_total,0) DESC";

		return $q = $this->yud->query($sql)->result_array();
	}

	function up_status_diterima($nomor_peserta, $pilihan){
		$sts = false;
		$q1 = $this->yud->query("SELECT status FROM tb_yudisium WHERE nomor_peserta = '$nomor_peserta' AND pilihan = '$pilihan'")->row_array();
		if(!empty($q1)){
			$status = $q1['status'];
			if($status == '1'){
				$oposite = '0';
			}else{
				$oposite = '1';
			}

			$sts = array('sukses');
		

		 	$q2 = $this->yud->query("UPDATE tb_yudisium SET status = '$oposite' WHERE nomor_peserta = '$nomor_peserta' AND pilihan = '$pilihan'");
		 }
		return $sts;

	}

	function up_status_diterima_prodi($kode_prodi, $pilihan, $status, $kelas){
		$q1 = $this->yud->query("UPDATE tb_yudisium SET status = '$status' WHERE kode_prodi = '$kode_prodi' AND pilihan = '$pilihan' AND kode_kelas = '$kelas'");
		return $q1;
	}

	function get_detail_nilai_ujian($peserta){
		$q = $this->yud->query("SELECT t1.nomor_peserta AS nomor_peserta, t1.nilai AS nilai, t2.nama_ujian AS nama_ujian, t3.nama_peserta AS nama_peserta, t3.asal_sekolah AS asal_sekolah, COALESCE(t4.nama_prodi, '-') as pilihan1, COALESCE(t5.nama_prodi, '-') as pilihan2
			FROM tb_nilai t1 LEFT JOIN tb_master_ujian t2 ON t1.kode_ujian = t2.kode_ujian JOIN tb_data_peserta t3 ON t1.nomor_peserta = t3.nomor_peserta JOIN 
			(SELECT s2.nomor_peserta as nomor_peserta, s1.nama_prodi as nama_prodi FROM tb_master_prodi s1 JOIN tb_yudisium s2 ON s1.kode_prodi = s2.kode_prodi WHERE s2.pilihan = '1') t4 ON t1.nomor_peserta = t4.nomor_peserta
			LEFT JOIN
			(SELECT s2.nomor_peserta as nomor_peserta, s1.nama_prodi as nama_prodi FROM tb_master_prodi s1 JOIN tb_yudisium s2 ON s1.kode_prodi = s2.kode_prodi WHERE s2.pilihan = '2') t5 ON t1.nomor_peserta = t5.nomor_peserta 
			WHERE t1.nomor_peserta = '$peserta';")->result_array();

		if(empty($q)){
			$q = $this->yud->query("SELECT t1.nomor_peserta as nomor_peserta, t1.nama_peserta as nama_peserta, 'X0X' as nilai, 'X0X' AS nama_ujian, t1.asal_sekolah as asal_sekolah, COALESCE(t2.nama_prodi, '-') as pilihan1, COALESCE(t3.nama_prodi, '-') as pilihan2 
				FROM tb_data_peserta t1 LEFT JOIN 
				(SELECT s2.nomor_peserta as nomor_peserta, s1.nama_prodi as nama_prodi FROM tb_master_prodi s1 JOIN tb_yudisium s2 ON s1.kode_prodi = s2.kode_prodi WHERE s2.pilihan = '1') t2 ON t1.nomor_peserta = t2.nomor_peserta
				LEFT JOIN
				(SELECT s2.nomor_peserta as nomor_peserta, s1.nama_prodi as nama_prodi FROM tb_master_prodi s1 JOIN tb_yudisium s2 ON s1.kode_prodi = s2.kode_prodi WHERE s2.pilihan = '2') t3 ON t1.nomor_peserta = t3.nomor_peserta 
				WHERE t1.nomor_peserta = '$peserta';")->result_array();
		}

		return $q;



		// return $q = $this->yud->query("SELECT t1.nomor_peserta AS nomor_peserta, t1.nilai AS nilai, t2.nama_ujian AS nama_ujian, t3.nama_peserta AS nama_peserta, t3.asal_sekolah AS asal_sekolah 
		// 	FROM tb_nilai t1 LEFT JOIN tb_master_ujian t2 ON t1.kode_ujian = t2.kode_ujian JOIN tb_data_peserta t3 ON t1.nomor_peserta = t3.nomor_peserta 
		// 	WHERE t1.nomor_peserta = '$peserta'")->result_array();
	}

	function get_rekapitulasi_diterima($kd_fak = ''){
		
		$sql = "SELECT t1.kode_prodi, t2.nama_prodi, COALESCE(t3.jumlah, 0) as pilihan1, COALESCE(t4.jumlah, 0) as pilihan2 FROM (SELECT s1.kode_prodi as kode_prodi FROM tb_yudisium s1 JOIN tb_master_prodi s2 ON s1.kode_prodi = s2.kode_prodi WHERE s2.kode_fakultas = '$kd_fak' AND s1.kode_jalur IN (SELECT kode_jalur FROM tb_master_jalur) GROUP BY s1.kode_prodi) t1
			LEFT JOIN tb_master_prodi t2 ON t1.kode_prodi = t2.kode_prodi LEFT JOIN
			( SELECT t1.kode_prodi as kode_prodi, t1.nama_prodi as nama_prodi , count(t2.kode_prodi) as jumlah FROM tb_master_prodi t1 LEFT JOIN tb_yudisium t2 ON t1.kode_prodi = t2.kode_prodi WHERE t2.pilihan = '1' AND t2.status = '1' GROUP BY t1.kode_prodi ) t3
			ON t1.kode_prodi = t3.kode_prodi LEFT JOIN
			( SELECT t1.kode_prodi as kode_prodi, t1.nama_prodi as nama_prodi , count(t2.kode_prodi) as jumlah FROM tb_master_prodi t1 LEFT JOIN tb_yudisium t2 ON t1.kode_prodi = t2.kode_prodi WHERE t2.pilihan = '2' AND t2.status = '1' GROUP BY t1.kode_prodi ) t4
			ON t1.kode_prodi = t4.kode_prodi;";

		return $q = $this->yud->query($sql)->result_array();
	}


	function get_rekapitulasi_diterima2($kd_fak = '', $kd_jalur = ''){
		
		$sql = "SELECT q1.kode_prodi as kode_prodi, t1.* , t2.nama_fakultas, t3.pilihan AS pilihan, t3.diterima AS diterima FROM (SELECT s1.kode_prodi as kode_prodi FROM tb_yudisium s1 JOIN tb_master_prodi s2 ON s1.kode_prodi = s2.kode_prodi WHERE s2.kode_fakultas = '6' AND s1.kode_jalur = '82' GROUP BY s1.kode_prodi) q1
			LEFT JOIN tb_master_prodi t1 ON q1.kode_prodi = t1.kode_prodi JOIN tb_master_fakultas t2 ON t1.kode_fakultas = t2.kode_fakultas 
			LEFT JOIN (SELECT s1.kode_prodi as kode_prodi, s1.pilihan as pilihan, COALESCE(COUNT(*), 0) as diterima FROM tb_yudisium s1 WHERE status = '0' GROUP BY s1.pilihan, s1.kode_prodi ORDER BY s1.kode_prodi, s1.pilihan) t3 ON t1.kode_prodi = t3.kode_prodi";

		return $q = $this->yud->query($sql)->result_array();
	}

	function get_data_peserta_diterima($tahun, $gelombang, $jalur, $kelas, $kd_prodi){
		$sql = "SELECT t1.nomor_peserta AS nomor_peserta, t2.nama_peserta AS nama_peserta FROM tb_yudisium t1 LEFT JOIN tb_data_peserta t2 ON t1.nomor_peserta = t2.nomor_peserta WHERE tahun = '$tahun' AND kode_gelombang = '$gelombang' AND kode_jalur = '$jalur' AND kode_kelas = '$kelas' AND kode_prodi = '$kd_prodi' AND status = '1' ORDER BY t1.nomor_peserta";

		return $q = $this->yud->query($sql)->result_array();

	}

	function get_rekap_nilai_ujian($tahun, $gelombang, $jalur){
		$sql = "SELECT t1.kode_ujian, t2.nama_ujian, ROUND(t1.min,2) AS min, ROUND(t1.max,2) AS max, ROUND(t1.average,2) AS average, ROUND(t1.std,2) AS std FROM (
					SELECT kode_ujian , MIN(nilai) AS min, MAX(nilai) AS max, AVG(nilai) AS average, STDDEV(nilai) AS std FROM tb_nilai  WHERE nomor_peserta IN 
					(SELECT nomor_peserta FROM tb_yudisium WHERE tahun = '$tahun' AND kode_gelombang = '$gelombang' AND kode_jalur = '$jalur') GROUP BY kode_ujian
				) t1 LEFT JOIN tb_master_ujian t2 ON t1.kode_ujian = t2.kode_ujian";

		return $q = $this->yud->query($sql)->result_array();
	}



}
