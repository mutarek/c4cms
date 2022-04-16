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
}