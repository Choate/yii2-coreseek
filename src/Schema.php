<?php
/**
 * Created by PhpStorm.
 * User: Choate
 * Date: 2018/11/5
 * Time: 11:11
 */

namespace choate\yii2\coreseek;

use yii\sphinx\Schema AS YiiSchema;

class Schema extends YiiSchema
{
    public function createQueryBuilder()
    {
        return new QueryBuilder($this->db);
    }
}