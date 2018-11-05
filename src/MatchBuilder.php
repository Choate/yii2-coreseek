<?php
/**
 * Created by PhpStorm.
 * User: Choate
 * Date: 2018/11/5
 * Time: 10:57
 */

namespace choate\yii2\coreseek;

use yii\sphinx\MatchBuilder AS YiiMatchBuilder;

class MatchBuilder extends YiiMatchBuilder
{

    /**
     * @inheritdoc
     */
    public function buildHashMatch($match, &$params)
    {
        $parts = [];

        foreach ($match as $column => $value) {
            $parts[] = $this->buildMatchColumn($column) . ' ' . $this->buildMatchValue($value, $params);
        }

        return count($parts) === 1 ? $parts[0] : implode(' ', $parts);
    }

    /**
     * @inheritdoc
     */
    public function buildAndMatch($operator, $operands, &$params)
    {
        $parts = [];
        foreach ($operands as $operand) {
            if (is_array($operand) || is_object($operand)) {
                $operand = $this->buildMatch($operand, $params);
            }

            if ($operand !== '') {
                $parts[] = $operand;
            }
        }

        if (empty($parts)) {
            return '';
        }

        return implode(($operator === 'OR' ? ' | ' : ' '), $parts);
    }
}