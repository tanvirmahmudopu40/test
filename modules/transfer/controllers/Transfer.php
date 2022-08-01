<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transfer extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('transfer_model');
        $this->load->model('patient/patient_model');
        if (!$this->ion_auth->in_group(array('admin', 'Nurse', 'Accountant', 'Doctor','Receptionist', 'Laboratorist', 'im', 'Patient'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $data['transfers'] = $this->transfer_model->getTransfer();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('transfer', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        // $data['transfers'] = $this->transfer_model->getTransfer();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {

        $id = $this->input->post('id');
        $hospital = $this->input->post('hospital');
        $patient = $this->input->post('patient');
        $date = $this->input->post('date');
        if (!empty($date)) {
            $date = strtotime($date);
        } else {
            $date = time();
        }
        $reason = $this->input->post('reason');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Title Field
        $this->form_validation->set_rules('hospital', 'Hospital Name', 'trim|required|min_length[1]|max_length[200]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('patient', 'Transfer Patient', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating date Field
        $this->form_validation->set_rules('date', 'date', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating date Field
        $this->form_validation->set_rules('reason', 'Reason', 'trim|min_length[1]|max_length[1000]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("transfer/editTransfer?id=$id");
            } else {
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {

            $data = array();
            $data = array(
                'hospital' => $hospital,
                'patient' => $patient,
                'date' => $date,
                'reason' => $reason
            );



            if (empty($id)) {     // Adding New Transfer
                $this->transfer_model->insertTransfer($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating Transfer
                $this->transfer_model->updateTransfer($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
         
            redirect('transfer'); 
        }
    }

    function getTransfer() {
        $data['transfers'] = $this->transfer_model->getTransfer();
        $this->load->view('transfer', $data);
    }

    function editTransfer() {
        $data = array();
        $id = $this->input->get('id');
        $data['transfer'] = $this->transfer_model->getTransferById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editTransferByJason() {
        $id = $this->input->get('id');
        $data['transfer'] = $this->transfer_model->getTransferById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $this->transfer_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('transfer');
    }
    function getPatientTransferList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "1" => "hospital",
            "2" => "patient",
            "3" => "reason",
            "4" => "date",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['transfer'] = $this->transfer_model->getTransferPatientBySearch($search, $order, $dir);
            } else {
                $data['transfer'] = $this->transfer_model->getTransferPatientWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['transfer'] = $this->transfer_model->getTransferPatientByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['transfer'] = $this->transfer_model->getTransferPatientByLimit($limit, $start, $order, $dir);
            }
        }
       
        $i = 0;
        foreach ($data['transfers'] as $transfer) {
            $i = $i + 1;
            $settings = $this->settings_model->getSettings();
          
            $load = '<button type="button" class="btn btn-info btn-xs btn_width load" data-toggle="modal" data-id="' . $medicine->id . '">' . lang('load') . '</button>';
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $medicine->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';

            $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="medicine/delete?id=' . $medicine->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            $info[] = array(
                $i,
                $transfer->hospital,
                $transfer->patient,
                date('d-m-Y', $transfer->date),
                
                $transfer->reason,
               
                $option1 . ' ' . $option2
                   
            );
        }

        if (!empty($data['transfers'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('transfers')->num_rows(),
                "recordsFiltered" => $this->db->get('transfers')->num_rows(),
                "data" => $info
            );
        } else {
            $output = array(
              
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }
}

/* End of file transfer.php */
/* Location: ./application/modules/transfer/controllers/transfer.php */
