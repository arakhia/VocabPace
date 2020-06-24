<?php

function generatesUserAvatar($email)
{
    $avatarURL = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?s=180&d=identicon&r=g";
    return $avatarURL;
}

?>