<?php

const DB_HOST = 'localhost';
const DB_NAME = 'cafe_data';
const DB_USER = 'root';
const DB_PASSWORD = '';
const DB_PORT = 3308;

function database(): PDO
{
    static $connection = null;

    if ($connection === null) {
        $connection = new PDO(
            'mysql:host=' . DB_HOST .
            ';port=' . DB_PORT .
            ';dbname=' . DB_NAME .
            ';charset=utf8mb4',
            DB_USER,
            DB_PASSWORD,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    return $connection;
}

function escaped(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}