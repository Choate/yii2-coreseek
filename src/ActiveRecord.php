<?php
/**
 * Created by PhpStorm.
 * User: Choate
 * Date: 2018/11/5
 * Time: 15:24
 */

namespace choate\yii2\coreseek;

use yii\sphinx\ActiveRecord AS YiiActiveRecord;
use Yii;

class ActiveRecord extends YiiActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return Yii::createObject(ActiveQuery::class, [get_called_class()]);
    }
}