<?php

if (! function_exists('money')) {
    function money($amount, $currency = 'eur', $fraction_digits = 2)
    {
        $locale = config('app.locale');

        $fmt = numfmt_create($locale, NumberFormatter::CURRENCY);

        $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, $fraction_digits);

        return $fmt->formatCurrency($amount / 100, $currency);
    }
}
