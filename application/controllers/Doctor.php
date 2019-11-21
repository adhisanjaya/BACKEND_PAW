<?php 
use Restserver \Libraries\REST_Controller ; 
Class Doctor extends REST_Controller{

    public function __construct(){ 
        header('Access-Control-Allow-Origin: *'); 
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE"); 
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding"); 
        parent::__construct(); $this->load->model('DoctorModel'); $this->load->library('form_validation'); 
    } 
    public function index_get(){ 
        return $this->returnData($this->db->get('dokter')->result(), false); 
    } 
    public function index_post($id = null){ 
        $validation = $this->form_validation; 
        $rule = $this->DoctorModel->rules(); 
        if($id == null){ 
            // array_push($rule,[ 
            //     'field' => 'password', 
            //     'label' => 'password', 
            //     'rules' => 'required' 
            // ], 
            // [ 
            //     'field' => 'email', 
            //     'label' => 'email', 
            //     'rules' => 'required|valid_email|is_unique[users.email]' 
            // ] ); 
        } else{ 
            // array_push($rule, [ 
            //     'field' => 'email', 
            //     'label' => 'email', 
            //     'rules' => 'required|valid_email' 
            // ] ); 
        } 
        $validation->set_rules($rule); 
        if (!$validation->run()) { 
            return $this->returnData($this->form_validation->error_array(), true); 
        } 
        $doctor = new DoctorData(); 
        $doctor->name = $this->post('name'); 
        $doctor->spesialis = $this->post('spesialis'); 
        $doctor->rumahSakit = $this->post('rumahSakit');
        if($id == null){ 
            $response = $this->DoctorModel->store($doctor);
        }else{ 
            $response = $this->DoctorModel->update($doctor,$id); 
        } 
        return $this->returnData($response['msg'], $response['error']); 
    } 
    public function index_delete($id = null){ 
        if($id == null){ 
            return $this->returnData('Parameter Id Tidak Ditemukan', true); 
        } 
        $response = $this->DoctorModel->destroy($id); 
        return $this->returnData($response['msg'], $response['error']); 
    } 
    public function returnData($msg,$error){ 
        $response['error']=$error; 
        $response['message']=$msg; 
        return $this->response($response); 
    } 
} 
Class DoctorData{ 
    public $name; 
    public $spesialis; 
    public $rumahSakit;
}