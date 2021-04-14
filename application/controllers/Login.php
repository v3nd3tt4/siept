<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
    }

    public function index(){
        // if($this->session->userdata('level') == 'panitera'){
        //     echo '<script>window.location.href = "'.base_url().'panitera/surat_tugas";</script>';
        //     exit();
        // }else{
        //     echo '<script>window.location.href = "'.base_url().'";</script>';
        //     exit();
        // }       
        
        $this->load->view('login');
    }

    public function proses_login(){
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $cek = $this->db->get_where('db_siept.tb_user', array('username' => $username, 'password' => $password));
        if($cek->num_rows() != 0){
            $sess = array(
                'id_user' => $cek->row()->id_user,
                'username' => $cek->row()->username,
                'nama_user' => $cek->row()->nama_user,
                'level' => $cek->row()->level,
                'login' => true
            );
            $this->session->set_userdata($sess);
            echo '<script>alert("Berhasil Login");</script>';
            if($cek->row()->level == 'panitera'){
                echo '<script>window.location.href = "'.base_url().'panitera/surat_tugas";</script>';
            }else if($cek->row()->level == 'pp'){
                echo '<script>window.location.href = "'.base_url().'pp/surat_tugas";</script>';
            }else if($cek->row()->level == 'jurusita'){
                echo '<script>window.location.href = "'.base_url().'jurusita/surat_tugas";</script>';
            }else{
                echo '<script>window.location.href = "'.base_url().'surat_tugas";</script>';
            }            
        }else{
            echo '<script>alert("User tidak ditemukan");</script>';
            echo '<script>window.location.href = "'.base_url().'";</script>';
        }
    }

    public function logout(){
        $this->session->sess_destroy();
        echo '<script>alert("Berhasil Keluar");</script>';
        echo '<script>window.location.href = "'.base_url().'";</script>';
    }
}
    