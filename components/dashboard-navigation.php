<?php

function dashboardNavLink($color, $label, $icon, $path, $page)
{
    $activeStyle = $page === $path ? "text-[#0D57E3] " : "text-gray-500";

    echo '
    <a class="' . $activeStyle . ' p-4 cursor-pointer border-t-2 hover:text-[' . $color['primary'] . ']
     " href="' . $path . '"> <i class="fa ' . $icon . ' mr-1" aria-hidden="true"></i>
    ' . $label . '</a>
    ';
}

function dashboardNavigation($userData, $patientDashboardNav, $color, $userType)
{
    $page = basename($_SERVER['REQUEST_URI']);

    ?>
    <div class="col-span-9 md:col-span-2 bg-white border-2 rounded-lg">
        <div class="flex w-full items-center justify-center py-10 flex-col space-y-2">
            <div class="bg-gray-100 w-[150px] h-[150px] rounded-full p-2 flex items-center">
                <div class="rounded-full bg-red-500 overflow-hidden flex items-center">
                    <img class="w-full h-full object-cover" src="" alt="profile-image">
                </div>
            </div>
            <?php
            if ($userType === 'patient') {
                ?>
                <h2 class="font-semibold">
                    <?php echo $userData['firstName'] . " " . $userData['lastName'] ?>

                </h2>
            <?php } else if ($userType === 'doctor') { ?>
                    <h2 class="font-semibold">
                    <?php echo "Dr. " . $userData['firstName'] . " " . $userData['lastName'] ?>

                    </h2>
            <?php } ?>


            <p class="text-xs text-gray-500">BDS, MDS - Oral & Maxillofacial Surgery</p>
        </div>
        <div class="flex flex-col">
            <?php
            foreach ($patientDashboardNav as $menu) {
                dashboardNavLink(color: $color, label: $menu['label'], icon: $menu['icon'], path: $menu['path'], page: $page);
            }
            ?>
        </div>
    </div>

    <?php
}
?>