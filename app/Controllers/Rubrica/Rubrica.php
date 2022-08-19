<?php

namespace App\Controllers\Rubrica;

use App\Controllers\BaseController;
use App\Models\RubricaModel;

class Rubrica extends BaseController
{
    private $erros = [];
    private $rubricaModel;
    private $rubricas;
    public function __construct()
    {
        $this->rubricaModel = new RubricaModel();
        $this->rubricas = $this->rubricaModel->findAll();
    }

    public function show()
    {
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        //$accounts = $this->accountModel->findAll();
        $data = array(
            'title_page' => 'Listar rubricas',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            //'msgs' => $msg,
            'erro' => $this->erros,
            'rubricas' => $this->rubricas,
            'msgs' => $msg,
            //'erro' => $this->erros
        );

        return view('rubrica/form/list', $data);
        
        
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
            'title_page' => 'Cadastrar rubrica',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            'erro' => $this->erros,
            //'accounts' => $this->accounts
            //'erro' => $this->erros
        );

        return view('rubrica/form/add', $data);
    }

    public function create()
    {
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        $data = array(
            'title_page' => 'Cadastrar rubrica',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,           
            'erro' => '',
           
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
            $dataPost['description'] = mb_strtoupper($dataPost['description']);
            
            //dd($dataPost);
            $save = $this->rubricaModel->save($dataPost);

            if($save){
                
                $data['msgs'] = [
                    'message' => 'Operação realizada com sucesso!',
                    'alert' => 'success',
                    'status' => $this->statusSuccess
                ];
                session()->set('success', $data);
            } else {
                //return redirect()->back()->with('erro',$this->rubricaModel->errors());
                return redirect()->back()->withInput()->with('erro', $this->rubricaModel->errors());
            }

            return redirect()->to('rubrica/list');
            //return redirect()->to('account/add');
            //return redirect()->route('account/form/add');
            //return view('account/form/add', $data);
        }

        return view('rubrica/form/add', $data);
    }

    public function getById(int $id)
    {
        return $this->rubricaModel->find($id);
       
    }

}
