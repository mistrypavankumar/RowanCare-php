<?php 

  // default colors list
  $color = [
    'primary' => '#0D57E3',
    'secondary' => '#C8CACC',
    'bg' => "#ffffff"
  ];

  
  // default menu list
  Class Menu{
    public $name;
    public $path;

    public function __construct($name, $path){
      $this->name = $name;
      $this-> path=  $path ;
    }
  }

  $menuList = [
    new Menu("Home","/"),
    new Menu("Pharmacy", "/pharmacy")
  ]





?>