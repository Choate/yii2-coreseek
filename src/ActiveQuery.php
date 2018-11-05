<?php
/**
 * Created by PhpStorm.
 * User: Choate
 * Date: 2018/11/5
 * Time: 11:24
 */

namespace choate\yii2\coreseek;

use yii\helpers\ArrayHelper;
use yii\sphinx\ActiveQuery AS YiiActiveQuery;

class ActiveQuery extends YiiActiveQuery
{
    public function count($q = '*', $db = null)
    {
        $query = clone $this;
        $query->limit(0)->showMeta(true);
        $result = $query->search();

        return ArrayHelper::getValue($result, 'meta.total', 0);
    }
}