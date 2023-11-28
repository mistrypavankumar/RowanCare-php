<?php function uploadProfile($userData, $name, $profileImage)
{ ?>

    <div class="flex items-center gap-5 mb-5">
        <div class="w-24 h-24 bg-gray-200 overflow-hidden">
            <?php if (!empty($profileImage)) : ?>
                <img class="w-full object-cover" src="<?php echo $profileImage; ?>" alt="Profile Image">
            <?php else : ?>
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <p class="text-xl font-bold text-gray-500">
                        <?php
                        require_once 'components/functions.php';
                        echo getFirstLetter($userData['firstName']) ? getFirstLetter($userData['firstName']) : "DP";
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
        <div>
            <div class="p-4">
                <div class="flex flex-col md:flex-row md:items-center gap-5">
                    <div>
                        <label for="<?php echo $name ?>" class="flex items-center justify-center cursor-pointer bg-blue-500 hover:bg-blue-700 duration-500 text-white font-bold py-2 px-4 rounded">
                            <i class="fa fa-upload mr-2"></i>
                            <span>Upload Photo</span>
                            <input id="<?php echo $name ?>" name="<?php echo $name ?>" type="file" class="hidden" onchange="updateFileName()" />
                        </label>
                    </div>

                    <?php if (!empty(basename($profileImage ?? ""))) : ?>
                        <div>
                            <button type="button" id="removeProfileBtn" class="bg-red-500 text-white text-center py-2 px-4 rounded w-full">Remove profile</button>
                        </div>

                    <?php endif; ?>
                </div>
                <?php if (!empty($profileImage)) : ?>
                    <span id="file-name" class="ml-2 text-sm text-gray-500 mt-2">Current:
                        <?php echo basename($profileImage); ?>
                    </span>
                <?php else : ?>
                    <span id="file-name" class="ml-2 text-sm text-gray-500 mt-2"></span>
                <?php endif; ?>
                <p class="text-xs text-gray-500 mt-3">Allowed JPG, PNG and JPEG</p>
            </div>

        </div>
    </div>
<?php } ?>