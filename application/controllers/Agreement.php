<?php 
use Restserver \Libraries\REST_Controller ; 
Class Agreement extends REST_Controller{

    public function __construct(){ 
        header('Access-Control-Allow-Origin: *'); 
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE"); 
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding"); 
        parent::__construct(); $this->load->model('AgreementModel'); $this->load->library('form_validation'); 
    } 
    public function index_get($id = null){ 
        if($id==null)
        {
            $this->db->select('a.id, us.name as user_name, d.name as dokter_name, a.tanggalJanji as tanggalJanji, rs.name as rumahSakit_name, a.keluhan as keluhan');
            $this->db->from('agreement as a');
            $this->db->join('users as us', 'us.id = a.id_user');
            $this->db->join('dokter as d', 'd.id = a.id_rumahSakit');
            $this->db->join('rumahSakit as rs', 'rs.id = a.id_rumahSakit');
        }else{
            $this->db->select('a.id, us.name as user_name, d.name as dokter_name, a.tanggalJanji as tanggalJanji, rs.name as rumahSakit_name, a.keluhan as keluhan');
            $this->db->from('agreement as a');
            $this->db->join('users as us', 'us.id = a.id_User');
            $this->db->join('dokter as d', 'd.id = a.id_rumahSakit');
            $this->db->join('rumahSakit as rs', 'rs.id = a.id_rumahSakit');
            $this->db->where('a.id', $id);
        }
        
        $query=$this->db->get();
        $data=$query->result_array();
        return $this->returnData($data, false); 
    } 
    public function index_post($id = null){ 
        $validation = $this->form_validation; 
        $rule = $this->AgreementModel->rules(); 
        if($id == null){ 
            array_push($rule,
            [ 
                'field' => 'id_user', 
                'label' => 'id_user', 
                'rules' => 'required' 
            ],
            [ 
                'field' => 'id_dokter', 
                'label' => 'id_dokter', 
                'rules' => 'required' 
            ],
            [ 
                'field' => 'id_rumahSakit', 
                'label' => 'id_rumahSakit', 
                'rules' => 'required' 
            ] 
            ); 
        } else{ 
            array_push($rule, 
            [ 
                'field' => 'id_user', 
                'label' => 'id_user', 
                'rules' => 'required' 
            ],
            [ 
                'field' => 'id_dokter', 
                'label' => 'id_dokter', 
                'rules' => 'required' 
            ],
            [ 
                'field' => 'id_rumahSakit', 
                'label' => 'id_rumahSakit', 
                'rules' => 'required' 
            ] 
            ); 
        } 
        $validation->set_rules($rule);
        if (!$validation->run()) { 
            return $this->returnData($this->form_validation->error_array(), true); 
        } 
        $agreement = new AgreementData(); 
        $agreement->id_user = $this->post('id_user'); 
        $agreement->id_dokter = $this->post('id_dokter');
        $agreement->tanggalJanji = $this->post('tanggalJanji');
        $agreement->id_rumahSakit = $this->post('id_rumahSakit');
        $agreement->keluhan = $this->post('keluhan');
        if($id == null){ 
            $response = $this->AgreementModel->store($agreement);
        }else{ 
            $response = $this->AgreementModel->update($agreement,$id); 
        } 
        return $this->returnData($response['msg'], $response['error']); 
    } 
    public function index_delete($id = null){ 
        if($id == null){ 
            return $this->returnData('Parameter Id Tidak Ditemukan', true); 
        } 
        $response = $this->AgreementModel->destroy($id); 
        return $this->returnData($response['msg'], $response['error']); 
    } 
    public function returnData($msg,$error){ 
        $response['error']=$error; 
        $response['message']=$msg; 
        return $this->response($response); 
    } 
} 
Class AgreementData{ 
    public $id_user; 
    public $id_dokter;
    public $tanggalJanji;
    public $id_rumahSakit;
    public $keluhan;
}