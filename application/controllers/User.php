<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		cek_login();
	}

	public function index()
	{
		$data['judul'] = 'User';
		$data['page'] = 'User';
		$data['url'] = base_url('User');

		$this->db->select('*');
		$this->db->from('fai_akun');
		$this->db->join('fai_jabatan', 'fai_jabatan.id_jabatan = fai_akun.id_jabatan');
		$this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fai_akun.id_lokasi');
		$this->db->where('fai_akun.tgl_delete', null);
		if($_SESSION['role_user'] == 2){
			$this->db->where('fai_akun.id_lokasi', $_SESSION['id_lokasi']);
		}
		$data['user'] = $this->db->get()->result();

		$this->load->view('header', $data);
		$this->load->view('user', $data);
		$this->load->view('footer');
	}

	public function tambah()
	{
		$data['judul'] = 'Tambah User';
		$data['page'] = 'User';
		$data['url'] = base_url('User/tambah/');
		$data['action'] = base_url('User/tambah_simpan/');

		$this->db->where('tgl_delete', null);
		$data['jabatan'] = $this->db->get('fai_jabatan')->result();

		$this->db->where('tgl_delete', null);
		$data['lokasi'] = $this->db->get('fai_lokasi')->result();

		$this->load->view('header', $data);
		$this->load->view('manage_user', $data);
		$this->load->view('footer');
	}

	public function edit()
	{
		$data['judul'] = 'Edit User';
		$data['page'] = 'User';
		$data['url'] = base_url('User/edit/');
		$data['action'] = base_url('User/edit_simpan/');

		$id_akun = $this->db->escape_str($this->uri->segment(3));

		//$this->db->select('*');
		//$this->db->from('fai_akun');
		//$this->db->join('fai_akun_lokasi', 'fai_akun_lokasi.id_akun = fai_akun.id_akun');
		$this->db->where('id_akun', $id_akun);
		$this->db->where('tgl_delete', null);
		$user = $this->db->get('fai_akun');

		if ($user->num_rows() == 1) {
			$data['user'] = $user->first_row();

			$this->db->where('tgl_delete', null);
			$data['jabatan'] = $this->db->get('fai_jabatan')->result();

			$this->db->where('tgl_delete', null);
			$data['lokasi'] = $this->db->get('fai_lokasi')->result();

			$this->load->view('header', $data);
			$this->load->view('manage_user', $data);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Error, data tidak ada.</b></center></div>');
			redirect('User');
		}
	}

	public function tambah_simpan()
	{
		try {
			$this->db->trans_start();
			$nama_user = $this->input->post('nama_user');
			$id_user = randid();

			if ($this->cek_nama($nama_user) == 0) {
				//echo $this->input->post('menu_kas');exit();
				if($this->input->post('menu_kas')){
					$this->tambah_permission($id_user, 'kas');
				}

				if($this->input->post('menu_kas_tipe')){
					$this->tambah_permission($id_user, 'kas_tipe');
				}

				if($this->input->post('menu_aset_pinjam')){
					$this->tambah_permission($id_user, 'aset_pinjam');
				}

				if($this->input->post('menu_aset')){
					$this->tambah_permission($id_user, 'aset');
				}

				if($this->input->post('menu_aset_kembali')){
					$this->tambah_permission($id_user, 'aset_kembali');
				}

				if($this->input->post('menu_monitoring_bayar')){
					$this->tambah_permission($id_user, 'monitoring_bayar');
				}

				if($this->input->post('menu_monitoring_riwayat_bayar')){
					$this->tambah_permission($id_user, 'monitoring_riwayat_bayar');
				}

				if($this->input->post('tender')){
					$this->tambah_permission($id_user, 'tender');
					$this->tambah_permission($id_user, 'Riwayat_tender');
				}

				$data = array(
					'id_akun' => $id_user,
					'nama_user' => strtoupper($nama_user),
					'email' => $this->input->post('email'),
					'password' => md5('123456789'),
					'id_jabatan' => $this->input->post('id_jabatan'),
					'id_lokasi' => $this->input->post('id_lokasi'),
					'sisa_cuti' => 12,
					'role_user' => 1,
					'role_pegawai' => $this->input->post('role_pegawai'),
					'role_shift' => $this->input->post('role_shift'),
					'no_telp' => $this->input->post('no_telp')
				);
				$this->db->insert('fai_akun', $data);

				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data telah disimpan</b></center></div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Error, data sudah ada.</b></center></div>');
			}

			$this->db->trans_complete();
		} catch (\Throwable $th) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('User');
	}

	private function tambah_permission($id_akun, $menu)
	{
		$data = array(
			'id_permission' => '',
			'id_user' => $id_akun,
			'id_menu' => $menu
		);
		$this->db->insert('fma_permission', $data);
	}

	public function edit_simpan()
	{
		try {
			$this->db->trans_start();
			$id_akun = $this->db->escape_str($this->input->post('id_akun'));
			$nama_user = $this->input->post('nama_user');
			$id_user = $id_akun;

			$this->db->where('id_user', $id_akun);
			$this->db->delete('fma_permission');

			if($this->input->post('menu_kas')){
				$this->tambah_permission($id_user, 'kas');
			}

			if($this->input->post('menu_kas_tipe')){
				$this->tambah_permission($id_user, 'kas_tipe');
			}

			if($this->input->post('menu_aset_pinjam')){
				$this->tambah_permission($id_user, 'aset_pinjam');
			}

			if($this->input->post('menu_aset')){
				$this->tambah_permission($id_user, 'aset');
			}

			if($this->input->post('menu_aset_kembali')){
				$this->tambah_permission($id_user, 'aset_kembali');
			}

			if($this->input->post('menu_monitoring_bayar')){
				$this->tambah_permission($id_user, 'monitoring_bayar');
			}

			if($this->input->post('menu_monitoring_riwayat_bayar')){
				$this->tambah_permission($id_user, 'monitoring_riwayat_bayar');
			}

			if($this->input->post('menu_tender')){
				$this->tambah_permission($id_user, 'tender');
				$this->tambah_permission($id_user, 'Riwayat_tender');
			}

			//if ($this->cek_nama($nama_user) == 0) {
			$this->db->set('nama_user', $nama_user);
			$this->db->set('email', $this->input->post('email'));
			$this->db->set('id_jabatan', $this->input->post('id_jabatan'));
			$this->db->set('id_lokasi', $this->input->post('id_lokasi'));
			$this->db->set('no_telp', $this->input->post('no_telp'));
			$this->db->set('role_pegawai', $this->input->post('role_pegawai'));
			$this->db->set('role_shift', $this->input->post('role_shift'));
			$this->db->where('id_akun', $id_akun);
			$this->db->update('fai_akun');
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data telah diperbarui</b></center></div>');
			//}else{
			//	$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
			//		<center><b>Error, data sudah ada.</b></center></div>');
			//}

			$this->db->trans_complete();
		} catch (\Throwable $e) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('User');
	}

	public function hapus_user()
	{
		try {
			$this->db->trans_start();
			$id_akun = $this->db->escape_str($this->uri->segment(3));

			$this->db->set('tgl_delete', date('Y-m-d H:i:s'));
			$this->db->where('id_akun', $id_akun);
			$this->db->update('fai_akun');

			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data telah dihapus</b></center></div>');

			$this->db->trans_complete();
		} catch (\Throwable $e) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('User');
	}

	private function cek_nama($nama)
	{
		$this->db->where('nama_user', $nama);
		$n = $this->db->get('fai_akun')->num_rows();
		return $n;
	}

	public function reset_password()
	{
		try {
			$this->db->trans_start();
			$id_akun = $this->db->escape_str($this->uri->segment(3));

			$this->db->set('password', md5('123456789'));
			$this->db->where('id_akun', $id_akun);
			$this->db->update('fai_akun');

			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Reset Password Berhasil</b></center></div>');

			$this->db->trans_complete();
		} catch (\Throwable $e) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
				<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('User');
	}
}
