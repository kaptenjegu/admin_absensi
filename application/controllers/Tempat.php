<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tempat extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		cek_login();
	}

    public function index()
	{
		$data['judul'] = 'Tempat Kerja';
		$data['page'] = 'Tempat';
		$data['url'] = base_url('Tempat');

		//$this->db->where('id_user', $_SESSION['id_akun']);
		//$this->db->where('tgl_absen', date('Y-m-d'));
		//$data['absen'] = $this->db->get('fai_absen')->first_row();

		$this->load->view('header', $data);
		$this->load->view('tempat', $data);
		$this->load->view('footer');
	}

    public function tambah()
	{
		$data['judul'] = 'Tambah User';
		$data['page'] = 'User';
		$data['url'] = base_url('User/tambah/');

		$this->load->view('header', $data);
		$this->load->view('manage_user', $data);
		$this->load->view('footer');
	}

}