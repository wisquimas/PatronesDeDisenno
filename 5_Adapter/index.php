<?php

/**
 * Adapter
 * Sirve para adaptar un sistema antiguo a uno moderno
 */

/**
 * Class Shipping
 * Sistemas
 */
abstract class Shipping
{
    protected $origen;
    protected $destino;
    protected $peso;
    protected $total;

    abstract public function request($origen, $destino, $peso);

    public function DevolverPrecio()
    {
        echo "El paquete ira desde {$this->origen} a {$this->destino}.\nTiene un peso de {$this->peso}.\nEl coste de {$this->total}.\n";
    }
}

/**
 * Class Adaptee
 * Clase antigua o fuente original de recursos
 */
class ShippingAdaptee extends Shipping
{
    public function request($origen, $destino, $peso)
    {
        $this->origen = $origen;
        $this->destino = $destino;
        $this->peso = $peso;

        $this->total = rand(0, 12) * (int)($peso);
    }
}

/**
 * Class TargetShipping
 * Nuevo Elemento modificado, nueva sdk, etc...
 */
class TargetShipping
{
    private $origen;
    private $destino;
    private $peso;
    private $total;

    public function login($credenciales)
    {
        echo "Recibimos credenciales \n";
    }

    /**
     * @param mixed $origen
     */
    public function setOrigen($origen)
    {
        $this->origen = $origen;
    }

    /**
     * @param mixed $destino
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;
    }

    /**
     * @param mixed $peso
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;
    }

    public function setTotal()
    {

        $this->total = rand(0, 10000) * (float)($this->peso);
    }

    /**
     * @return mixed
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * @return mixed
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * @return mixed
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }
}

/**
 * Class Adapter
 * Adaptador para trabajar con la clase nueva desde los mismos metodos que usaba la vieja
 */
class Adapter extends ShippingAdaptee
{
    public function request($origen, $destino, $peso)
    {
        $target = new TargetShipping();

        //Logueamos
        $target->login('credenciales');

        //Configuramos y trabajamos en remoto
        $target->setOrigen($origen);
        $target->setDestino($destino);
        $target->setPeso($peso);
        $target->setTotal();

        //Configuramos este
        $this->origen = $target->getOrigen();
        $this->destino = $target->getDestino();
        $this->peso = $target->getPeso();
        $this->total = $target->getTotal();
    }
}

/**
 * Class Client
 * Consume los servicios
 */
class Client
{
    public $shipping;

    public function __construct(Shipping $shipping)
    {
        $this->shipping = $shipping;
    }

    public function run($origen, $destino, $peso)
    {
        $shipping = $this->shipping;
        $shipping->request($origen, $destino, $peso);
        return $shipping;
    }
}

/*************************************
 * Arranque
 ************************************/

try {
    $adaptee = new Client(new ShippingAdaptee());
    $envio = $adaptee->run('Buenos Aires', 'Lujan', 800);
    $envio->DevolverPrecio();

    echo "\n\n";

    $adaptee = new Client(new Adapter());
    $envio = $adaptee->run('Buenos Aires', 'Lujan', 800);
    $envio->DevolverPrecio();

} catch (\Error $e) {
    var_dump($e);
} catch (\Exception $e) {
    var_dump($e);
}