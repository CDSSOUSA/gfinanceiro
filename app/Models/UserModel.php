<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function verify_login ($login, $password)
    {
        $params = [
            'login' => $login
        ];

        $db = db_connect();
        $results = $db->query("SELECT id, passwrd, ".$this->aes_decrypt('login')." login FROM tb_users WHERE {$this->aes_encrypt(':login:')} = login", $params)->getResultArray();
       //dd($results);
        
       if(count($results) === [] || !password_verify($password, $results[0]['passwrd'])){
           return [
               'status' => false                  
            ];
        }
        return $a = [
            'status' => true,
            'id' => $results[0]['id'],   
            'login' => ($results[0]['login'])
        ];
       
        // return count($results) == 0 ?  false: password_verify($password, $results[0]['passwrd']);
    }

    private function aes_encrypt($fieldValue)
    {
        return "AES_ENCRYPT($fieldValue, UNHEX(SHA2('".AES_KEY."',512)))";
    }

    private function aes_decrypt($fieldValue)
    {
        
        return "AES_DECRYPT($fieldValue, UNHEX(SHA2('".AES_KEY."',512)))";
    }
}
