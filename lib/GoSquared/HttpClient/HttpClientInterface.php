<?php

/*
 * This file is part of the GoSquared API Client package.
 *
 * (c) Joseph Bielawski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GoSquared\HttpClient;

use GoSquared\Api\ApiInterface;
use GoSquared\Exception\InvalidArgumentException;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
interface HttpClientInterface
{
    /**
     * @return void
     */
    public function configure();

    /**
     * @param string $siteToken
     * @param string $apiKey
     *
     * @return void
     */
    public function authenticate($siteToken, $apiKey = '');

    /**
     * Send a GET request
     *
     * @param  string       $path       Request path
     * @param  array        $parameters GET Parameters
     * @param  ApiInterface $api        Instance of used API class
     *
     * @return array                    Data
     */
    public function get($path, array $parameters = array(), ApiInterface $api);

    /**
     * Send a POST request
     *
     * @param  string       $path       Request path
     * @param  array        $parameters POST Parameters
     * @param  ApiInterface $api        Instance of used API class
     *
     * @return array                    Data
     */
    public function post($path, array $parameters = array(), ApiInterface $api);

    /**
     * Send a PATCH request
     *
     * @param  string       $path       Request path
     * @param  array        $parameters PATCH Parameters
     * @param  ApiInterface $api        Instance of used API class
     *
     * @return array              Data
     */
    public function patch($path, array $parameters = array(), ApiInterface $api);

    /**
     * Send a PUT request
     *
     * @param  string       $path       Request path
     * @param  array        $parameters PUT Parameters
     * @param  ApiInterface $api        Instance of used API class
     *
     * @return array                    Data
     */
    public function put($path, array $parameters = array(), ApiInterface $api);

    /**
     * Send a DELETE request
     *
     * @param  string       $path       Request path
     * @param  array        $parameters DELETE Parameters
     * @param  ApiInterface $api        Instance of used API class
     *
     * @return array                    Data
     */
    public function delete($path, array $parameters = array(), ApiInterface $api);

    /**
     * Send a request to the server, receive a response,
     * decode the response and returns an associative array
     *
     * @param  string       $path       Request API path
     * @param  array        $parameters Parameters
     * @param  string       $httpMethod HTTP method to use
     * @param  ApiInterface $api        Instance of used API class
     *
     * @return array                    Data
     */
    public function request($path, array $parameters = array(), $httpMethod = 'GET', ApiInterface $api);

    /**
     * Retrieve an option value.
     *
     * @param string $name The option name
     *
     * @return mixed       The value
     *
     * @throws InvalidArgumentException
     */
    public function getOption($name);

    /**
     * Change an option value.
     *
     * @param string $name   The option name
     * @param mixed  $value  The value
     */
    public function setOption($name, $value);
}
