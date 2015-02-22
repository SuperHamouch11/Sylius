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
interface FilterInterface
{
    /**
     * @param DataSourceInterface $dataSource
     * @param string $field
     * @param mixed  $data
     */
    public function apply(DataSourceInterface $dataSource, $field, $data);

    /**
     * @return string
     */
    public function getType();
}
