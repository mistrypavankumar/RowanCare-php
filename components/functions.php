<?php

function listOfFooterLinks($title, $links = [], $mainDivStyle, $titleStyle, $style)
{
    echo '<div class = "' . $mainDivStyle . '">';
    echo '<h2 class = "' . $titleStyle . '">' . $title . '</h2>';

    foreach ($links as $linkText => $linkHref) {
        echo '<a class ="' . $style . '"href="' . $linkHref . '">' . $linkText . '</a>';
    }
    echo '</div>';
}


function textInputField($data, $label, $textType, $value, $disabled = null)
{
    // Check if $data is an array and $data[$value] is set
    $inputValue = is_array($data) && isset($data[$value]) ? $data[$value] : '';

    echo '
    <div class="flex flex-col gap-2">
        <label for="htmlFor">' . htmlspecialchars($label) . '</label>
        <input class="outline-none p-3 text-gray-500 rounded-md border-2" type="' . htmlspecialchars($textType) . '"
            name="' . htmlspecialchars($value) . '" placeholder="Enter Your ' . htmlspecialchars($label) . '" value="' . htmlspecialchars($inputValue) .
        '" ' . $disabled . ' required >
    </div>
    ';
}



function getFirstLetter($name)
{
    if (empty($name)) {
        return "DP"; // Default initials
    }

    $words = explode(" ", $name);
    $initials = '';

    foreach ($words as $w) {
        $initials .= mb_substr($w, 0, 1);
    }

    $initials = mb_substr($initials, 0, 2);

    return strtoupper($initials);
}


function createDialog($dialogId, $dialogContent, $showButtonText = "Show the dialog", $closeButtonText = "Close")
{
?>
    <dialog id="<?php echo $dialogId; ?>">
        <button autofocus><?php echo $closeButtonText; ?></button>
        <p><?php echo $dialogContent; ?></p>
    </dialog>
    <button id="show-<?php echo $dialogId; ?>"><?php echo $showButtonText; ?></button>

    <script>
        const dialog = document.querySelector("#<?php echo $dialogId; ?>");
        const showButton = document.querySelector("#show-<?php echo $dialogId; ?>");
        const closeButton = document.querySelector("#<?php echo $dialogId; ?> button");

        // "Show the dialog" button opens the dialog modally
        showButton.addEventListener("click", () => {
            dialog.showModal();
        });

        // "Close" button closes the dialog
        closeButton.addEventListener("click", () => {
            dialog.close();
        });
    </script>
<?php
}
