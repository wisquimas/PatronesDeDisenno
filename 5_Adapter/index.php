<?php
namespace Test;
    /**
     * Adapter
     *
     */
/**
 * Class SDK
 * Trabaja con los sdk del sistema
 * @package Test
 */
class SDK
{
    static public function GetTime($data, $className = Tiempo::class)
    {
        $time = TiempoSDKBuilder::construir($className, $data);
        return $time;
    }
}

/**
 * Interface SDKBuilderInterface
 * Obliga al builder especifico a comprobar familia
 * @package Test
 */
interface SDKBuilderInterface
{
    /**
     * @return string
     */
    static function getValidClassFamily();
}

/**
 * Class SDKBuilder
 * Crea las funciones basicas del sistema
 * @package Test
 */
abstract class SDKBuilder implements SDKBuilderInterface
{
    final static public function construir($className, array $attributes)
    {
        if (static::validate($className)) {
            $constructor = new static;
            $objeto = new $className();
            $constructor->Configure($objeto, $attributes);
            return $objeto;
        }
    }

    final static function validate($className)
    {
        $validClassFamily = static::getValidClassFamily();
        $test = new $className;
        if ($test instanceof $validClassFamily) {
            return true;
        }
        return false;
    }

    final private function Configure(Model $objeto, array $attributes)
    {
        $configuracion = $objeto->configure($attributes);
        if (is_array($configuracion) && count($configuracion) > 0) {
            foreach ($configuracion as $propiedad => $value) {
                if (isset($objeto->$propiedad)) {
                    $objeto->$propiedad = $value;
                };
            }
        }
    }
}

/**
 * Class TiempoSDKBuilder
 * Configura
 * @package Test
 */
class TiempoSDKBuilder extends SDKBuilder
{
    /**
     * @return string
     */
    static function getValidClassFamily()
    {
        return Tiempo::class;
    }
}

/**
 * Interface ModelInterface
 * Obliga a los modelos a tener un script de configuracion
 * @package Test
 */
interface ModelInterface
{
    /**
     * @param array $attributes
     * @return array
     */
    public function configure(array $attributes);
}

/**
 * Class Model
 * Obliga a no definir constructores
 * @package Test
 */
abstract class Model implements ModelInterface
{
    final public function __construct()
    {
    }
}

/**
 * Class Tiempo
 * Define un posible objeto
 * @package Test
 */
class Tiempo extends Model
{
    public $nombre = '';

    public function configure(array $attributes)
    {
        return [
            'nombre' => 2,
            'apellido' => 'pepe'
        ];
    }
}

/**
 * Class Tiempo2
 * Define un segundo posible objeto
 * @package Test
 */
class Tiempo2 extends Tiempo
{
    public function configure(array $attributes)
    {
        return [
            'nombre' => 5,
            'apellido' => 'pepe'
        ];
    }
}

/*************************************
 * Arranque
 ************************************/

try {
    $time = SDK::GetTime(['nombre' => 'hola'], Tiempo::class);
    $time2 = SDK::GetTime(['nombre' => 'hola'], Tiempo2::class);
    var_dump($time);
    var_dump($time2);
} catch (\Error $e) {
    var_dump($e);
} catch (\Exception $e) {
    var_dump($e);
}