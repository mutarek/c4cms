<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\RegisterModel;

class Admin extends Controller
{
    public function __construct() {
        helper('form');
    }
    public function index()
    {
        return view('admin/login');
    }
    public function register()
    {
        $session = session();
        $data = [];
        $rules = [
            'uname'=> 'required|min_length[4]',
            'email'=> 'required|valid_email|is_unique[users.email]',
            'psw'=> 'required',
            'number'=> 'required',
        ];
        if($this->request->getMethod() == 'post')
        {
            if($this->validate($rules))
            {
                $uniid = md5(str_shuffle('abcdefghijklmnopqrst'.time()));
                $mydata = [
                    'username'=>$this->request->getVar('uname',FILTER_SANITIZE_STRING),
                    'email'=>$this->request->getVar('email'),
                    'password'=> password_hash($this->request->getVar('psw'),PASSWORD_DEFAULT),
                    'mobile'=>$this->request->getVar('number'),
                    'uid'=> $uniid,
                    'activation_date'=> date("Y-m-d h:i:s"),
                ];
                $registermodel = new RegisterModel();
                $response = $registermodel->insert_data($mydata);
                if($response)
                {
                    $session->setTempdata('smsg',"Success",3);
                    return redirect()->to(current_url());
                }
                else
                {
                    $session->setTempdata('wmsg',"Error",3);
                    return redirect()->to(current_url());
                }
            }
            else
            {
                $data['validators'] = $this->validator;
            }
        }
        return view('admin/register',$data);
    }
}