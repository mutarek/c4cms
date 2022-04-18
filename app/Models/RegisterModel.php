<?php
namespace App\Models;
use CodeIgniter\Model;

class RegisterModel extends Model
{
    public function insert_data($data)
    {
        $db = \Config\Database::connect();
        $res = $db->table('users')->insert($data);
        if($res)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function verifyUniid($uuid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('activation_date,uid,status');
        $builder->where('uid',$uuid);
        $result = $builder->get();
        if($builder->countAll() == 1)
        {
            return $result->getRow();
        }
        else
        {
            return false;
        }

    }
}