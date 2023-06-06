<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jabatan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		cek_login();
	}

	public function index()
	{
		$data['judul'] = 'Jabatan';
		$data['page'] = 'Jabatan';
		$data['url'] = base_url('Jabatan');

		$this->db->where('tgl_delete', null);
		$data['jabatan'] = $this->db->get('fai_jabatan')->result();

		$this->load->view('header', $data);
		$this->load->view('jabatan', $data);
		$this->load->view('footer');
	}

	public function tambah()
	{
		$nama_jabatan = $this->db->escape_str($this->input->post('nama_jabatan'));
		try {
			$this->db->trans_start();

			if ($this->cek_nama($nama_jabatan) == 0) {
				$data = array(
					'id_jabatan' => randid(),
					'nama_jabatan' => $nama_jabatan
				);
				$this->db->insert('fai_jabatan', $data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data telah disimpan</b></center></div>');
			}else{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Error, data sudah ada.</b></center></div>');
			}

			$this->db->trans_complete();
			
		} catch (\Throwable $e) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('Jabatan');
	}

	public function edit()
	{
		$id_jabatan = $this->db->escape_str($this->input->post('id_jabatan'));
		$nama_jabatan = $this->db->escape_str($this->input->post('nama_jabatan'));
		try {
			$this->db->trans_start();

			if ($this->cek_nama($nama_jabatan) == 0) {
				$this->db->set('nama_jabatan', $nama_jabatan);
				$this->db->where('id_jabatan', $id_jabatan);
				$this->db->update('fai_jabatan');
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data telah disimpan</b></center></div>');
			}else{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Error, data sudah ada.</b></center></div>');
			}

			$this->db->trans_complete();
			
		} catch (\Throwable $e) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('Jabatan');
	}

	private function cek_nama($nama)
	{
		$this->db->where('nama_jabatan', $nama);
		$n = $this->db->get('fai_jabatan')->num_rows();
		return $n;
	}

	public function get_data()
	{
		$id = $this->uri->segment(3);
		$this->db->where('id_jabatan', $this->db->escape_str($id));
		$data = $this->db->get('fai_jabatan')->first_row();
		echo json_encode($data);
	}
}
