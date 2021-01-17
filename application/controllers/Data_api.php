<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_api extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('mymodel');
    }

    function index()
    {
        //$pasien = $this->mymodel->Get('pasien');
        //$pasien = $this->db->query('SELECT username, email FROM pasien')->result();

        $id_pasien = $this->input->get('id_pasien');
        if($id_pasien=='')
        {
            $pasien = $this->mymodel->Get('pasien');
        }
        else
        {
            $pasien = $this->mymodel->GetWhere('pasien', array('id_pasien'=>$id_pasien));
        }

        echo json_encode($pasien);
    }

    function daftar_pasien()
    {
        $this->load->model('mymodel');
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password'))
            );

            $query = $this->mymodel->Insert('pasien', $data);

            if($query)
            {
                $hasil = array('status'=>'Berhasil daftar pasien!');
                echo json_encode($hasil);
            }
            else
            {
                $hasil = array('status'=>'Gagal daftar pasien!');
                echo json_encode($hasil);
            }    
    }

    function update_username_relawan()
    {
        $this->load->model('mymodel');

            if(empty($this->input->post('password')))
            {
                $password = $this->input->post('passwordSebelum');
            }
            else
            {
                $password = md5($this->input->post('password'));
            }

            $data = array(
                'username' => $this->input->post('username')
            );

            $where = array(
                'id_pasien' => $this->input->post('id_pasien')
            );

            $query = $this->mymodel->Update('pasien', $data, $where);
            if($query)
            {
                $hasil = array('status'=>'Berhasil edit username pasien!');
                echo json_encode($hasil);
            }
            else
            {
                $hasil = array('status'=>'Gagal edit username pasien!');
                echo json_encode($hasil);
            }    
    }

    function hapus_pasien($id_pasien)
    {        
        $id_pasien = array(
            'id_pasien' => $id_pasien
        );

        $query = $this->mymodel->Delete('pasien', $id_pasien);
        if($query)
        {
            $hasil = array('status' => 'Berhasil Hapus Pasien!');
            echo json_encode($hasil);
        }
        else
        {
            $hasil = array('status' => 'Gagal Hapus Pasien!');
            echo json_encode($hasil);
        }
    }
}
?>