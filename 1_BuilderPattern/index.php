<?php
/**
 * Builder Pattern
 *
 * El patron se utiliza cuando nosotros sabemos cual es la clase final que queremos recibir pero queremos poder tener la libertad de contruirlo de distintas formas como si fueran plantillas de una misma clase
 *
 * Este patron tiene 4 elementos escenciales:
 *  - Builder abstracto : En este caso usamos CarBuilder el cual nos define los pasos que se utilizan para hacer la construccion
 *  - Directo: El director es el que le establece al Builder los pasos que debe realizar para devolver el producto final
 *  - Builder especifico: Extiende al builder abstracto y se encarga de realizar las acciones personalizadas del producto especifico
 *  - Model: Producto final que quiere ser recibido
 */

/**
 * Class CarBuilder
 * Establece las funciones y propiedades principales para construir un carro
 */
abstract class CarBuilder
{
    /**
     * @var $Carro Carro
     */
    protected $Carro = null;

    final public function __construct()
    {
        $this->Carro = new Carro();
    }

    final public function get()
    {
        return $this->Carro;
    }

    public abstract function setPuertas();

    public abstract function setRuedas();

    public abstract function setMarcas();
}

/**
 * Class CarroDirector
 * Dirije al Builder para que realice su trabajo
 */
final class CarroDirector
{
    static function constructor(CarBuilder $builder)
    {
        $builder->setPuertas();
        $builder->setRuedas();
        $builder->setMarcas();

        return $builder->get();
    }
}

/**
 * Class TruchoCarBuilder
 * Ejemplo de builder especifico de un coche sin marca con 4 puertas y 4 ruedas
 */
class TruchoCarBuilder extends CarBuilder
{
    public function setPuertas()
    {
        $this->Carro->setPuertas(4);
    }

    public function setRuedas()
    {
        $this->Carro->setRuedas(4);
    }

    public function setMarcas()
    {
        $this->Carro->setMarca('Sin Marca');
    }
}

/**
 * Class FerrariCarBuilder
 * Ejemplo de builder concreto de un ferrari con 2 puertas y 4 ruedas
 */
class FerrariCarBuilder extends CarBuilder
{
    public function setPuertas()
    {
        $this->Carro->setPuertas(2);
    }

    public function setRuedas()
    {
        $this->Carro->setRuedas(4);
    }

    public function setMarcas()
    {
        $this->Carro->setMarca('Ferrari');
    }
}

/**
 * Class Carro
 * Producto final
 */
final class Carro
{
    private $puertas = 0;
    private $ruedas  = 0;
    private $marca   = null;

    public function doSomething()
    {
        echo '<pre>';
        var_dump($this);
        echo '</pre>';
    }

    public function setPuertas($puertas)
    {
        $this->puertas = (int)$puertas;
    }

    public function setRuedas($ruedas)
    {
        $this->ruedas = (int)$ruedas;
    }

    public function setMarca($marca)
    {
        $this->marca = (string)$marca;
    }
}

/**
 * Arranque
 */

try {
    $carro = CarroDirector::constructor(new TruchoCarBuilder);
    $carro->doSomething();

    $ferrari = CarroDirector::constructor(new FerrariCarBuilder);
    $ferrari->doSomething();
} catch (Error $e) {
    var_dump($e);
} catch (Exception $e) {
    var_dump($e);
}
