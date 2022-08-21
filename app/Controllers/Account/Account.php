<?php

namespace App\Controllers\Account;

use App\Controllers\BaseController;
use App\Models\AccountModel;

class Account extends BaseController
{
    private $erros = [];
    private $accountModel;
    private $accounts;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
        $this->accounts = $this->accountModel->findAll();
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
            'title_page' => 'Cadastrar conta bancária',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            'bank' => ['cef', 'santander', 'sicred','carteira'],
            'erro' => $this->erros,
            'accounts' => $this->accounts
            //'erro' => $this->erros
        );

        return view('account/form/add', $data);
    }

    public function create()
    {
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        $data = array(
            'title_page' => 'Cadastrar conta bancária',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            'bank' => ['cef', 'santander', 'sicred','carteira'],
            'erro' => '',
            'accounts' => $this->accounts
        );

        /*$val = $this->validate(
            [
                'numeric_account' => 'required',
                'bank' => 'required',
            ],
            [
                'numeric_account' => [
                    'required' => 'Preenchimento obrigatório!'
                ],
                'bank' =>[
                    'required' => 'Preenchimento obrigatório!'
                ]]
        );*/
        /*if (!$val) {
            //dd($val);
            return redirect()->back()->withInput()->with('erro', $this->validator);
            //return redirect()->to('/admin/blog');
        }*/
        if ($this->request->getMethod() === 'post') {
            
            /*$save = $this->accountModel->save([
                'numeric_account' => mb_strtoupper($this->request->getPost('numeric_account')),
                'bank'            => mb_strtoupper($this->request->getPost('bank')),
                'status'            => 'A',
            ]);*/

            $dataPost = $this->request->getPost();
            $dataPost['numeric_account'] = mb_strtoupper($dataPost['numeric_account']);
            $save = $this->accountModel->save($dataPost);
            
            if($save){
                
                $data['msgs'] = [
                    'message' => 'Operação realizada com sucesso!',
                    'alert' => 'success',
                    'status' => $this->statusSuccess
                ];
                session()->set('success', $data);
            } else {
                return redirect()->back()->withInput()->with('erro', $this->accountModel->errors());
            }

            return redirect()->to('account/list');
            //return redirect()->to('account/add');
            //return redirect()->route('account/form/add');
            //return view('account/form/add', $data);
        }

        return view('account/form/add', $data);
    }
    public function update()
    {
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        $data = array(
            'title_page' => 'Editar conta bancária',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            'bank' => ['cef', 'santander', 'sicred','carteira'],
            'erro' => '',
            'accounts' => $this->accounts
        );

        /*$val = $this->validate(
            [
                'numeric_account' => 'required',
                'bank' => 'required',
            ],
            [
                'numeric_account' => [
                    'required' => 'Preenchimento obrigatório!'
                ],
                'bank' =>[
                    'required' => 'Preenchimento obrigatório!'
                ]]
        );*/
        /*if (!$val) {
            //dd($val);
            return redirect()->back()->withInput()->with('erro', $this->validator);
            //return redirect()->to('/admin/blog');
        }*/
        if ($this->request->getMethod() === 'put') {
            
            /*$save = $this->accountModel->save([
                'numeric_account' => mb_strtoupper($this->request->getPost('numeric_account')),
                'bank'            => mb_strtoupper($this->request->getPost('bank')),
                'status'            => 'A',
            ]);*/

            $dataPost = $this->request->getPost();
            $dataPost['numeric_account'] = mb_strtoupper($dataPost['numeric_account']);
            //dd($dataPost);
            $save = $this->accountModel->save($dataPost);

            if($save){
                
                $data['msgs'] = [
                    'message' => 'Operação realizada com sucesso!',
                    'alert' => 'success',
                    'status' => $this->statusSuccess
                ];
                session()->set('success', $data);
            } else {
                return redirect()->back()->withInput()->with('erro', $this->accountModel->errors());
            }

            return redirect()->to('account/list');
            //return redirect()->to('account/add');
            //return redirect()->route('account/form/add');
            //return view('account/form/add', $data);
        }

        //return view('account/form/add', $data);
    }

    public function edit(int $id)
    {
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        $data = array(
            'title_page' => 'Editar conta bancária',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            'bank' => ['cef', 'santander', 'sicred','carteira'],
            'erro' => '',
            'account' => $this->accountModel->find($id)
        );

        return view('account/form/edit', $data);

    }
   
    public function list()
    {
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        //$accounts = $this->accountModel->findAll();
        $data = array(
            'title_page' => 'Listar conta bancária',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            //'msgs' => $msg,
            'bank' => ['cef', 'santander', 'sicred','carteira'],
            'erro' => $this->erros,
            'accounts' => $this->accounts,
            'msgs' => $msg,
            //'erro' => $this->erros
        );

        return view('account/form/list', $data);
        //return $accounts;
    }

    public function delete()
    {

        $idConta = $this->request->getPost('idConta');
        //dd($idConta);
        $excluir = $this->accountModel->delete($idConta);

        if($excluir){
              
            $data['msgs'] = [
                'message' => 'Operação realizada com sucesso!',
                'alert' => 'success',
                'status' => $this->statusSuccess
            ];
            session()->set('success', $data);
        }
        return redirect()->to('account/list');
       

    }

    public function balance()
    {
        $data = array(
            'title_page' => 'Listar Saldo conta bancária',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            //'msgs' => $msg,
            'bank' => ['cef', 'santander', 'sicred','carteira'],
            'erro' => $this->erros,
            'accounts' => $this->accounts,
           // 'msgs' => $msg,
            //'erro' => $this->erros
        );

        return view('account/form/balance', $data);
    }
}
