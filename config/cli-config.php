<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

$paths = [
    __DIR__ . '/../src/Domain/Client',
    __DIR__ . '/../src/Domain/Client/BankAccount'
];

$isDevMode  = true;

$dbParams = [
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => '',
    'dbname' => 'hank',
    'host' => '127.0.0.1',
    'charset' => 'utf8'
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