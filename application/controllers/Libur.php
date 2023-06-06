<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Libur extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		cek_login();
	}

	public function index()
	{		
		$data['judul'] = 'Hari Libur';
		$data['page'] = 'Libur';
		$data['url'] = base_url('Libur');

        $data['libur'] = $this->db->get('fai_libur')->result();

		$this->load->view('header', $data);
		$this->load->view('libur', $data);
		$this->load->view('footer');
	}

    public function get_detail()
	{
		$this->db->where('id_libur', $this->db->escape_str($this->uri->segment(3)));
		$libur = $this->db->get('fai_libur')->first_row();
		echo json_encode($libur);
	}

    public function simpan_tambah()
	{
        try {
            $this->db->trans_start();

            $data = array(
                'id_libur' => randid(),
                'tgl_libur' => $this->input->post('tgl_libur'),
                'keterangan' => $this->input->post('keterangan')
            );
            $this->db->insert('fai_libur', $data);

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Libur Berhasil disimpan</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Libur');
    }

    public function simpan_edit()
	{
        try {
            $this->db->trans_start();

            $this->db->set('tgl_libur', $this->input->post('tgl_libur'));
            $this->db->set('keterangan', $this->input->post('keterangan'));
            $this->db->where('id_libur', $this->input->post('id_libur'));
            $this->db->update('fai_libur');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Libur Berhasil diperbarui</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Libur');
    }
}
