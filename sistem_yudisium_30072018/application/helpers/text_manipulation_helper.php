<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

	function related_text($str){
		$conj_differ=array('dan','atau', 'tetapi', 'sesudah', 'jika', 'agar', 'supaya', 'dengan', 'bahwa', 'karena', 'ketika', 'maka', 'sedangkan', 'hingga', 'meski', 'lalu', 'sambil', 'serta', 
						'apabila', 'lagi pula', 'andaikata', 'sebab', 'sebelum', 'selama', 'sehingga', 'seandainya', 'sekiranya', 'melainkan', 'semenjak', 'andaikan', 'bagaikan', 'asalkan', 
						'jangankan', 'walaupun', 'meskipun', 'kendatipun', 'lagi', 'hanya', 'sekalipun', 'sungguhpun', 'melainkan', 'sampai-sampai', 'tatkala', 'kecuali', 'seraya', 'sambil');
		$noun_differ=array('uin','sunan','kalijaga','fakultas','jurusan', 'prodi', 'program studi');
		$verb_differ=array('juarai', 'gandeng', 'sosialisasikan', 'tulis', 'bangun', 'pembukaan', 'kuasai', 'dipermainkan', 'bersertifikasi', 'dialog', 'magang', 'mengatasi', 'mengukir',
							'kukuhkan', 'pagelaran', 'kerjasama', 'seminar', 'diluncurkan', 'kembangkan', 'melalui', 'kreatifitas', 'seminarkan', 'menjaga ', 'mensyukuri', 'kelahiran',
							'sosialisasikan', 'pemanfaatan', 'kontribusi', 'pemikiran', 'selenggarakan', 'internalisasi', 'dibutuhkan', 'lewat', ' keamanan', 'dikaji', 'gerakan', 'ikuti',
							' mewisuda', 'gelar', 'kirim', 'menganalisis', 'raih', 'meluncurkan', 'lolos', 'luluskan', 'komunikasi', 'perkuat', 'antarkan', 'delegasi', 'belajar', 'penerapan',
							'keinginan', 'kemunduran', 'diteliti', 'ditafsirkan', 'borong', 'gencarnya', 'menerima', 'kunjungan', 'pemanfaatan', 'kehilangan', 'dikenal', 'rindu', 'ukir',
							'penyerahan', 'menangi', 'kunjungi', 'perkembangan', 'membangun', 'lantik', 'penyiaran', 'menuju', 'dipelajari', 'dilantik', 'memperoleh', 'memperkuat',
							'pengembangan', 'pemaknaan', 'komparasikan', 'memberi', 'pemutaran', 'pencegahan', 'pemberantasan', 'penyalahgunaan', 'pelaksanaan', 'penerimaan', 'diworkshopkan',
							'implementasi', 'tambah', 'dirikan', 'disatukan', 'membawa', 'peringati', 'bakti', 'terima', 'lakukan', 'selenggarakan', 'optimalisasi', 'pemenuhan', 'pembentukan',
							'masuk', 'beri', 'revisi', 'modeling', 'launching', 'dapat', 'berubah', 'menggali', 'temu', 'menulis', 'revitalisasi', 'adakan', 'menggandeng', 'planning', 'merangkai',
							'menentukan', 'penandatanganan', 'aktualisasi', 'intergrasi', 'mengentaskan', 'ikut', 'mensyukuri', 'kelahiran', 'mengubah', 'menata', ' hadiri', 'tingkatkan',
							'antarkan', 'mempercepat', 'lantik ', 'pengaruhi', 'digali', 'penyusunan', 'menjalani', 'pemahaman', 'penghijauan', 'angkat', 'pembinaan', 'mengantarkan',
							'penyucian', 'bekerjasama', 'memperkenalkan', 'gapai', 'menawarkan', 'implementasi', 'hasilkan', 'dilakukan', 'menyongsong', 'ciptakan', 'mewujudkan', 'penulisan',
							'peningkatan', 'perjuangkan', 'konsultasi', 'pemberdayaan', 'bentuk', 'pendampingan', 'pembelajaran', 'gagas', 'resmikan', 'perintisan', 'miliki', 'penyetaraan',
							'memahami', 'mengeksplorasi', 'terimplementasi', 'perceraian', 'penguatan', 'perubahan', 'disegani', 'bersatu', 'payungi', 'terwujud', 'pluralitas', 'tanggulangi',
							'majukan', 'pandangan', 'ciptakan', 'ikuti', 'terintegrasi', 'perkuat', 'komparasikan', 'mendesak', 'standarisasi', 'mengkaji', 'perjalanan', 'plagiasi',
							'radikalisme', 'berkunjung', 'sepakati', 'geliat', 'menyongsong', 'menuju', 'selenggarakan', 'penelusuran', 'deradikalisasi', 'pengumuman', 'mewisuda ',
							'bagikan', 'seminar', 'mensyukuri', 'audit', 'seminar', 'olimpiade', 'mirroring', 'penelitian', 'herregistrasi', 'wisuda', 'soft launching', 'diskusi', 'anugrah',
							'uji', 'perekrutan pengajar', 'menyelenggarakan', 'seminar', 'pmb', 'pembukaan', 'mengadakan', 'nonton', 'melaksanakan', 'bekali', 'pelaksanaan', 'berbahasa',
							'upacara', 'peringati', 'selenggarakan', 'mensyukuri', 'seminar', 'konferensi', 'menumbuhkembangkan', 'pembebasan', 'kunjungi ', 'penerimaan', 'wisuda', 'beri',
							'pengumuman', 'olimpiade', 'juara', 'mengangkat', 'raih', 'bangun', 'angkat', 'juara', 'pengumuman', 'adakan', 'kebebasan', 'masuk', 'kembangkan', 'selenggarakan',
							'tandatangan', 'jelaskan', 'kunjungi', 'pemikiran', 'luluskan', 'raih', 'substansi', 'teliti', 'kesetaraan', 'pengamatan', 'training', 'angkat', 'mewisuda', 'launching',
							'menyatu', 'interaksi', 'merujuk', 'diklat', 'latihan', 'launching', 'raih', 'diskusi', 'dikembangkan', 'pembumian', 'building', 'adakan pelatihan', 'menyumbang',
							'berkunjung', 'lantik', 'teliti', 'perjuangkan', 'perkuat', 'temu', 'mengikuti', 'berpengaruh', 'hilangkan', 'bangun', 'anugerahkan', 'mengembangkan', 'teliti',
							'bekerja', 'temu', 'seleksi', 'penerimaan', 'pertemuan', 'pencapaian pengajaran pengasuhan pengembangan', 'training', 'luluskan', 'seminar', 'meewisuda', 'pelaksanaan',
							'tentukan', 'beri', 'raih', 'satukan', 'pembenahan', 'pelaksanaan', 'memandang', 'mensyukuri', 'terima', 'perkawinan', 'berjumpa', 'lantik', 'penanganan', 'pelatihan', 
							'debat', 'kembangkan', 'pemikiran', 'training', 'pembebasan', 'kembangkan', 'peringatan', 'bekerjasama', 'mewisuda', 'berkunjung', 'tulis', 'bekerja', 'menerima', 
							'raih', 'berprestasi', 'penelitian', 'hadirkan', 'raih', 'memilih', 'pembangunan', 'mengadakan', 'mencetak', 'gelar', 'laksanakan', 'resmikan', 'berlakukan',
							'selenggarakan', 'dilantik', 'tawarkan', 'bantu', 'mewisuda', 'penerimaan', 'berkunjung', 'terima', 'melawat', 'penafsiran', 'mengajar', 'gelar diskusi', 'membentuk',
							'mengenang', 'kunjungi', 'membangun', 'meningkat', 'diterima', 'selenggarakan pelatihan', 'memperkaya', 'touring', 'terima', 'gerakan', 'slenggarakan',
							'pelaksanaan', 'berjalan', 'kerjasama', 'perlindungan berperan', 'terima', 'kunjungi  penjajakan pengembangan', 'pagelaran', 'luluskan', 'raih', 'ciptakan',
							'peringati', 'selenggarakan', 'ikuti', 'gelar', 'selenggarakan', 'teiti ', 'terbitkan', 'penerimaan', 'pengorganisasian', 'korupsi', 'kunjungi', 'selenggarakan',
							'diliburkan', 'putuskan', 'kegiatan', 'terima', 'mengembangkan', 'berangkatkan', 'berpendapat', 'respons', 'harumkan', 'kukuhkan', 'seminar', 'penyerahan', 
							'pemulihan', 'dikukuhkan', 'kunjungi', 'menulis', 'dikukuhkan', 'bertamu', 'rekomendasikan', 'hadirkan', 'antarkan', 'melantik', 'teruskan', 'tentukan',
							'pembentukan', 'pelanggaran', 'respek', 'layanan', 'sosialisasi', 'lantik', 'jumpa', 'ajarkan', 'diprediksi', 'perluas', 'temukan', 'tanggapi', 'bedah', 
							'berikan', 'ceramah', 'siolaturahmi', 'komunikasi', 'nyatakan', 'perlawanan', 'menggugah', 'penyiaran', 'penegakan', 'memaknai', 'pengelolaan', 'perlindungan');
	
		$arr_title=explode(' ',strtolower($str));	
		$arr_filter=array_diff($arr_title,$conj_differ);
		$arr_filter=array_diff($arr_title,$noun_differ);
		$arr_filter=array_diff($arr_filter,$verb_differ);
		return str_replace("'","''",$arr_filter);
	}