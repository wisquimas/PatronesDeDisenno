<?php

/**
 * Observer
 * Permite añadir observadores que lueso seran notificados
 */

/**
 * Class Observable
 * Este trait permite de forma facil añadir la observabilidad en cualquier objeto
 */
trait Observable
{
    /**
     * @var Observer[]
     */
    private $observers = [];

    final public function addObserver(Observer $observer)
    {
        if (array_search($observer, $this->observers) === false) {
            array_push($this->observers, $observer);
        }
    }

    final public function removeObserver(Observer $observer)
    {
        $position = array_search($observer, $this->observers);
        if ($position) unset($this->observers[$position]);
    }

    final public function notifyAll(Message $message)
    {
        if (count($this->observers)) {
            foreach ($this->observers as $observer) {
                $observer->notify($message);
            }
        }
    }
}

/**
 * Class Blog
 * Clase a la que le permitimos ser observable y notificar
 */
class Blog
{
    use Observable;

    public function postear(Post $post)
    {
        echo "Almacenar post\n";
        //notificar
        $this->notifyAll(new PostMessage($post));
    }
}

/**
 * Interface Observer
 * Interfas de clases que pueden ser notificadas. Obligamos a recibir un objeto de un tipo determinado por seguridad y comodidad
 */
interface Observer
{
    public function notify(Message $message);
}

/**
 * Class Usuario
 * Observador concreto
 */
class Usuario implements Observer
{
    private $nombre;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
    }

    public function notify(Message $message)
    {
        echo "Notificacion para: {$this->nombre}\n";
        echo "{$message->getInfo()}\n";
    }
}

/**
 * Class Post
 * Elemento que usamos de ejemplo
 */
class Post
{
    private $title;
    private $content;

    public function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
}

/**
 * Interface Message
 * Interfaz que nos ayudara de forma sencilla para poder utilizar cualquier tipo de mensaje en el sistema
 */
interface Message
{
    public function getInfo();
}

/**
 * Class PostMessage
 * Elemento que puede ser usado como mensaje
 */
class PostMessage implements Message
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getInfo()
    {
        return "Tenemos un nuevo mensaje: \"{$this->post->getTitle()}\"";
    }
}

/*************************************
 * Arranque
 ************************************/

try {
    $blog = new Blog();

    $juan = new Usuario('Juan');
    $pepe = new Usuario('Pepe');

    $blog->addObserver($juan);
    $blog->addObserver($pepe);

    $blog->postear(new Post('Titular', 'mensaje'));

    $blog->removeObserver($pepe);
    $blog->postear(new Post('Titular2', 'mensaje'));

} catch (\Error $e) {
    var_dump($e);
} catch (\Exception $e) {
    var_dump($e);
}