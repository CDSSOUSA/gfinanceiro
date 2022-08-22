<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $users = [
            [

                'login' => 'cleber',
                'passwrd' => 'aaa'
            ],
            [
                'login' => 'diana',
                'passwrd' => 'bbb'
            ]
        ];

        $db = db_connect();

        foreach($users as $user){

            $params = [
                'login' => $user['login'],
                'passwrd' => password_hash($user['passwrd'],PASSWORD_DEFAULT)
            ];

            $db->query("INSERT INTO tb_users(login,passwrd ) VALUES (
                
                AES_ENCRYPT(:login:, UNHEX(SHA2('".AES_KEY."', 512))),
                 :passwrd:)", $params);
             
        }
    }
}
