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
		if ($_SESSION['role_user'] == 2) {
			$this->db->where('fai_akun.id_lokasi', $_SESSION['id_lokasi']);
		}
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

	public function tambah_libur_lembur()
	{
		try {
			$this->db->trans_start();

			$id_akun = $this->db->escape_str($this->input->post('id_akun'));
			$bulan = $this->input->post('bulan');
			$tipe_absen = $this->input->post('tipe_absen');
			$tgl_absen = $this->input->post('tgl_absen');
			$point_lembur = $this->input->post('point_lembur');
			$mulai_absen = $this->input->post('mulai_absen');
			$selesai_absen = $this->input->post('selesai_absen');

			if ($tipe_absen == 11) {	//libur shift
				$data = array(
					'id_absen' => randid(),
					'id_user' => $id_akun,
					'tgl_absen' => $tgl_absen,
					'absen_masuk' 	=> '',
					'absen_pulang' 	=> '',
					'pending' 	=> 11,
					'catatan_pending' 	=> 'Libur Shift'
				);
				$this->db->insert('fai_absen', $data);

				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Libur Shift telah ditambahkan</b></center></div>');
			} elseif ($tipe_absen == 99999) {	//lembur
				$data = array(
					'id_lembur' => randid(),
					'id_akun' => $id_akun,
					'tgl_lembur' => $tgl_absen,
					'mulai_lembur'     => $mulai_absen,
					'selesai_lembur'     => $selesai_absen,
					'point_lembur'     => $point_lembur,
					'status_lembur'     => 1,   //acc
					'keterangan'     => 'Kerja Lembur'
				);
				$this->db->insert('fai_lembur', $data);

				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Lembur telah ditambahkan</b></center></div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Error, data gagal ditambahkan.</b></center></div>');
			}

			$this->db->trans_complete();
		} catch (\Throwable $th) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('Riwayat/data_rilis/?id_akun=' . $id_akun . '&bulan=' . $bulan);
	}
}
