<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leavemanager extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('leavemanager_model');
        $this->load->model('patient/patient_model');
        $this->load->model('doctor/doctor_model');
        if (!$this->ion_auth->in_group(array('admin', 'Doctor'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('leavemanager', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {

        $id = $this->input->post('id');
        $patient = $this->input->post('patient');
        $doctor = $this->input->post('doctor');
        if ((empty($id))) {
            $add_date = time();
        } else {
            $add_date = $this->db->get_where('leavemanager', array('id' => $id))->row()->add_date;
        }
        $start_date = $this->input->post('start_date');
        if (!empty($start_date)) {
            $start_date = strtotime($start_date);
        } else {
            $start_date = time();
        }
        $end_date = $this->input->post('end_date');
        if (!empty($end_date)) {
            $end_date = strtotime($end_date);
        } else {
            $end_date = time();
        }
        $company = $this->input->post('company');
        $diagnosis = $this->input->post('diagnosis');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Title Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[1]|max_length[300]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('doctor', 'Doctor', 'trim|required|min_length[1]|max_length[300]|xss_clean');
        // Validating Title Field
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|min_length[1]|max_length[300]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('end_date', 'End Date', 'trim|required|min_length[1]|max_length[300]|xss_clean');
        // Validating Title Field
        $this->form_validation->set_rules('company', 'Company', 'trim|min_length[1]|max_length[300]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('diagnosis', 'Diagnosis', 'trim|min_length[1]|max_length[1000]|xss_clean');
        

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("leavemanager/editLeavemanager?id=$id");
            } else {
                $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $patientname = $this->patient_model->getPatientById($patient)->name;
            $doctorname = $this->doctor_model->getDoctorById($doctor)->name;
            $data = array();
            $data = array(
                'patient' => $patient,
                'doctor' => $doctor,
                'patient_name' => $patientname,
                'doctor_name' => $doctorname,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'company' => $company,
                'diagnosis' => $diagnosis,
                'add_date' => $add_date
            );



            if (empty($id)) {     // Adding New Leavemanager
                $this->leavemanager_model->insertLeavemanager($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating Leavemanager
                $this->leavemanager_model->updateLeavemanager($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
         
            redirect('leavemanager'); 
        }
    }

    function getLeavemanager() {
        $data['leavemanagers'] = $this->leavemanager_model->getLeavemanager();
        $this->load->view('leavemanager', $data);
    }

    function editLeavemanager() {
        $data = array();
        $id = $this->input->get('id');
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['leavemanager'] = $this->leavemanager_model->getLeavemanagerById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editLeavemanagerByJason() {
        $id = $this->input->get('id');
        $data['leavemanager'] = $this->leavemanager_model->getLeavemanagerById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $this->leavemanager_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('leavemanager');
    }
    function getLeavemanagerList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "1" => "patient_name",
            "2" => "doctor_name",
            "3" => "company",
            "4" => "diagnosis",
            
            
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['leavemanagers'] = $this->leavemanager_model->getLeavemanagerBySearch($search, $order, $dir);
            } else {
                $data['leavemanagers'] = $this->leavemanager_model->getLeavemanagerWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['leavemanagers'] = $this->leavemanager_model->getLeavemanagerByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['leavemanagers'] = $this->leavemanager_model->getLeavemanagerByLimit($limit, $start, $order, $dir);
            }
        }
       
        $i = 0;
        foreach ($data['leavemanagers'] as $leavemanager) {
            $i = $i + 1;
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $leavemanager->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';
            $option2 = '<a class="btn btn-info btn-xs btn_width " href="leavemanager/viewDetails?id=' . $leavemanager->id . '" ><i class="fa fa-eye"> </i> ' . lang('view') . '</a>';
            $option3 = '<a class="btn btn-info btn-xs btn_width delete_button" href="leavemanager/delete?id=' . $leavemanager->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            $info[] = array(
                $i,
                
                $leavemanager->patient_name,
                $leavemanager->doctor_name,
                date('d-m-Y', $leavemanager->start_date),
                date('d-m-Y', $leavemanager->end_date),
                $leavemanager->company,
                
                
                
               
                $option1 . ' ' . $option2. ' ' . $option3
                   
            );
        }

        if (!empty($data['leavemanagers'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('leavemanager')->num_rows(),
                "recordsFiltered" => $this->db->get('leavemanager')->num_rows(),
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
       
        $data['leavemanager'] = $this->leavemanager_model->getLeavemanagerById($id);
        $data['redirectlink'] = '';
        $data['redirect'] = '';
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('view_details', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function download() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['leavemanager'] = $this->leavemanager_model->getLeavemanagerById($id);
        $settings1 = $this->settings_model->getSettings();
        error_reporting(0);
        $data['redirect'] = 'download';
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
        $mpdf->SetHTMLFooter('
      <div style="text-align:right;font-weight: bold; 
    font-size: 8pt;
    font-style: italic;">
     ' . lang('user') . ' : ' . $this->ion_auth->user($data['leavemanager']->user)->row()->username . '
      </div>', 'O');

        $html = $this->load->view('view_details', $data, true);

        $mpdf->WriteHTML($html);

        $filename = "leave--00" . $id . ".pdf";
        $mpdf->Output($filename, 'D');
    }
}

/* End of file leavemanager.php */
/* Location: ./application/modules/leavemanager/controllers/leavemanager.php */
