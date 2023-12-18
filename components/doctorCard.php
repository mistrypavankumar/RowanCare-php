<?php

function doctorCard($doctorData, $specialization, $profileImage, $doctorAddress, $firstLetters, $color, $viewProfileBtn = true)
{
?>
    <div class="h-auto col-span-9 md:col-span-7 border-2 rounded-lg p-6">
        <div class="flex flex-col md:flex-row justify-between">
            <div class="flex flex-col items-center md:items-start text-center md:text-start md:flex-row gap-5">
                <?php if (!empty($profileImage['imagePath'] ?? "")) : ?>
                    <div class="w-[150px] h-[150px] overflow-hidden rounded-lg">
                        <img class="w-full object-cover" src="<?php echo $profileImage['imagePath'] ?>" alt="doctor" srcset="">
                    </div>
                <?php else : ?>
                    <div class="w-[150px] h-[150px] overflow-hidden rounded-lg bg-gray-200 flex items-center justify-center">
                        <h1 class="font-bold text-2xl text-gray-500"><?php echo $firstLetters ?></h1>
                    </div>
                <?php endif; ?>
                <div class="flex flex-col items-center md:items-start">
                    <h1 class="text-xl font-medium">Dr. <?php echo $doctorData['firstName'] . " " . $doctorData['lastName'] ?></h1>
                    <p class="text-gray-500">desljsljf lakjfl ajsldfj alfdjl</p>
                    <div class="w-4 h-4 flex items-center gap-2 mt-4 -ml-20 md:-ml-0">
                        <img class="w-full object-cover" src="assets/icons/dark/specialities-01.svg" alt="icon">
                        <p class="text-[<?php echo $color["primary"] ?>] font-medium"><?php echo $specialization['specialization'] ?></p>
                    </div>
                    <p class="text-gray-500 mt-2">
                        Rating <span class="text-black font-medium">(35)</span>
                    </p>
                    <p class="text-gray-500 mt-1">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <span><?php echo $doctorAddress['state'] ?>, <?php echo $doctorAddress['country'] ?></span>
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 flex flex-col items-center md:items-start w-full md:w-[19%] text-center md:text-start">
                <div class="flex gap-2 items-center">
                    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                    <span>100%</span>
                </div>
                <div class="flex gap-2 items-center">
                    <i class="fa fa-comment-o" aria-hidden="true"></i>
                    <span>35 Feedback</span>
                </div>
                <div class="flex gap-2 items-center">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <span><?php echo $doctorAddress['state'] ?>, <?php echo $doctorAddress['country'] ?></span>
                </div>
                <div class="flex gap-2 items-center">
                    <i class="fa fa-money" aria-hidden="true"></i>
                    <span><?php if ($specialization['consultingFee']) {
                                echo "$" . $specialization['consultingFee'];
                            } else {
                                echo "Not provided";
                            } ?></span>
                </div>

                <div class="flex flex-col w-full gap-4 mt-5">
                    <?php if ($viewProfileBtn) : ?>
                        <a class="text-center border-2 rounded-lg border-[<?php echo $color['primary'] ?>] text-[<?php echo $color['primary'] ?>] w-full py-2 font-semibold hover:bg-[<?php echo $color['primary'] ?>] hover:text-white duration-500" href="view-doctor-details.php?doctorId=<?php echo $doctorData['doctorId'] ?>">View Profile</a>

                    <?php endif; ?>
                    <a class="text-center border-2 rounded-lg border-[<?php echo $color['primary'] ?>] bg-[<?php echo $color['primary'] ?>] w-full py-2 font-semibold text-white" href="book-appointment.php?doctorId=<?php echo $doctorData['doctorId'] ?>">Book Appointment</a>
                </div>
            </div>
        </div>
    </div>


<?php } ?>