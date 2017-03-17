<?php

/**
 * Facade
 * Sirve como interfaz simple para controlar subsistemas
 */

/**
 * Class Scanner
 * Supuesto subsistema complejo
 */
class Scanner
{
    private $name;

    public function __construct()
    {
        $this->name = 'Scanner';
        echo "Iniciando Scanner\n";
    }

    public function run()
    {
        echo "Run {$this->name}\n";
    }
}

/**
 * Class Parser
 * Supuesto subsistema complejo
 */
class Parser
{
    private $name;

    public function __construct()
    {
        $this->name = 'Parser';
        echo "Iniciando Parser\n";
    }

    public function run()
    {
        echo "Run {$this->name}\n";
    }
}

/**
 * Class Compiler
 *
 * Ejemplo de facade porque se encarga de mandar a subsistemas complejos como si de director se tratase
 */
class Compiler
{
    private $name;
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var Scanner
     */
    private $scanner;

    public function __construct()
    {
        $this->name = 'Compiler';
        $this->scanner = new Scanner();
        $this->parser = new Parser();
        echo "Iniciando Compiler\n";
    }

    public function Compilar()
    {
        echo "Compilando...\n";
        $this->scanner->run();
        $this->parser->run();
        echo "Finaliza Compilado\n";
    }
}

/*************************************
 * Arranque
 ************************************/

try {
    $compilador = new Compiler();
    $compilador->Compilar();

} catch (Error $e) {
    var_dump($e);
} catch (Exception $e) {
    var_dump($e);
}