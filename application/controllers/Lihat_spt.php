<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lihat_spt extends CI_Controller {

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
    }	

	public function cetak($nomor_surat){
		$this->load->library('encryption');
		$nomor_surat_enc = $this->encryption->decrypt($nomor_surat);
		$q = $this->db->get_where('db_siept.tb_surat', array('nomor_surat_full'=>$nomor_surat_enc));
		echo cetak_spt($q->row()->id_surat);
	}

	
}