<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Karyawan_model', 'karyawan');
        if ($this->session->userdata('nik') == null) {
            redirect(base_url() . 'auth/login');
        }
    }

    public function messageAlert($type, $title)
    {
        $messageAlert = "
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
    
        Toast.fire({
            type: '" . $type . "',
            title: '" . $title . "'
        });
        ";
        return $messageAlert;
    }

    public function index()
    {
        $this->karyawan->addHistory($this->session->userdata('name'), $this->session->userdata('name') . ' Telah melakukan login', date('d/m/Y H:i:s'));
        $dataKaryawan = $this->karyawan->getDataKaryawanById($this->session->userdata('id'));
        $data['dataKaryawan'] = $dataKaryawan;
        $data['settingAbsensi'] = $this->karyawan->getSettingAbsensi();
        $data['absensiKaryawan'] = $this->karyawan->getAbsensiKaryawanById($this->session->userdata('id'));
        $data['alasanKaryawan'] = $this->karyawan->getAlasanKaryawanByName($this->session->userdata('name'));
        $this->load->view('user/Dashboard', $data);
    }

    public function absenMasuk()
    {
        $idk = $this->uri->segment('3');
        $cekId = $this->karyawan->getDataKaryawanById($idk);
        if ($cekId[0]->id) {
            $getSettingAbsensi = $this->karyawan->getSettingAbsensi();
            $start = $getSettingAbsensi[0]->mulai_absen;
            $end = $getSettingAbsensi[0]->selesai_absen;
            if (!(strtotime($start) <= time())) {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Waktu untuk absen belum di mulai'));
                redirect(base_url() . 'user');
            } elseif (!(time() >= strtotime($end))) {
                $absensiKaryawan = $this->karyawan->getAbsensiKaryawanById($idk);
                if ($absensiKaryawan[0]->absen == 1) {
                    $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Sudah absen'));
                    redirect(base_url() . 'user');
                } else {
                    $absenHarian = $this->karyawan->absenHarian($idk);
                    $tambahKehadiran = $this->karyawan->updateAbsensiKaryawan($idk, 'hadir', '+', '1');
                    $tambahHistory = $this->karyawan->addHistory($cekId[0]->name, $cekId[0]->name . ' telah melakukan absen', date('d/m/Y H:i:s'));
                    $daftarAbsen = $this->karyawan->absenMasuk($idk);
                    if ($absenHarian && $tambahKehadiran && $tambahHistory && $daftarAbsen) {
                        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Absen berhasil'));
                        redirect(base_url() . 'user');
                    } else {
                        $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal untuk absen'));
                        redirect(base_url() . 'user');
                    }
                }
            } else {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Batas waktu untuk absen telah berakhir'));
                redirect(base_url() . 'user');
            }
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal untuk absen'));
            redirect(base_url() . 'user');
        }
    }
    public function absenPulang()
    {
        $id = $this->uri->segment('3');
        $cekId = $this->karyawan->getDataKaryawanById($id);
        if ($cekId[0]->id) {
            $getSettingAbsensi = $this->karyawan->getSettingAbsensi();
            $start = $getSettingAbsensi[0]->mulai_absen;
            $end = $getSettingAbsensi[0]->selesai_absen;
            if (strtotime($start) >= time()) {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Waktu untuk absen belum di mulai'));
                redirect(base_url() . 'user');
            } elseif (time() >= strtotime($end)) {
                $absensiKaryawan = $this->karyawan->getAbsensiKaryawanById($id);
                if ($absensiKaryawan[0]->absen == 2) {
                    $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Sudah absen'));
                    redirect(base_url() . 'user');
                } else {
                    $tambahKehadiran = $this->karyawan->updateAbsensiKaryawan($id, 'hadir', '+', '1');
                    $absenHarian = $this->karyawan->absenHarian2($id);
                    $daftarAbsen = $this->karyawan->absenPulang($id);
                    $tambahHistory = $this->karyawan->addHistory($cekId[0]->name, $cekId[0]->name . ' telah melakukan absen', date('d/m/Y H:i:s'));
                    if ($absenHarian && $tambahKehadiran && $tambahHistory && $daftarAbsen) {
                        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Absen berhasil'));
                        redirect(base_url() . 'user');
                    } else {
                        $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal untuk absen'));
                        redirect(base_url() . 'user');
                    }
                }
            } else {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Batas waktu untuk absen telah berakhir'));
                redirect(base_url() . 'user');
            }
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal untuk absen'));
            redirect(base_url() . 'user');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }
}
