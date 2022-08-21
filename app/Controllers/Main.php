<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Main extends BaseController
{
    public $menu = [];

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
    public function index()
    {
        session()->set('menu', $this->menu);
   
        $msg = [
            'message' => '',
            'alert' => ''
        ];
        $data = array(
            'title' => 'Principal',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            //'menu' => $this->menu

            //'erro' => $this->erros
        );

        return view('main/main', $data);
    }
}
