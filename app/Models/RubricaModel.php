<?php

namespace App\Models;

use CodeIgniter\Model;

class RubricaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_rubrics';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['description', 'status'];

    // Validation
    protected $validationRules      = [
        'description' => 'required|min_length[5]',
        
    ];
    protected $validationMessages   = [
        'description' => [
            'required' => 'Preenchimento obrigatório!',
            'min_length' => 'Preencher com no mínimo 5 caracter!'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    
}
