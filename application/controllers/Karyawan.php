<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Karyawan_model', 'karyawan');
        if ($this->session->userdata('nik') == null) {
            redirect(base_url() . 'auth/login');
        } elseif ($this->session->userdata('level') == 'Karyawan') {
            redirect(base_url() . 'user');
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
        $this->karyawan->addHistory('Admin', 'Admin telah melakukan login', date('d/m/Y H:i:s'));
        $this->load->view('admin/Dashboard');
    }

    public function data_karyawan()
    {
        $data['getAllDataKaryawan'] = $this->karyawan->getAllDataKaryawan();
        $this->load->view('admin/DataKaryawan', $data);
    }
    public function rekap_absen()
    {
        $data['rekap'] = $this->karyawan->getAllRekapAbsen();
        $this->load->view('admin/RekapAbsen', $data);
    }

    public function tambah_karyawan()
    {
        $this->load->view('admin/TambahKaryawan');
    }

    public function absensi_karyawan()
    {
        $data['dataKaryawan'] = $this->karyawan->getAllDataKaryawan();
        $data['daftarAbsen'] = $this->karyawan->getAllDaftarAbsen();
        $this->load->view('admin/AbsensiKaryawan', $data);
    }

    public function setting_absensi()
    {
        $this->load->view('admin/SettingAbsensi');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function resetAbsen()
    {
        $data = $this->karyawan->getAllDaftarAbsen();
        $Array = array();
        foreach ($data as $rows) {
            $newArray = array(
                'id_pegawai' => $rows->id,
                'nama' => $rows->nama,
                'tanggal' => $rows->tanggal,
                'jam_masuk' => $rows->jam_masuk,
                'jam_pulang' => $rows->jam_pulang,
                'status' => $rows->status
            );
            array_push($Array, $newArray);
        }
        $this->karyawan->addRekap($Array);
        $this->karyawan->resetAbsen();
        $this->karyawan->resetDaftarAbsen();
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil mereset absen'));
        redirect(base_url() . 'karyawan/absensi_karyawan');
    }
    public function reset($idk)
    {
        $this->karyawan->resetAbsenByID($idk);
        $this->karyawan->resetDaftarAbsenByID($idk);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil mereset absen'));
        redirect(base_url() . 'karyawan/absensi_karyawan');
    }

    public function isTime($time)
    {
        return preg_match("#([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}#", $time);
    }

    public function settingAbsensi()
    {
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        if ($start && $end) {
            if ($this->isTime($start) && $this->isTime($end)) {
                $this->karyawan->settingAbsensi($start, $end);
                $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil mengubah pengaturan'));
                redirect(base_url() . 'karyawan/setting_absensi');
            } else {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Format jam salah'));
                redirect(base_url() . 'karyawan/setting_absensi');
            }
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal mengubah pengaturan'));
            redirect(base_url() . 'karyawan/setting_absensi');
        }
    }

    public function edit()
    {
        $idk = $this->uri->segment(3);
        $cekId = $this->karyawan->getDataKaryawanById($idk);
        if ($cekId[0]->id) {
            $dataKaryawan = $this->karyawan->getDataKaryawanById($idk);
            $data['dataKaryawan'] = $dataKaryawan;
            $data['absensiKaryawan'] = $this->karyawan->getAbsensiKaryawanById($idk);
            $data['alasanKaryawan'] = $this->karyawan->getAlasanKaryawanByName($dataKaryawan[0]->name);
            $this->load->view('admin/EditKaryawan', $data);
        } else {
            redirect();
        }
    }

    public function delete()
    {
        $id = $this->uri->segment(3);
        $cekId = $this->karyawan->getDataKaryawanById($id);

        if ($cekId[0]->id) {
            $deleteKaryawan = $this->karyawan->deleteKaryawan($id);
            $deleteAbsen = $this->karyawan->deleteAbsen($cekId[0]->name);
            if ($deleteKaryawan == 1 && $deleteAbsen) {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus karyawan'));
                redirect(base_url() . 'karyawan/data_karyawan');
            } else {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal menghapus karyawan'));
                redirect(base_url() . 'karyawan/data_karyawan');
            }
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal menghapus karyawan'));
            redirect(base_url() . 'karyawan/data_karyawan');
        }
    }

    public function changeFotoKaryawan()
    {
        $id = $this->input->post('id');
        $upload = $this->karyawan->uploadImage();
        if ($id && $upload['result'] == "success") {
            $data = array(
                'image_name' => $upload['file']['file_name']
            );
            $changeFoto = $this->karyawan->changeInfoKaryawanById($id, $data);
            if ($changeFoto == 1) {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil mengubah foto'));
                redirect(base_url() . 'karyawan/edit/' . $id);
            } else {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal mengubah foto'));
                redirect(base_url() . 'karyawan/edit/' . $id);
            }
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal mengupload gambar'));
            redirect(base_url() . 'karyawan/edit/' . $id);
        }
    }

    public function changeInfoKaryawan()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $position = $this->input->post('position');
        $age = $this->input->post('age');
        $start_date = $this->input->post('start_date');
        $salary = $this->input->post('salary');
        $email = $this->input->post('email');
        $handphone = $this->input->post('handphone');
        $nik = $this->input->post('nik');
        $tentang = $this->input->post('tentang');
        if ($name && $position && $age && $start_date && $salary && $email && $handphone && $nik && $tentang) {
            $data = array(
                'name' => $name,
                'position' => $position,
                'age' => $age,
                'start_date' => $start_date,
                'salary' => $salary,
                'email' => $email,
                'handphone' => $handphone,
                'nik' => $nik,
                'tentang' => $tentang
            );
            $changeInfo = $this->karyawan->changeInfoKaryawanById($id, $data);
            if ($changeInfo == 1) {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil mengubah info'));
                redirect(base_url() . 'karyawan/edit/' . $id);
            } else {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal mengubah info'));
                redirect(base_url() . 'karyawan/edit/' . $id);
            }
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal mengubah info'));
            redirect(base_url() . 'karyawan/edit/' . $id);
        }
    }

    public function tambahKaryawan()
    {
        $name = $this->input->post('name');
        $position = $this->input->post('position');
        $age = $this->input->post('age');
        $start_date = $this->input->post('start_date');
        $salary = $this->input->post('salary');
        $email = $this->input->post('email');
        $handphone = $this->input->post('handphone');
        $nik = $this->input->post('nik');
        $password = md5($this->input->post('password'));
        $tentang = $this->input->post('tentang');
        $upload = $this->karyawan->uploadImage();
        if ($name && $position && $age && $start_date && $salary && $email && $handphone && $nik && $password && $tentang && $upload) {
            if ($upload['result'] == "success") {
                $data = array(
                    'name' => $name,
                    'position' => $position,
                    'age' => $age,
                    'start_date' => $start_date,
                    'salary' => $salary,
                    'email' => $email,
                    'handphone' => $handphone,
                    'nik' => $nik,
                    'tentang' => $tentang,
                    'image_name' => $upload['file']['file_name']
                );
                $addUserKaryawan = $this->karyawan->addUserKaryawan($nik, $password);
                $addDataKarywan = $this->karyawan->addDataKaryawan($data);
                $addAbsensiKaryawan = $this->karyawan->addAbsensiKaryawan(array('nama' => $name, 'hadir' => 0, 'tidak_hadir' => 0, 'izin' => 0));
                $addDaftarAbsen = $this->karyawan->addDaftarAbsen(array('nama' => $name, 'status' => 'Belum Absen'));
                if ($addUserKaryawan == 1 || $addDataKarywan == 1 || $addAbsensiKaryawan == 1 || $addDaftarAbsen == 1) {
                    $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan karyawan'));
                    redirect(base_url() . 'karyawan/tambah_karyawan');
                } else {
                    $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal menambahkan karyawan'));
                    redirect(base_url() . 'karyawan/tambah_karyawan');
                }
            } else {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal mengupload gambar'));
                redirect(base_url() . 'karyawan/tambah_karyawan');
            }
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal menambahkan karyawan'));
            redirect(base_url() . 'karyawan/tambah_karyawan');
        }
    }

    public function absensiKaryawan()
    {
        $name = $this->input->post('name');
        $kehadiran = $this->input->post('kehadiran');
        $jumlah = $this->input->post('jumlah');
        $alasan = $this->input->post('alasan');
        $date = date('d/m/Y');
        if ($name && $kehadiran && $jumlah && $alasan) {
            $absensiKaryawan = $this->karyawan->getAbsensiKaryawanByName($name);
            if ($absensiKaryawan[0]->id) {
                $updateAbsensiKaryawan = $this->karyawan->updateAbsensiKaryawan($absensiKaryawan[0]->id, $kehadiran, '+', $jumlah);
                $addAlasanKaryawan = $this->karyawan->addAlasanKaryawan($name, $alasan, $date);
                if ($updateAbsensiKaryawan == 1 || $addAlasanKaryawan == 1) {
                    $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambah absensi'));
                    redirect(base_url() . 'karyawan/absensi_karyawan');
                } else {
                    $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal menambah absensi'));
                    redirect(base_url() . 'karyawan/absensi_karyawan');
                }
            } else {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal menambah absensi'));
                redirect(base_url() . 'karyawan/absensi_karyawan');
            }
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal menambah absensi'));
            redirect(base_url() . 'karyawan/absensi_karyawan');
        }
    }
    public function absenMasuk()
    {
        $id = $this->uri->segment(3);
        $cekId = $this->karyawan->getDataKaryawanById($id);
        if ($cekId[0]->id) {
            $getSettingAbsensi = $this->karyawan->getSettingAbsensi();
            $start = $getSettingAbsensi[0]->mulai_absen;
            $end = $getSettingAbsensi[0]->selesai_absen;
            if (!(strtotime($start) <= time())) {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Waktu untuk absen belum di mulai'));
                redirect(base_url() . 'karyawan/absensi_karyawan');
            } elseif (!(time() >= strtotime($end))) {
                $absensiKaryawan = $this->karyawan->getAbsensiKaryawanById($id);
                if ($absensiKaryawan[0]->absen == 1) {
                    $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Sudah absen'));
                    redirect(base_url() . 'karyawan/absensi_karyawan');
                } else {
                    $absenHarian = $this->karyawan->absenHarian($id);
                    $tambahKehadiran = $this->karyawan->updateAbsensiKaryawan($id, 'hadir', '+', '1');
                    $daftarAbsen = $this->karyawan->absenMasuk($id);
                    if ($absenHarian && $tambahKehadiran && $daftarAbsen) {
                        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Absen berhasil'));
                        redirect(base_url() . 'karyawan/absensi_karyawan');
                    } else {
                        $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal untuk absen'));
                        redirect(base_url() . 'karyawan/absensi_karyawan');
                    }
                }
            } else {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Batas waktu untuk absen telah berakhir'));
                redirect(base_url() . 'karyawan/absensi_karyawan');
            }
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal untuk absen'));
            redirect(base_url() . 'karyawan/absensi_karyawan');
        }
    }
    public function absenPulang()
    {
        $id = $this->uri->segment(3);
        $cekId = $this->karyawan->getDataKaryawanById($id);
        if ($cekId[0]->id) {
            $getSettingAbsensi = $this->karyawan->getSettingAbsensi();
            $getSettingAbsensi[0]->mulai_absen;
            $end = $getSettingAbsensi[0]->selesai_absen;
            if (strtotime($end) >= time()) {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Waktu untuk absen belum di mulai'));
                redirect(base_url() . 'karyawan/absensi_karyawan');
            } elseif (time() >= strtotime($end)) {
                $absensiKaryawan = $this->karyawan->getAbsensiKaryawanById($id);
                if ($absensiKaryawan[0]->absen == 2) {
                    $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Sudah absen'));
                    redirect(base_url() . 'karyawan/absensi_karyawan');
                } else {
                    $tambahKehadiran = $this->karyawan->updateAbsensiKaryawan($id, 'hadir', '+', '1');
                    $absenHarian = $this->karyawan->absenHarian2($id);
                    $daftarAbsen = $this->karyawan->absenPulang($id);
                    if ($tambahKehadiran || $absenHarian || $daftarAbsen) {
                        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Absen berhasil'));
                        redirect(base_url() . 'karyawan/absensi_karyawan');
                    } else {
                        $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal untuk absen'));
                        redirect(base_url() . 'karyawan/absensi_karyawan');
                    }
                }
            } else {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Batas waktu untuk absen telah berakhir'));
                redirect(base_url() . 'karyawan/absensi_karyawan');
            }
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal untuk absen'));
            redirect(base_url() . 'karyawan/absensi_karyawan');
        }
    }
}
