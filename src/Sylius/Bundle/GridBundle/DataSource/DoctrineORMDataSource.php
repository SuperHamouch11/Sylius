<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\GridBundle\DataSource;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sylius\Component\Grid\DataSource\DataSourceInterface;

/**
 * Doctrine DataSource.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class DoctrineORMDataSource implements DataSourceInterface
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @param QueryBuilder $queryBuilder
     */
    function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function comparison($field, $operator, $value)
    {
        // TODO: Implement comparison() method.
    }

    /**
     * {@inheritdoc}
     */
    public function equals($field, $value)
    {
        $this->queryBuilder->andWhere(sprintf('o.%s = :%s', $field, $field))->setParameter($field, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function notEquals($field, $value)
    {
        $this->queryBuilder->andWhere(sprintf('o.%s != :%s', $field, $field))->setParameter($field, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function lessThan($field, $value)
    {
        $this->queryBuilder->andWhere(sprintf('o.%s < :%s', $field, $field))->setParameter($field, $value);
    }

    public function lessThanOrEqual($field, $value)
    {
        $this->queryBuilder->andWhere(sprintf('o.%s =< :%s', $field, $field))->setParameter($field, $value);
    }

    public function greaterThan($field, $value)
    {
        $this->queryBuilder->andWhere(sprintf('o.%s > :%s', $field, $field))->setParameter($field, $value);
    }

    public function greaterThanOrEqual($field, $value)
    {
        $this->queryBuilder->andWhere(sprintf('o.%s => :%s', $field, $field))->setParameter($field, $value);
    }

    public function in($field, array $values)
    {
        $this->queryBuilder->andWhere(
            $this->queryBuilder->expr()->in(sprintf('o.%s', $field), $values)
        );
    }

    public function notIn($field, array $values)
    {
        $this->queryBuilder->andWhere(
            $this->queryBuilder->expr()->notIn(sprintf('o.%s', $field), $values)
        );
    }

    public function isNull($field)
    {
        $this->queryBuilder->andWhere(
            $this->queryBuilder->expr()->isNull(sprintf('o.%s', $field))
        );
    }

    public function isNotNull($field)
    {
        $this->queryBuilder->andWhere(
            $this->queryBuilder->expr()->isNotNull(sprintf('o.%s', $field))
        );
    }

    public function like($field, $pattern)
    {
        $this->queryBuilder->andWhere(
            $this->queryBuilder->expr()->like(sprintf('o.%s', $field), $this->queryBuilder->expr()->literal($pattern))
        );
    }

    public function notLike($field, $pattern)
    {
        $this->queryBuilder->andWhere(
            $this->queryBuilder->expr()->notLike(sprintf('o.%s', $field), $this->queryBuilder->expr()->literal($pattern))
        );
    }

    public function orderBy($field, $direction)
    {
        $this->queryBuilder->orderBy(sprintf('o.%s', $field), $direction);
    }

    public function getData()
    {
        return new Pagerfanta(new DoctrineORMAdapter($this->queryBuilder));
    }
}
