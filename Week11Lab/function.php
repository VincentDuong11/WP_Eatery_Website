<?php
function validateEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

function validatePhone($phone)
{
    if (preg_match("/^[0-9]{10}$/", $phone)) {
        return true;
    }
    return false;
}
