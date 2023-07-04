<?php

class DB
{
    private static PDO $instance;

    public static function connect(): PDO
    {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO(
                    DSN,
                    DB_USER,
                    DB_PASS,
                    [
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                echo $e->getMessage();
                die();
            }
        }

        return self::$instance;
    }
}
