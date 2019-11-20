<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class SparepartModel extends CI_Model 
{ 
    private $table = 'spareparts'; 
    public $id; 
    public $name; 
    public $merk; 
    public $amount;
    public $created_at;
    public $rule = [ 
        [ 
            'field' => 'name', 
            'label' => 'name', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'merk', 
            'label' => 'merk', 
            'rules' => 'required' 
        ], 
        [ 
            'field' => 'amount', 
            'label' => 'amount', 
            'rules' => 'required' 
        ], 
    ]; 
    public function Rules() { return $this->rule; } 
    
    // public function getAll() { return 
    //     $this->db->get('data_mahasiswa')->result(); 
    // } 
    
    public function store($request) { 
        $now = date("Y-m-d H:i:s");
        $this->name = $request->name;
        $this->merk = $request->merk;
        $this->amount = $request->amount;
        $this->created_at = $now;
        if($this->db->insert($this->table, $this)){ 
            return ['msg'=>'Berhasil','error'=>false];
        } 
        return ['msg'=>'Gagal','error'=>true]; 
    } 
    public function update($request,$id) { 
        $updateData = ['name' => $request->name, 'merk' =>$request->merk, 'amount' =>$request->amount]; 
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