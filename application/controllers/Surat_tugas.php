<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_tugas extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
		$arr = array('admin', 'perdata');
        if(!in_array($this->session->userdata('level', true),$arr) ){
			echo '<script>alert("Maaf, anda tidak memiliki akses ke halaman ini");</script>';
            echo '<script>window.location.href = "'.base_url().'";</script>';
			exit();
        }
    }
	public function index()
	{
		// var_dump("expression");exit();
		$this->db->from('db_siept.tb_surat');
		$this->db->join('db_siept.tb_acara', 'tb_acara.id_acara = tb_surat.id_acara', 'left');
		$this->db->join('db_siept.tb_status', 'tb_status.id_status = tb_surat.id_status', 'left');
		$this->db->join('db_siept.tb_user', 'tb_user.id_user = tb_surat.id_pp', 'left');
		if($this->input->post('id_status',true)){
			$this->db->where(array('db_siept.tb_surat.id_status' => $this->input->post('id_status',true)));
		}
		$this->db->order_by('id_surat', 'DESC');
		$this->db->order_by('urutan_nomor_surat', 'DESC');
		$this->db->order_by('bulan_nomor_surat', 'DESC');
		$surat = $this->db->get();
		$data = array(
			'page' => 'dashboard_surat_tugas',
			'surat' => $surat,
			'link' => 'surat_tugas'
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function tambah($id_surat='')
	{
		// var_dump("expression");exit();
		$js = $this->db->get_where('sipp320.jurusita', array('aktif' => 'Y'));

		$dasar = $this->db->get('db_siept.tb_dasar');
		$perihal = $this->db->get('db_siept.tb_perihal');
		$guna = $this->db->get('db_siept.tb_guna');
		$acara = $this->db->get('db_siept.tb_acara');

		$get_surat = $this->db->get_where('db_siept.tb_surat', array('id_surat' => $id_surat));

		$pihak = $this->db->get_where('sipp320.pihak', array('id' => $get_surat->row()->id_pihak_penerima));
		$jurusita = $this->db->get_where('sipp320.perkara_jurusita', array('perkara_id' => $get_surat->row()->id_perkara));

		$data = array(
			'page' => 'tambah_surat_tugas',
			'js' => $js,
			'dasar' => $dasar,
			'perihal' => $perihal,
			'guna' => $guna,
			'acara' => $acara,
			'link' => 'surat_tugas',
			'get_surat' => $get_surat,
			'pihak' => $pihak,
			'jurusita' => $jurusita
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function tambah_sendiri()
	{
		// var_dump("expression");exit();
		$js = $this->db->get_where('sipp320.jurusita', array('aktif' => 'Y'));

		$dasar = $this->db->get('db_siept.tb_dasar');
		$perihal = $this->db->get('db_siept.tb_perihal');
		$guna = $this->db->get('db_siept.tb_guna');
		$acara = $this->db->get('db_siept.tb_acara');

		// $get_surat = $this->db->get_where('db_siept.tb_surat', array('id_surat' => $id_surat));

		// $pihak = $this->db->get_where('sipp320.pihak', array('id' => $get_surat->row()->id_pihak_penerima));
		// $jurusita = $this->db->get_where('sipp320.perkara_jurusita', array('perkara_id' => $get_surat->row()->id_perkara));

		$data = array(
			'page' => 'tambah_surat_tugas_sendiri',
			'js' => $js,
			'dasar' => $dasar,
			'perihal' => $perihal,
			'guna' => $guna,
			'acara' => $acara,
			'link' => 'surat_tugas',
			// 'get_surat' => $get_surat,
			// 'pihak' => $pihak,
			// 'jurusita' => $jurusita
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function get_nomor_perkara(){
		$nomor_perkara = $this->input->post('search', true);
		$this->db->from('sipp320.perkara');
		$this->db->like(array('sipp320.perkara.nomor_perkara' => $nomor_perkara));
		$this->db->limit(10);
		$r = $this->db->get();
		if($r->num_rows() > 0){
			$list = array();
			$key=0;
			foreach($r->result() as $row) {
				$list[$key]['id'] = $row->perkara_id;
				$list[$key]['text'] = $row->nomor_perkara; 
			$key++;
			}
			echo json_encode($list);
		}else{
			echo 'no result';
		}
	}

	public function simpan_sendiri(){
		$id_perkara = $this->input->post('nomor_perkara', true);
		$id_pihak_penerima = $this->input->post('tujuan', true);
		$id_jurusita = $this->input->post('jurusita', true);
		$tanggal_surat = $this->input->post('tanggal_surat', true);
		$perihal = $this->input->post('perihal', true);
		$dasar = $this->input->post('dasar', true);
		$guna = $this->input->post('guna', true);

		$hari = $this->input->post('tanggal', true);
		$pukul = $this->input->post('pukul', true);
		$acara = $this->input->post('acara', true);

		$id_dasar = $dasar;
		$id_perihal = $perihal;
		$id_guna = $guna;
		$id_acara = $acara;


		$cek = $this->db->get('db_siept.tb_surat');
		if($cek->num_rows() == 0){
			$cek_tb_no_terakhir = $this->db->get('db_siept.tb_no_surat_terakhir');
			$nomor_urutan = $cek_tb_no_terakhir->row()->nomor_terakhir+1;
		}else{
			$this->db->from('db_siept.tb_surat');
			$this->db->order_by('urutan_nomor_surat', 'DESC');
			$this->db->limit(1);
			$q = $this->db->get();
			$nomor_urutan = $q->row()->urutan_nomor_surat + 1;
		}

		$q = $this->db->get_where('sipp320.perkara', array('perkara_id' => $id_perkara));
		$nomor_perkara = $q->row()->nomor_perkara;

		$bulan = date('n');
		$tahun = date('Y');
		$nomor_surat = 'W15.U8/'.$nomor_urutan.'/SPT/HK.02/'.$bulan.'/'.$tahun;

		$this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets_srtdash/'; //string, the default is application/cache/
        $config['errorlog']     = './assets_srtdash/'; //string, the default is application/logs/
        $config['imagedir']     = './assets_srtdash/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name=date('YmdHis').'.png'; //buat name dari qr code sesuai dengan nim
 
		$this->load->library('encryption');
		$nomor_surat2 = $this->encryption->encrypt($nomor_surat);

        $params['data'] = base_url().'lihat_spt/'.$nomor_surat2; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		// echo $nomor_surat;
		$data_to_save = array(
			'nomor_surat_full' => $nomor_surat,
			'id_perkara' => $id_perkara,
			'nomor_perkara' => $nomor_perkara,
			'id_jurusita' => $id_jurusita,
			'perihal' => $perihal,
			'urutan_nomor_surat' => $nomor_urutan,
			'bulan_nomor_surat' => $bulan,
			'tahun_nomor_surat' => $tahun,
			'tanggal_surat' => $tanggal_surat,
			'id_pihak_penerima' => $id_pihak_penerima,
			'tanggal_buat' => date('Y-m-d H:i:s'),
			'dasar' => $dasar,
			'pembuat' => $this->session->userdata('username') != '' ? 'vendetta' : $this->session->userdata('username'),
			'qrcode' => $image_name,
			'id_dasar' => $id_dasar,
			'id_perihal' => $id_perihal,
			'id_status' => 1,
			'id_guna' => $id_guna,
			'hari' => $hari,
			'pukul' => $pukul,
			'id_acara' => $id_acara,
			// 'id_pp' => $this->session->userdata('id_user')

		);
		

		$simpan = $this->db->insert('db_siept.tb_surat', $data_to_save);
		$id_surat = $insert_id = $this->db->insert_id();
		if($simpan){
			echo '<script>alert("Berhasil diproses");</script>';
			// $this->cetak($id_surat);
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'surat_tugas";</script>';
		}else{
			echo '<script>alert("Gagal diproses");</script>';
            echo '<script>window.history.back();</script>';
		}
		
	}

	public function get_pihak(){
		$perkara_id = $this->input->post('perkara_id');
		$pihak = array();
		$q = $this->db->get_where('sipp320.perkara_pihak1', array('perkara_id' => $perkara_id));
		foreach($q->result() as $rp1){
			$pihak[] = array(
				'id_pihak' => $rp1->pihak_id,
				'nama_pihak' => $rp1->nama,
				'alamat' => $rp1->alamat
			);
		}

		$q2 = $this->db->get_where('sipp320.perkara_pihak2', array('perkara_id' => $perkara_id));
		foreach($q2->result() as $rp2){
			$pihak[] = array(
				'id_pihak' => $rp2->pihak_id,
				'nama_pihak' => $rp2->nama,
				'alamat' => $rp2->alamat
			);
		}

		$q3 = $this->db->get_where('sipp320.perkara_pihak4', array('perkara_id' => $perkara_id));
		foreach($q3->result() as $rp3){
			$pihak[] = array(
				'id_pihak' => $rp3->pihak_id,
				'nama_pihak' => $rp3->nama,
				'alamat' => $rp3->alamat
			);
		}
		echo json_encode($pihak);
	}

	public function simpan(){
		$id_surat = $this->input->post('id_surat', true);
		$id_perkara = $this->input->post('nomor_perkara', true);
		$id_pihak_penerima = $this->input->post('tujuan', true);
		$id_jurusita = $this->input->post('jurusita', true);
		$tanggal_surat = $this->input->post('tanggal_surat', true);
		$perihal = $this->input->post('perihal', true);
		$dasar = $this->input->post('dasar', true);
		$guna = $this->input->post('guna', true);

		$hari = $this->input->post('tanggal', true);
		$pukul = $this->input->post('pukul', true);
		$acara = $this->input->post('acara', true);

		$id_dasar = $dasar;
		$id_perihal = $perihal;
		$id_guna = $guna;
		$id_acara = $acara;


		$cek = $this->db->get('db_siept.tb_surat');
		$cek_tb_no_terakhir = $this->db->get_where('db_siept.tb_no_surat_terakhir', array('status' => 'ya'));

		if($cek_tb_no_terakhir->num_rows() > 0){
			$cek_tb_no_terakhir = $this->db->get('db_siept.tb_no_surat_terakhir');
			$nomor_urutan = $cek_tb_no_terakhir->row()->nomor_terakhir+1;
		}else{
			if($cek->num_rows() == 0){
				$nomor_urutan = 1;
			}else{
				$this->db->from('db_siept.tb_surat');
				$this->db->order_by('urutan_nomor_surat', 'DESC');
				$this->db->limit(1);
				$q = $this->db->get();
				$nomor_urutan = $q->row()->urutan_nomor_surat + 1;
			}
		}

		$q = $this->db->get_where('sipp320.perkara', array('perkara_id' => $id_perkara));
		$nomor_perkara = @$q->row()->nomor_perkara;

		$bulan = date('n');
		$tahun = date('Y');
		$nomor_surat = 'W15.U8/'.$nomor_urutan.'/SPT/HK.02/'.$bulan.'/'.$tahun;

		$this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets_srtdash/'; //string, the default is application/cache/
        $config['errorlog']     = './assets_srtdash/'; //string, the default is application/logs/
        $config['imagedir']     = './assets_srtdash/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name=date('YmdHis').'.png'; //buat name dari qr code sesuai dengan nim
 
        $this->load->library('encryption');
		$nomor_surat_enc = $this->encryption->encrypt($nomor_surat);

        $params['data'] = base_url().'lihat_spt/cetak/'.$nomor_surat_enc; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		// echo $nomor_surat;
		$data_to_save = array(
			'nomor_surat_full' => $nomor_surat,
			// 'id_perkara' => $id_perkara,
			// 'nomor_perkara' => $nomor_perkara,
			'id_jurusita' => $id_jurusita,
			// 'perihal' => $perihal,
			'urutan_nomor_surat' => $nomor_urutan,
			'bulan_nomor_surat' => $bulan,
			'tahun_nomor_surat' => $tahun,
			'tanggal_surat' => $tanggal_surat,
			// 'id_pihak_penerima' => $id_pihak_penerima,
			'tanggal_buat' => date('Y-m-d H:i:s'),
			// 'dasar' => $dasar,
			'pembuat' => empty($this->session->userdata('username')) ? 'vendetta' : $this->session->userdata('username'),
			'qrcode' => $image_name,
			'id_dasar' => $id_dasar,
			'id_perihal' => $id_perihal,
			'id_status' => 1,
			'id_guna' => $id_guna,
			// 'hari' => $hari,
			// 'pukul' => $pukul,
			// 'id_acara' => $id_acara

		);
		

		$simpan = $this->db->update('db_siept.tb_surat', $data_to_save, array('id_surat' => $id_surat));
		$id_surat = $insert_id = $this->db->insert_id();
		if($simpan){
			echo '<script>alert("Berhasil diproses");</script>';
			// $this->cetak($id_surat);
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'surat_tugas";</script>';
		}else{
			echo '<script>alert("Gagal diproses");</script>';
            echo '<script>window.history.back();</script>';
		}
		
	}

	public function detail($id_surat){
		echo $id_surat;
	}

	public function cetak($id_surat){
		echo cetak_spt($id_surat);
	}

	// public function cetak($id_surat){
	// 	$qu = $this->db->get_where('db_siept.tb_surat', array('id_surat' => $id_surat));
	// 	$qu = $qu->row();

	// 	$nomor_surat = $qu->nomor_surat_full;
	// 	$nomor_perkara = $qu->nomor_perkara;

	// 	$perkara_id = $qu->id_perkara;
	// 	$qperkara = $this->db->get_where('sipp320.perkara', array('perkara_id' => $perkara_id));

	// 	$tglregister = tgl_indo($qperkara->row()->tanggal_pendaftaran);

	// 	$dasar = $this->db->get_where('db_siept.tb_dasar', array('id_dasar' => $qu->id_dasar));
	// 	$perihal = $this->db->get_where('db_siept.tb_perihal', array('id_perihal' => $qu->id_perihal));
	// 	$guna = $this->db->get_where('db_siept.tb_guna', array('id_guna' => $qu->id_guna));
	// 	$acara = $this->db->get_where('db_siept.tb_acara', array('id_acara' => $qu->id_acara));

	// 	$perihal = $perihal->row()->text;
	// 	$tanggal_surat = tgl_indo($qu->tanggal_surat);
	// 	$dasar = $dasar->row()->text;

	// 	$guna = $guna->row()->text;
	// 	$acara = $acara->row()->text;

		
	// 	$hari_ini = hari_ini(date('D', strtotime($qu->hari)));
	// 	$hari = $hari_ini.', '.tgl_indo($qu->hari);
	// 	$pukul = $qu->pukul;
		
	// 	$pecah = explode('/', $nomor_perkara);
	// 	$kode = $pecah[1];

	// 	//query get jenis perkara
	// 	$qkode = $this->db->get_where('sipp320.alur_perkara', array('kode' => $kode));
	// 	$jnspkr = $qkode->row()->nama;
	// 	$kodejnspkr = $qkode->row()->kode;

	// 	//cek1
	// 	$sbg = '';
	// 	$qp1 = $this->db->get_where('sipp320.perkara_pihak1', array('perkara_id' => $qu->id_perkara, 'pihak_id' => $qu->id_pihak_penerima));
	// 	$cek_gugatan = stripos('Gugatan', $jnspkr);


	// 	// $arrp = array('Pdt.P');
		
	// 	$cek_perm = $this->db->get_where('db_siept.tb_kode_permohonan', array('kode_perkara' => $kodejnspkr));
		
	// 	if($qp1->num_rows() > 0){
	// 		if($cek_perm->num_rows() != 0){
	// 			$sbb = 'Pemohon';
	// 		}else{
	// 			$sbb = 'Penggugat';
	// 		}
	// 		$qpm1 = $this->db->get_where('sipp320.perkara_pihak1', array('perkara_id' => $qu->id_perkara));
	// 		if($qpm1->num_rows() > 1){
	// 			$sbg = ' {\b '.$sbb.' '. KonDecRomawi($qp1->row()->urutan).'}';
	// 		}else{
	// 			$sbg = ' {\b '.$sbb.'}';
	// 		}			
	// 	}else{
	// 		$qp2 = $this->db->get_where('sipp320.perkara_pihak2', array('perkara_id' => $qu->id_perkara, 'pihak_id' => $qu->id_pihak_penerima));
	// 		if($qp2->num_rows() > 0){
	// 			if($cek_perm->num_rows() != 0){
	// 				$sbb = 'Termohon';
	// 			}else{
	// 				$sbb = 'Tergugat';
	// 			}
	// 			$qpm2 = $this->db->get_where('sipp320.perkara_pihak2', array('perkara_id' => $qu->id_perkara));
	// 			if($qpm2->num_rows() > 1){
	// 				$sbg = ' {\b '.$sbb.' '. KonDecRomawi($qp2->row()->urutan).'}';
	// 			}else{
	// 				$sbg = ' {\b '.$sbb.'}';
	// 			}	
	// 		}else{
	// 			$qp4 = $this->db->get_where('sipp320.perkara_pihak4', array('perkara_id' => $qu->id_perkara, 'pihak_id' => $qu->id_pihak_penerima));
	// 			if($qp4->num_rows() > 0){
	// 				if($cek_perm->num_rows() != 0){
	// 					$sbb = 'Turut Termohon';
	// 				}else{
	// 					$sbb = 'Turut Tergugat';
	// 				}
	// 				$qpm4 = $this->db->get_where('sipp320.perkara_pihak4', array('perkara_id' => $qu->id_perkara));
	// 				if($qpm4->num_rows() > 1){
	// 					$sbg = ' {\b '.$sbb.' '. KonDecRomawi($qp4->row()->urutan).'}';
	// 				}else{
	// 					$sbg = ' {\b '.$sbb.'}';
	// 				}
	// 			}
	// 		}
	// 	}

	// 	$qtujuan = $this->db->get_where('sipp320.pihak', array('id' => $qu->id_pihak_penerima));
    //     $pihak = $qtujuan->row()->nama;
	// 	$nmtujuan = $pihak;
	// 	$almtujuan = $qtujuan->row()->alamat.', dalam hal ini disebut sebagai '.$sbg.';';

	// 	$js = $this->db->get_where('sipp320.jurusita', array('aktif' => 'Y', 'id' => $qu->id_jurusita));
	// 	$nmjs = $js->row()->nama;
	// 	$nipjs = $js->row()->nip;

	// 	$jabatanjs = 'Jurusita';
		
	// 	$ttdel = './assets_srtdash/qrcode/'.$qu->qrcode; 
		
	// 	include './application/libraries/Image.php';
	// 	$functions = new Image($ttdel);
	// 	$ttdarr = array('4', '6');
	// 	if(in_array($qu->id_status, $ttdarr)){
	// 		$hex = $functions->getContent();
	// 	}else{
	// 		$hex = '';
	// 	}	

	// 	$document = file_get_contents("./assets_srtdash/SPT_temp_permohonan.rtf");		

	// 	$qpihak1 = $this->db->get_where('sipp320.perkara_pihak1', array('perkara_id' => $qu->id_perkara));

	// 	$pihak1 = '';
	// 	foreach($qpihak1->result()  as $rpihak1){
	// 		// $pihak1 .= '{\pard ';
	// 		$pihak1 .=  '{\b '.$rpihak1->nama.'}, beralamat di '.$rpihak1->alamat.'; '; 
	// 		// $pihak1 .=  $rpihak1->nama.', beralamat di '.$rpihak1->alamat.'; \line'; 
	// 		// $pihak1 .= ' \par}';
	// 	}

	// 	$qpihak2 = $this->db->get_where('sipp320.perkara_pihak2', array('perkara_id' => $qu->id_perkara));

	// 	$pihak2 = '';
	// 	foreach($qpihak2->result()  as $rpihak2){
	// 		// $pihak1 .= '{\pard ';
	// 		$pihak2 .=  '{\b '.$rpihak2->nama.'}, beralamat di '.$rpihak2->alamat.'; '; 
	// 		// $pihak1 .=  $rpihak1->nama.', beralamat di '.$rpihak1->alamat.'; \line'; 
	// 		// $pihak1 .= ' \par}';
	// 	}

	// 	$qpihak4 = $this->db->get_where('sipp320.perkara_pihak4', array('perkara_id' => $qu->id_perkara));

	// 	$pihak4 = '';
	// 	$no4=1;
	// 	if($qpihak4->num_rows() > 0){
	// 		$pihak4 .= ' {\pard\qc Dan \par}';
	// 	}
	// 	if($qpihak4->num_rows() > 1){
	// 		// $pihak4 .= '{\rtf1 ';
	// 		// $pihak4 .= '\pard{\pntext\f0 1.\tab}\*\pn\pnlvlbody\pnf0\pnindent0\pnstart1\pndec{\pntxta.}';
	// 		// $pihak4 .= '\fi-360\li480\sa50\sl0\slmult1';
			
			
	// 		foreach($qpihak4->result()  as $rpihak4){
	// 			$pihak1 .= '{\pard ';
	// 			$pihak4 .=  '{\b '.$no4.'. '.$rpihak4->nama.'}, beralamat di '.$rpihak4->alamat.';\line\line'; 
	// 			// $pihak4 .= $rpihak4->nama.' beralamat di '.$rpihak4->alamat.';\par';
	// 			// $pihak1 .=  $rpihak1->nama.', beralamat di '.$rpihak1->alamat.'; \line'; 
	// 			$pihak1 .= '\par}';
	// 			$no4++;
	// 		}
	// 		// $pihak4 .= '\pard\par normal text';
	// 		// $pihak4 .= '}';
	// 	}else if($qpihak4->num_rows() == 1){
	// 		foreach($qpihak4->result()  as $rpihak4){
	// 			// $pihak1 .= '{\pard ';
	// 			$pihak4 .=  '{\b '.$rpihak4->nama.'}, beralamat di '.$rpihak4->alamat.';\line \line '; 
	// 			// $pihak1 .=  $rpihak1->nama.', beralamat di '.$rpihak1->alamat.'; \line'; 
	// 			// $pihak1 .= '\par}';
	// 		}
	// 	}
 
	// 	// mereplace tanda %%%NAMA% dengan data nama dari form
	// 	$document = str_replace("%%nosur%%", $nomor_surat, $document);
	// 	$document = str_replace("%%noper%%", $nomor_perkara, $document);
	// 	$document = str_replace("%%perihal%%", $perihal, $document);
	// 	$document = str_replace("%%tglbuat%%", $tanggal_surat, $document);
	// 	$document = str_replace("%%nmtujuan%%", $nmtujuan, $document);
	// 	$document = str_replace("%%almtujuan%%", $almtujuan, $document);
	// 	$document = str_replace("%%nmjs%%", $nmjs, $document);
	// 	$document = str_replace("%%nipjs%%", $nipjs, $document);
	// 	$document = str_replace("%%jabatanjs%%", $jabatanjs, $document);
	// 	$document = str_replace("%%dasar%%", $dasar, $document);
	// 	$document = str_replace("%%ttdel%%", $hex, $document);
	// 	$document = str_replace("%%jnspkr%%", $jnspkr, $document);
	// 	$document = str_replace("%%pihak1%%", $pihak1, $document);
	// 	$document = str_replace("%%p2%%", $pihak2, $document);
	// 	$document = str_replace("%%pemdll%%", $pihak4, $document);
	// 	$document = str_replace("%%guna%%", $guna, $document);
	// 	$document = str_replace("%%acara%%", $guna, $document);
	// 	$document = str_replace("%%haritgl%%", $hari, $document);
	// 	$document = str_replace("%%pukul%%", $pukul, $document);
	// 	$document = str_replace("%%emnhp%%", '', $document);
	// 	$document = str_replace("%%tglregister%%", $tglregister, $document);

	// 	header("Content-type: application/msword");
	// 	header("Content-disposition: inline; filename=".$nomor_surat.".rtf");
	// 	header("Content-length: " . strlen($document));
	// 	echo $document;
	// 	// redirect(base_url().'surat_tugas', 'refresh');
	// 	// echo '<script>window.location.href = "'.base_url().'surat_tugas";</script>';
	// }

	public function cetak_backup($id_surat){
		$qu = $this->db->get_where('db_siept.tb_surat', array('id_surat' => $id_surat));
		$qu = $qu->row();

		$nomor_surat = $qu->nomor_surat_full;
		$nomor_perkara = $qu->nomor_perkara;

		$dasar = $this->db->get_where('db_siept.tb_dasar', array('id_dasar' => $qu->id_dasar));
		$perihal = $this->db->get_where('db_siept.tb_perihal', array('id_perihal' => $qu->id_perihal));

		$perihal = $perihal->row()->text;
		$tanggal_surat = tgl_indo($qu->tanggal_surat);
		$dasar = $dasar->row()->text;

		$qtujuan = $this->db->get_where('sipp320.pihak', array('id' => $qu->id_pihak_penerima));
        $pihak = $qtujuan->row()->nama;
		$nmtujuan = $pihak;
		$almtujuan = $qtujuan->row()->alamat;

		$js = $this->db->get_where('sipp320.jurusita', array('aktif' => 'Y', 'id' => $qu->id_jurusita));
		$nmjs = $js->row()->nama;
		$nipjs = $js->row()->nip;

		$jabatanjs = 'Jurusita';
		
		$ttdel = './assets_srtdash/qrcode/'.$qu->qrcode; 
		
		include './application/libraries/Image.php';
		$functions = new Image($ttdel);
		if($qu->id_status == '4'){
			$hex = $functions->getContent();
		}else{
			$hex = '';
		}
		

		$document = file_get_contents("./assets_srtdash/SPT_temp.rtf");

		$pecah = explode('/', $nomor_perkara);
		$kode = $pecah[1];

		//query get jenis perkara
		$qkode = $this->db->get_where('sipp320.alur_perkara', array('kode' => $kode));
		$jnspkr = $qkode->row()->nama;

		$qpihak1 = $this->db->get_where('sipp320.perkara_pihak1', array('perkara_id' => $qu->id_perkara));

		$pihak1 = '';
		foreach($qpihak1->result()  as $rpihak1){
			// $pihak1 .= '{\pard ';
			$pihak1 .=  '{\b '.$rpihak1->nama.'}, beralamat di '.$rpihak1->alamat.'; '; 
			// $pihak1 .=  $rpihak1->nama.', beralamat di '.$rpihak1->alamat.'; \line'; 
			// $pihak1 .= ' \par}';
		}

		$qpihak2 = $this->db->get_where('sipp320.perkara_pihak2', array('perkara_id' => $qu->id_perkara));

		$pihak2 = '';
		foreach($qpihak2->result()  as $rpihak2){
			// $pihak1 .= '{\pard ';
			$pihak2 .=  '{\b '.$rpihak2->nama.'}, beralamat di '.$rpihak2->alamat.'; '; 
			// $pihak1 .=  $rpihak1->nama.', beralamat di '.$rpihak1->alamat.'; \line'; 
			// $pihak1 .= ' \par}';
		}

		$qpihak4 = $this->db->get_where('sipp320.perkara_pihak4', array('perkara_id' => $qu->id_perkara));

		$pihak4 = '';
		$no4=1;
		if($qpihak4->num_rows() > 0){
			$pihak4 .= ' {\pard\qc Dan \par}';
		}
		if($qpihak4->num_rows() > 1){
			// $pihak4 .= '{\rtf1 ';
			// $pihak4 .= '\pard{\pntext\f0 1.\tab}\*\pn\pnlvlbody\pnf0\pnindent0\pnstart1\pndec{\pntxta.}';
			// $pihak4 .= '\fi-360\li480\sa50\sl0\slmult1';
			
			
			foreach($qpihak4->result()  as $rpihak4){
				$pihak1 .= '{\pard ';
				$pihak4 .=  '{\b '.$no4.'. '.$rpihak4->nama.'}, beralamat di '.$rpihak4->alamat.';\line\line'; 
				// $pihak4 .= $rpihak4->nama.' beralamat di '.$rpihak4->alamat.';\par';
				// $pihak1 .=  $rpihak1->nama.', beralamat di '.$rpihak1->alamat.'; \line'; 
				$pihak1 .= '\par}';
				$no4++;
			}
			// $pihak4 .= '\pard\par normal text';
			// $pihak4 .= '}';
		}else if($qpihak4->num_rows() == 1){
			foreach($qpihak4->result()  as $rpihak4){
				// $pihak1 .= '{\pard ';
				$pihak4 .=  '{\b '.$rpihak4->nama.'}, beralamat di '.$rpihak4->alamat.';\line \line '; 
				// $pihak1 .=  $rpihak1->nama.', beralamat di '.$rpihak1->alamat.'; \line'; 
				// $pihak1 .= '\par}';
			}
		}
 
		// mereplace tanda %%%NAMA% dengan data nama dari form
		$document = str_replace("%%nosur%%", $nomor_surat, $document);
		$document = str_replace("%%noper%%", $nomor_perkara, $document);
		$document = str_replace("%%perihal%%", $perihal, $document);
		$document = str_replace("%%tglbuat%%", $tanggal_surat, $document);
		$document = str_replace("%%nmtujuan%%", $nmtujuan, $document);
		$document = str_replace("%%almtujuan%%", $almtujuan, $document);
		$document = str_replace("%%nmjs%%", $nmjs, $document);
		$document = str_replace("%%nipjs%%", $nipjs, $document);
		$document = str_replace("%%jabatanjs%%", $jabatanjs, $document);
		$document = str_replace("%%dasar%%", $dasar, $document);
		$document = str_replace("%%ttdel%%", $hex, $document);
		$document = str_replace("%%jnspkr%%", $jnspkr, $document);
		$document = str_replace("%%pihak1%%", $pihak1, $document);
		$document = str_replace("%%p2%%", $pihak2, $document);
		$document = str_replace("%%pemdll%%", $pihak4, $document);

		header("Content-type: application/msword");
		header("Content-disposition: inline; filename=spt.rtf");
		header("Content-length: " . strlen($document));
		echo $document;
	}

	public function teruskan($id_surat){
		$update = $this->db->update('db_siept.tb_surat', array('id_status' => 2), array('id_surat' => $id_surat));
		if($update){
			echo '<script>alert("Berhasil disimpan");</script>';
			echo '<script>window.history.back();</script>';
		}else{
			echo '<script>alert("Gagal disimpan");</script>';
            echo '<script>window.history.back();</script>';
		}
	}

	public function teruskan2(){
		if($this->input->post('jenis_spt', true)=='custom'){
			if(!empty($_FILES['file_spt']['tmp_name'])){
				$config['upload_path']          = './upload';
				$config['allowed_types']        = 'rtf|RTF';
				$config['file_name']            = date('YmdHis');
				$config['overwrite']			= true;
				$config['max_size']             = 1024; // 1MB
				// $config['max_width']            = 1024;
				// $config['max_height']           = 768;

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('file_spt')) {
					$file_custome =  $this->upload->data("file_name");
					$data_to_save = array(
						'jenis_surat_acc' => $this->input->post('jenis_spt', true), 
						'file_custome' => $file_custome, 
						'tanggal_teruskan_panitera' => date('Y-m-d'),
						'id_status' => 2
					);
					$simpan = $this->db->update('db_siept.tb_surat', $data_to_save, array('id_surat' => $this->input->post('id_surat', true)));
					if($simpan){
						$return = array('status' => 'ok', 'text' => '<div class="alert alert-success" role="alert">Berhasil diteruskan!</div>');
						echo json_encode($return); exit();
					}else{
						$return = array('status' => 'failed', 'text' => '<div class="alert alert-danger" role="alert">Gagal diteruskan!</div>');
						echo json_encode($return);exit();
					}
				}else{
					$return = array('status' => 'failed', 'text' => '<div class="alert alert-danger" role="alert">'.$this->upload->display_errors().'</div>');
					echo json_encode($return);exit();			
				}
			}else{
				$return = array('status' => 'failed', 'text' => '<div class="alert alert-danger" role="alert">File SPT harus diisi!</div>');
				echo json_encode($return);exit();
			}
		}else{
			$data_to_save = array(
				'jenis_surat_acc' => $this->input->post('jenis_spt', true), 
				'tanggal_teruskan_panitera' => date('Y-m-d'),
				'id_status' => 2
			);
			$simpan = $this->db->update('db_siept.tb_surat', $data_to_save, array('id_surat' => $this->input->post('id_surat', true)));
			if($simpan){
				$return = array('status' => 'ok', 'text' => '<div class="alert alert-success" role="alert">Berhasil diteruskan!</div>');
				echo json_encode($return); exit();
			}else{
				$return = array('status' => 'failed', 'text' => '<div class="alert alert-danger" role="alert">Gagal diteruskan!</div>');
				echo json_encode($return);exit();
			}
		}
	}
}