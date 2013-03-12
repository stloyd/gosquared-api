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
 * @link   https://www.gosquared.com/developer/latest/concurrents/
 */
class Concurrents extends AbstractApi
{
    protected $unitCost = 1;

    public function show($presenter = null)
    {
        if (null !== $presenter && !in_array($presenter, array('old', 'plain'))) {
            throw new InvalidArgumentException('The "presenter" parameter can contain only "old" or "plain" value.');
        }

        return $this->get('concurrents', array('presenter' => $presenter));
    }
}
