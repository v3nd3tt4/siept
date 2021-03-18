<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dasar extends CI_Controller {

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
        if($this->session->userdata('level', true) != 'admin'){
			echo '<script>alert("Maaf, anda tidak memiliki akses ke halaman ini");</script>';
            echo '<script>window.location.href = "'.base_url().'";</script>';
			exit();
        }
    }
	public function index()
	{
		// var_dump("expression");exit();
		$this->db->from('db_siept.tb_dasar');
		$this->db->order_by('id_dasar', 'DESC');
		$dasar = $this->db->get();
		$data = array(
			'page' => 'master_data/dasar/index',
			'link' => 'dasar',
			'dasar' => $dasar
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function tambah(){
		$data = array(
			'page' => 'master_data/dasar/tambah',
			'link' => 'dasar',
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function edit($id_dasar){
		$this->db->from('db_siept.tb_dasar');
		$this->db->where(array('id_dasar' => $id_dasar));
		$dasar = $this->db->get();
		$data = array(
			'page' => 'master_data/dasar/edit',
			'link' => 'dasar',
			'dasar' => $dasar
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function simpan(){
		$text = $this->input->post('text', true);
		$data = array(
			'text' => $text,
			'tanggal_buat' => date('Y-m-d H:i:s')
		);
		$simpan = $this->db->insert('db_siept.tb_dasar', $data);
		if($simpan){
			echo '<script>alert("Berhasil disimpan");</script>';
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'master/dasar";</script>';
		}else{
			echo '<script>alert("Gagal disimpan");</script>';
            echo '<script>window.history.back();</script>';
		}
	}

	public function update(){
		$text = $this->input->post('text', true);
		$id_dasar = $this->input->post('id_dasar', true);
		$data = array(
			'text' => $text,
			'tanggal_buat' => date('Y-m-d H:i:s')
		);
		$simpan = $this->db->update('db_siept.tb_dasar', $data, array('id_dasar' => $id_dasar));
		if($simpan){
			echo '<script>alert("Berhasil diupdate");</script>';
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'master/dasar";</script>';
		}else{
			echo '<script>alert("Gagal diupdate");</script>';
            echo '<script>window.history.back();</script>';
		}
	}

	public function hapus($id_dasar){
		
		$simpan = $this->db->delete('db_siept.tb_dasar', array('id_dasar' => $id_dasar));
		if($simpan){
			echo '<script>alert("Berhasil dihapus");</script>';
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'master/dasar";</script>';
		}else{
			echo '<script>alert("Gagal dihapus");</script>';
            echo '<script>window.history.back();</script>';
		}
	}
}