<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class DoctorModel extends CI_Model 
{ 
    private $table = 'dokter'; 
    public $id; 
    public $name; 
    public $spesialis; 
    public $id_rumahSakit;
    public $image;
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
            'field' => 'id_rumahSakit', 
            'label' => 'id_rumahSakit', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'image', 
            'label' => 'image', 
            'rules' => 'required' 
        ]
    ]; 
    public function Rules() { return $this->rule; } 
    
    public function getAll() { return 
        $this->db->get('dokter')->result(); 
    } 
    
    public function store($request) { 
        $this->name = $request->name; 
        $this->spesialis = $request->spesialis; 
        $this->id_rumahSakit = $request->id_rumahSakit;
        $this->image= $request->image;
        if($this->db->insert($this->table, $this)){ 
            return ['msg'=>'Berhasil','error'=>false];
        } 
        return ['msg'=>'Gagal','error'=>true]; 
    } 
    public function update($request,$id) { 
        $updateData = [
            'name' => $request->name,
            'spesialis' => $request->spesialis,
            'id_rumahSakit' => $request->id_rumahSakit,
            'image'=>$request->image,
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


} 
?>