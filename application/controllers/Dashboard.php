<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		cek_login();
	}

	public function index()
	{
		$data['judul'] = 'Dashboard';
		$data['page'] = 'Dashboard';
		$data['url'] = base_url('Dashboard');

		$this->db->select('*');
		$this->db->from('fai_absen');
		$this->db->join('fai_akun', 'fai_absen.id_user = fai_akun.id_akun');
		$this->db->join('fai_lokasi', 'fai_akun.id_lokasi = fai_lokasi.id_lokasi');
		$this->db->join('fai_pending_detail', 'fai_absen.pending = fai_pending_detail.id_pending');
		$this->db->where('(fai_absen.pending = 7 OR fai_absen.pending = 8 OR fai_absen.pending = 9 OR fai_absen.pending = 1 OR fai_absen.pending = 10)');
		//$this->db->or_where('fai_absen.pending', '8');
		//$this->db->or_where('fai_absen.pending', '9');
		//$this->db->or_where('fai_absen.pending', '1');
		//$this->db->or_where('fai_absen.pending', '10');
		if($_SESSION['role_user'] == 2){
			$this->db->where('fai_akun.id_lokasi', $_SESSION['id_lokasi']);
		}
		$data['dashboard'] = $this->db->get()->result();

		$this->db->select('*');
		$this->db->from('fai_lembur');
		$this->db->join('fai_akun', 'fai_lembur.id_akun = fai_akun.id_akun');
		$this->db->join('fai_lokasi', 'fai_akun.id_lokasi = fai_lokasi.id_lokasi');
		$this->db->where('fai_lembur.status_lembur', '0');
		if($_SESSION['role_user'] == 2){
			$this->db->where('fai_akun.id_lokasi', $_SESSION['id_lokasi']);
		}
		$data['lembur'] = $this->db->get()->result();

		$this->db->where('role_pegawai', 1);
		$this->db->where('tgl_delete', null);
		$user = $this->db->get('fai_akun')->num_rows();

		$this->db->where('pending >= 4');
		$this->db->where('pending <= 6');
		$this->db->where('tgl_absen', date('Y-m-d', strtotime('today')));
		$off = $this->db->get('fai_absen')->num_rows();

		$this->db->where('(pending = 0 OR pending = 2)');
		//$this->db->or_where('pending', '2');
		$this->db->where('tgl_absen', date('Y-m-d', strtotime('today')));
		$masuk = $this->db->get('fai_absen')->num_rows();
		
		$tdk_masuk = $user - $masuk;
		$data['chart'] = array('user' => $user, 'masuk' => $masuk, 'tdk_masuk' => $tdk_masuk, 'off' => $off);

		$this->load->view('header', $data);
		$this->load->view('dashboard', $data);
		$this->load->view('footer');
	}

	public function get_detail()
	{
		$this->db->select("*, DATE_FORMAT(tgl_absen,'%d/%m/%Y') AS tgl_absen2");
		$this->db->from('fai_absen');
		$this->db->join('fai_akun', 'fai_absen.id_user = fai_akun.id_akun');
		$this->db->join('fai_jabatan', 'fai_akun.id_jabatan = fai_jabatan.id_jabatan');
		$this->db->join('fai_pending_detail', 'fai_absen.pending = fai_pending_detail.id_pending');
		$this->db->where('fai_absen.id_absen', $this->db->escape_str($this->uri->segment(3)));
		$dashboard = $this->db->get()->first_row();
		echo json_encode($dashboard);
	}

	public function get_data_chart()
	{
		$this->db->where('role_pegawai', 1);
		$this->db->where('tgl_delete', null);
		$user = $this->db->get('fai_akun')->num_rows();

		$this->db->where('pending >= 4');
		$this->db->where('pending <= 6');
		$this->db->where('tgl_absen', date('Y-m-d', strtotime('today')));
		$off = $this->db->get('fai_absen')->num_rows();

		$this->db->where('pending = 0 OR pending = 2');
		//$this->db->or_where('pending', 2);
		//$this->db->where('role_pegawai', 1);
		$this->db->where('tgl_absen', date('Y-m-d', strtotime('today')));
		$masuk = $this->db->get('fai_absen')->num_rows();

		$tdk_masuk = $user - $masuk;
		$data = array('user' => $user, 'masuk' => $masuk, 'tdk_masuk' => $tdk_masuk, 'off' => $off);
		echo json_encode($data);
	}

	public function simpan_pengajuan()
	{
		try {
			$id_absen = $this->db->escape_str($this->input->post('id_absen'));
			$id_pending = $this->input->post('pending');
			$opsi = $this->input->post('opsi');
			$alasan = $this->input->post('alasan');
			$id_user = $this->input->post('id_user');
			$tgl_absen = $this->input->post('tgl_absen');
			$this->db->trans_start();

			switch ($id_pending) {
				case 1:	//lupa absen
					$acc = 2;
					$tipe = 'Lupa Absen';
					break;
				case 7:	//cuti
					$acc = 4;
					$tipe = 'Cuti';
					break;
				case 8:	//unpaid leave
					$acc = 5;
					$tipe = 'Unpaid Leave';
					break;
				case 9:	//sakit
					$acc = 6;
					$tipe = 'Sakit';
					break;
				case 10:	//Libur Shift
					$acc = 11;
					$tipe = 'Libur Shift';
					break;
			}

			if ($opsi == 1) {
				$this->db->set('pending', $acc);
				$this->db->where('id_absen', $id_absen);
				$this->db->update('fai_absen');

				$this->notifkasi(2, 'Pengajuan Absen ' . $tipe . ' tanggal ' . $tgl_absen . ' disetujui', '', $id_user);

				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data berhasil disimpan</b></center></div>');
			} else {
				$this->db->where('id_absen', $id_absen);
				$this->db->delete('fai_absen');

				//Pengembalian sisa cuti karena cuti dihapus/ditolak
				$this->db->where('id_akun', $id_user);
				$user = $this->db->get('fai_akun')->first_row();

				$this->db->set('sisa_cuti', $user->sisa_cuti + 1);
				$this->db->where('id_akun', $id_user);
				$this->db->update('fai_akun');

				$this->notifkasi(1, 'Pengajuan Absen ' . $tipe . ' tanggal ' . $tgl_absen . ' ditolak', $alasan, $id_user);

				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data berhasil dihapus</b></center></div>');
			}

			$this->db->trans_complete();
		} catch (\Throwable $e) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('Dashboard');
	}

	private function notifkasi($mode, $isi, $alasan, $id_user)	//$mode - alert / success
	{
		$data = array(
			'id_notif' => randid(),
			'mode_notif' => $mode,
			'isi_notif' => $isi,
			'alasan' => $alasan,
			'status_baca' => 0,
			'id_user' => $id_user
		);
		$this->db->insert('fai_notif', $data);
	}

	public function time_server()
	{
		echo date('H') . '<span class="blink_me">:</span>' . date('i');
	}

	public function tertunda()
	{
		$data['judul'] = 'Absen Tertunda';
		$data['page'] = 'Absen_tertunda';
		$data['url'] = base_url('Absen/tertunda');

		$this->load->view('header', $data);
		$this->load->view('absen_tertunda', $data);
		$this->load->view('footer');
	}

	public function masuk()
	{
		//if (($this->uri->segment(3) == $_SESSION['id_akun'])) {
		if (($this->uri->segment(3) == $_SESSION['id_akun']) and (date('H') >= 6 and date('H') <= 12)) {
			try {
				$this->db->trans_start();
				$absen_masuk = date('H:i');
				$tgl_absen = date('Y-m-d');
				$id_user = $_SESSION['id_akun'];
				$n = $this->cek_dobel_data($id_user, $tgl_absen, 'masuk');
				if ($n == 0) {
					$data = array(
						'id_absen' => randid(),
						'id_user' => $id_user,
						'tgl_absen' => $tgl_absen,
						'absen_masuk' 	=> $absen_masuk,
						'absen_pulang' 	=> '',
						'pending' 	=> 0,
						'catatan_pending' 	=> ''
					);
					$this->db->insert('fai_absen', $data);
					$msg = 'Absen Masuk berhasil';
					$jam = $absen_masuk;
				} else {
					$msg = 'Sudah absen masuk';
				}
				$this->db->trans_complete();
				$status = 200;
			} catch (\Throwable $e) {
				$status = 400;
				$msg = 'Caught exception: ' .  $e->getMessage();
			}
		} else {
			$status = 500;
			$msg = 'Diluar jam absen masuk';
		}

		$result = array(
			'status' => $status,
			'msg' => $msg,
			'jam' => $jam ?? 0
		);
		echo json_encode($result);
	}

	public function pulang()
	{
		//if (($this->uri->segment(3) == $_SESSION['id_akun'])) {
		if (($this->uri->segment(3) == $_SESSION['id_akun']) and (date('H') >= 14 and date('H') <= 21)) {
			try {
				$this->db->trans_start();
				$absen_pulang = date('H:i');
				$tgl_absen = date('Y-m-d');
				$id_user = $_SESSION['id_akun'];
				$n = $this->cek_dobel_data($id_user, $tgl_absen, 'pulang');

				if ($n == 1) {
					$this->db->set('absen_pulang', $absen_pulang);
					$this->db->where('id_user', $id_user);
					$this->db->where('tgl_absen', $tgl_absen);
					$this->db->update('fai_absen');
					$status = 200;
					$msg = 'Absen Pulang berhasil';
				} else {
					if ($this->cek_data_pulang($id_user, $tgl_absen) == 1) {
						$status = 200;
						$msg = 'Sudah absen pulang';
					} else {
						$status = 400;
						$msg = 'Belum absen masuk';
					}
				}
				$this->db->trans_complete();
				$jam = $absen_pulang;
			} catch (\Throwable $e) {
				$status = 400;
				$msg = 'Caught exception: ' .  $e->getMessage();
			}
		} else {
			$status = 500;
			$msg = 'Diluar jam absen pulang';
		}

		$result = array(
			'status' => $status,
			'msg' => $msg,
			'jam' => $jam ?? 0
		);
		echo json_encode($result);
	}

	private function cek_dobel_data($id_user, $tgl_absen,  $mode)
	{
		$this->db->where('id_user', $id_user);
		$this->db->where('tgl_absen', $tgl_absen);

		if ($mode == 'pulang') {
			$this->db->where('absen_pulang', '');
		}

		$n = $this->db->get('fai_absen')->num_rows();
		return $n;
	}

	private function cek_data_pulang($id_user, $tgl_absen)
	{
		$this->db->where('id_user', $id_user);
		$this->db->where('tgl_absen', $tgl_absen);
		$this->db->where('absen_pulang <> ""');
		$n = $this->db->get('fai_absen')->num_rows();
		return $n;
	}

	public function simpan_lembur()
	{
		try {
			$this->db->trans_start();

			$id_lembur = $this->db->escape_str($this->input->post('id_lembur'));
			$id_user = $this->db->escape_str($this->input->post('id_user'));

			//echo $this->input->post('point_lembur');exit();

			$this->db->set('point_lembur', $this->input->post('point_lembur'));
			$this->db->set('status_lembur', 1);
			$this->db->where('id_lembur', $id_lembur);
			$this->db->where('id_akun', $id_user);
			$this->db->update('fai_lembur');

			$this->notifkasi(2, 'Pengajuan Lembur disetujui', '', $id_user);

			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Lembur berhasil disetujui</b></center></div>');

			$this->db->trans_complete();
		} catch (\Throwable $e) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
				<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('Dashboard');
	}

	public function get_detail_lembur()
	{
		$this->db->select("*, DATE_FORMAT(tgl_lembur,'%d/%m/%Y') AS tgl_lembur2, fai_lembur.keterangan as keterangan2");
		$this->db->from('fai_lembur');
		$this->db->join('fai_akun', 'fai_lembur.id_akun = fai_akun.id_akun');
		$this->db->join('fai_jabatan', 'fai_akun.id_jabatan = fai_jabatan.id_jabatan');
		$this->db->where('fai_lembur.id_lembur', $this->db->escape_str($this->uri->segment(3)));
		$lembur = $this->db->get()->first_row();
		echo json_encode($lembur);
	}

	public function hapus_lembur()
	{
		try {
			$this->db->trans_start();

			$id_lembur = $this->db->escape_str($this->uri->segment(3));

			$this->db->where('id_lembur', $id_lembur);
			$this->db->delete('fai_lembur');

			$this->notifkasi(1, 'Pengajuan Lembur ditolak', 'Silakan kontak admin/HRD', $id_user);

			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data berhasil dihapus</b></center></div>');

			$this->db->trans_complete();
		} catch (\Throwable $e) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
				<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('Dashboard');
	}
}
