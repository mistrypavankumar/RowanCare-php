<?php

function banner($title, $path)
{

    ?>
    <div class="h-[40vh] md:h-[50vh] bg-[#F5F8FE]">
        <div class="h-full flex flex-col items-center justify-end pb-[70px] md:pb-24">
            <h1 class="font-bold text-4xl md:text-5xl mb-5">
                <?php echo $title; ?>
            </h1>
            <p class="text-gray-500">Home |
                <span class="text-gray-900">
                    <?php echo $path; ?>
                </span>
            </p>
        </div>
    </div>
    <?php
}

?>