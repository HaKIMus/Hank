<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = [
    __DIR__ . '/../src/Domain/Client',
    __DIR__ . '/../src/Domain/Client/Wallet'
];

$isDevMode  = true;

$dbParams = [
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => '',
    'dbname' => 'hank',
    'host' => '127.0.0.1',
];

$config = Setup::createYAMLMetadataConfiguration($paths, $isDevMode);

try {
    $entityManager = EntityManager::create($dbParams, $config);
} catch (\Doctrine\ORM\ORMException $e) {
    print $e->getMessage() . ' File:' . $e->getFile();
}

try {
    Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
} catch (\Doctrine\DBAL\DBALException $e) {
    print $e->getMessage() . ' File:' . $e->getFile();
}

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);