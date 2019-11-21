<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class UserModel extends CI_Model 
{ 
    private $table = 'users'; 
    public $id; 
    public $name; 
    public $email; 
    public $password;
    public $tempatLahir;
    public $tanggalLahir;
    public $umur;
    public $jenisKelamin;
    public $bpjs;
    public $rule = [ 
        [ 
            'field' => 'name', 
            'label' => 'name', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'email', 
            'label' => 'email', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'password', 
            'label' => 'password', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'tempatLahir', 
            'label' => 'tempatLahir', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'tanggalLahir', 
            'label' => 'tanggalLahir', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'umur', 
            'label' => 'umur', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'jenisKelamin', 
            'label' => 'jenisKelamin', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'bpjs', 
            'label' => 'bpjs', 
            'rules' => 'required' 
        ],
    ]; 
    public function Rules() { return $this->rule; } 
    
    // public function getAll() { return 
    //     $this->db->get('data_mahasiswa')->result(); 
    // } 
    
    public function store($request) { 
        $this->name = $request->name; 
        $this->email = $request->email; 
        $this->password = password_hash($request->password, PASSWORD_BCRYPT);
        $this->tempatLahir = $request->tempatLahir;
        $this->tanggalLahir = $request->tanggalLahir;
        $this->umur = $request->umur;
        $this->jenisKelamin = $request->jenisKelamin;
        $this->bpjs = $request->bpjs;
        if($this->db->insert($this->table, $this)){ 
            return ['msg'=>'Berhasil','error'=>false];
        } 
        return ['msg'=>'Gagal','error'=>true]; 
    } 
    public function update($request,$id) { 
        $updateData = [
            'email' => $request->email, 
            'name' => $request->name,
            'tempatLahir' => $request->tempatLahir,
            'tanggalLahir' => $request->tanggalLahir,
            'umur' => $request->umur,
            'jenisKelamin' => $request->jenisKelamin,
            'bpjs' => $request->bpjs
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

    public function verify($request){
        $user = $this->db->select('*')->where(array('email' => $request->email))->get($this->table)->row_array();
        if(!empty($user) && password_verify($request->password , $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }
} 
?>