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
 */
class Events extends AbstractApi
{
    public function configure()
    {
        $this->baseUrl = $this->client->getOption('events_endpoint');
    }

    public function store($name, array $parameters = array())
    {
        if (in_array($name, array('a', '_name'))) {
            throw new InvalidArgumentException('The "name" parameter cannot be empty or equal to values: "a" or "_name".');
        }

        return $this->post('event?name='.$name, $parameters);
    }
}
