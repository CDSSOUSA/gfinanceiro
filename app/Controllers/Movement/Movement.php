<?php

namespace App\Controllers\Movement;

use App\Controllers\BaseController;
use App\Models\AccountModel;
use App\Models\MovementModel;
use App\Models\RubricaModel;
use CodeIgniter\HTTP\URI;

class Movement extends BaseController
{

    private $erros = [];
    private $movementModel;
    private $movements;
    private $rubric;
    private $account;


    public function __construct()
    {
        $this->movementModel = new MovementModel();
        $this->rubrics = new RubricaModel();
        $this->account = new AccountModel();
        $this->movements = $this->movementModel->findAll();
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
            'title_page' => 'Cadastrar movimentação',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            'erro' => $this->erros,
            'rubrics' => $this->rubrics->orderBy('description')->findAll(),
            'bank' => $this->account->findAll(),
            //'erro' => $this->erros
        );

        return view('movement/form/add', $data);
    }

    public function create()
    {
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        $data = array(
            'title_page' => 'Cadastrar movimentações',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            'rubrics' => $this->rubrics->findAll(),
            'erro' => '',
            'bank' => $this->account->findAll(),

        );

        $val = $this->validate(
            [
                'type_mov'  => 'required',
                'date_mov'  => 'required',
                'id_rubric' => 'required',
                'value_mov' => 'required',
                'origin'    => 'required',
                'observation'    => 'permit_empty|min_length[5]'
            ],
            [
                'type_mov'  => [
                    'required' => 'Preenchimento obrigatório!'
                ],
                'date_mov'  => [
                    'required' => 'Preenchimento obrigatório!'
                ],
                'id_rubric' => [
                    'required' => 'Preenchimento obrigatório!'
                ],
                'value_mov' => [
                    'required' => 'Preenchimento obrigatório!'
                ],
                'origin'    => [
                    'required' => 'Preenchimento obrigatório!'
                ],
                'observation'    => [
                    'min_length' => 'Preencher com no mínimo 5 caracter!'
                ]

            ]
        );
        if (!$val) {
            //dd($val);
            //return redirect()->back()->withInput()->with('erro', $this->validator);
            return redirect()->back()->withInput()->with('erro', $this->movementModel->errors());
            //return redirect()->to('/admin/blog');
        }
        if ($this->request->getMethod() === 'post') {

            /*$save = $this->accountModel->save([
                'numeric_account' => mb_strtoupper($this->request->getPost('numeric_account')),
                'bank'            => mb_strtoupper($this->request->getPost('bank')),
                'status'            => 'A',
            ]);*/

            $dataPost = $this->request->getPost();
            //dd($dataPost);
            $dataPost['date_mov'] = convertToDate($dataPost['date_mov']);
            $dataPost['value_mov'] = maskCoin($dataPost['value_mov']);

            $value = $dataPost['value_mov'];
            $origin = $dataPost['origin'];
            $operation = $dataPost['type_mov'];

            if ($dataPost['type_mov'] == 'D') {
                $dataPost['value_mov'] = -$dataPost['value_mov'];
            }

            $dateAttribute = convertDateToAttribute($dataPost['date_mov']);

            $this->movementModel->transStart();
            $save = $this->movementModel->save($dataPost);
            $this->movementModel->transComplete();

            $this->account->transStart();
            $updateBalanceAccount = $this->account->updateBalancAccount($origin, $value, $operation);
            $this->account->transComplete();




            if ($save && $updateBalanceAccount) {

                $this->movementModel->transCommit();
                $this->account->transCommit();

                $data['msgs'] = [
                    'message' => 'Operação realizada com sucesso!',
                    'alert' => 'success',
                    'status' => $this->statusSuccess
                ];
                session()->set('success', $data);
            } else {
                $this->movementModel->transRollback();
                $this->account->transRollback();
                return redirect()->back()->withInput()->with('erro', $this->movementModel->errors());
            }

            return redirect()->to('movement/resume/' . $dateAttribute);
            //return redirect()->to('account/add');
            //return redirect()->route('account/form/add');
            //return view('account/form/add', $data);
        }

        return view('movement/form/add', $data);
    }

    public function show()
    {
        $yearActual = date('Y');
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        //$accounts = $this->accountModel->findAll();
        $data = array(
            'title_page' => 'Listar movimentações',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            //'msgs' => $msg,
            'erro' => $this->erros,
            //'rubricas' => $this->rubricas,
            'msgs' => $msg,
            'resume' => null,
            'balancePrevius' => [],
            'yearActual' => $yearActual,
            'bank' => $this->account->findAll(),
            //'erro' => $this->erros
        );

        return view('movement/form/list', $data);
    }

    public function resume(int $mouth, int $year)
    {
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];

        $resume = $this->movementModel->resume($mouth, $year);
        $balancePrevius = $this->movementModel->balancePrevius($mouth, $year);


        $data = array(
            'title_page' => 'Listar movimentações',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            'rubrics' => $this->rubrics->findAll(),
            'account' => $this->account,
            'erro' => '',
            'resume' => $resume,
            'balancePrevius' => $balancePrevius

        );
        session()->set('date', convertToMonthExtens($mouth) . '/' . $year);
        return view('movement/form/list', $data);
        //return redirect()->back()->with('resume', $resume);
        //return redirect()->to('movement/list');
        //return $resume ;
    }
    public function resumeDay(int $mouth, int $year, int $day)
    {
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        $resume = $this->movementModel->resume($mouth, $year, $day);
        $balancePrevius = $this->movementModel->balancePrevius($mouth, $year, $day);


        $data = array(
            'title_page' => 'Listar movimentações',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            'rubrics' => $this->rubrics->findAll(),
            'account' => $this->account,
            'erro' => '',
            'resume' => $resume,
            'balancePrevius' => $balancePrevius

        );
        session()->set('date', convertToMonthExtens($mouth) . '/' . $year);
        return view('movement/form/list', $data);
        //return redirect()->back()->with('resume', $resume);
        //return redirect()->to('movement/list');
        //return $resume ;
    }

    public function edit(int $id)
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
            'title_page' => 'Editar movimentação',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            'erro' => $this->erros,
            'rubrics' => $this->rubrics->orderBy('description')->findAll(),
            'bank' => $this->account->findAll(),
            'movement' => $this->movementModel->find($id),
            'rubric' => $this->rubrics,
            'account' => $this->account,
            //'erro' => $this->erros
        );

        return view('movement/form/edit', $data);
    }
    public function update()
    {
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        $data = array(
            'title_page' => 'Editar movimentação',
            //'blogAtual' => $this->blog->find($id),
            //'blogs' => $this->blog->blogRecents($id),
            //'horarioSegunda' => $this->horarioSegunda->getHorarioDiaSemana(2,1),
            'msgs' => $msg,
            'bank' => $this->account->findAll(),
            'erro' => '',
            'rubric' => $this->rubrics
        );

        if ($this->request->getMethod() === 'put') {

            /*$save = $this->accountModel->save([
                'numeric_account' => mb_strtoupper($this->request->getPost('numeric_account')),
                'bank'            => mb_strtoupper($this->request->getPost('bank')),
                'status'            => 'A',
            ]);*/
            $dataPost = $this->request->getPost();
            $dataPost['date_mov'] = convertToDate($dataPost['date_mov']);
            $dataPost['value_mov'] = maskCoin($dataPost['value_mov']);
            $data['movement'] = $this->movementModel->find($dataPost['id']);

            if ($dataPost['type_mov'] == 'D') {
                $dataPost['value_mov'] = -$dataPost['value_mov'];
            }
            $dateAttribute = convertDateToAttribute($dataPost['date_mov']);

            $save = $this->movementModel->save($dataPost);

            if ($save) {

                $data['msgs'] = [
                    'message' => 'Operação realizada com sucesso!',
                    'alert' => 'success',
                    'status' => $this->statusSuccess
                ];
                session()->set('success', $data);
            } else {
                return redirect()->back()->withInput()->with('erro', $this->movementModel->errors());
            }

            return redirect()->to('movement/resume/' . $dateAttribute);
            //return redirect()->to('account/add');
            //return redirect()->route('account/form/add');
            //return view('account/form/add', $data);
        }

        //return view('account/form/add', $data);
    }

    public function search(string $tipo)
    {
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msg['status'] = session('erro')['status'];
            $msg['message'] = session('erro')['msg'];
            $msg['alert'] = session('erro')['alert'];
            //dd($this->erros);
        }
        //$accounts = $this->accountModel->findAll();

        $data = array(
            'title_page' => 'Consultar por ' . $tipo,
            'erro' => $this->erros,
            'msgs' => $msg,
            'type' => $tipo,


        );
        $data['data'] = [
            'item'=>[],
            'option'=>'Date'
        ];

        $data['name'] = 'date_mov';

        if ($tipo == 'rubrica') {

            $data['type'] = $tipo;
            $data['data'] = [
                'item' => $this->rubrics->orderBy('description')->findAll(),
                'option' => 'Rubric'
            ];
            $data['name'] = 'id_rubric';
        } 

        if($tipo == 'origem'){
            $data['type'] = $tipo;
            $data['data'] = [
                'item' => $this->account->findAll(),
                'option' => 'Origin'
            ];
            $data['name'] = 'origin';
        }


        return view('movement/form/search', $data);
    }
    public function result()
    {
        $msg = [
            'message' => '',
            'alert' => '',
            'status' => ''
        ];
        //$accounts = $this->accountModel->findAll();
        $data = array(
            //'title_page' => 'Consultar por '. $tipo,           
            'erro' => $this->erros,
            'msgs' => $msg,
            //'type' => $tipo,
            'rubrics' => $this->rubrics->orderBy('description')->findAll(),
            'account' => $this->account,

        );

        $val = $this->validate(
            [
                'value' => 'required',

            ],
            [
                'value' => [
                    'required' => 'Preenchimento obrigatório!'
                ],
            ]
        );

        $dataType = $this->request->getPost();
        $campo = $this->request->getPost();

        if (!$val) {
            //dd($val);
            //return redirect()->back()->withInput()->with('erro', $this->validator);
            $dataErro = ['msg' => 'Preenchimento obrigatório!', 'type' => $dataType, 'status' => $this->statusErro, 'alert' => 'danger'];
            session()->set('erro', $dataErro);
            return redirect()->to('/movement/search/' . $dataType['typeSearch']);
        }

        if ($this->request->getMethod() === 'post') {

            /*$save = $this->accountModel->save([
                'numeric_account' => mb_strtoupper($this->request->getPost('numeric_account')),
                'bank'            => mb_strtoupper($this->request->getPost('bank')),
                'status'            => 'A',
            ]);*/

            $dataPost = $this->request->getPost();

            //dd($dataPost);
            
            $search = $this->movementModel->getMovementForType(
                $campo['field'], 
                $campo['field'] == 'date_mov' ? convertToDate($dataPost['value']) : $dataPost['value']);

            if ($search) {

                $data['msgs'] = [
                    'message' => 'Dados encontrados com sucesso!',
                    'alert' => 'success',
                    'status' => $this->statusSuccess
                ];
                $data['result'] = $search;
                $data['type'] =$dataType['typeSearch'];
                session()->set('success', $data);
            } else {
                $dataErro = ['msg' => 'Nenhum dado encontrado para a consulta!', 'type' => 'rubrica', 'status' => $this->statusWarning, 'alert' => 'warning'];
                session()->set('erro', $dataErro);
                return redirect()->to('/movement/search/'.$dataType['typeSearch']);
            }

            //return redirect()->to('movement/resume/'.$dateAttribute);
            //return redirect()->to('account/add');
            //return redirect()->route('account/form/add');
            return view('movement/form/result', $data);
        }
    }
}
