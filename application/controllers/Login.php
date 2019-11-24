<?php

use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin:*');
        header("Access-Control-Allow-Methods:GET,OPTIONS,POST,DELETE");
        header("Access-Control-Allow-Headers:Content-Type,Content-Length,Accept-Encoding,Authorization");

        parent::__construct();
        $this->load->model('UserModel');
        $this->load->library('form_validation');
        $this->load->helper(['jwt', 'authorization']);
    }
    public function Rules()
    {
        return [
            [
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required'
            ],
            [
                'field' => 'email',
                'label' => 'email',
                'rules' => 'required|valid_email'
            ]
        ];
    }

    public function index_post()
    {
        $validation = $this->form_validation;
        $rule = $this->Rules();
        $validation->set_rules($rule);
        if (!$validation->run()) {
            return $this->response($this->form_validation->error_array());
        }
        $user = new UserData();
        $user->password = $this->post('password');
        $user->email = $this->post('email');

        if ($result = $this->UserModel->verify($user)) { 
            // return $this->response($result);
            $token = AUTHORIZATION::generateToken(['id' => $result['id'], 'name' => $result['name']]);
            $status = parent::HTTP_OK;

            // $result_all = $this->UserModel->getAll();
            $response = [
                'status' => $status, 
                'token' => $token, 
                'user_type' => $result['user_type'
            ], 
            'id'=>$result['id'],
            'name' => $result['name'], 
            'email' => $result['email'],
            'tempatLahir' => $result['tempatLahir'],
            'tanggalLahir' => $result['tanggalLahir'],
            'umur' => $result['umur'],
            'jenisKelamin' => $result['jenisKelamin'],
            'bpjs' => $result['bpjs'],
            'created_at' => $result['created_at'],
            'image'=>$result['image']];
            return $this->response($response, $status);
        } else {
            return $this->response('gagal');
        }
    }
}
class UserData
{
    public $name;
    public $email;
    public $password;
    public $tempatLahir;
    public $tanggalLahir;
    public $umur;
    public $jenisKelamin;
    public $bpjs;
}