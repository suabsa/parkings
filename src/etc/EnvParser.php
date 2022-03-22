<?php

/**
 * @author Subhash Rijal <subhash.rijal@ambientia.fi>
 * @copyright Copyright (c) 2022
 * @package parkman_*
 */

namespace src\etc;
/**
 * This class parses the env.php file. env.php file contains some sensetive information.
 * by defining the parser this way, it is more dynamic and very little change is needed in the future for migration.
 */
class EnvParser
{
    /**
     * @return string
     */
    public function load($path)
    {
        if (!file_exists($path)) {
            //TODO Add file not exist error
            return $this->errorMessage();
        }

        if (!is_readable($path)) {
            //TODO Add file not readable error
            return $this->errorMessage();
        }
        //Reads file by striping/ignoring new lines
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

    /**
     * @return string
     */
    private function errorMessage(): string
    {
        return "Something went wrong.Could not connect to server.";
    }
}

