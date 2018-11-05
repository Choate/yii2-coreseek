<?php
/**
 * Created by PhpStorm.
 * User: Choate
 * Date: 2018/11/5
 * Time: 11:13
 */

namespace choate\yii2\coreseek;

use yii\sphinx\Connection AS YiiConnection;

class Connection extends YiiConnection
{
    public $schemaMap = [
        'mysqli' => 'choate\yii2\coreseek\Schema',   // MySQL
        'mysql' => 'choate\yii2\coreseek\Schema',    // MySQL
    ];
}