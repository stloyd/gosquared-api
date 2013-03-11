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

use Buzz\Message\Response as BaseResponse;

class Response extends BaseResponse
{
    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        $response = parent::getContent();
        $content  = json_decode($response, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return $response;
        }

        return $content;
    }
}
