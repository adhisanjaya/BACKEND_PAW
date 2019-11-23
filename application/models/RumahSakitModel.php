<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class RumahSakitModel extends CI_Model 
{ 
    private $table = 'rumahSakit'; 
    public $id; 
    public $name; 
    public $alamat; 
    public $rule = [ 
        [ 
            'field' => 'name', 
            'label' => 'name', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'alamat', 
            'label' => 'alamat', 
            'rules' => 'required' 
        ]
    ]; 
    public function Rules() { return $this->rule; } 
    
    // public function getAll() { return 
    //     $this->db->get('data_mahasiswa')->result(); 
    // } 
    
    public function store($request) { 
        $this->name = $request->name; 
        $this->alamat = $request->alamat;
        if($this->db->insert($this->table, $this)){ 
            return ['msg'=>'Berhasil','error'=>false];
        } 
        return ['msg'=>'Gagal','error'=>true]; 
    } 
    public function update($request,$id) { 
        $updateData = [
            'name' => $request->name,
            'alamat' => $request->alamat
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