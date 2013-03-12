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
 * @link   https://www.gosquared.com/developer/latest/pages/
 */
class Pages extends AbstractApi
{
    protected $parameters = array(
        'referrer',
        'organic',
        'campaign',
        'presenter',
        'limit',
    );

    protected $unitCost = 1;

    public function show(array $parameters = array())
    {
        if (isset($parameters['presenter']) && !in_array($parameters['presenter'], array('old', 'plain'))) {
            throw new InvalidArgumentException('The "presenter" parameter can contain only "old" or "plain" value.');
        }

        return $this->get('pages', $parameters);
    }
}
