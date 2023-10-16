<?php
function specialitiesCard($darkIconPath, $lightIconPath, $label){
?>

<div class="w-full group py-10 cursor-pointer flex flex-col justify-center items-center border-2 rounded-md">
    <div
        class="w-24 h-24 bg-[#F5F8FE] group-hover:bg-[#0D57E3] duration-300 rounded-full flex justify-center items-center">
        <img class="group-hover:hidden" src="<?php echo htmlspecialchars($darkIconPath); ?>" alt="Cardiology Icon">

        <img class="hidden group-hover:block duration-300" src="<?php echo htmlspecialchars($lightIconPath) ?>"
            alt="Cardiology Icon">
    </div>
    <div class="mt-3">
        <h1 class="font-bold"><?php echo $label ?> </h1>
    </div>
</div>

<?php
}
?>


