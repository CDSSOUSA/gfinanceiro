<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_accounts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['numeric_account', 'bank', 'status', 'balance'];

    // Validation
    protected $validationRules      = [
        'numeric_account' => 'required',
        'bank' => 'required'
    ];
    protected $validationMessages   = [
        'numeric_account' => [
            'required' => 'Preenchimento obrigatório!'
        ],
        'bank' => [
            'required' => 'Preenchimento obrigatório!'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;


    public function updateBalancAccount(int $origem, float $value, string $operation): bool
    {

        $balance = $this->find($origem);
        $balance['balance'];

        $newValue = 0;
        $newValue = $balance['balance'] - $value;

        if ($operation == 'R') {
            $newValue = $balance['balance'] + $value;
        }
        return $this->set('balance', $newValue)
            ->where('id', $origem)
            ->update();
    }
}
