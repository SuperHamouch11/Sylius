<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Grid\Filter;
use Sylius\Component\Grid\DataSource\DataSourceInterface;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class StringFilter implements FilterInterface
{
    const TYPE_EQUAL        = 'equal';
    const TYPE_EMPTY        = 'empty';
    const TYPE_NOT_EMPTY    = 'not_empty';
    const TYPE_CONTAINS     = 'contains';
    const TYPE_NOT_CONTAINS = 'not_contains';
    const TYPE_STARTS_WITH  = 'starts_with';
    const TYPE_ENDS_WITH    = 'ends_with';
    const TYPE_IN           = 'in';
    const TYPE_NOT_IN       = 'not_in';

    /**
     * {@inheritdoc}
     */
    public function apply(DataSourceInterface $dataSource, $field, $data)
    {
        $value = $data['value'];
        $type = $data['type'];

        if (empty($value) && !in_array($type, array(self::TYPE_EMPTY, self::TYPE_NOT_EMPTY))) {
            return;
        }

        switch ($data['type']) {
            case self::TYPE_EQUAL:
                $dataSource->equals($field, $value);
            break;
            case self::TYPE_EMPTY:
                $dataSource->isNull($field);
            break;
            case self::TYPE_NOT_EMPTY:
                $dataSource->isNotNull($field);
            break;
            case self::TYPE_CONTAINS:
                $dataSource->like($field, '%'.$value.'%');
            break;
            case self::TYPE_NOT_CONTAINS:
                $dataSource->notLike($field, '%'.$value.'%');
            break;
            case self::TYPE_STARTS_WITH:
                $dataSource->like($field, $value.'%');
            break;
            case self::TYPE_ENDS_WITH:
                $dataSource->like($field, '%'.$value);
            break;
            case self::TYPE_IN:
                $dataSource->in($field, array_map('trim', explode(',', $value)));
            break;
            case self::TYPE_NOT_IN:
                $dataSource->notIn($field, array_map('trim', explode(',', $value)));
            break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'string';
    }
}
