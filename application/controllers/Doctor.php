<?php 
use Restserver \Libraries\REST_Controller ; 
Class Doctor extends REST_Controller{

    public function __construct(){ 
        header('Access-Control-Allow-Origin: *'); 
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE"); 
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding"); 
        parent::__construct(); $this->load->model('DoctorModel'); $this->load->library('form_validation'); 
    } 
    public function index_get($id = null){ 
        if($id==null)
        {
            $this->db->select('d.id, d.name as name, d.spesialis as spesialis, rs.name as rumahSakit_name, d.image as image');
            $this->db->from('dokter as d');
            $this->db->join('rumahSakit as rs', 'rs.id = d.id_rumahSakit');
        }else{
            $this->db->select('d.id, d.name as name, d.spesialis as spesialis, rs.name as rumahSakit_name, d.image as image');
            $this->db->from('dokter as d');
            $this->db->join('rumahSakit as rs', 'rs.id = d.id_rumahSakit');
            $this->db->where('d.id', $id);
        }
        
        $query=$this->db->get();
        $data=$query->result_array();
        return $this->returnData($data, false); 
    } 
    public function index_post($id = null){ 
        $validation = $this->form_validation; 
        $rule = $this->DoctorModel->rules(); 
        if($id == null){ 
            array_push($rule,[ 
                'field' => 'id_rumahSakit', 
                'label' => 'id_rumahSakit', 
                'rules' => 'required' 
            ] ); 
        } else{ 
            array_push($rule, [ 
                'field' => 'id_rumahSakit', 
                'label' => 'id_rumahSakit', 
                'rules' => 'required' 
            ] ); 
        } 
        $validation->set_rules($rule);
        if (!$validation->run()) { 
            return $this->returnData($this->form_validation->error_array(), true); 
        } 
        $doctor = new DoctorData(); 
        $doctor->name = $this->post('name'); 
        $doctor->spesialis = $this->post('spesialis'); 
        $doctor->id_rumahSakit = $this->post('id_rumahSakit');
        $doctor->image = $this->post('image');
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
    public $id_rumahSakit;
    public $image;
}