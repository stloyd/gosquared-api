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
 * @link   https://www.gosquared.com/developer/latest/visitors/
 */
class Visitors extends AbstractApi
{
    protected $parameters = array(
        'visitorID',
        'limit',
        'page',
        'referrer',
        'organic',
        'campaign',
        'visitorsMode',
        'presenter',
    );

    protected $unitCost = 2;

    public function show(array $parameters = array())
    {
        if (isset($parameters['visitorsMode']) && !in_array($parameters['visitorsMode'], array('all', 'returning', 'tagged'))) {
            throw new InvalidArgumentException('The "visitorsMode" parameter can contain only "all", "returning" or "tagged" value.');
        }

        if (isset($parameters['presenter']) && !in_array($parameters['presenter'], array('old', 'plain'))) {
            throw new InvalidArgumentException('The "presenter" parameter can contain only "old" or "plain" value.');
        }

        return $this->get('visitors', $parameters);
    }
}
