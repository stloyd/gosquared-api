<?php

/*
 * This file is part of the GoSquared API Client package.
 *
 * (c) Joseph Bielawski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GoSquared;

use GoSquared\Api\ApiInterface;
use GoSquared\Exception\InvalidArgumentException;
use GoSquared\HttpClient\HttpClientInterface;
use GoSquared\HttpClient\Adapter\Buzz\BuzzAdapter;

/**
 * Simple OOP powered GoSquared API client
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @link   http://github.com/stloyd/gosquared-api
 */
class Client
{
    /**
     * @var array
     */
    private $options = array(
        'api_endpoint'    => 'http://api.gosquared.com/latest/',
        'api_version'     => '1.0',

        'events_endpoint' => 'https://data.gosquared.com/',

        'user_agent'      => 'GoSquared PHP API (http://github.com/stloyd/gosquared-api)',
        'timeout'         => 10,
    );

    /**
     * The Buzz instance used to communicate with GoSquared API
     *
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * Instantiate a new GoSquared API client
     *
     * @param null|HttpClientInterface $httpClient GoSquared API client
     */
    public function __construct(HttpClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $name
     *
     * @return ApiInterface
     *
     * @throws InvalidArgumentException
     */
    public function api($name)
    {
        switch ($name) {
            case 'aggregate':
            case 'aggregate_stats':
            case 'aggregateStats':
                $api = new Api\AggregateStats();
                break;

            case 'campaigns':
                $api = new Api\Campaigns();
                break;

            case 'concurrents':
                $api = new Api\Concurrents();
                break;

            case 'engagement':
                $api = new Api\Engagement();
                break;

            case 'events':
                $api = new Api\Events();
                break;

            case 'geo':
                $api = new Api\Geo();
                break;

            case 'ignored':
            case 'ignoredVisitors':
            case 'ignored_visitors':
                $api = new Api\IgnoredVisitors();
                break;

            case 'organics':
                $api = new Api\Organics();
                break;

            case 'overview':
                $api = new Api\Overview();
                break;

            case 'pages':
                $api = new Api\Pages();
                break;

            case 'referrers':
                $api = new Api\Referrers();
                break;

            case 'sites':
                $api = new Api\Sites();
                break;

            case 'time':
                $api = new Api\Time();
                break;

            case 'time_series':
            case 'timeSeries':
                $api = new Api\TimeSeries();
                break;

            case 'visitors':
                $api = new Api\Visitors();
                break;

            default:
                throw new InvalidArgumentException(sprintf('Unknown api instance called: "%s"', $name));
        }

        $api->setClient($this->getHttpClient());

        return $api;
    }

    /**
     * Authenticate a user for all next requests
     *
     * @param string $siteToken The GoSquared API key of your account
     * @param string $apiKey    The site token for the site you are retrieving data for
     */
    public function authenticate($siteToken, $apiKey)
    {
        $this->getHttpClient()->authenticate($siteToken, $apiKey);
    }

    /**
     * @return HttpClientInterface
     */
    public function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = new BuzzAdapter($this->options);
        }

        return $this->httpClient;
    }

    /**
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $name
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        return $this->options[$name];
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws InvalidArgumentException
     */
    public function setOption($name, $value)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        $this->options[$name] = $value;
    }
}
