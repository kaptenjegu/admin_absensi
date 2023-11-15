<?php

function cek_login()
{
	$ci = get_instance();
	if (!$_SESSION['nama_user']) {
		//$ci->session->set_flashdata('msg', '<div style="background-color: orange; color: black;width: 20%; height:20px;margin-left:40%;">
		//			<center><b>Mohon untuk login ulang</b></center></div>');
		$ci->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Mohon untuk login ulang</b></center></div>');
		redirect('login');
	}
}

function randid()
{
	date_default_timezone_set('Asia/Jakarta');
	$length = 7;
	$rand = substr(str_shuffle(str_repeat($x = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
	$rand2 = substr(str_shuffle(str_repeat($x = '0123456789', ceil($length / strlen($x)))), 1, $length);
	$time = date('Y-m-d h-i-s');
	$id = md5($time . $rand . 'PTFPT' . $rand2);
	return $id;
}

function riwayat($id_request, $status, $deadline)
{
	date_default_timezone_set('Asia/Jakarta');
	$ci = get_instance();
	$id_riwayat = randid();

	$ci->db->where('id_request', $id_request);
	$ci->db->where('id_status', $status);
	$n = $ci->db->get('riwayat_request')->num_rows();

	if ($n) {
		$ci->db->set('deadline', $deadline);
		$ci->db->where('id_request', $id_request);
		$ci->db->where('id_status', $status);
		$ci->db->update('riwayat_request');
	} else {
		$data = array(
			'id_riwayat' => $id_riwayat,
			'id_request' => $id_request,
			'id_user' 	=> $_SESSION['id_user'],
			'deadline' 	=> $deadline,
			'id_status' => $status
		);
		$ci->db->insert('riwayat_request', $data);

		$data = array(
			'id_notif' => randid(),
			'id_riwayat' => $id_riwayat
		);
		$ci->db->insert('notif', $data);
	}
}

function riwayat2($id_request, $status)
{
	date_default_timezone_set('Asia/Jakarta');
	$ci = get_instance();
	/*$id_riwayat = randid();
	
	$ci->db->where('id_request', $id_request);
	$ci->db->where('id_status', $status);
	$n = $ci->db->get('riwayat_request')->num_rows();
	
	if($n){*/
	$ci->db->set('created_at', date('Y-m-d H-i-s'));
	$ci->db->where('id_request', $id_request);
	$ci->db->where('id_status', $status);
	$ci->db->update('riwayat_request');
	/*}else{
		$data = array(
			'id_riwayat' => $id_riwayat,
			'id_request' => $id_request,
			'id_user' 	=> $_SESSION['id_user'],
			//'deadline' 	=> '',
			'created_at' 	=> date('Y-m-d H-i-s'),
			'id_status' => $status
		);
		$ci->db->insert('riwayat_request', $data);
		
		$data = array(
			'id_notif' => randid(),
			'id_riwayat' => $id_riwayat
		);
		$ci->db->insert('notif', $data);
	}*/
}

function periksa($id_request)
{	//konversi status kesudah periksa atau belum
	$ci = get_instance();

	$ci->db->where('id_request', $id_request);
	$ci->db->where('role', $_SESSION['role']);
	$ci->db->group_by('role');
	$p = $ci->db->get('pemeriksaan')->num_rows();

	if ($p > 0) {
		$status = 'Sudah diperiksa';
	} else {
		$status = 'Belum diperiksa';
	}

	return $status;
}

function sub_kategori($id)
{
	$ci = get_instance();
	$ci->db->where('id_sub_kategori', $id);
	$data = $ci->db->get('sub_kategori')->first_row();
	return $data->nama_sub_kategori;
}

function usulan()
{
	$id = $_SESSION['role'];
	$ci = get_instance();

	$ci->db->select('*');
	$ci->db->from('barang_request');
	$ci->db->join('status_pengadaan', 'status_pengadaan.id_status=barang_request.id_status');
	$ci->db->join('jenis', 'jenis.id_jenis=barang_request.id_jenis');
	$ci->db->join('kategori', 'kategori.id_kategori=barang_request.id_kategori');

	if ($id == 1 and $_SESSION['id_kantor'] == 1) { //GM PJBS	
		$ci->db->where('barang_request.id_status = 11');
	} elseif ($id == 1 and $_SESSION['id_kantor'] == 2) {	//GM BPI/EVP
		$ci->db->where('barang_request.id_status = 12 OR barang_request.id_status = 24 OR barang_request.id_status = 27 OR barang_request.id_status = 44 OR barang_request.id_status = 47 OR barang_request.id_status = 49');
	} elseif ($id == 2) { //mgr umum
		$ci->db->where('barang_request.id_kategori = 2');
		$ci->db->where('barang_request.id_status = 15 OR barang_request.id_status = 48');
	} elseif ($id == 5) { //mgr om
		$ci->db->where('barang_request.id_kategori = 1');
		$ci->db->where('barang_request.id_status = 15 OR barang_request.id_status = 17 OR barang_request.id_status = 45');
	} elseif ($id == 6) { //staff om
		$ci->db->where('barang_request.id_status = 16 OR barang_request.id_status = 42 OR barang_request.id_status = 36');
	} elseif ($id == 3 and $_SESSION['id_kantor'] == 2) {	//staff BPI - umum
		$ci->db->where('barang_request.id_status = 21 OR barang_request.id_status = 39');
	} elseif ($id == 8) {	//staff Pengadaan - y/t
		$ci->db->where('barang_request.id_status = 18 OR barang_request.id_status = 38');
	} elseif ($id == 4 and $_SESSION['id_kantor'] == 2) {	//staff Pemeriksaan - Gudang
		$ci->db->where('barang_request.id_status = 30 OR barang_request.id_status = 19');
	} elseif ($id == 7 and $_SESSION['id_kantor'] == 2) {	//staff Keu BPI
		$ci->db->where('barang_request.id_status = 40');
	} elseif ($id == 8 and $_SESSION['id_kantor'] == 2) {	//staff Pengadaan BPI
		$ci->db->where('barang_request.id_status = 18');
	} else {
		$ci->db->where('barang_request.id_status = 0');
	}

	$ci->db->where('barang_request.aktif', 1);
	$ci->db->order_by('created_at', 'desc');
	$data = $ci->db->get();

	$hasil['jumlah'] = $data->num_rows();
	$hasil['data'] = $data->result();

	//if($_SESSION['role']==3 AND $_SESSION['id_kantor']==1){
	//	$n = 0;
	//}
	return $hasil;
}

function view_tgl($tgl)
{
	//$ci = get_instance();
	$t = explode(' ', $tgl);
	return $t[0];
}

function view_jam($tgl)
{
	//$ci = get_instance();
	$t = explode(' ', $tgl);
	return $t[1];
}

function grup_by()
{
	$ci = get_instance();
	$query = $ci->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
}

function view_riwayat($id_request, $id_status)
{
	$ci = get_instance();

	$ci->db->where('id_request', $id_request);
	$ci->db->where('id_status', $id_status);
	$d = $ci->db->get('riwayat_request');
	if ($d->num_rows()) {
		$data = $d->first_row();
		return $data->deadline;
	} else {
		return '-';
	}
}

function hapus_alasan($id_request)
{
	$ci = get_instance();

	$ci->db->set('alasan_ditolak', '');
	$ci->db->where('id_request', $id_request);
	$ci->db->update('barang_request');
}

function hapus_karantina($id_request)
{
	$ci = get_instance();

	$ci->db->set('id_status', 36);	//Auto  = Barang/jasa telah diperiksa, sedang dibuatkan BA
	$ci->db->set('alasan_ditolak', '');
	$ci->db->where('id_request', $id_request);
	$ci->db->update('barang_request');
}

function dashboard($id)
{
	$ci = get_instance();

	if ($id == 1) {
		$ci->db->where('id_status', 40);
		$data = $ci->db->get('barang_request')->num_rows();
	} elseif ($id == 2) {
		$ci->db->where('id_status<>40');
		$ci->db->where('id_status<>11');
		$data = $ci->db->get('barang_request')->num_rows();
	} elseif ($id == 3) {
		$ci->db->where('id_status', 11);
		$data = $ci->db->get('barang_request')->num_rows();
	} elseif ($id == 4) {
		$ci->db->where('aktif', 1);
		$data = $ci->db->get('user')->num_rows();
	} elseif ($id == 5) {
		$data = $ci->db->get('barang_request')->num_rows();
	} elseif ($id == 6) {
		$ci->db->where('id_pengadaan', 2);
		$data = $ci->db->get('barang_request')->num_rows();
	} else {
		$ci->db->where('id_status', 11);
		$data = $ci->db->get('barang_request')->num_rows();
	}

	return $data;
}

function tgl_before($id_request, $id_status)
{
	$ci = get_instance();
	$ci->db->where('id_request', $id_request);
	$ci->db->where('id_status', $id_status);
	$d = $ci->db->get('riwayat_request');
	if ($d->num_rows()) {
		$data = $d->first_row();
		return $data->created_at;
	} else {
		return '-';
	}
}

function notif_pjbs($id, $opsi)
{
	$ci = get_instance();
	$data = array(
		'id_notif' => '',
		'id_request' => $id,
		'id_status' => $opsi	//1 - disetujui , 2 - ditolak
	);
	$ci->db->insert('notif_pjbs', $data);
}

function generate_warna()
{
	date_default_timezone_set('Asia/Jakarta');
	$ci = get_instance();
	$length = 6;

	do {
		$rand = substr(str_shuffle(str_repeat($x = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
		$rand = '#' .  $rand;

		$ci->db->where('warna_lokasi', $rand);
		$ci->db->where('tgl_delete', null);
		$n = $ci->db->get('fai_lokasi')->num_rows();
	}while($n >= 1);

	return $rand;
}