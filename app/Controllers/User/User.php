<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    
    private $erros = [];
    private $userModel;   

    public function __construct()
    {
        $this->userModel = new UserModel();        
    }

    public function add()
    {
        $msg = [
            'status' => '',
            'message' => '',
            'alert' => '',
        ];

        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msg['status'] = $this->statusErro;
            $msg['message'] = 'Erro(s) no preenchimento do formulário!';
            $msg['alert'] = 'danger';
        }
        $data = array(
            'title_page' => 'Cadastrar conta usuário',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,            
            'erro' => $this->erros,           
            
        );

        return view('user/form/add', $data);
    }

    public function forgot()
    {
        $msg = [
            'status' => '',
            'message' => '',
            'alert' => '',
        ];

        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msg['status'] = $this->statusErro;
            $msg['message'] = 'Erro(s) no preenchimento do formulário!';
            $msg['alert'] = 'danger';
        }
        $data = array(
            'title_page' => 'Recuperar senha do usuário',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,            
            'erro' => $this->erros,           
            
        );

        return view('user/form/forgot', $data);
    }
    public function recover()
    {
        $msg = [
            'status' => '',
            'message' => '',
            'alert' => '',
        ];

        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msg['status'] = $this->statusErro;
            $msg['message'] = 'Erro(s) no preenchimento do formulário!';
            $msg['alert'] = 'danger';
        }
        $data = array(
            'title_page' => 'Recuperar senha do usuário',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,            
            'erro' => $this->erros,           
            
        );

        return view('user/form/recover', $data);
    }
}
