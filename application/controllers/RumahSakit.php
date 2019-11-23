<?php 
use Restserver \Libraries\REST_Controller ; 
Class RumahSakit extends REST_Controller{

    public function __construct(){ 
        header('Access-Control-Allow-Origin: *'); 
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE"); 
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding"); 
        parent::__construct(); $this->load->model('RumahSakitModel'); $this->load->library('form_validation'); 
    } 
    public function index_get(){ 
        return $this->returnData($this->db->get('rumahSakit')->result(), false); 
    } 
    public function index_post($id = null){ 
        $validation = $this->form_validation; 
        $rule = $this->RumahSakitModel->rules(); 
        if($id == null){ 
            array_push($rule,[ 
                'field' => 'name', 
                'label' => 'name', 
                'rules' => 'required' 
            ], 
            [ 
                'field' => 'alamat', 
                'label' => 'alamat', 
                'rules' => 'required' 
            ] ); 
        } 
        $validation->set_rules($rule); 
        if (!$validation->run()) { 
            return $this->returnData($this->form_validation->error_array(), true); 
        } 
        $rumahSakit = new RumahSakitData(); 
        $rumahSakit->name = $this->post('name'); 
        $rumahSakit->alamat = $this->post('alamat'); 
        if($id == null){ 
            $response = $this->RumahSakitModel->store($rumahSakit);
        }else{ 
            $response = $this->RumahSakitModel->update($rumahSakit,$id); 
        } 
        return $this->returnData($response['msg'], $response['error']); 
    } 
    public function index_delete($id = null){ 
        if($id == null){ 
            return $this->returnData('Parameter Id Tidak Ditemukan', true); 
        } 
        $response = $this->RumahSakitModel->destroy($id); 
        return $this->returnData($response['msg'], $response['error']); 
    } 
    public function returnData($msg,$error){ 
        $response['error']=$error; 
        $response['message']=$msg; 
        return $this->response($response); 
    } 
} 
Class RumahSakitData{ 
    public $name; 
    public $alamat; 
}