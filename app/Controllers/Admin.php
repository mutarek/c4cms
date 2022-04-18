<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\RegisterModel;

class Admin extends Controller
{
    public function __construct() {
        helper('form');
        helper('date');
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
                    $to = $this->request->getVar('email');
                    $subject = 'Account Activation Link - Dhaka City';
                    $msg = "Hey!".$this->request->getVar('uname',FILTER_SANITIZE_STRING)."<br> <br> For Activate your valuable account . Please click the link below <br> <br>"
                    ."<a href='".base_url()."/admin/activate/".$uniid."'>Activate Now </a><br><br>";
                    $email = \Config\Services::email();
                    $email->setTo($to);
                    $email->setFrom('bangladeshtourist@gmail.com','Info');
                    $email->setSubject($subject);
                    $email->setMessage($msg);
                    if($email->send())
                    {
                        $session->setTempdata('smsg','Account Create Successfully,Please Activate your account',3);
                        return redirect()->to(current_url());
                    }
                    else
                    {
                        $data = $email->printDebugger(['headers']);
                        print_r($data);
                    }
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
    public function activate($uid=null)
    {
        $data = [];
        if(!empty($uid))
        {
            $rmodel = new RegisterModel();
            $result = $rmodel->verifyUniid($uid);
            if($result)
            {
                if($this->verifyTime($result->activation_date))
                {
                    echo "Okey";
                }
                else
                {
                    $data['errors'] = "Sorry! Your Activation Time is expired ,Contact Admin";
                }
            }
            else
            {
                $data['errors'] = "Sorry! Your Link is not Available";
            }
        }
        else
        {
            $data['errors'] = "Sorry! Unable to process your request";
        }
        return view('admin/activate_view',$data);
    }
    public function verifyTime($regtime)
    {
        $current_time = now();
        echo $current_time."<br>";
        $reg =  strtotime($regtime);
        echo $regtime."<br>";
        $differnce = $current_time - $reg;
        echo $differnce;
        
        if($differnce < 60)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}