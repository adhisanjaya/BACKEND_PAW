<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class DoctorModel extends CI_Model 
{ 
    private $table = 'dokter'; 
    public $id; 
    public $name; 
    public $spesialis; 
    public $rumahSakit;
    public $rule = [ 
        [ 
            'field' => 'name', 
            'label' => 'name', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'spesialis', 
            'label' => 'spesialis', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'rumahSakit', 
            'label' => 'rumahSakit', 
            'rules' => 'required' 
        ]
    ]; 
    public function Rules() { return $this->rule; } 
    
    // public function getAll() { return 
    //     $this->db->get('data_mahasiswa')->result(); 
    // } 
    
    public function store($request) { 
        $this->name = $request->name; 
        $this->spesialis = $request->spesialis; 
        $this->rumahSakit = $request->rumahSakit;
        if($this->db->insert($this->table, $this)){ 
            return ['msg'=>'Berhasil','error'=>false];
        } 
        return ['msg'=>'Gagal','error'=>true]; 
    } 
    public function update($request,$id) { 
        $updateData = [
            'name' => $request->name,
            'spesialis' => $request->spesialis,
            'rumahSakit' => $request->rumahSakit,
        ]; 
        if($this->db->where('id',$id)->update($this->table, $updateData)){ 
            return ['msg'=>'Berhasil','error'=>false]; 
        } 
        return ['msg'=>'Gagal','error'=>true]; 
    } 
        
    public function destroy($id){ 
        if (empty($this->db->select('*')->where(array('id' => $id))->get($this->table)->row())) 
        return ['msg'=>'Id tidak ditemukan','error'=>true]; 
        if($this->db->delete($this->table, array('id' => $id))){ 
            return ['msg'=>'Berhasil','error'=>false]; 
        } 
        return ['msg'=>'Gagal','error'=>true]; 
    }

    // public function verify($request){
    //     $user = $this->db->select('*')->where(array('email' => $request->email))->get($this->table)->row_array();
    //     if(!empty($user) && password_verify($request->password , $user['password'])) {
    //         return $user;
    //     } else {
    //         return false;
    //     }
    // }
} 
?>