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


function textInputField($userData, $label, $textType, $value, $disabled = null)
{
    echo '
    <div class="flex flex-col gap-2">
        <label for="htmlFor">' . $label . '</label>
        <input class="outline-none p-3 text-gray-500 rounded-md border-2" type="' . $textType . '"
            name="' . $value . '" placeholder="Enter Your ' . $label . '" value="' . $userData[$value] .
        '" ' . $disabled . ' required >
    </div>
    ';
}

?>