<?php

if (!function_exists('format_amount')) {
    function format_amount(int|float $amount): string
    {
        return number_format($amount / 100, 2, ',', ' ') . ' €';
    }
}