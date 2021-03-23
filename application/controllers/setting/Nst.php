<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nst extends CI_Controller {

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
		$this->db->from('db_siept.tb_no_surat_terakhir');
		$this->db->order_by('id_no_surat_terakhir', 'DESC');
		$nst = $this->db->get();
		$data = array(
			'page' => 'setting/nst/index',
			'link' => 'nst',
			'nst' => $nst
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function tambah(){
		$data = array(
			'page' => 'master_data/acara/tambah',
			'link' => 'acara',
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function edit($id_no_surat_terakhir){
		$this->db->from('db_siept.tb_no_surat_terakhir');
		$this->db->where(array('id_no_surat_terakhir' => $id_no_surat_terakhir));
		$nst = $this->db->get();
		$data = array(
			'page' => 'setting/nst/edit',
			'link' => 'nst',
			'nst' => $nst
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function simpan(){
		$text = $this->input->post('text', true);
		$data = array(
			'text' => $text,
			'tanggal_buat' => date('Y-m-d H:i:s')
		);
		$simpan = $this->db->insert('db_siept.tb_acara', $data);
		if($simpan){
			echo '<script>alert("Berhasil disimpan");</script>';
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'master/acara";</script>';
		}else{
			echo '<script>alert("Gagal disimpan");</script>';
            echo '<script>window.history.back();</script>';
		}
	}

	public function update(){
		$nomor_terakhir = $this->input->post('nomor_terakhir', true);
        $status = $this->input->post('status', true);
		$id_no_surat_terakhir = $this->input->post('id_nst', true);
		$data = array(
			'nomor_terakhir' => $nomor_terakhir,
			'status' => $status
		);
		$simpan = $this->db->update('db_siept.tb_no_surat_terakhir', $data, array('id_no_surat_terakhir' => $id_no_surat_terakhir));
		if($simpan){
			echo '<script>alert("Berhasil diupdate");</script>';
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'setting/nst";</script>';
		}else{
			echo '<script>alert("Gagal diupdate");</script>';
            echo '<script>window.history.back();</script>';
		}
	}

	public function hapus($id_acara){
		
		$simpan = $this->db->delete('db_siept.tb_acara', array('id_acara' => $id_acara));
		if($simpan){
			echo '<script>alert("Berhasil dihapus");</script>';
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'master/acara";</script>';
		}else{
			echo '<script>alert("Gagal dihapus");</script>';
            echo '<script>window.history.back();</script>';
		}
	}
}