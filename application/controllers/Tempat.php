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

		$this->db->where('tgl_delete', null);
		$data['lokasi'] = $this->db->get('fai_lokasi')->result();

		$this->load->view('header', $data);
		$this->load->view('tempat', $data);
		$this->load->view('footer');
	}

	public function tambah()
	{
		try {
			$this->db->trans_start();

			$nama_lokasi = $this->input->post('nama_lokasi');
			$long_lokasi = $this->input->post('long_lokasi');
			$lat_lokasi = $this->input->post('lat_lokasi');

			if ($this->cek_lokasi($nama_lokasi) == 0) {
				$data = array(
					'id_lokasi' => randid(),
					'nama_lokasi' => $nama_lokasi,
					'long_lokasi' => $long_lokasi,
					'lat_lokasi' => $lat_lokasi
				);
				$this->db->insert('fai_lokasi', $data);

				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Tempat Kerja telah disimpan</b></center></div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Error, Nama Tempat Kerja sudah ada.</b></center></div>');
			}

			$this->db->trans_complete();
		} catch (\Throwable $e) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('Tempat');
	}

	private function cek_lokasi($nama)
	{
		$this->db->where('nama_lokasi', $nama);
		$n = $this->db->get('fai_lokasi')->num_rows();
		return $n;
	}

	public function get_data()
	{
		$id = $this->uri->segment(3);
		$this->db->where('id_lokasi', $this->db->escape_str($id));
		$this->db->where('tgl_delete', null);
		$data = $this->db->get('fai_lokasi')->first_row();
		echo json_encode($data);
	}

	public function edit()
	{
		try {
			$this->db->trans_start();

			$id_lokasi = $this->db->escape_str($this->input->post('id_lokasi'));
			$nama_lokasi = $this->db->escape_str($this->input->post('nama_lokasi'));
			$long_lokasi = $this->db->escape_str($this->input->post('long_lokasi'));
			$lat_lokasi = $this->db->escape_str($this->input->post('lat_lokasi'));

			if ($this->cek_lokasi($nama_lokasi) == 0) {
				$this->db->set('nama_lokasi', $nama_lokasi);
				$this->db->set('long_lokasi', $long_lokasi);
				$this->db->set('lat_lokasi', $lat_lokasi);
				$this->db->where('id_lokasi', $id_lokasi);
				$this->db->update('fai_lokasi');
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data telah disimpan</b></center></div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Error, data sudah ada.</b></center></div>');
			}

			$this->db->trans_complete();
		} catch (\Throwable $e) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('Tempat');
	}
}
