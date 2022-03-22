<?php
/**
 * @author Subhash Rijal <subhash.rijal@ambientia.fi>
 * @copyright Copyright (c) 2022
 * @package
 */

namespace src\Model;

use src\etc;
use src\etc\Database\AbstractConnect;

class Garages extends AbstractConnect
{
    /**
     * @param $country
     * @return mixed
     */
    public function fetchGaragesByCountry($country)
    {
        $countryData = $this->connect()->prepare(
            "SELECT * FROM parkings.country AS c LEFT JOIN parkings.owner AS o ON c.country_id=o.country_id LEFT JOIN parkings.garage AS g on o.owner_id=g.owner_id WHERE c.country  =:name"
        );
        $countryData->execute(['name' => $country]);
        //2 here returns associative array for each column
        return $countryData->fetchAll(2);
    }

    /**
     * @param $owner
     * @return mixed
     */
    public function fetchGarageByOwner($owner)
    {
        $ownerData = $this->connect()->prepare(
            "SELECT * FROM parkings.owner AS o JOIN parkings.country AS c ON o.country_id=c.country_id JOIN parkings.garage AS g on o.owner_id = g.owner_id WHERE o.garage_owner like :owner"
        );
        $ownerData->execute(['owner' => $owner]);
        return  $ownerData->fetchAll(2);
    }

    /**
     * @param $location
     * @return mixed
     */
    public function fetchGarageByLocation($location)
    {
        $garageData = $this->connect()->prepare(
            "SELECT * FROM parkings.garage AS g JOIN parkings.owner as o ON o.owner_id = g.owner_id JOIN parkings.country as c ON c.country_id = o.country_id WHERE g.point like :point"
        );
        $garageData->execute(['point' => $location]);
        return  $garageData->fetchAll(2);
    }

}