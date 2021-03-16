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
	public function index()
	{
		// var_dump("expression");exit();
		$this->db->from('db_siept.tb_surat');
		$this->db->join('db_siept.tb_perihal', 'tb_perihal.id_perihal = tb_surat.id_perihal');
		$this->db->join('db_siept.tb_status', 'tb_status.id_status = tb_surat.id_status');
		$this->db->order_by('id_surat', 'DESC');
		$surat = $this->db->get();
		$data = array(
			'page' => 'dashboard_surat_tugas',
			'surat' => $surat,
			'link' => 'surat_tugas'
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function tambah()
	{
		// var_dump("expression");exit();
		$js = $this->db->get_where('db_sipp.jurusita', array('aktif' => 'Y'));

		$dasar = $this->db->get('db_siept.tb_dasar');
		$perihal = $this->db->get('db_siept.tb_perihal');

		$data = array(
			'page' => 'tambah_surat_tugas',
			'js' => $js,
			'dasar' => $dasar,
			'perihal' => $perihal,
			'link' => 'surat_tugas'
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function get_nomor_perkara(){
		$nomor_perkara = $this->input->post('search', true);
		$this->db->from('db_sipp.perkara');
		$this->db->like(array('db_sipp.perkara.nomor_perkara' => $nomor_perkara));
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

	public function get_pihak(){
		$perkara_id = $this->input->post('perkara_id');
		$pihak = array();
		$q = $this->db->get_where('db_sipp.perkara_pihak1', array('perkara_id' => $perkara_id));
		foreach($q->result() as $rp1){
			$pihak[] = array(
				'id_pihak' => $rp1->pihak_id,
				'nama_pihak' => $rp1->nama,
				'alamat' => $rp1->alamat
			);
		}

		$q2 = $this->db->get_where('db_sipp.perkara_pihak2', array('perkara_id' => $perkara_id));
		foreach($q2->result() as $rp2){
			$pihak[] = array(
				'id_pihak' => $rp2->pihak_id,
				'nama_pihak' => $rp2->nama,
				'alamat' => $rp2->alamat
			);
		}

		$q3 = $this->db->get_where('db_sipp.perkara_pihak4', array('perkara_id' => $perkara_id));
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
		$id_perkara = $this->input->post('nomor_perkara', true);
		$id_pihak_penerima = $this->input->post('tujuan', true);
		$id_jurusita = $this->input->post('jurusita', true);
		$tanggal_surat = $this->input->post('tanggal_surat', true);
		$perihal = $this->input->post('perihal', true);
		$dasar = $this->input->post('dasar', true);

		$id_dasar = $dasar;
		$id_perihal = $perihal;

		$cek = $this->db->get('db_siept.tb_surat');
		if($cek->num_rows() == 0){
			$nomor_urutan = 1;
		}else{
			$this->db->from('db_siept.tb_surat');
			$this->db->order_by('urutan_nomor_surat', 'DESC');
			$this->db->limit(1);
			$q = $this->db->get();
			$nomor_urutan = $q->row()->urutan_nomor_surat + 1;
		}

		$q = $this->db->get_where('db_sipp.perkara', array('perkara_id' => $id_perkara));
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
 
        $params['data'] = $nomor_surat; //data yang akan di jadikan QR CODE
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
			// 'perihal' => $perihal,
			'urutan_nomor_surat' => $nomor_urutan,
			'bulan_nomor_surat' => $bulan,
			'tahun_nomor_surat' => $tahun,
			'tanggal_surat' => $tanggal_surat,
			'id_pihak_penerima' => $id_pihak_penerima,
			'tanggal_buat' => date('Y-m-d H:i:s'),
			// 'dasar' => $dasar,
			'pembuat' => empty($this->session->userdata('user')) ? 'vendetta' : $this->session->userdata('user'),
			'qrcode' => $image_name,
			'id_dasar' => $id_dasar,
			'id_perihal' => $id_perihal
		);
		

		$simpan = $this->db->insert('db_siept.tb_surat', $data_to_save);
		$id_surat = $insert_id = $this->db->insert_id();
		if($simpan){
			echo '<script>alert("Berhasil diproses");</script>';
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
		$qu = $this->db->get_where('db_siept.tb_surat', array('id_surat' => $id_surat));
		$qu = $qu->row();

		$nomor_surat = $qu->nomor_surat_full;
		$nomor_perkara = $qu->nomor_perkara;

		$dasar = $this->db->get_where('db_siept.tb_dasar', array('id_dasar' => $qu->id_dasar));
		$perihal = $this->db->get_where('db_siept.tb_perihal', array('id_perihal' => $qu->id_perihal));

		$perihal = $perihal->row()->text;
		$tanggal_surat = tgl_indo($qu->tanggal_surat);
		$dasar = $dasar->row()->text;

		$qtujuan = $this->db->get_where('db_sipp.pihak', array('id' => $qu->id_pihak_penerima));
        $pihak = $qtujuan->row()->nama;
		$nmtujuan = $pihak;
		$almtujuan = $qtujuan->row()->alamat;

		$js = $this->db->get_where('db_sipp.jurusita', array('aktif' => 'Y', 'id' => $qu->id_jurusita));
		$nmjs = $js->row()->nama;
		$nipjs = $js->row()->nip;

		$jabatanjs = 'Jurusita';
		
		$ttdel = './assets_srtdash/qrcode/'.$qu->qrcode; 
		
		include './application/libraries/Image.php';
		$functions = new Image($ttdel);

		$hex = $functions->getContent();

		$document = file_get_contents("./assets_srtdash/SPT_temp.rtf");
 
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

		header("Content-type: application/msword");
		header("Content-disposition: inline; filename=spt.rtf");
		header("Content-length: " . strlen($document));
		echo $document;
	}
}