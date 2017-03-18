<?php

/**
 * Command
 * Utiliza comandos para controlar un objeto impidiendo asi el uso directo del mismo
 */

/**
 * Interface Command
 * Clase base de comandos
 */
interface Command
{
    public function execute();
}

/**
 * Interface LightInterface
 * Interface simplemente para que funcione siempre a full. Esto es extra pero es super necesario para escalar
 */
interface LightInterface
{
    public function turnOn();

    public function turnOff();
}

/**
 * Class Light
 * Objeto que vamos a manipular
 */
class Light implements LightInterface
{
    public function turnOn()
    {
        echo "Endender luz\n";
    }

    public function turnOff()
    {
        echo "Apagar luz\n";
    }
}

/**
 * Class Switcher
 * Invocara los comandos para manipular la luz de forma especifica.
 * Digamos que esta funcion se encarga de encapsular cada comando especifico
 */
class SwitcherLight
{
    private $onCommand;
    private $offCommand;

    public function __construct(LightCommand $onCommand, LightCommand $offCommand)
    {
        $this->onCommand = $onCommand;
        $this->offCommand = $offCommand;
    }

    public function on()
    {
        $this->onCommand->execute();
    }

    public function off()
    {
        $this->offCommand->execute();
    }
}

/**
 * Class LightCommand
 * Simplemente me aseguro que los comandos de luz funcionen como espero
 */
abstract class LightCommand implements Command
{
    protected $light;

    final public function __construct(LightInterface $light)
    {
        $this->light = $light;
    }
}

/**
 * Class OnCommand
 * Comando para encender
 */
class OnLightCommand extends LightCommand
{
    public function execute()
    {
        $this->light->turnOn();
    }
}

/**
 * Class OffCommand
 * Comando para apagar
 */
class OffLightCommand extends LightCommand
{
    public function execute()
    {
        $this->light->turnOff();
    }
}

/**
 * Interface SwitchClientInterface
 * Existe para obligar la existencia de estos elementos
 */
interface SwitchClientInterface
{
    public function __construct();

    public function execute($cmd);
}

/**
 * Class SwitchClient
 * Funcion que se encargara de correr los comandos.
 * Funciona y controla la manipulacion como si fuera una libreria
 */
class SwitchClient implements SwitchClientInterface
{
    protected $foco;
    protected $switch;

    /**
     * SwitchClient constructor.
     */
    public function __construct()
    {
        $this->foco = new Light();
        $this->switch = new SwitcherLight(new OnLightCommand($this->foco), new OffLightCommand($this->foco));
    }

    /**
     * Declara la libreria del sistema
     * @param $cmd
     * @throws Exception
     */
    public function execute($cmd)
    {
        switch ($cmd) {
            case 'on':
                $this->switch->on();
                break;
            case 'off':
                $this->switch->off();
                break;
            default:
                throw new Exception('No se ha recibido comando');
                break;
        }
    }
}

/*************************************
 * Arranque
 ************************************/

try {
    $switchClient = new SwitchClient();
    $switchClient->execute('on');
    $switchClient->execute('off');

} catch (\Error $e) {
    var_dump($e);
} catch (\Exception $e) {
    var_dump($e);
}