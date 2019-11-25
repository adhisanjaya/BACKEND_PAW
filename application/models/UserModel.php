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
    public $user_type;
    public $created_at;
    public $image;
    public $rule = [ 
        [ 
            'field' => 'email', 
            'label' => 'email', 
            'rules' => 'required' 
        ],
    ]; 
    public function Rules() { return $this->rule; } 
    
    public function getAll() { return 
        $this->db->get($this->table)->result();
    } 
    
    public function store($request) { 
        $this->name = $request->name; 
        $this->email = $request->email; 
        $this->password = password_hash($request->password, PASSWORD_BCRYPT);
        $this->tempatLahir = $request->tempatLahir;
        $this->tanggalLahir = $request->tanggalLahir;
        $this->umur = $request->umur;
        $this->jenisKelamin = $request->jenisKelamin;
        $this->bpjs = $request->bpjs;
        $this->created_at = $request->created_at;
        $this->user_type = $request->user_type;
        $this->image = 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1024px-User_icon_2.svg.png';
        if($this->db->insert($this->table, $this)){ 
            return ['msg'=>'Berhasil Simpan User','error'=>false];
        } 
        return ['msg'=>'Gagal Simpan User','error'=>true]; 
    } 
    public function update($request,$id) { 
        $updateData = [
            'email' => $request->email, 
            'name' => $request->name,
            'tempatLahir' => $request->tempatLahir,
            'tanggalLahir' => $request->tanggalLahir,
            'umur' => $request->umur,
            'jenisKelamin' => $request->jenisKelamin,
            'bpjs' => $request->bpjs,
            'image'=>$request->image ,
            'user_type'=>$request->user_type];
        if($this->db->where('id',$id)->update($this->table, $updateData)){ 
            return ['msg'=>'Berhasil Update User','error'=>false]; 
        } 
        return ['msg'=>'Gagal Update User','error'=>true]; 
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