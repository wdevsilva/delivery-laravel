<?php

    try {
    $port = DATABASE_CONFIG['port'] ?? getenv('DB_PORT') ?: 3306;
    $pdo = new PDO(DATABASE_CONFIG['drive'].':host='.DATABASE_CONFIG['host'].';port='.$port.';dbname='.DATABASE_CONFIG['dbname'], DATABASE_CONFIG['user'], DATABASE_CONFIG['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('ERROR:' . $e->getMessage());
    }