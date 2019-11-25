<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class AgreementModel extends CI_Model 
{ 
    private $table = 'agreement'; 
    public $id; 
    public $id_user; 
    public $id_dokter;
    public $tanggalJanji;
    public $id_rumahSakit;
    public $keluhan;
    public $rule = [ 
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
            'field' => 'tanggalJanji', 
            'label' => 'tanggalJanji', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'id_rumahSakit', 
            'label' => 'id_rumahSakit', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'keluhan', 
            'label' => 'keluhan', 
            'rules' => 'required' 
        ]
    ]; 
    public function Rules() { return $this->rule; } 
    
    // public function getAll() { return 
    //     $this->db->get('agreement')->result(); 
    // } 
    
    public function store($request) { 
        $this->id_user = $request->id_user; 
        $this->id_dokter = $request->id_dokter;
        $this->tanggalJanji = $request->tanggalJanji;
        $this->id_rumahSakit = $request->id_rumahSakit;
        $this->keluhan = $request->keluhan;
        if($this->db->insert($this->table, $this)){ 
            return ['msg'=>'Berhasil','error'=>false];
        } 
        return ['msg'=>'Gagal','error'=>true]; 
    } 
    public function update($request,$id) { 
        $updateData = [
            'id_user' => $request->id_user,
            'id_dokter' => $request->id_dokter,
            'tanggalJanji' => $request->tanggalJanji,
            'id_rumahSakit' => $request->id_rumahSakit,
            'keluhan'=>$request->keluhan,
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