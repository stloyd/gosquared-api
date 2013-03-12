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
 * @link   https://www.gosquared.com/developer/latest/time/
 */
class Time extends AbstractApi
{
    protected $apiKeyRequired    = false;
    protected $siteTokenRequired = false;

    public function show(array $parameters = array())
    {
        if (!empty($parameters)) {
            throw new InvalidArgumentException('The "time" function don\'t support any parameters.');
        }

        return $this->get('time');
    }
}
