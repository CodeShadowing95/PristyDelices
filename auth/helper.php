<?php

function validate_input_text($textValue) {
    if (!empty($textValue)) {
        // trim(value) to remove any spaces or whites spaces from the beginning or end of the value
        $trim_text = trim($textValue);
        // remove all illegal characters from $trim_text and store it in $sanitize_str
        $sanitize_str = filter_var($trim_text, FILTER_SANITIZE_STRING);
        return $sanitize_str;
    }
    return '';
}

function validate_input_email($emailValue) {
    if (!empty($emailValue)) {
        // trim(value) to remove any spaces or whites spaces from the beginning or end of the value
        $trim_text = trim($emailValue);
        // remove all illegal characters from $trim_text and store it in $sanitize_str
        $sanitize_str = filter_var($trim_text, FILTER_SANITIZE_EMAIL);
        return $sanitize_str;
    }
    return '';
}