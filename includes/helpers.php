<?php

use Carbon\Carbon;

if (!function_exists('carbon')) {
    function carbon()
    {
        return Carbon::now();
    }
}

if (!function_exists('currency')) {
    /**
     * Format the amount in decimal
     * into Indian currency
     * @param  decimal $amount
     * @return string
     *
     * @author Daksh Mehta <dm@rimail.in>
     */
    function currency($amount)
    {
        if ($amount != null) {
            return '&#x20b9; ' . number_format($amount, 2) . '/-';
        } else {
            return '&#x20b9; ' . number_format(0, 2) . '/-';
        }
    }
}
