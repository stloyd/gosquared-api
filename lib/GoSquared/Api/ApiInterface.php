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

/**
 * Api interface
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
interface ApiInterface
{
    /**
     * @return integer
     */
    public function getUnitCost();

    /**
     * @return boolean
     */
    public function isSiteTokenRequired();

    /**
     * @return boolean
     */
    public function isApiKeyRequired();

    /**
     * @return boolean
     */
    public function isCombinePossible();
}
