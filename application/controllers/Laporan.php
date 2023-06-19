<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		cek_login();
	}

	public function index()
	{
		$data['judul'] = 'Laporan';
		$data['page'] = 'Laporan';
		$data['url'] = base_url('Laporan');

		$this->db->where('tgl_delete', null);
		$data['lokasi'] = $this->db->get('fai_lokasi')->result();

		$this->load->view('header', $data);
		$this->load->view('laporan', $data);
		$this->load->view('footer');
	}

	public function laporan()
	{

		$d = cal_days_in_month(CAL_GREGORIAN, 5, date('Y'));
		//$nbln = date('m');
		$nbln = intval($_GET['bulan']) ?? date('m');
		$id_lokasi = $this->db->escape_str($_GET['id_lokasi']) ?? '';
		$ny = date('Y');

		switch ($nbln) {
			case 1:
				$b = 'Jan';
				$b2 = 'JANUARI';
				break;
			case 2:
				$b = 'Feb';
				$b2 = 'FEBRUARI';
				break;
			case 3:
				$b = 'Mar';
				$b2 = 'MARET';
				break;
			case 4:
				$b = 'Apr';
				$b2 = 'APRIL';
				break;
			case 5:
				$b = 'Mei';
				$b2 = 'MEI';
				break;
			case 6:
				$b = 'Juni';
				$b2 = 'JUNI';
				break;
			case 7:
				$b = 'Juli';
				$b2 = 'JULI';
				break;
			case 8:
				$b = 'Agust';
				$b2 = 'AGUSTUS';
				break;
			case 9:
				$b = 'Sept';
				$b2 = 'SEPTEMBER';
				break;
			case 10:
				$b = 'Okt';
				$b2 = 'OKTOBER';
				break;
			case 11:
				$b = 'Nov';
				$b2 = 'NOVEMBER';
				break;
			case 12:
				$b = 'Des';
				$b2 = 'DESEMBER';
				break;
		}

		$this->data_absen($b, $b2, $d, $nbln, $ny, $id_lokasi);
	}

	private function data_absen($b, $b2, $d, $nbln, $ny, $id_lokasi)
	{
		$lokasi = $this->get_lokasi($id_lokasi);
		$table = '<div style="width:100%;text-align: center;font-weight: bold;">REKAP ABSENSI KARYAWAN PT. FALCON PRIMA TEHNIK<br>BULAN ' . $b2 . ' ' . date('Y') . ' <br>TEMPAT KERJA ' . strtoupper($lokasi) . '</div><br><center><table border="2">';
		$table2 = '<table border="2">';
		$table3 = '<table border="2">';
		//$table .= '<tr><td style="text-align:center;">No</td><td style="text-align:center;">Nama</td><td>1-' . $b . '</td><td>2-' . $b . '</td><td>3-' . $b . '</td><td>4-' . $b . '</td><td>5-' . $b . '</td><td>6-' . $b . '</td><td>7-' . $b . '</td><td>8-' . $b . '</td><td>9-' . $b . '</td><td>10-' . $b . '</td><td>11-' . $b . '</td><td>12-' . $b . '</td><td>13-' . $b . '</td><td>14-' . $b . '</td><td>15-' . $b . '</td><td>16-' . $b . '</td><td>17-' . $b . '</td><td>18-' . $b . '</td><td>19-' . $b . '</td><td>20-' . $b . '</td><td>21-' . $b . '</td><td>22-' . $b . '</td><td>23-' . $b . '</td><td>24-' . $b . '</td><td>25-' . $b . '</td><td>26-' . $b . '</td><td>27-' . $b . '</td><td>28-' . $b . '</td></tr>';
		//$table .= '<tr><td style="text-align:center;">No</td><td style="text-align:center;">Nama</td><td style="width:30px;text-align: center;">1</td><td style="width:30px;text-align: center;">2</td><td style="width:30px;text-align: center;">3</td><td style="width:30px;text-align: center;">4</td><td style="width:30px;text-align: center;">5</td><td style="width:30px;text-align: center;">6</td><td style="width:30px;text-align: center;">7</td><td style="width:30px;text-align: center;">8</td><td style="width:30px;text-align: center;">9</td><td style="width:30px;text-align: center;">10</td><td style="width:30px;text-align: center;">11</td><td style="width:30px;text-align: center;">12</td><td style="width:30px;text-align: center;">13</td><td style="width:30px;text-align: center;">14</td><td style="width:30px;text-align: center;">15</td><td style="width:30px;text-align: center;">16</td><td style="width:30px;text-align: center;">17</td><td style="width:30px;text-align: center;">18</td><td style="width:30px;text-align: center;">19</td><td style="width:30px;text-align: center;">20</td><td style="width:30px;text-align: center;">21</td><td style="width:30px;text-align: center;">22</td><td style="width:30px;text-align: center;">23</td><td style="width:30px;text-align: center;">24</td><td style="width:30px;text-align: center;">25</td><td style="width:30px;text-align: center;">26</td><td style="width:30px;text-align: center;">27</td><td style="width:30px;text-align: center;">28</td></tr>';

		//create tabel header tanggal
		$x = 1;
		$th = '';


		//header tabel || TGL
		for ($n = 1; $n <= $d; $n++) {
			if($this->cek_libur($ny . '-' . $nbln . '-' . $n) >= 1){
				$tgl_merah = 'color: red;font-weight: bold;';
			}else{
				$tgl_merah = '';
			}
			$th .= '<td style="width:30px;text-align: center;' . $tgl_merah . '">' . $n . '</td>';
		}

		$table .= '<tr><td style="text-align:center;">No</td><td style="text-align:center;">Nama</td>' . $th . '</tr>';
		$table2 .= '<tr><td style="text-align:center;">No</td><td style="text-align:center;">Nama</td><td style="width:30px;text-align: center;background-color: green;">M</td><td style="width:30px;text-align: center;background-color: gray;">C</td><td style="width:30px;text-align: center;background-color: #0cd107;">S</td><td style="width:30px;text-align: center;background-color: #0a8ef3;">LBR</td><td style="width:30px;text-align: center;background-color: #c97d8c;">UL</td><td style="width:30px;text-align: center;background-color: red;">TK</td><td style="width:70px;text-align: center;background-color: orange;">LS</td><td style="width:70px;text-align: center;background-color: yellow;">L</td><td style="width:70px;text-align: center;background-color: white;">Hari Kerja</td><td style="width:70px;text-align: center;background-color: greenyellow;">PAID</td><td style="width:70px;text-align: center;background-color: red;">UNPAID</td></tr>';
		$table3 .= '<tr><td style="text-align:center;">No</td><td style="text-align:center;">Nama</td>' . $th . '</tr>';

		if (strlen($nbln) == 1) {
			$nbln = '0' . $nbln;
		}

		//get nama user
		$this->db->where('tgl_delete', null);
		$this->db->where('role_pegawai', 1);
		$this->db->where('id_lokasi', $id_lokasi);
		$user = $this->db->get('fai_akun')->result();

		foreach ($user as $u) {
			$td = $td3 = '';
			$m = $tk = $c = $s = $ul = $lbr = $l_shift = $l_nshift = 0;
			$n_efektif = 0;

			$this->db->where('id_user', $u->id_akun);
			$this->db->where('pending <> 1');
			$this->db->where('pending <> 3');
			$this->db->where('pending <> 7');
			$this->db->where('pending <> 8');
			$this->db->where('pending <> 9');
			$this->db->where('pending <> 10');
			$absen = $this->db->get('fai_absen')->result();

			$this->db->where('id_akun', $u->id_akun);
			$this->db->where('status_lembur', 1);
			$lembur = $this->db->get('fai_lembur')->result();

			for ($n = 1; $n <= $d; $n++) {	// loop jumlah tgl
				$n_data = $n_lembur = $plbr =   0;

				//mencari data absen
				foreach ($absen as $a) {

					if (strlen($n) == 1) {
						$n = '0' . $n;
					}

					if ($a->tgl_absen == $ny . '-' . $nbln . '-' . $n) {
						$n_data += 1;
						$p = $a->pending;
					} else {
						$n_data += 0;
					}
				}

				//mencari data lembur
				foreach ($lembur as $l) {

					if (strlen($n) == 1) {
						$n = '0' . $n;
					}

					if ($l->tgl_lembur == $ny . '-' . $nbln . '-' . $n) {
						$n_lembur += 1;
						$plbr = $l->point_lembur;
					} else {
						$n_lembur += 0;
					}
				}

				if ($n_data > 0) {
					if (($p == 0) or ($p == 2)) {
						$td .= '<td style="background-color: green;width:30px;text-align: center;">M</td>';
						$m += 1;
						$n_efektif += 1;
					} elseif ($p == 4) {
						$td .= '<td style="background-color: gray;width:30px;text-align: center;">C</td>';
						$c += 1;
						$n_efektif += 1;
					} elseif ($p == 5) {	//ULeave
						$td .= '<td style="background-color: #c97d8c;width:30px;text-align: center;">UL</td>';
						$ul += 1;
						$n_efektif += 1;
					} elseif ($p == 6) {
						$td .= '<td style="background-color: #0cd107;width:30px;text-align: center;">S</td>';
						$s += 1;
						$n_efektif += 1;
					} elseif ($p == 11) {
						$td .= '<td style="background-color: orange;width:30px;text-align: center;">LS</td>';
						$l_shift += 1;
					}
					
				} elseif (date('D', strtotime($ny . '-' . $nbln . '-' . $n)) == 'Sun') {
					$td .= '<td style="background-color: yellow;width:30px;text-align: center;">L</td>';
					$l_nshift += 1;
				} elseif ($this->cek_libur($ny . '-' . $nbln . '-' . $n) >= 1) {
					$td .= '<td style="background-color: yellow;width:30px;text-align: center;">L</td>';
					$l_nshift += 1;
				} else {
					$td .= '<td style="background-color: red;width:30px;text-align: center;">TK</td>';
					$tk += 1;
					$n_efektif += 1;
				}

				if ($n_lembur > 0) {
					$td3 .= '<td style="background-color: #0a8ef3;width:30px;text-align: center;">LBR</td>';
					$lbr += $plbr;
				}else{
					$td3 .= '<td style="background-color: transparent;width:30px;text-align: center;"></td>';
				}
			}
			//echo date('D', strtotime($ny . '-' . $nbln . '-28'));

			//$table .= '<tr><td style="text-align:center;">' . $x . '</td><td style="text-align:center;">' . $u->nama_user . '</td><td style="text-align: center;"><b><center>' . strval($x + 1) . '</center></b></td><td style="background-color: green;">' . strval($x + 10) . '</td><td style="background-color: red;">5</td><td style="background-color: yellow;">6</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
			$table .= '<tr><td style="text-align:center;">' . $x . '</td><td style="text-align:center;">' . $u->nama_user . '</td>' . $td . '</tr>';
			$table2 .= '<tr><td style="text-align:center;">' . $x . '</td><td style="text-align:center;">' . $u->nama_user . '</td><td style="text-align:center;">' . $m . '</td><td style="text-align:center;">' . $c . '</td><td style="text-align:center;">' . $s . '</td><td style="text-align:center;">' . $lbr . '</td><td style="text-align:center;">' . $ul . '</td><td style="text-align:center;">' . $tk . '</td><td style="text-align:center;">' . $l_shift . '</td><td style="text-align:center;">' . $l_nshift . '</td><td style="text-align:center;">' . $n_efektif . '</td><td style="text-align:center;background-color: greenyellow;">' . ($m + $s + $lbr + $c) . '</td><td style="text-align:center;background-color: red;">' . ($ul + $tk) . '</td></tr>';
			$table3 .= '<tr><td style="text-align:center;">' . $x . '</td><td style="text-align:center;">' . $u->nama_user . '</td>' . $td3. '</tr>';
			$x += 1;
		}

		$table .= '</table><br>';
		$table .= '<table><tr><td style="background-color: green;width:30px;text-align: center;">M</td><td>:</td><td>Masuk Kerja</td><td>&emsp;</td>';
		$table .= '<td style="background-color: gray;width:30px;text-align: center;">C</td><td>:</td><td>Cuti</td><td>&emsp;</td>';
		$table .= '<td style="background-color: yellow;width:30px;text-align: center;">L</td><td>:</td><td>Libur</td><td>&emsp;</td>';
		$table .= '<td style="background-color: orange;width:30px;text-align: center;">LS</td><td>:</td><td>Libur Shift</td><td>&emsp;</td>';
		$table .= '<td style="background-color: #0cd107;width:30px;text-align: center;">S</td><td>:</td><td>Sakit</td><td>&emsp;</td>';
		$table .= '<td style="background-color: #0a8ef3;width:30px;text-align: center;">LBR</td><td>:</td><td>Lembur</td><td>&emsp;</td>';
		$table .= '<td style="background-color: #c97d8c;width:30px;text-align: center;">UL</td><td>:</td><td>Unpaid Leave</td><td>&emsp;</td>';
		$table .= '<td style="background-color: red;width:30px;text-align: center;">TK</td><td>:</td><td>Tidak Masuk Kerja</td><td>&emsp;</td>';
		$table .= '</tr></table><br><br>';
		$table = $table . $table2 . '</table><br><br>' . $table3 . '</table></center>';
		echo $table;
	}

	private function cek_libur($tgl)
	{
		$this->db->where('tgl_libur', $tgl);
		$n = $this->db->get('fai_libur')->num_rows();
		return $n;
	}

	private function get_lokasi($id)
	{
		$this->db->where('id_lokasi', $id);
		$h = $this->db->get('fai_lokasi')->first_row();
		return $h->nama_lokasi;
	}
}
