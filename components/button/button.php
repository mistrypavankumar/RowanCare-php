<?php 

class Button{
    private $text;
    private $class;

    public function __construct($text, $class) {
        $this->text = $text;
        $this->class = $class;
    }

    public function primaryButton(){
        echo '<h1 class="md:text-xl w-fit px-5 py-2 rounded-md border-2 border-red hover:bg-blue-500 cursor-pointer outline-none font-semibold duration-300 hover:scale-105 '.$this->class .'">'.$this->text."</h1>";   
    }

}

?>