<?php 

  // default colors list
  $color = [
    'primary' => '#0D57E3',
    'secondary' => '#C8CACC',
    'bg' => "#ffffff"
  ];

  $specialities = [
    ['dark' => './assets/icons/dark/specialities-01.svg', 'light' => './assets/icons/light/specialities-01.svg', 'name' => 'Cardiology'],
    ['dark' => './assets/icons/dark/specialities-02.svg', 'light' => './assets/icons/light/specialities-02.svg', 'name' => 'Neurology'],
    ['dark' => './assets/icons/dark/specialities-04.svg', 'light' => './assets/icons/light/specialities-04.svg', 'name' => 'Orthopedic'],
    ['dark' => './assets/icons/dark/specialities-05.svg', 'light' => './assets/icons/light/specialities-05.svg', 'name' => 'Dentist'],
    ['dark' => './assets/icons/dark/specialities-06.svg', 'light' => './assets/icons/light/specialities-06.svg', 'name' => 'Ophthalmology']
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