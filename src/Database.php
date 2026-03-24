<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Database {
    private static $instance = null;
    private $database;

    private function __construct() {
        $configFile = dirname(__DIR__) . '/regidb-d8863-firebase-adminsdk-fbsvc-9a8b6a2dda.json';
        
        if (!file_exists($configFile)) {
            throw new Exception("Firebase credentials file not found. Please download from Firebase Console and save as firebase-credentials.json");
        }

        $serviceAccount = ServiceAccount::fromValue($configFile);
        
        $envFile = dirname(__DIR__) . '/.env';
        $databaseUrl = 'https://regitrack-default.firebaseio.com';
        
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES);
            foreach ($lines as $line) {
                if (strpos($line, 'FIREBASE_DATABASE_URL=') === 0) {
                    $databaseUrl = trim(substr($line, strlen('FIREBASE_DATABASE_URL=')));
                    break;
                }
            }
        }
        
        $this->database = (new Factory())
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri($databaseUrl)
            ->createDatabase();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getReference($path) {
        return $this->database->getReference($path);
    }

    public function get($path) {
        return $this->getReference($path)->getValue();
    }

    public function set($path, $data) {
        return $this->getReference($path)->set($data);
    }

    public function push($path, $data) {
        return $this->getReference($path)->push($data);
    }

    public function update($path, $data) {
        return $this->getReference($path)->update($data);
    }

    public function remove($path) {
        return $this->getReference($path)->remove();
    }
}

function db() {
    return Database::getInstance();
}