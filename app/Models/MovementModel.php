<?php

namespace App\Models;

use CodeIgniter\Model;

class MovementModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_movements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['type_mov', 'date_mov', 'id_rubric', 'value_mov', 'status', 'origem','observation'];


    // Validation
    protected $validationRules      = [
        'type_mov'  => 'required',
        'date_mov'  => 'required',
        'id_rubric' => 'required',
        'value_mov' => 'required',
        'origem'    => 'required'
    ];
    protected $validationMessages   = [
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
        'origem'    => [
            'required' => 'Preenchimento obrigatório!'
        ]

    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function resume(int $mouth, int $year, int $day = null)
    {
        
        $isBissexto = false;
        $mouthThirty = ['04', '06', '09', '11'];

        $dayIn = '01';
        $dayOut = '30';

        if ($mouth == '02') {
            $isBissexto = validBissexto($year);
            $dayOut = '28';
        } else if ($isBissexto && $mouth == '02') {
            $dayOut = '29';
        } else if (!in_array($mouth, $mouthThirty)) {
            $dayOut = '31';
        }

        if($day !== null){           
            $dayIn = $day;
            $dayOut = $day;
        }
        
        $dateIn = $year . '-' . $mouth . '-' . $dayIn;
        $dateOut = $year . '-' . $mouth . '-' . $dayOut;
        
       

        return $this->where('date_mov >=', $dateIn)
            ->where('date_mov <=', $dateOut)
            ->orderBy('date_mov')
            ->findAll();
    }
    public function balancePrevius(int $mouth, int $year, int $day = null)
    {
        $isBissexto = false;
        $mouthThirty = ['04', '06', '09', '11'];
        $dayIn = '01';
        $dayOut = '30';

        $dateIn = $year . '-' . $mouth . '-' . $dayIn;       
        $mouthPrevius = date('m', strtotime($dateIn));
        $yearPrevius = $year;      

        if ($mouthPrevius == '02') {
            $isBissexto = validBissexto($yearPrevius);
            $dayOut = '28';
        } else if ($isBissexto && $mouthPrevius == '02') {
            $dayOut = '29';
        } else if (!in_array($mouthPrevius, $mouthThirty)) {
            $dayOut = '31';
        }

        if($day !== null){
            $dayOut = $day;
        }

        $dateInPrevius = getenv('DATE_START');
        $dateOutPrevius = $yearPrevius . '-' . $mouthPrevius . '-' . $dayOut;

        return $this->selectSum('value_mov')
            ->where('date_mov >=', $dateInPrevius)
            ->where('date_mov <=', $dateOutPrevius)
            ->get()->getRowArray();        
    }

    public function getMovementForRubric(int $id)
    {
        return $this->where('id_rubric', $id)
            ->orderBy('date_mov')
            ->findAll();
    }
}
