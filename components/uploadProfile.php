<?php function uploadProfile($userData, $name)
{ ?>

    <div class="flex items-center gap-5 mb-5">
        <div class="w-24 h-24 bg-gray-200 overflow-hidden">
            <?php if (!empty($userData['image_path'])): ?>
                <img class="w-full object-cover" src="<?php echo $userData['image_path']; ?>" alt="Profile Image">
            <?php else: ?>
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
                <label for="<?php echo $name ?>"
                    class="flex items-center justify-center cursor-pointer bg-blue-500 hover:bg-blue-700 duration-500 text-white font-bold py-2 px-4 rounded">
                    <i class="fa fa-upload mr-2"></i>
                    <span>Upload Photo</span>
                    <input id="<?php echo $name ?>" name="<?php echo $name ?>" type="file" class="hidden"
                        onchange="updateFileName()" />
                </label>
                <?php if (!empty($userData['image_path'])): ?>
                    <span id="file-name" class="ml-2 text-sm text-gray-500 mt-2">Current:
                        <?php echo basename($userData['image_path']); ?>
                    </span>
                <?php else: ?>
                    <span id="file-name" class="ml-2 text-sm text-gray-500 mt-2"></span>
                <?php endif; ?>
                <p class="text-xs text-gray-500 mt-3">Allowed JPG, PNG and JPEG</p>
            </div>

        </div>
    </div>
<?php } ?>