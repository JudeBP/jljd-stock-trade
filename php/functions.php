<?php

// Sanitizes input - avoids injections and scripting
function clean($input){
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    $input = trim($input);
    return $input;
}

// Hide Bank Details
function hideBank($bank){
    $first_digits = substr($bank, 0, strlen($bank) - 3);
    $bank = str_replace($first_digits, str_repeat('*', strlen($first_digits)), $bank);
    return $bank;
}

?>