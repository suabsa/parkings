<?php

/**
 * @author Subhash Rijal <subhash.rijal@ambientia.fi>
 * @copyright Copyright (c) 2022
 * @package
 */

namespace src\etc\Database;

use PDO;
use src\etc;

class AbstractConnect
{
    protected const APP_ENV = 'APP_ENV';
    protected const DATABASE_USER = 'DATABASE_USER';
    protected const DATABASE_PASSWORD = 'DATABASE_PASSWORD';
    protected const DATABASE_DNS = 'DATABASE_DNS';
    /**
     * @var etc\EnvParser
     */
    public $envParser;
    /**
     * @var null
     */
    public $dbConnect = null;

    public function __construct(
        etc\EnvParser $envParser
    )
    {
        $this->envParser = $envParser;
    }

    /**
     * @return PDO|void
     */
    public function connect()
    {
        try {
            $envParser = $this->envParser->load($_SERVER['DOCUMENT_ROOT'] . '/etc/variables.env');
            //In case these variables are not populated. It gets populated from here.
            (!isset($_SERVER[self::DATABASE_USER])) ?? $this->envParser->load($envParser);
            /**
             * Steps:
             * 1. Database Connection
             * 2. Set cache on class level to make it load only once.
             */
            if ($this->dbConnect === null) {
                $this->dbConnect = new PDO($_SERVER[self::DATABASE_DNS], $_SERVER[self::DATABASE_USER], $_SERVER[self::DATABASE_PASSWORD]);
            }

            //For more security purpose
            $this->dbConnect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->dbConnect;
        } catch (\Throwable $exception) {
            //TODO Add some loggins. May be new debug file?
            echo sprintf('Connetion failed. Check the DB connection credentials. Exception: %s. Trace: %s',
                $exception->getMessage(),
                $exception->getTraceAsString()
            );
        }
    }
}
