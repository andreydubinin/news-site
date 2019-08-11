<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 11.08.2019
 * Time: 17:53
 */

namespace App\Repository\Traits;


use Doctrine\ORM\QueryBuilder;

trait SetFilterTrait
{
    protected function setFilter(QueryBuilder $builder, array $filters, string $alias): QueryBuilder
    {
        foreach ($filters as $field => $filter) {
            if (is_array($filter)) {
                $operand = $filter['operand'] ?? '=';
                $value = $filter['value'] ?? 'null';
            } else {
                $operand = '=';
                $value = $filter;
            }
            $builder->andWhere("$alias.$field $operand $value");
        }
        return $builder;
    }
}