<?php
    defined('BASEPATH') OR exit('No direct script access allowed.');
    
    class Dashboardpasien extends CI_Controller{
        public function index()
        {
            if(!empty($this->session->userdata('id_pasien')))
            {
                $this->load->view('pasien/index');
            }
            else
            {
                $this->session->sess_destroy();
                redirect(base_url());
            }
        }

        public function logout()
        {
            $this->session->sess_destroy();
            redirect(base_url());
        }

        public function profil($id_pasien)
        {
            $this->load->model('mymodel');

            $pasien = $this->mymodel->GetWhere('pasien', array('id_pasien'=>$id_pasien));
            $data = array(
                'id_pasien'=>$id_pasien,
                'username'=>$pasien[0]['username'],
                'email'=>$pasien[0]['email'],
                'password'=>$pasien[0]['password'],
                'nama_lengkap_pasien'=>$pasien[0]['nama_lengkap_pasien'],
                'tempat_lahir'=>$pasien[0]['tempat_lahir'],
                'tanggal_lahir'=>$pasien[0]['tanggal_lahir'],
                'alamat_pasien'=>$pasien[0]['alamat_pasien'],
                'no_hp'=>$pasien[0]['no_hp'],
            );

            $this->load->view('pasien/profil', $data);
        }

        public function proses_edit_profil($id_pasien)
        {
            $this->load->model('mymodel');
            
            $data = array(
                'username'=>$this->input->post('username'),
                'nama_lengkap_pasien'=>$this->input->post('nama_lengkap_pasien'),
                'tempat_lahir'=>$this->input->post('tempat_lahir'),
                'tanggal_lahir'=>$this->input->post('tanggal_lahir'),
                'alamat_pasien'=>$this->input->post('alamat_pasien'),
                'no_hp'=>$this->input->post('no_hp')
            );

            $where = array(
                'id_pasien' => $id_pasien
            );
            //var_dump($data);

            $query = $this->mymodel->Update('pasien', $data, $where);
            if($query)
            {
                echo "<script>alert('Edit Profil Sukses!')</script>";
                $this->profil($id_pasien);
            }
            else
            {
                echo "<script>alert('Edit Profil Gagal!')</script>";
                $this->profil($id_pasien);
            }
        }

        public function dokter($id_pasien)
        {
            $this->load->model('mymodel');

            $dokter_pasien = $this->mymodel->GetDokterPasien($id_pasien);
            $data = array('data'=>$dokter_pasien);

            $this->load->view('pasien/dokter', $data);
        }

        public function hapus_dokter($id_pasien_terdaftar)
        {
            $this->load->model('mymodel');
            $id_pasien_terdaftar = array(
                'id_pasien_terdaftar' => $id_pasien_terdaftar
            );

            $query = $this->mymodel->Delete('pasien_terdaftar', $id_pasien_terdaftar);
            if($query)
            {
                echo "<script>alert('Hapus Dokter Sukses!')</script>";
                $this->dokter($this->session->userdata('id_pasien'));
            }
            else
            {
                echo "<script>alert('Hapus Dokter Gagal!')</script>";
                $this->dokter($this->session->userdata('id_pasien'));
            }
        }

        public function daftar_dokter($id_pasien)
        {
            $this->load->model('mymodel');

            $dokter = $this->mymodel->Get('dokter');
            $data = array('data'=>$dokter);

            $this->load->view('pasien/daftar_dokter', $data);
        }

        public function proses_daftar_dokter($id_pasien)
        {
            $this->load->model('mymodel');

            $data = array(
                'id_pasien' => $id_pasien,
                'id_dokter' => $this->input->post('dokter')
            );

            $query = $this->mymodel->Insert('pasien_terdaftar', $data);
            if($query)
            {
                echo "<script>alert('Daftar Dokter Sukses!')</script>";
                $this->dokter($id_pasien);
            }
            else
            {
                echo "<script>alert('Daftar Dokter Gagal!')</script>";
                $this->daftar_dokter($id_pasien);
            }
        }
    }
?>