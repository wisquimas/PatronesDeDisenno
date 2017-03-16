<?php
/**
 * Abstract Factory
 * Es igual al Factory Method solo que sube un nivel mas la arquitectura de las fabricas
 */

/**
 * Class Car
 * Producto real
 */
abstract class Car
{
    public $marca = '';
    public $maxSpeed = 0;

    final public function doSomething()
    {
        echo "Esta carro es de la marca {$this->marca} y su velocidad maxima es de {$this->maxSpeed} \n";
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
        $this->marca = 'VW';
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
        $this->marca = 'VW';
        $this->maxSpeed = 155;
    }
}

abstract class AbstractFactory
{
    protected $manufacturer = null;

    public function __construct()
    {
        $this->manufacturer = 'Desconocido';
    }

    /**
     * Fabricar carro
     * @param string $tipo
     * @return mixed
     */
    abstract public function FabricarCarro($tipo = '');

    final static public function GetFactory($factoryName = '')
    {
        switch ($factoryName) {
            case 'vw':
                return new VWFactory();
                break;
            default:
                throw new Exception('No se definio el nombre de la fabrica');
                break;
        }
    }
}

/**
 * Class Factory
 * Fabrica de coches
 * Se encarga de decidir que elemento se costruira.
 */
final class VWFactory extends AbstractFactory
{
    public function __construct()
    {
        $this->manufacturer = 'VW';
    }

    /**
     * Fabrica de Carros
     * @param string $tipo
     * @return FamilyCar|null|SportCar
     */
    public function FabricarCarro($tipo = '')
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
    $fabrica = AbstractFactory::GetFactory('vw');

    $deportivo = $fabrica->FabricarCarro('SportCar');
    var_dump($deportivo);

    $familiar = $fabrica->FabricarCarro('FamilyCar');
    var_dump($familiar);
} catch (Error $e) {
    var_dump($e);
} catch (Exception $e) {
    var_dump($e);
}