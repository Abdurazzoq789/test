<?php

namespace common\models;

use yii\helpers\VarDumper;

class Util
{

    public static function VarDump($data)
    {
        VarDumper::dump($data, 100, true);
    }

    public static function getPercent($totalCount, $count)
    {
        return ($count * 100) / $totalCount;
    }

}