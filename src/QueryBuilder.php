<?php
/**
 * Created by PhpStorm.
 * User: Choate
 * Date: 2018/11/5
 * Time: 10:56
 */

namespace choate\yii2\coreseek;

use yii\sphinx\Query;
use yii\sphinx\QueryBuilder AS YiiQueryBuilder;

class QueryBuilder extends YiiQueryBuilder
{
    private $_matchBuilder;

    /**
     * @inheritdoc
     */
    public function getMatchBuilder()
    {
        if ($this->_matchBuilder === null) {
            $this->_matchBuilder = new MatchBuilder($this->db);
        }
        return $this->_matchBuilder;
    }

    /**
     * @inheritdoc
     */
    public function buildAndCondition($indexes, $operator, $operands, &$params)
    {
        $parts = [];
        foreach ($operands as $operand) {
            if (is_array($operand)) {
                $operand = $this->buildCondition($indexes, $operand, $params);
            }
            if ($operand !== '') {
                $parts[] = $operand;
            }
        }
        if (!empty($parts)) {
            return implode(" $operator ", $parts);
        } else {
            return '';
        }
    }

    /**
     * @inheritdoc
     */
    public function buildHashCondition($indexes, $condition, &$params)
    {
        $parts = [];
        foreach ($condition as $column => $value) {
            if (is_array($value) || $value instanceof Query) {
                // IN condition
                $parts[] = $this->buildInCondition($indexes, 'IN', [$column, $value], $params);
            } else {
                if (strpos($column, '(') === false) {
                    $quotedColumn = $this->db->quoteColumnName($column);
                } else {
                    $quotedColumn = $column;
                }
                if ($value === null) {
                    $parts[] = "$quotedColumn IS NULL";
                } else {
                    $parts[] = $quotedColumn . '=' . $this->composeColumnValue($indexes, $column, $value, $params);
                }
            }
        }

        return count($parts) === 1 ? $parts[0] : implode(' AND ', $parts);
    }
}