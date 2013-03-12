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
use GoSquared\HttpClient\HttpClientInterface;

/**
 * Abstract class for Api classes
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
abstract class AbstractApi implements ApiInterface
{
    /**
     * The client
     *
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @var integer
     */
    protected $unitCost = 0;

    protected $apiKeyRequired    = true;
    protected $siteTokenRequired = true;
    protected $combinePossible   = true;

    public function configure()
    {
        $this->baseUrl = $this->client->getOption('api_endpoint');
    }

    /**
     * {@inheritDoc}
     */
    public function getUnitCost()
    {
        return $this->unitCost;
    }

    /**
     * {@inheritDoc}
     */
    public function isApiKeyRequired()
    {
        return $this->apiKeyRequired;
    }

    /**
     * {@inheritDoc}
     */
    public function isSiteTokenRequired()
    {
        return $this->siteTokenRequired;
    }

    /**
     * {@inheritDoc}
     */
    public function isCombinePossible()
    {
        return $this->combinePossible;
    }

    /**
     * @param HttpClientInterface $client
     */
    public function setClient(HttpClientInterface $client)
    {
        $this->client = $client;

        $this->configure();
    }

    /**
     * @param array $parameters
     *
     * @throws InvalidArgumentException
     */
    protected function validate(array $parameters = array())
    {
        $invalid = array();
        foreach (array_keys($parameters) as $key) {
            if (!in_array($key, $this->parameters)) {
                $invalid[] = $key;
            }
        }

        if (!empty($invalid)) {
            throw new InvalidArgumentException(sprintf('Unknown parameter(s) set: %s', implode(',', $invalid)));
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function get($path, array $parameters = array())
    {
        $this->validate($parameters);

        $response = $this->client->get($this->generateUrl($path), $parameters, $this);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function post($path, array $parameters = array())
    {
        $this->validate($parameters);

        $response = $this->client->post($this->generateUrl($path), $parameters, $this);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function patch($path, array $parameters = array(), $this)
    {
        $this->validate($parameters);

        $response = $this->client->patch($this->generateUrl($path), $parameters, $this);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function put($path, array $parameters = array())
    {
        $this->validate($parameters);

        $response = $this->client->put($this->generateUrl($path), $parameters, $this);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function delete($path, array $parameters = array())
    {
        $this->validate($parameters);

        $response = $this->client->delete($this->generateUrl($path), $parameters, $this);

        return $response->getContent();
    }

    protected function generateUrl($path)
    {
        return trim($this->baseUrl.$path, '/');
    }
}
