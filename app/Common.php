<?php

use function PHPUnit\Framework\returnSelf;

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter4.github.io/CodeIgniter4/
 */

/**
 * Method nbsp
 *
 * @param int $qtde [explicite description]
 *
 * @return string
 */
function nbsp(int $qtde = null): string
{

    $n = '';
    if ($qtde == null)
        return '&nbsp;';

    for ($i = 1; $i <= $qtde; $i++) {
        $n .= '&nbsp;';
    }
    return $n;
}

/**
 * Method convertStatus
 *
 * @param string $status [explicite description]
 *
 * @return string
 */
function convertStatus(string $status): string
{
    return $status === 'A' ? 'ATIVO' : 'INATIVO';
}

function convertRubric(string $rubric): string
{
    return $rubric === 'R' ? 'RECEITA' : 'DESPESA';
}

/**
 * Method maskCoin
 *
 * @param string $valor [explicite description]
 *
 * @return string
 */
function maskCoin(string $valor): string
{
    $part1 = implode("", explode(".", $valor));

    return implode(".", explode(",", $part1));
}

function convertCoin(float $coin)
{
    return 'R$ ' . number_format($coin, 2, ',', '.');
}

/**
 * Method convertToMonthExtens
 *
 * @param int $mes [explicite description]
 *
 * @return string
 */
function convertToMonthExtens(int $mes): string
{
    $mesExtenso = 0;
    switch ($mes) {
        case 1;
            $mesExtenso = 'JAN';
            break;
        case 2;
            $mesExtenso = 'FEV';
            break;
        case 3;
            $mesExtenso = 'MAR';
            break;
        case 4;
            $mesExtenso = 'ABR';
            break;
        case 5;
            $mesExtenso = 'MAI';
            break;
        case 6;
            $mesExtenso = 'JUN';
            break;
        case 7;
            $mesExtenso = 'JUL';
            break;
        case 8;
            $mesExtenso = 'AGO';
            break;
        case 9;
            $mesExtenso = 'SET';
            break;
        case 10;
            $mesExtenso = 'OUT';
            break;
        case 11;
            $mesExtenso = 'NOV';
            break;
        case 12;
            $mesExtenso = 'DEZ';
            break;
    }
    return $mesExtenso;
}

function formatYearTwoDigits(int $year)
{
    return substr($year, -2);
}

/**
 * Method validBissexto
 *
 * @param int $year [explicite description]
 *
 * @return bool
 */
function validBissexto(int $year): bool
{
    $bissexto = false;
    // Divisível por 4 e nAo divisível por 100 ou divisível por 400
    if ((($year % 4) == 0 && ($year % 100) != 0) || ($year % 400) == 0) {
        $bissexto = true;
    }

    return $bissexto;
}

function convertToDate(string $data): string
{
    if (!empty($data)) {
        $data = explode("/", $data);
        return $dataAtendimento = $data[2] . "-" . $data[1] . "-" . $data[0];
    }
    return '';
}

function convertDateToAttribute(string $date)
{
    $a = explode('-', $date);

    return $a[1] . '/' . $a[0];
}

function convertCoinNegative($value)
{
    if (substr($value, 1) == '-') {
        dd('');
        $d = explode('-', $value);
        return $d[1];
    }
    //dd(substr($value,1));
    return $value;
}

function defineDayEnd(string $month, string $year): string
{
    $isBissexto = false;
    $mouthThirty = ['04', '06', '09', '11'];

    $dayOut = '30';

    if ($month == '02') {
        $isBissexto = validBissexto($year);
        $dayOut = '28';
    } else if ($isBissexto && $month == '02') {
        $dayOut = '29';
    } else if (!in_array($month, $mouthThirty)) {
        $dayOut = '31';
    }
    return $dayOut;
}

function buttomGroup(string $btnSubmit = 'Salvar', string $btnClear = 'Limpar')
{
    $icon = [
        'btnSubmit' => $btnSubmit == 'Salvar' ? 'fa-save' : 'fa-search',
        'btnClear' => 'fa-ban'
    ];
    return '<button type="submit" class="btn btn-primary"><i class="icon fas ' . $icon['btnSubmit'] . '"></i> ' . $btnSubmit . '</button>
                    <button type="reset" class="btn btn-secondary"><i class="icon fas ' . $icon['btnClear'] . '"></i> ' . $btnClear . '</button>';
}

function fieldSearch(array $data, array $erro)
{

    $function = 'defineInput' . $data['option'];

    return $function($data['item'], $erro);
}

function defineFieldErro(array $erro)
{
    $error = '';
    if ($erro !== []) {
        $error = '<span class="invalid-feedback">' . $erro['msg'] . '</span>';
    }
    return $error;
}

function defineInputDate(array $data, array $erro)
{
    $a = '<div class="form-group">
            <label>Data :: </label>
                <div class="input-group">
                    <input type="text" id="datepicker" name="value" class="form-control date" placeholder="Selecione ...">
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>';
    $a .= defineFieldErro($erro);
    $a .= '</div>';
    return $a;
}

function defineInputRubric(array $data, array $erro)
{
    $a = '<div class="form-group">
            <label>Rubrica :: </label>
                <select class="form-control" name="value">
                    <option value="">Selecione ...</option>';
                foreach ($data as $item) :
                    $a .= '<option value="' . $item['id'] . '"' . set_select('id_rubric', $item['id'], false) . '>' . mb_strtoupper($item['description']) . '</option>';
                endforeach;
                $a .= '</select>';
    $a .= defineFieldErro($erro);
    $a .= '</div>';
    return $a;
}
function defineInputOrigin(array $data, array $erro)
{
    $a = '<div class="form-group">
            <label>Origem :: </label>
            <select class="form-control" name="value">
                <option value="">Selecione ...</option>';
            foreach ($data as $item) :
                $a .= '<option value="' . $item['id'] . '"' . set_select('origin', $item['id'], false) . '>' . mb_strtoupper($item['bank']) . '</option>';
            endforeach;
            $a .= '</select>';
    $a .= defineFieldErro($erro);
    $a .= '</div>';
    return $a;
}
