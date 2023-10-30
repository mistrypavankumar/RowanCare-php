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

?>