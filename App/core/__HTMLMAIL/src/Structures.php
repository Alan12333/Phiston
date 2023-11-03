<?php
class Structures
{
    /**
     * En esta variable se guardaran las entradas a la clase
     */
    protected $string;

    /**
     * En esta variable se almacenaran los datos del arreglo recibido desde la expresión ForIn
     */
    protected $array;

    protected $index;

    /**
     * Separa los tipos de integración en el ciclo for
     */

    public function reemplazar($cadena = "", $arreglo=[], $index=0)
    {
        $this->index = $index;
        $this->string = $cadena;
        $this->array = $arreglo;
        return $this->DefineType();
    }

    private function DefineType()
    {
        $separate = explode("{item}", $this->string);
        if(join($separate) === $this->string)
        {
            return $this->ManyItems();
        }
        else
        {
            return $this->OneItem();
        }
    }

    private function OneItem()
    {
        $spring = explode("{index}", $this->string);
        if(count($spring) >= 2)
        {
            $completestring = "";
            $completestring = str_replace('{item}', $this->array, $this->string);
            $completestring = str_replace('{index}', $this->index, $completestring);
        }
        else
        {
            $completestring = "";
            $completestring = str_replace('{item}', $this->array, $this->string);
        }
        return htmlspecialchars_decode($completestring);
    }

    private function ManyItems()
    {
        $spring = explode("{index}", $this->string);
        if(count($spring) >= 2)
        {
            $patron = "/{item\.\w+}/";
            $var = "";
            // Realizar la búsqueda utilizando preg_match
            if (preg_match_all($patron, $this->string, $matches)) {
                $itemNombre = $matches[0]; // Obtener el primer resultado encontrado
                foreach($itemNombre as $item)
                {
                    $sep1 = explode("{item.", $item);
                    $sep2 = explode("}", join($sep1));
                    $var = $sep2[0];
                    $this->string = str_replace($item, $this->array[$var], $this->string);
                    $this->string = str_replace("{index}", $this->index, $this->string);
                }
            } 
        }
        else
        {
            $patron = "/{item\.\w+}/";
            $var = "";
            // Realizar la búsqueda utilizando preg_match
            if (preg_match_all($patron, $this->string, $matches)) {
                $itemNombre = $matches[0]; // Obtener el primer resultado encontrado
                foreach($itemNombre as $item)
                {
                    $sep1 = explode("{item.", $item);
                    $sep2 = explode("}", join($sep1));
                    $var = $sep2[0];
                    $this->string = str_replace($item, $this->array[$var], $this->string);
                }
            } 
        }
        return htmlspecialchars_decode($this->string);
    }
}
?>