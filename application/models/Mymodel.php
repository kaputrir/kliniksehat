<?php
    defined('BASEPATH') OR exit('No direct script access allowed.');
    
    class Mymodel extends CI_Model{
        public function Get($table)
        {
            $res = $this->db->get($table);
            return $res->result_array();
        }

        public function GetWhere($table, $data)
        {
            $res = $this->db->get_where($table, $data);
            return $res->result_array();
        }

        public function Insert($table, $data)
        {
            $res = $this->db->insert($table, $data);
            return $res;
        }

        public function Update($table, $data, $where)
        {
            $res = $this->db->update($table, $data, $where);
            return $res;
        }

        public function Delete($table, $where)
        {
            $res = $this->db->delete($table, $where);
            return $res;
        }

        public function GetDokterPasien($id_pasien)
        {
            $res = $this->db->query("SELECT pt.waktu_input_data, d.nama_dokter, d.hari_praktek, d.jam_praktek, d.foto, pt.id_dokter, pt.id_pasien_terdaftar FROM pasien_terdaftar pt JOIN dokter d ON pt.id_dokter = d.id_dokter WHERE pt.id_pasien='$id_pasien'");
            return $res->result_array();
        }

        public function email_ada_gak($email)
        {
            $sql = "SELECT count(email) as c FROM pasien WHERE email = '$email'";
            $query = $this->db->query($sql);
            $res = $query->result_array();
            return $res[0]['c'];
        }
    }
?>