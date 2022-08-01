<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transfer_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertTransfer($data) {
        $this->db->insert('transfer', $data);
    }

    function getTransfer() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('transfer');
        return $query->result();
    }

    function getTransferById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('transfer');
        return $query->row();
    }

    function updateTransfer($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('transfer', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('transfer');
    }

    function updateIonUser($username, $email, $password, $ion_user_id) {
        $uptade_ion_user = array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        );
        $this->db->where('id', $ion_user_id);
        $this->db->update('users', $uptade_ion_user);
    }
    function getTransferPatientBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->like('id', $search);
        $this->db->or_like('hospital', $search);
        // $this->db->or_like('patient', $search);
        $this->db->or_like('date', $search);
        $this->db->or_like('reason', $search);
        $this->db->or_like('patient_name', $search);
        $this->db->or_like('patient_id', $search);
        $this->db->or_like('patient_phone', $search);
        
        $query = $this->db->get('transfer');
        return $query->result();
    }
    function getTransferPatientWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'asc');
        }
        $query = $this->db->get('transfer');
        return $query->result();
    }
    function getTransferPatientByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->like('id', $search);
        $this->db->or_like('hospital', $search);
        // $this->db->or_like('patient', $search);
        $this->db->or_like('date', $search);
        $this->db->or_like('reason', $search);
        $this->db->or_like('patient_name', $search);
        $this->db->or_like('patient_id', $search);
        $this->db->or_like('patient_phone', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('transfer');
        return $query->result();
    }
    function getTransferPatientByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('transfer');
        return $query->result();
    }
}
