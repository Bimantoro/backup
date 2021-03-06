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

	function in_cfg_pilihan($tahun, $jalur, $gel, $kelas, $pilihan, $mulai, $selesai, $no, $ketua, $tgl){
		return $q = $this->yud->query("INSERT INTO tb_config_pilihan VALUES ('$tahun', '$jalur', '$gel', '$kelas', '$pilihan', '$mulai', '$selesai', '$no', '$ketua', '$tgl')");
	}

	function up_cfg_pilihan($tahun, $jalur, $gel, $kelas, $pilihan, $mulai, $selesai, $no, $ketua, $tgl){
		return $q = $this->yud->query("UPDATE tb_config_pilihan SET tgl_mulai = '$mulai', tgl_selesai = '$selesai', ketua_yudisium = '$ketua', tgl_yudisium = '$tgl', no_yudisium = '$no', kode_kelas = '$kelas' WHERE tahun = '$tahun' AND kode_jalur = '$jalur' AND kode_gelombang = '$gel' AND pilihan = '$pilihan' ");
	}

	function del_cfg_pilihan($tahun, $jalur, $gel, $kelas, $pilihan){
		return $q = $this->yud->query("DELETE FROM tb_config_pilihan WHERE tahun = '$tahun' AND kode_jalur = '$jalur' AND kode_gelombang = '$gel' AND pilihan = '$pilihan' AND kode_kelas = '$kelas' ");
	}

	function get_cfg_pilihan($tahun, $jalur, $gel, $kelas, $pilihan){
		return $q = $this->yud->query("SELECT * FROM tb_config_pilihan WHERE tahun = '$tahun' AND kode_jalur = '$jalur' AND kode_gelombang = '$gel' AND pilihan = '$pilihan' AND kode_kelas = '$kelas' ")->row_array();
	}

	function get_all_cfg_pilihan(){
		return $q = $this->yud->query("SELECT * FROM tb_config_pilihan")->result_array();
	}

	function get_cfg_pilihan_by_date($tanggal = ''){
		if($tanggal == ''){
			$tanggal = date('Y-m-d');
		}
		return $q = $this->yud->query("SELECT * FROM tb_config_pilihan WHERE tgl_mulai <= '$tanggal' AND '$tanggal' <= tgl_selesai")->result_array();
	}

	//ini function untuk listing data peserta :
	function get_data_peserta_prodi($prodi){
		$sql = "SELECT t1.nomor_peserta as nomor_peserta, t2.nama_peserta as nama_peserta, t1.pilihan as pilihan FROM tb_yudisium t1 JOIN tb_data_peserta t2 ON t1.nomor_peserta = t2.nomor_peserta WHERE t1.kode_prodi = '$prodi' ORDER BY t1.pilihan ASC, t1.nomor_peserta ASC";

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
}
