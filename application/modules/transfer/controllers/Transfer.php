<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transfer extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('transfer_model');
        $this->load->model('patient/patient_model');
        if (!$this->ion_auth->in_group(array('admin', 'Doctor'))) {
            redirect('home/permission');
        }
    }

    public function index() {
        $data['patients'] = $this->patient_model->getPatient();
        $data['transfers'] = $this->transfer_model->getTransfer();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('transfer', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data['patients'] = $this->patient_model->getPatient();
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

        $p_name = $this->input->post('p_name');
        $p_email = $this->input->post('p_email');
        if (empty($p_email)) {
            $p_email = $p_name . '-' . rand(1, 1000) . '-' . $p_name . '-' . rand(1, 1000) . '@example.com';
        }
        if (!empty($p_name)) {
            $password = $p_name . '-' . rand(1, 100000000);
        }
        $p_phone = $this->input->post('p_phone');
        $p_age = $this->input->post('p_age');
        $p_gender = $this->input->post('p_gender');
        $patient_id = rand(10000, 1000000);
        // if ((empty($id))) {
            $add_date = date('m/d/y');
            $registration_time = time();
            $patient_add_date = $add_date;
            $patient_registration_time = $registration_time;
        // } else {
        //     $add_date = $this->appointment_model->getAppointmentById($id)->add_date;
        //     $registration_time = $this->appointment_model->getAppointmentById($id)->registration_time;
        // }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($patient == 'add_new') {
            $this->form_validation->set_rules('p_name', 'Patient Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('p_phone', 'Patient Phone', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        }
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
                $data['patients'] = $this->patient_model->getPatient();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            if ($patient == 'add_new') {

                $data_p = array(
                    'patient_id' => $patient_id,
                    'name' => $p_name,
                    'email' => $p_email,
                    'phone' => $p_phone,
                    'sex' => $p_gender,
                    'age' => $p_age,
                    'add_date' => $patient_add_date,
                    'registration_time' => $patient_registration_time,
                    'how_added' => 'from_appointment',
                    'payment_confirmation' => 'Active',
                    'appointment_confirmation' => 'Active',
                    'appointment_creation' => 'Active',
                    'meeting_schedule' => 'Active'
                );
                $username = $this->input->post('p_name');
                // Adding New Patient
                if ($this->ion_auth->email_check($p_email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                    
                        redirect('transfer');
                    
                } else {
                    $dfg = 5;
                    $this->ion_auth->register($username, $password, $p_email, $dfg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $p_email))->row()->id;
                    $this->patient_model->insertPatient($data_p);
                    $patient_user_id = $this->db->get_where('patient', array('email' => $p_email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->patient_model->updatePatient($patient_user_id, $id_info);
                }

                $patient = $patient_user_id;
            }

            $patientinfo = $this->patient_model->getPatientById($patient);
            // print_r($patientname);
            // die();
            $data = array();
            $data = array(
                'patient_name' => $patientinfo->name,
                'patient_email' => $patientinfo->email,
                'patient_phone' => $patientinfo->phone,
                'patient_address' => $patientinfo->address,
                'patient_age' => $patientinfo->age,
                'patient_gender' => $patientinfo->sex,
                'patient_id' => $patientinfo->patient_id,
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
        $data['patients'] = $this->patient_model->getPatient();
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
            "2" => "patient_name",
            "3" => "patient_id",
            "4" => "patient_phone",
            "5" => "date",
            "6" => "reason",
            
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['transfers'] = $this->transfer_model->getTransferPatientBySearch($search, $order, $dir);
            } else {
                $data['transfers'] = $this->transfer_model->getTransferPatientWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['transfers'] = $this->transfer_model->getTransferPatientByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['transfers'] = $this->transfer_model->getTransferPatientByLimit($limit, $start, $order, $dir);
            }
        }
       
        $i = 0;
        foreach ($data['transfers'] as $transfer) {
            $i = $i + 1;
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $transfer->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';
            $option2 = '<a class="btn btn-info btn-xs btn_width " href="transfer/viewDetails?id=' . $transfer->id . '" ><i class="fa fa-eye"> </i> ' . lang('view') . '</a>';           
            $option3 = '<a class="btn btn-info btn-xs btn_width delete_button" href="transfer/delete?id=' . $transfer->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            $info[] = array(
                $i,
                
                $transfer->hospital,
                $transfer->patient_name,
                $transfer->patient_id,
                $transfer->patient_phone,
                $transfer->reason,
                date('d-m-Y', $transfer->date),
                
                
                $option1 . ' ' . $option2. ' ' . $option3
                // $option1 . ' ' . $option3
                   
            );
        }

        if (!empty($data['transfers'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('transfer')->num_rows(),
                "recordsFiltered" => $this->db->get('transfer')->num_rows(),
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
    function viewDetails() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
       
        $data['transfer'] = $this->transfer_model->getTransferById($id);
        $data['redirectlink'] = '';
        $data['redirect'] = '';
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('view_details', $data);
        $this->load->view('home/footer'); // just the footer fi
    }
}

/* End of file transfer.php */
/* Location: ./application/modules/transfer/controllers/transfer.php */
