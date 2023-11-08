<?php
class Page_Controller extends Views
{
    public $user = "";
    /**
     * Si usaras un modelo la variable debe ser protected por ejemplo
     * 
     * protected $usuario;
     */

    public function __construct()
    {
        /**
         * Dentro del controlador debes crear la instancia de tu modelo para que este puede ser accesible en toda la clase
         * 
         *por ejemplo
         *
         * $this->usuario = new Usuario;
        */
    }

    public function index()
    {
        return $this->View("index", "Phiston");
    }

    public function inicio($alan)
    {
        echo $alan;
    }
}
