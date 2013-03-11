<?php

/*
 * This file is part of the GoSquared API Client package.
 *
 * (c) Joseph Bielawski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GoSquared\HttpClient\Adapter\Buzz\Listener;

use Buzz\Listener\ListenerInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Buzz\Util\Url;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class AuthListener implements ListenerInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * @param string $siteToken
     * @param string $apiKey
     */
    public function __construct($siteToken, $apiKey)
    {
        $this->options = array(
            'api_key'    => '' === $apiKey ? null : $apiKey,
            'site_token' => $siteToken,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function preSend(RequestInterface $request)
    {
        $url  = $request->getUrl();
        $url .= (false === strpos($url, '?') ? '?' : '&').utf8_encode(http_build_query($this->options, '', '&'));

        $request->fromUrl(new Url($url));
    }

    /**
     * {@inheritDoc}
     */
    public function postSend(RequestInterface $request, MessageInterface $response)
    {
    }
}
