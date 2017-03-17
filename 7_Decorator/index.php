<?php

/**
 * Decorator
 * Añade nuevo comportamiento a objetos. Lo importante en esto es tener una interfaz comun y crear un nuevo elemento que nos sirva como interfaz intermedia para trabajar con ese objeto
 */

/**
 * Interface ShapeInterface
 *
 * Interfa base
 */
interface ShapeInterface
{
    public function draw();
}

/**
 * Class Circulo
 * Objeto Circulo ue utiliza una interfaz sencilla
 */
class Circulo implements ShapeInterface
{

    public function draw()
    {
        echo "Imprimir circulo\n";
    }
}

/**
 * Class Decorator
 * Decorador o wrapper que encapsula el elemento, configura las funciones basicas y crea nuevas funciones.
 * Esta clase nos permite darle muchisima mas versatibilidad al sistema
 */
abstract class Decorator implements ShapeInterface
{
    protected $element;

    public function __construct(ShapeInterface $element)
    {
        $this->element = $element;
    }


    public function draw()
    {
        $this->element->draw();
    }

    abstract function text();
}

/**
 * Class ShapeDecorator
 * Decorador especifico
 */
class ShapeDecorator extends Decorator
{

    function text()
    {
        echo "Aguante lo pibe\n";
    }
}

/*************************************
 * Arranque
 ************************************/

try {
    $circulo = new Circulo();
    $circulo->draw();

    $circulo2 = new ShapeDecorator(new Circulo());
    $circulo2->draw();
    $circulo2->text();

} catch (\Error $e) {
    var_dump($e);
} catch (\Exception $e) {
    var_dump($e);
}