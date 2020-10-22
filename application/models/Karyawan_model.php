<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllDataKaryawan()
    {
        return $this->db->get('data_karyawan')->result();
    }
    public function getAllRekapAbsen()
    {
        return $this->db->get('rekap_absen')->result();
    }

    public function getDataKaryawanById($idk)
    {
        return $this->db->get_where('data_karyawan', array('id' => $idk))->result();
    }

    public function getDataKaryawanByNik($nik)
    {
        return $this->db->get_where('data_karyawan', array('nik' => $nik))->result();
    }

    public function getAbsensiKaryawanById($idk)
    {
        return $this->db->get_where('absensi_karyawan', array('id' => $idk))->result();
    }

    public function getAbsensiKaryawanByName($name)
    {
        return $this->db->get_where('absensi_karyawan', array('nama' => $name))->result();
    }

    public function getAlasanKaryawanByName($name)
    {
        return $this->db->order_by('id', 'DESC')->get_where('alasan_karyawan', array('nama' => $name))->result();
    }

    public function changeInfoKaryawanById($idk, $data)
    {
        return $this->db->set($data)->where('id', $idk)->update('data_karyawan');
    }

    public function addDataKaryawan($data)
    {
        return $this->db->insert('data_karyawan', $data);
    }

    public function addAbsensiKaryawan($data)
    {
        return $this->db->insert('absensi_karyawan', $data);
    }
    public function addDaftarAbsen($data)
    {
        return $this->db->insert('daftar_absen', $data);
    }


    public function updateAbsensiKaryawan($idk, $kehadiran, $option, $jumlah)
    {
        return $this->db->set($kehadiran, $kehadiran . $option . $jumlah, FALSE)->where('id', $idk)->update('absensi_karyawan');
    }

    public function addAlasanKaryawan($name, $alasan, $date)
    {
        return $this->db->insert('alasan_karyawan', array('nama' => $name, 'alasan' => $alasan, 'tanggal' => $date));
    }

    public function resetAbsen()
    {
        return $this->db->set('absen', '0', FALSE)->update('absensi_karyawan');
    }
    public function resetDaftarAbsen()
    {
        return $this->db->set('tanggal', '')->set('jam_masuk', '')->set('jam_pulang', '')->set('status', 'Belum Absen')->update('daftar_absen');
    }
    public function resetAbsenById($idk)
    {
        return $this->db->set('absen', '0', FALSE)->where('id', $idk)->update('absensi_karyawan');
    }
    public function resetDaftarAbsenById($idk)
    {
        return $this->db->set('tanggal', '')->set('jam_masuk', '')->set('jam_pulang', '')->set('status', 'Belum Absen')->where('id', $idk)->update('daftar_absen');
    }
    public function deleteKaryawan($idk)
    {
        return $this->db->delete('data_karyawan', array('id' => $idk));
    }
    public function deleteAbsen($nama)
    {
        return $this->db->delete('daftar_absen', array('nama' => $nama));
    }

    public function loginKaryawan($nik, $password)
    {
        return $this->db->where('nik', $nik)->where('password', $password)->get('users_karyawan')->result();
    }

    public function addUserKaryawan($nik, $password)
    {
        return $this->db->insert('users_karyawan', array('nik' => $nik, 'password' => $password, 'level' => 'Karyawan'));
    }

    public function settingAbsensi($start, $end)
    {
        return $this->db->set('mulai_absen', $start)->set('selesai_absen', $end)->update('setting_absensi');
    }

    public function getSettingAbsensi()
    {
        return $this->db->get('setting_absensi')->result();
    }

    public function absenHarian($idk)
    {
        return $this->db->set('absen', '1')->where('id', $idk)->update('absensi_karyawan');
    }
    public function absenHarian2($idk)
    {
        return $this->db->set('absen', '2')->where('id', $idk)->update('absensi_karyawan');
    }

    public function addHistory($name, $info, $tanggal)
    {
        return $this->db->insert('history_karyawan', array('nama' => $name, 'info' => $info, 'tanggal' => $tanggal));
    }

    public function uploadImage()
    {
        $config['upload_path'] = './images/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '2048';
        $config['remove_space'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('upload_image')) {
            return array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
        } else {
            return array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
        }
    }
    public function getAllDaftarAbsen()
    {
        return $this->db->get('daftar_absen')->result();
    }
    public function absenMasuk($idk)
    {
        $tanggal = date('d/m/Y');
        $jam = date('H:i');
        return $this->db->set('tanggal', $tanggal)->set('jam_masuk', $jam)->set('status', 'Masuk')->where('id', $idk)->update('daftar_absen');
    }
    public function absenPulang($idk)
    {
        $tanggal = date('d/m/Y');
        $jam = date('H:i');
        return $this->db->set('tanggal', $tanggal)->set('jam_pulang', $jam)->set('status', 'Pulang')->where('id', $idk)->update('daftar_absen');
    }
    public function addRekap($data)
    {
        $this->db->insert_batch('rekap_absen', $data);
    }
}
