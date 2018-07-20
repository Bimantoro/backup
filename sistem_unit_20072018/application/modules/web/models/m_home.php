<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class M_home extends CI_Model {

    //func for get headline news
    function headline_berita() {
        $q = $this->db->query("select * from d_berita where rownum<=1 and status=1 order by id_berita desc");
        return $q;
    }

    //func get 5 latest berita
    function get_berita() {
        $q = $this->db->query("select * from d_berita where rownum<=5 and status=0 order by id_berita desc");
        return $q;
    }

    //func get 5 latest lowongan
    function get_lowongan() {
        $q = $this->db->query("select * from d_lowongan where rownum<=5 order by id_lowongan desc");
        return $q;
    }

    //function get forum universitas
    function get_forum() {
        $q = $this->db->query("select * from d_topik t where rownum<=5 and t.kd_jurusan='0' and t.angkatan='0' and t.id_komentar='1' order by id_topik desc");
        return $q;
    }

}

/*End of m_home.php*/
/* Location: ./application/modules/home/models/m_home.php */