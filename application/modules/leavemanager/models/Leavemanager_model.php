<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leavemanager_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertLeavemanager($data) {
        $this->db->insert('leavemanager', $data);
    }

    function getLeavemanager() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('leavemanager');
        return $query->result();
    }

    function getLeavemanagerById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('leavemanager');
        return $query->row();
    }

    function updateLeavemanager($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('leavemanager', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('leavemanager');
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
    function getLeavemanagerBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->like('id', $search);
        $this->db->or_like('patient_name', $search);
        $this->db->or_like('doctor_name', $search);
        $this->db->or_like('company', $search);
        $this->db->or_like('start_date', $search);
        $this->db->or_like('end_date', $search);
        
        
        $query = $this->db->get('leavemanager');
        return $query->result();
    }
    function getLeavemanagerWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'asc');
        }
        $query = $this->db->get('leavemanager');
        return $query->result();
    }
    function getLeavemanagerByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->like('id', $search);
        $this->db->or_like('patient_name', $search);
        $this->db->or_like('doctor_name', $search);
        $this->db->or_like('company', $search);
        $this->db->or_like('start_date', $search);
        $this->db->or_like('end_date', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('leavemanager');
        return $query->result();
    }
    function getLeavemanagerByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('leavemanager');
        return $query->result();
    }
}
