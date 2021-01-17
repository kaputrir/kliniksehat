<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Depan extends CI_Controller {

	public function index()
	{
		$this->load->view('index');
    }
    
    public function login()
	{
		$this->load->view('login');
    }
    
    public function proses_daftar_pasien()
    {
        $this->load->model('mymodel');
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password'))
            );
            //var_dump($data);

            $query = $this->mymodel->Insert('pasien', $data);

            if($query)
            {
                echo "<script>alert('Daftar Pasien Sukses!')</script>";
                $this->index();
            }
            else
            {
                echo "<script>alert('Daftar Pasien Gagal!')</script>";
                $this->load->view('index');
            }
    }

    public function proses_login_pasien()
    {
        $this->load->model('mymodel');

            $where = array(
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password'))
            );

            $cek = $this->mymodel->GetWhere('pasien', $where);
            //var_dump($where);
            
            $count_cek = count($cek);
            if($count_cek>0)
            {
                $data_session = array(
                    'id_pasien' => $cek[0]['id_pasien'],
                    'username' => $cek[0]['username']
                );
                $this->session->set_userdata($data_session);
                echo "<script>alert('Login Pasien Sukses!')</script>";
                redirect(base_url("index.php/dashboardpasien"));
            }
            else
            {
                echo "<script>alert('Login Pasien Gagal!')</script>";
                $this->index();
            }
    }

    function email_ada()
    {
        $this->load->model('mymodel');
        $email = $this->input->post('email');
        
        if($this->mymodel->email_ada_gak($email)>0)
        {
            echo '1';
        }
        else
        {
            echo '0';
        }
    }
}
