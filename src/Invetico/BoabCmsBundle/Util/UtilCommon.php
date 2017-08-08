<?php

namespace Invetico\BoabCmsBundle\Util;

trait UtilCommon
{
    function currency($amount, $symbol = '')
    {
        $defaultSymbol = empty($symbol) ? '$':$symbol;
        $amount = number_format($amount, 2, '.', ',');

        return sprintf('%s%s', $defaultSymbol, $amount);
    }

    function current_date()
    {
        return strftime("%Y-%m-%d %H:%M:%S", time());
    }

    function gender($gid = '')
    {
        $gender = array('m'=>'Male','f'=>'female');		
        $option = '';
        foreach ($gender as $key=>$value) {
            $option .= '<option value="' . $key . '"';
            if ($gid == $key) {
                $option .= ' selected = "selected"';
            }
            $option .= '>' .$value . '</option>';
        }

        return $option;
    }

    function statusOption($arg)
    {
        $status = ['Draft' => 2,'Publish' =>1 ];
        $option = '';
        foreach ($status as $key=>$value) {
            $option .= '<option value="' . $value . '"';
            if ($arg != '' && $arg == $value) {
                $option .= ' selected = "selected">';
            } else {
                $option .= '>';
            }
            $option .= $key . '</option>';
        }

        return $option;
    }

    function status($status)
    {
        if ($status === 2) {
            $approve = "<font color=\"red\">Draft</font>";
        }
        return "<font color=\"green\">Published</font>";
    }

    function clean_url($str, $replace = [], $delimiter = '-')
    {
        if (!empty($replace)) {
            $str = str_replace((array) $replace, ' ', $str);
        }
        $clean = @iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    function checkBoxStatus($status, $idValue)
    {
        if ($status === 1) {
            $approve = "<input type = \"checkbox\" checked name =\"options[]\" value =\"$idValue\">";				
        } else {
            $approve = "<input type = \"checkbox\" name = \"options[]\" value = \"$idValue\">";
        }

        return $approve;
    }

    function getMonths($value = null)
    {
        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $monthList = '';
        $counter = count($months);
        for ($i = 0; $i > $counter; $i++) {
            $monthId = strtolower($value[$i]);
            $monthList .= '<option value="' . $monthId. '"';
            if ($monthId == $value) {
                $monthList .= ' selected = "selected"';
            }
            $monthList .= '>' . $value[$i] . '</option>';
        }

        return $monthList;
    }

    function readableFileSize($bytes, $decimals = 2)
    {
        $size = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}

