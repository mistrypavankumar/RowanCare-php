<?php
function bestDoctorCard(string $image, string $doctorName, string $specialization, string $rating, string $place)
{
    ?>
    <div class="overflow-hidden group cursor-pointer showdow-lg">
        <div class="w-full h-[250px] overflow-hidden rounded-t-15 bg-white rounded-tl-lg rounded-tr-lg">
            <img class="w-full group-hover:scale-110 duration-300" src="<?php echo $image ?>" alt="">
        </div>
        <div class="p-3 bg-white rounded-bl-lg rounded-br-lg">
            <div class="flex justify-between items-center">
                <h1 class="font-bold text-xl">
                    <?php echo $doctorName ?>
                </h1>
                <p class="text-white bg-yellow-500 px-3 rounded-full py-[1px]">
                    <?php echo $rating ?>
                </p>
            </div>
            <p class="text-[13px] text-gray-500 mb-3">
                <?php echo $specialization; ?>
            </p>

            <p class="text-[14px] text-gray-500/70 font-semibold">
                <?php echo $place; ?>
            </p>

        </div>
    </div>

    <?php
}
?>