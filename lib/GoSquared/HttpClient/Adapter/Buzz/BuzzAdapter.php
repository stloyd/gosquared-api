<?php

/*
 * This file is part of the GoSquared API Client package.
 *
 * (c) Joseph Bielawski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GoSquared\HttpClient\Adapter\Buzz;

use Buzz\Client\Curl;
use Buzz\Client\ClientInterface;
use Buzz\Listener\ListenerInterface;

use GoSquared\Api\ApiInterface;
use GoSquared\Exception\AuthorizationException;
use GoSquared\Exception\ErrorException;
use GoSquared\Exception\InvalidArgumentException;
use GoSquared\HttpClient\Adapter\AbstractAdapter;
use GoSquared\HttpClient\Adapter\Buzz\Listener\AuthListener;
use GoSquared\HttpClient\Adapter\Buzz\Listener\ErrorListener;
use GoSquared\HttpClient\Adapter\Buzz\Message\Request;
use GoSquared\HttpClient\Adapter\Buzz\Message\Response;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class BuzzAdapter extends AbstractAdapter
{
    /**
     * @var ListenerInterface[]
     */
    protected $listeners = array();
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * {@inheritDoc}
     */
    public function configure()
    {
        $this->addListener(new ErrorListener());

        $this->clearHeaders();
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate($siteToken, $apiKey = '')
    {
        $this->addListener(
            new AuthListener($siteToken, $apiKey)
        );

        if (!empty($siteToken)) {
            $this->authenticated = 1;
        }

        if (!empty($apiKey)) {
            $this->authenticated = 2;
        }
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        if (null === $this->client) {
            $this->setClient(new Curl());
        }

        return $this->client;
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient($client)
    {
        $this->client = $client;
        $this->client->setTimeout($this->options['timeout']);
        $this->client->setVerifyPeer(0);
    }

    /**
     * {@inheritDoc}
     */
    public function addListener($listener)
    {
        if (!$listener instanceof ListenerInterface) {
            throw new InvalidArgumentException;
        }

        $this->listeners[get_class($listener)] = $listener;
    }

    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = array(), ApiInterface $api)
    {
        if (0 < count($parameters)) {
            $path .= (false === strpos($path, '?') ? '?' : '&').http_build_query($parameters, '', '&');
        }

        return $this->request($path, array(), 'GET', $api);
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, array $parameters = array(), ApiInterface $api)
    {
        return $this->request($path, $parameters, 'POST', $api);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($path, array $parameters = array(), ApiInterface $api)
    {
        return $this->request($path, $parameters, 'PATCH', $api);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, array $parameters = array(), ApiInterface $api)
    {
        return $this->request($path, $parameters, 'DELETE', $api);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, array $parameters = array(), ApiInterface $api)
    {
        return $this->request($path, $parameters, 'PUT', $api);
    }

    /**
     * {@inheritDoc}
     */
    public function request($url, array $parameters = array(), $httpMethod = 'GET', ApiInterface $api)
    {
        if ($api->isApiKeyRequired() || $api->isSiteTokenRequired()) {
            if ($api->isSiteTokenRequired() && 1 > $this->authenticated) {
                throw new AuthorizationException('To use this API you must authenticate with `site_token` first!');
            }

            if ($api->isApiKeyRequired() && 2 > $this->authenticated) {
                throw new AuthorizationException('To use this API you must authenticate with `api_key` first!');
            }
        }

        $request = $this->createRequest($httpMethod, $url);
        $request->setContent($parameters);

        $hasListeners = 0 < count($this->listeners);
        if ($hasListeners) {
            foreach ($this->listeners as $listener) {
                $listener->preSend($request);
            }
        }

        $response = $this->createResponse();

        try {
            $this->getClient()->send($request, $response);
        } catch (\LogicException $e) {
            throw new ErrorException($e->getMessage());
        } catch (\RuntimeException $e) {
            throw new ErrorException($e->getMessage());
        }

        if ($hasListeners) {
            foreach ($this->listeners as $listener) {
                $listener->postSend($request, $response);
            }
        }

        return $response;
    }

    /**
     * @param string $httpMethod
     * @param string $url
     *
     * @return Request
     */
    protected function createRequest($httpMethod, $url)
    {
        $request = new Request($httpMethod);
        $request->setHeaders($this->headers);
        $request->fromUrl($url);

        return $request;
    }

    /**
     * @return Response
     */
    protected function createResponse()
    {
        return new Response();
    }
}
