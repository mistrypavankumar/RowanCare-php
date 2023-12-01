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

function dashboardNavigation($conn, $userData, $patientDashboardNav, $color, $userType, $profileImage)
{
    $page = basename($_SERVER['REQUEST_URI']);

    $address = getAddress($conn, $userData[$userType . "Id"], $userType);

?>
    <div class="h-fit col-span-9 md:col-span-2 bg-white border-2 rounded-lg">
        <div class="flex w-full items-center justify-center py-10 flex-col space-y-2">
            <div class="bg-gray-100 w-[150px] h-[150px] overflow-hidden rounded-full flex items-center justify-center">
                <?php if (!empty($profileImage ?? "")) : ?>
                    <div class="w-[150px] h-[150px] rounded-full overflow-hidden flex items-center">
                        <img class="w-full h-full object-cover rounded-full" src="<?php echo $profileImage; ?>" alt="Profile Image">

                    </div>
                <?php else : ?>
                    <div class="rounded-full bg-gray-200 overflow-hidden flex items-center justify-center w-full h-full">
                        <p class="text-xl font-bold text-gray-500">
                            <?php
                            require_once 'components/functions.php';
                            echo getFirstLetter($userData['firstName']) ? getFirstLetter($userData['firstName']) : "DP";
                            ?>
                        </p>
                    </div>
                <?php endif; ?>
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


            <?php if ($userType === "patient") {
                $res = explode("-", $userData['dateOfBirth']);
                $dob = date('d M Y', strtotime(implode("-", array_reverse($res))));

                $dateOfBirth = new DateTime($userData['dateOfBirth']);
                $today = new DateTime('today');
                $age = $dateOfBirth->diff($today)->y;  // y - get the year difference    
            ?>
                <div class="flex flex-col items-center justify-center gap-2">
                    <div class="flex items-center gap-2">
                        <i class="fa fa-birthday-cake text-gray-500 text-xs" aria-hidden="true"></i>
                        <p class="text-gray-500 text-xs font-medium"><?php echo $dob . ", " . $age . " years" ?></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa fa-map-marker text-gray-500 text-xs" aria-hidden="true"></i>
                        <p class="text-gray-500 text-xs font-medium"><?php echo $address['state'] ?></p>
                    </div>
                </div>
            <?php } else { ?>
                <p class="text-xs text-gray-500">BDS, MDS - Oral & Maxillofacial Surgery</p>
            <?php } ?>

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