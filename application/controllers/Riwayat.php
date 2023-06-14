<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		cek_login();
	}

	public function index()
	{
		$data['judul'] = 'Riwayat Absen';
		$data['page'] = 'Riwayat';
		$data['url'] = base_url('Riwayat');

		$data['user'] = $this->data_user();
		$data['riwayat'] = [];
		$data['lembur'] = [];

		$this->load->view('header', $data);
		$this->load->view('riwayat', $data);
		$this->load->view('footer');
	}

	private function data_user()
	{
		$this->db->where("tgl_delete", null);
		//$this->db->where("role_pegawai", '1');
		$user = $this->db->get('fai_akun')->result();
		return $user;
	}

	public function data_rilis()
	{
		//$bulan = $this->uri->segment(3) ?? 5;
		$bulan = $_GET['bulan'] ?? 5;
		$id_akun = $_GET['id_akun'] ?? $_SESSION['id_akun'];

		$data['user'] = $this->data_user();

		$this->db->where("tgl_absen >= '" . date('Y') . "-" . (int)$bulan . "-1'");
		$this->db->where("tgl_absen <='" . date('Y') . "-" . (int)$bulan . "-31'");
		$this->db->where('pending <> 1');
		$this->db->where('pending <> 3');
		$this->db->where("id_user", $this->db->escape_str($id_akun));
		$this->db->order_by('tgl_absen', 'desc');
		$data['riwayat'] = $this->db->get('fai_absen')->result();

		$this->db->where("tgl_lembur >= '" . date('Y') . "-" . (int)$bulan . "-1'");
		$this->db->where("tgl_lembur <='" . date('Y') . "-" . (int)$bulan . "-31'");
		$this->db->where('status_lembur', 1);
		$this->db->where("id_akun", $this->db->escape_str($id_akun));
		$this->db->order_by('tgl_lembur', 'desc');
		$data['lembur'] = $this->db->get('fai_lembur')->result();

		$data['judul'] = 'Riwayat Absen';
		$data['page'] = 'Riwayat';
		$data['url'] = base_url('Riwayat/data_rilis/?id_akun=' . $id_akun . '&bulan=' . $bulan);

		$this->load->view('header', $data);
		$this->load->view('riwayat', $data);
		$this->load->view('footer');
	}
}
