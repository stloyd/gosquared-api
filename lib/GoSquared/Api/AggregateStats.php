<?php

/*
 * This file is part of the GoSquared API Client package.
 *
 * (c) Joseph Bielawski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GoSquared\Api;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @link   https://www.gosquared.com/developer/latest/aggregateStats/
 */
class AggregateStats extends AbstractApi
{
    protected $unitCost = 1;

    public function show(array $parameters = array())
    {
        return $this->get('aggregateStats', $parameters);
    }
}
