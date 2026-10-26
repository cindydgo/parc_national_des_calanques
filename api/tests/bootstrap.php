<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// En local, .env.testing (facultatif) a priorité sur les valeurs de phpunit.xml.
// En CI, il n'existe pas : les variables viennent des secrets GitHub.
$dotenv = Dotenv::createMutable(
    dirname(__DIR__),
    '.env.testing'
);

$dotenv->safeLoad();