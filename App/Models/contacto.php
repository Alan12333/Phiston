<?php
class usuario extends Model
{
	public $id;
	public $nombre;
    public $correo;
    public $password;

	function __construct()
	{
		parent::__construct(contacto::class, $this);
	}

    // function para saber si algún dato sera encriptado
    public function bcrypt()
    {
        return [
            "password"
        ];
    }

}
?>