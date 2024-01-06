<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Main extends BaseController
{
    public $menu = [];
    private $erros = [];
    private $errosLogin = [];
    public function __construct()
    {
        $this->menu = [
            'itens' => [
                'item' => [
                    'account' => [
                        'title' => 'Conta Bancária',
                        'links'   => [
                           'Cadastrar' => '/account/add',
                           'Listar' => '/account/list',
                           'Saldo' => '/account/balance',
                         
                        ],
                        'icon' => '<i class="nav-icon far fa-money-bill-alt"></i>',
                    ],
                    'rubrica' => [
                        'title' => 'Rubrica',
                        'links'   => [
                            'Cadastrar' => '/rubrica/add',
                            'Listar' => '/rubrica/list'
                        ],
                        'icon' => '<i class="nav-icon fas fa-clipboard-list"></i>',
                    ],
                    'movement' => [
                        'title' => 'Movimentação',
                        'links'   => [
                            'Cadastrar' => '/movement/add',
                            'Listar' => '/movement/resume/'.date('m').'/'.date("Y"),
                            'Consultar' => [
                                'Rubrica' => '/movement/search/rubrica',
                                'Data' => '/movement/search/data',
                                'Origem' => '/movement/search/origem',
                            ]
                        ],
                        'icon' => '<i class="nav-icon far fa-calendar-alt"></i>',
                    ],
                ]
            ]

        ];
    }
    // public function index()
    // {
    //     session()->set('menu', $this->menu);
   
    //     $msg = [
    //         'message' => '',
    //         'alert' => ''
    //     ];
    //     $data = array(
    //         'title' => 'Principal',
    //         //'blogAtual' => $this->blog->find($id),
    //         //'blogs' => $this->blog->blogRecents($id),
    //         //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
    //         'msgs' => $msg,
    //         //'menu' => $this->menu

    //         //'erro' => $this->erros
    //     );

    //     return view('main/main', $data);
    // }

    public function index()
    {
        //session()->remove('erro');
        //session()->remove('erroLogin');
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msg['status'] = $this->statusErro;
            $msg['message'] = 'Erro(s) no preenchimento do formulário!';
            $msg['alert'] = 'danger';   
            //dd($this->erros);           
        }
        if(session()->has('erroLogin')){          
            $this->errosLogin = session('erroLogin');           
        }
        $data = array(
            'title' => 'Principal',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            //'menu' => $this->menu

            'erro' => $this->erros,
            'erroLogin' => $this->errosLogin
        );
        return view('main/login', $data);
    }

    public function login()
    {

        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
       

        $data = array(
            'title' => 'Principal',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            //'menu' => $this->menu

            'erro' => $this->erros,
        );

        $user = new UserModel();

        $val = $this->validate(
            [
                'login' => 'required',
                'passwrd' => 'required',

            ],
            [
                'login' => [
                    'required' => 'Preenchimento obrigatório!'
                ],
                'passwrd' => [
                    'required' => 'Preenchimento obrigatório!'
                ],
            ]
        );

        if (!$val) {
            //dd($val);
            //return redirect()->back()->withInput()->with('erro', $this->validator);
            //$dataErro = ['msg' => 'Login e Senha não conferem!', 'status' => $this->statusErro, 'alert' => 'danger'];
           session()->set('erro', $this->validator);
           return redirect()->to('/');
        }
        

        $rs = $user->verify_login($this->request->getPost('login'), $this->request->getPost('passwrd'));
        
        session()->set('menu', $this->menu);
        if(!$rs['status']){
            $dataErro = ['msg' => 'Login e Senha não conferem!', 'status' => $this->statusErro, 'alert' => 'danger'];
         
            session()->set('erroLogin', $dataErro);
            return redirect()->to('/');
        } else {  

        session()->set('data_login', $rs['login'] );

        return view('main/main', $data);
        }
    }
    public function logout()
    {
        session()->destroy();
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];

        $data = array(
            'title' => 'Principal',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            //'menu' => $this->menu

            'erro' => $this->erros,
            'erroLogin' => $this->errosLogin
        );
        return view('main/login',$data);   
    }

}
