<?php

namespace src\controller;
include($_SERVER['DOCUMENT_ROOT'] . '/etc/EnvParser.php');
include($_SERVER['DOCUMENT_ROOT'] . '/etc/Database/AbstractConnect.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Model/Garages.php');

use src\etc\EnvParser;
use src\Model\Garages;

/**
 * @author Subhash Rijal
 * @copyright Copyright (c) 2022
 * @package
 */
class ControllerIndex
{
    /**
     * @var Garages
     */
    private $garages;

    public function __construct(
        Garages $garages
    )
    {
        $this->garages = $garages;
    }

    public function handleResponse($requestPayLoad)
    {
        /**
         * Priority based on precise result sort.
         */
        if (isset($requestPayLoad['point']) && $pointData = $this->garages->fetchGarageByLocation($requestPayLoad['point'])) {
            $garageInfo = $pointData;
        } elseif (isset($requestPayLoad['owner']) && $owner = $this->garages->fetchGarageByOwner($requestPayLoad['owner'])) {
            $garageInfo = $owner;
        } else {
            if (isset($requestPayLoad['country'])) {
                $garageInfo = $this->garages->fetchGaragesByCountry($requestPayLoad['country']);
            }
        }

        $response = ['result' => false, 'garages' => "[]"];
        if (isset($garageInfo) && $garageInfo) {
            $response = ['result' => true, 'garages' => $garageInfo];
        }

        return $response;
    }
}

/**
 * When called upon controller
 */
$response = ["result" => false, "message" => "Payload Missing or Some Exception Occured."];
try {
    //For the input part
    $param = file_get_contents('php://input') ?? $_POST;
    $param = json_decode($param, true);
    if (@$param['country'] || @$param['owner'] || @$param['point']) {
        $envParser = new EnvParser();
        $controller = new ControllerIndex(new Garages($envParser));
        $response = $controller->handleResponse($param);
    }
    //Response part
    http_response_code(200);
} catch (\Exception $exception) {
    print_r($exception->getMessage());
    //TODO Set logger somewhere..
}

echo json_encode($response);


