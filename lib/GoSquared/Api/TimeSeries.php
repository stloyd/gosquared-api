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

use GoSquared\Exception\InvalidArgumentException;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @link   https://www.gosquared.com/developer/latest/timeSeries/
 */
class TimeSeries extends AbstractApi
{
    protected $parameters = array(
        'from',
        'to',
        'metrics',
        'interval',
        'timezone',
        'type',
    );

    protected $unitCost = 5;

    public function show(array $parameters = array())
    {
        if (isset($parameters['type']) && !in_array($parameters['type'], array('json', 'csv'))) {
            throw new InvalidArgumentException('The "type" parameter can contain only "json" or "csv" value.');
        }

        return $this->get('visitors', $parameters);
    }
}
