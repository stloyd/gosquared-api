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

use GoSquared\Exception\ErrorException;
use GoSquared\Exception\InvalidArgumentException;
use GoSquared\HttpClient\AbstractHttpClient;
use GoSquared\HttpClient\Adapter\Buzz\Listener\AuthListener;
use GoSquared\HttpClient\Adapter\Buzz\Listener\ErrorListener;
use GoSquared\HttpClient\Adapter\Buzz\Message\Request;
use GoSquared\HttpClient\Adapter\Buzz\Message\Response;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class BuzzHttpClient extends AbstractHttpClient
{
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
    public function get($path, array $parameters = array(), array $headers = array())
    {
        if (0 < count($parameters)) {
            $path .= (false === strpos($path, '?') ? '?' : '&').http_build_query($parameters, '', '&');
        }

        return $this->request($path, array(), 'GET', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'POST', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'PATCH', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'DELETE', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'PUT', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array())
    {
        $request = $this->createRequest($httpMethod, $path);
        $request->addHeaders($headers);
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
     * @param string $path
     *
     * @return Request
     */
    protected function createRequest($httpMethod, $path)
    {
        $request = new Request($httpMethod);
        $request->setHeaders($this->headers);
        $request->fromUrl(trim($this->options['api_endpoint'].$path, '/'));

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
