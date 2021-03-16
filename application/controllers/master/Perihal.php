<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perihal extends CI_Controller {

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
		$this->db->from('db_siept.tb_perihal');
		$this->db->order_by('id_perihal', 'DESC');
		$perihal = $this->db->get();
		$data = array(
			'page' => 'master_data/perihal/index',
			'link' => 'perihal',
			'perihal' => $perihal
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function tambah(){
		$data = array(
			'page' => 'master_data/perihal/tambah',
			'link' => 'perihal',
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function edit($id_perihal){
		$this->db->from('db_siept.tb_perihal');
		$this->db->where(array('id_perihal' => $id_perihal));
		$perihal = $this->db->get();
		$data = array(
			'page' => 'master_data/perihal/edit',
			'link' => 'perihal',
			'perihal' => $perihal
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function simpan(){
		$text = $this->input->post('text', true);
		$data = array(
			'text' => $text,
			'tanggal_buat' => date('Y-m-d H:i:s')
		);
		$simpan = $this->db->insert('db_siept.tb_perihal', $data);
		if($simpan){
			echo '<script>alert("Berhasil disimpan");</script>';
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'master/perihal";</script>';
		}else{
			echo '<script>alert("Gagal disimpan");</script>';
            echo '<script>window.history.back();</script>';
		}
	}

	public function update(){
		$text = $this->input->post('text', true);
		$id_perihal = $this->input->post('id_perihal', true);
		$data = array(
			'text' => $text,
			'tanggal_buat' => date('Y-m-d H:i:s')
		);
		$simpan = $this->db->update('db_siept.tb_perihal', $data, array('id_perihal' => $id_perihal));
		if($simpan){
			echo '<script>alert("Berhasil diupdate");</script>';
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'master/perihal";</script>';
		}else{
			echo '<script>alert("Gagal diupdate");</script>';
            echo '<script>window.history.back();</script>';
		}
	}

	public function hapus($id_perihal){
		
		$simpan = $this->db->delete('db_siept.tb_perihal', array('id_perihal' => $id_perihal));
		if($simpan){
			echo '<script>alert("Berhasil dihapus");</script>';
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'master/perihal";</script>';
		}else{
			echo '<script>alert("Gagal dihapus");</script>';
            echo '<script>window.history.back();</script>';
		}
	}
}