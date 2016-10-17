<?php

function camelCase($string)
{
    $string = ucwords(strtolower(str_replace([' ', '_', '-'], ' ', $string)));
    $field = lcfirst(str_replace(' ', '', $string));

    return $field;
}
