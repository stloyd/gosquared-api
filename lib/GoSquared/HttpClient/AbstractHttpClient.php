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

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
abstract class AbstractHttpClient implements HttpClientInterface
{
    /**
     * @var array
     */
    protected $listeners = array();
    /**
     * @var array
     */
    protected $headers = array();
    /**
     * @var array
     */
    protected $options = array();

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->options = array_merge($this->options, $options);

        $this->configure();

        $this->clearHeaders();
    }

    /**
     * {@inheritDoc}
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * Clears used headers
     */
    public function clearHeaders()
    {
        $this->headers = array(
            sprintf('User-Agent: %s', $this->options['user_agent']),
            'Content-Type: application/json'
        );
    }

    abstract public function addListener($listener);
}
