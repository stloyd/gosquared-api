<?php

/*
 * This file is part of the GoSquared API Client package.
 *
 * (c) Joseph Bielawski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GoSquared\HttpClient\Adapter\Buzz\Message;

use Buzz\Message\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * {@inheritDoc}
     */
    public function setContent($content)
    {
        parent::setContent(json_encode($content));
    }
}
