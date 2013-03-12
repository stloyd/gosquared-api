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
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @link   https://www.gosquared.com/developer/latest/reportPreferences/
 */
class ReportPreferences extends AbstractApi
{
    protected $parameters = array(
        'route',
    );

    protected $unitCost = 1;

    protected $siteTokenRequired = false;

    public function show($siteToken = null, array $parameters = array())
    {
        return $this->get(null === $siteToken ? 'reportPreferences' : 'reportPreferences/'.$siteToken, $parameters);
    }

    public function add($siteToken)
    {
        return $this->post('reportPreferences/'.$siteToken);
    }

    public function remove($siteToken)
    {
        return $this->delete('reportPreferences/'. $siteToken);
    }
}
