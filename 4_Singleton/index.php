<?php

/**
 * Singleton
 * Un solo objeto para todos el proyecto
 */
class MySingleton
{
    private $nombre = 'hola';

    private static $instance = null;

    private function __construct()
    {

    }

    /**
     * @return MySingleton
     */
    static public function Instance()
    {
        if (!static::$instance) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
}

/*************************************
 * Arranque
 ************************************/

try {
    $singleton = MySingleton::Instance();
    var_dump($singleton);
    $singleton->setNombre('nuevo nombre');
    var_dump($singleton);

    $singleton2 = MySingleton::Instance();
    var_dump($singleton2);
} catch (Error $e) {
    var_dump($e);
} catch (Exception $e) {
    var_dump($e);
}