<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
        $this->db->from('db_siept.tb_user');
        $this->db->order_by('id_user', 'DESC');
        $user = $this->db->get();
		$data = array(
			'page' => 'user/index',
			'link' => 'user',
            'user' => $user
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

    public function tambah(){
		$data = array(
			'page' => 'user/tambah',
			'link' => 'user',
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function edit($id_user){
		$this->db->from('db_siept.tb_user');
		$this->db->where(array('id_user' => $id_user));
		$user = $this->db->get();
		$data = array(
			'page' => 'user/edit',
			'link' => 'user',
			'user' => $user
		);
		$this->load->view('template_srtdash/wrapper', $data);
	}

	public function simpan(){
		$username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $nama_user = $this->input->post('nama_user', true);
        $level = $this->input->post('level', true);
		$data = array(
			'username' => $username,
            'password' => $password,
            'nama_user' => $nama_user,
            'level' => $level
		);
		$simpan = $this->db->insert('db_siept.tb_user', $data);
		if($simpan){
			echo '<script>alert("Berhasil disimpan");</script>';
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'user";</script>';
		}else{
			echo '<script>alert("Gagal disimpan");</script>';
            echo '<script>window.history.back();</script>';
		}
	}

	public function update(){
		$username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $nama_user = $this->input->post('nama_user', true);
        $id_user = $this->input->post('id_user', true);
        $level = $this->input->post('level', true);
		$data = array(
			'username' => $username,
            'password' => $password,
            'nama_user' => $nama_user,
            'level' => $level
		);
		$simpan = $this->db->update('db_siept.tb_user', $data, array('id_user' => $id_user));
		if($simpan){
			echo '<script>alert("Berhasil diupdate");</script>';
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'user";</script>';
		}else{
			echo '<script>alert("Gagal diupdate");</script>';
            echo '<script>window.history.back();</script>';
		}
	}

	public function hapus($id_user){
		
		$simpan = $this->db->delete('db_siept.tb_user', array('id_user' => $id_user));
		if($simpan){
			echo '<script>alert("Berhasil dihapus");</script>';
            // echo '<script>window.location.href = "'.base_url().'surat_tugas/cetak/'.$id_surat.'";</script>';
			echo '<script>window.location.href = "'.base_url().'user";</script>';
		}else{
			echo '<script>alert("Gagal dihapus");</script>';
            echo '<script>window.history.back();</script>';
		}
	}
}