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

$feeRanges = [
  ['fee' => '100-200'],
  ['fee' => '200-300'],
  ['fee' => '300-400'],
  ['fee' => '400-500'],
];


$bestDoctors = [
  [
    'doctorName' => 'Dr. John Smith',
    'specialization' => 'Neurology',
    'place' => 'New York',
    'rating' => '4.5',
    'image' => 'https://th.bing.com/th/id/R.2dccd776b3244753340c0d10e9d89e8d?rik=uegYhAEwMjgYlw&pid=ImgRaw&r=0https://th.bing.com/th/id/R.2dccd776b3244753340c0d10e9d89e8d?rik=uegYhAEwMjgYlw&pid=ImgRaw&r=0',
  ],
  [

    'doctorName' => 'Dr. Sarah Johnson',
    'specialization' => 'Cardiology',
    'place' => 'Los Angeles',
    'rating' => '4.8',
    'image' => 'https://th.bing.com/th/id/R.58f60f6b81ae6d054b6b4910a9771fbf?rik=%2fKjN%2fqPR7wXaUw&pid=ImgRaw&r=0',
  ],
  [
    'doctorName' => 'Dr. Michael Brown',
    'specialization' => 'Oncology',
    'place' => 'Chicago',
    'rating' => '4.2',
    'image' => 'https://th.bing.com/th/id/OIP.UxfwsnrF_UBmz31cptdmMAAAAA?pid=ImgDet&rs=1',
  ],
  [

    'doctorName' => 'Dr. Emily Davis',
    'specialization' => 'Dermatology',
    'place' => 'Houston',
    'rating' => '4.7',
    'image' => 'https://th.bing.com/th/id/R.cbaa04fd95eb831173fb920548a7360b?rik=91MZtT%2bC6hLpMQ&riu=http%3a%2f%2faditrihospital.com%2fwp-content%2fuploads%2f2020%2f08%2fDoctor_03-600x600.jpg&ehk=sH7D4HyHyDr2uXSgr8%2bmRx3r302%2b0n5lh3r5nD%2f4Ats%3d&risl=&pid=ImgRaw&r=0',
  ],
  [

    'doctorName' => 'Dr. Robert Wilson',
    'specialization' => 'Orthopedics',
    'place' => 'Philadelphia',
    'rating' => '4.3',
    'image' => 'https://i.pinimg.com/originals/36/8f/50/368f500d5cb96ada4e31e2ff7fb817ad.png',
  ],
  [
    'doctorName' => 'Dr. Jennifer Lee',
    'specialization' => 'Pediatrics',
    'place' => 'Phoenix',
    'rating' => '4.6',
    'image' => 'https://th.bing.com/th/id/R.ae483966e840cfe817709cfd0dbbbaab?rik=os6BEe7b%2fbdRkA&riu=http%3a%2f%2fskinos.in%2fimages%2fdoctor-4.jpg&ehk=nUYfC1FnF1Yp6o4%2foSlgx1kKkNTY5D5aG9DBrmhN%2fKs%3d&risl=&pid=ImgRaw&r=0',
  ],
  [
    'doctorName' => 'Dr. David Thompson',
    'specialization' => 'Gastroenterology',
    'place' => 'San Antonio',
    'rating' => '4.4',
    'image' => 'https://th.bing.com/th/id/R.b757258c7725f2b1bf7ed09feecc8d1f?rik=64%2fQHKru9x2irQ&riu=http%3a%2f%2famericanstimulusfunding.com%2fwp-content%2fuploads%2f2017%2f01%2fdoctor-with-co-workers-analyzing-an-x-ray_1098-581.jpg&ehk=eIl9O0G6nX7ckic%2b5VU5AmJjSr773I1yfmdFc6ycDhw%3d&risl=&pid=ImgRaw&r=0',
  ],
];


$doctorDashboardNav = [
  [
    'label' => "Dashboard",
    'path' => "doctor-dashboard.php",
    'icon' => "fa-window-maximize",
  ],
  [
    'label' => "Appointments",
    'path' => "",
    'icon' => "fa-calendar-check-o",
  ],
  [
    'label' => "My Patients",
    'path' => "",
    'icon' => "fa-user-plus",
  ],
  [
    'label' => "Schedule Timings",
    'path' => "",
    'icon' => "fa-hourglass-start",
  ],
  [
    'label' => "Available Timings",
    'path' => "",
    'icon' => "fa-clock-o",
  ],
  [
    'label' => "Invoices",
    'path' => "",
    'icon' => "fa-wpforms",
  ],
  [
    'label' => "Profile Settings",
    'path' => "doctor-profile-settings.php",
    'icon' => "fa-cog",
  ],
  [
    'label' => "Change Password",
    'path' => "",
    'icon' => "fa-lock",
  ],
  [
    'label' => "Logout",
    'path' => "logout.php",
    'icon' => "fa-sign-out",
  ],
];

$patientDashboardNav = [
  [
    'label' => "Dashboard",
    'path' => "patient-dashboard.php",
    'icon' => "fa-window-maximize",
  ],
  [
    'label' => "Book Appointment",
    'path' => "book-appointment.php",
    'icon' => "fa-calendar-check-o",
  ],
  [
    'label' => "Orders",
    'path' => "",
    'icon' => "fa-user-plus",
  ],
  [
    'label' => "Prescription",
    'path' => "",
    'icon' => "fa-hourglass-start",
  ],
  [
    'label' => "Billing",
    'path' => "",
    'icon' => "fa-clock-o",
  ],
  [
    'label' => "Profile Settings",
    'path' => "patient-profile-settings.php",
    'icon' => "fa-cog",
  ],
  [
    'label' => "Change Password",
    'path' => "",
    'icon' => "fa-lock",
  ],
  [
    'label' => "Logout",
    'path' => "logout.php",
    'icon' => "fa-sign-out",
  ],
];



// default menu list
class Menu
{
  public $name;
  public $path;

  public function __construct($name, $path)
  {
    $this->name = $name;
    $this->path = $path;
  }
}

$menuList = [
  new Menu("Home", "/"),
  new Menu("Pharmacy", "/pharmacy")
];
