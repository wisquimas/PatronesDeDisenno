<?php

/**
 * Factory Method
 *
 * Se utiliza cuando realmente no sabemos que tipo de producto recibiremos pero sabemos que lo necesitamos
 * Ej: Producto con id x... nos puede devolver un producto variable, simple, complejo, etc... Lo importante es que nos devuelva un producto
 */

/**
 * Class Car
 * Producto real
 */
abstract class Car
{
    public $marca    = '';
    public $maxSpeed = 0;

    final public function doSomething()
    {
        echo "Esta carro es de la marca {$this->marca} y su velocidad maxima es de {$this->maxSpeed} <br>";
    }
}

/**
 * Class SportCar
 * Tipo de coche 1
 */
class SportCar extends Car
{
    public function __construct()
    {
        $this->marca = 'Ferrari';
        $this->maxSpeed = 320;
    }
}

/**
 * Class FamilyCar
 * Tipo de coche 2
 */
class FamilyCar extends Car
{
    public function __construct()
    {
        $this->marca = 'Ford';
        $this->maxSpeed = 155;
    }
}

/**
 * Class Factory
 * Fabrica de coches
 * Se encarga de decidir que elemento se costruira.
 */
final class Factory
{
    /**
     * Fabrica de Carros
     * @param string $tipo
     * @return FamilyCar|null|SportCar
     */
    static public function FabricarCarro($tipo = '')
    {
        $producto = null;
        switch ($tipo) {
            case 'SportCar':
                $producto = new SportCar();
                break;
            case 'FamilyCar':
            default:
                $producto = new FamilyCar();
                break;
        }

        return $producto;
    }
}

/*************************************
 * Arranque
 ************************************/

try {
    $carro = Factory::FabricarCarro('SportCar');
    $carro->doSomething();

    $ferrari = Factory::FabricarCarro('FamilyCar');
    $ferrari->doSomething();
} catch (Error $e) {
    var_dump($e);
} catch (Exception $e) {
    var_dump($e);
}