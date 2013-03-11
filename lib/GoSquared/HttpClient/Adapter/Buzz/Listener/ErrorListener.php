<?php

namespace GoSquared\HttpClient\Adapter\Buzz\Listener;

use Buzz\Listener\ListenerInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use GoSquared\Exception\AuthorizationException;
use GoSquared\Exception\ApiLimitException;
use GoSquared\Exception\ErrorException;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class ErrorListener implements ListenerInterface
{
    /**
     * {@inheritDoc}
     */
    public function preSend(RequestInterface $request)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function postSend(RequestInterface $request, MessageInterface $response)
    {
        /** @var $response \GoSquared\HttpClient\Adapter\Buzz\Message\Response */
        if ($response->isClientError() || $response->isServerError()) {
            $content = $response->getContent();
            if (is_array($content) && isset($content['code'], $content['message'])) {
                switch ($content['code']) {
                    case 4001:
                        throw new AuthorizationException($content['message'], 403);
                        break;

                    case 4002:
                        throw new ApiLimitException($content['message'], 403);
                        break;

                    default:
                        throw new ErrorException($content['message'], $response->getStatusCode());
                        break;
                }
            }

            throw new ErrorException(isset($content['message']) ? $content['message'] : $content, $response->getStatusCode());
        }
    }
}
