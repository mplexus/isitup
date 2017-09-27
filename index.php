<?php

use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Configuration.
 */

$dotenv = new Dotenv('.');
$dotenv->load();

$env = getenv('app_env') ?? 'sandbox';

$config['database'] = [
  'driver'   => getenv($env.'_database_driver'),
  'user'     => getenv($env.'_database_user'),
  'password' => getenv($env.'_database_password'),
  'dbname'   => getenv($env.'_database_name'),
  'host'     => getenv($env.'_database_host'),
  'port'     => getenv($env.'_database_port'),
];

$config['redis'] = [
  'host' => getenv($env.'_redis_host'),
  'port' => getenv($env.'_redis_port'),
  'db' => getenv($env.'_redis_db'),
  'pass' => getenv($env.'_redis_pass'),
];

/**
 * Test Database Connection
 */
try {
  $pdo = new PDO('mysql:host='.$config['database']['host'].';dbname='.$config['database']['dbname'].'',
    $config['database']['user'],
    $config['database']['password']
  );

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $pdo = null;
} catch(PDOException $e) {
  header("HTTP/1.1 500 Internal Server Error");
  echo "Database: " . $e->getMessage() . "\n";
  die(1);
}

/**
 * Test Redis Storage
 */
try {
  $redis = new Redis();
  $redis->connect($config['redis']['host'], $config['redis']['port']);
  $redis->select($config['redis']['db']);
} catch (RedisException $e) {
  header("HTTP/1.1 500 Internal Server Error");
  echo "Redis: " . $e->getMessage() . "\n";
  die(1);
}

header("HTTP/1.1 200 OK");
