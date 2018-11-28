<?php

function ax_date_today()
{
    $cutOffTime = env('NEO_CUT_OFF_TIME', '08:00:00');
    if (date('H:i:s') < $cutOffTime) {
        return date('Y-m-d', strtotime('yesterday'));
    } else {
        return date('Y-m-d');
    }
}

function ax_date_period_format($start, $end)
{
    $startUTS = strtotime($start);
    $endUTS = strtotime($end);
    
    if ($start === $end) {
        $formatted = date('l, d M Y', $startUTS);
    } elseif (date('Y', $startUTS) === date('Y', $endUTS)) {
        if (date('m', $startUTS) === date('m', $endUTS)) {
            $formatted = date('d', $startUTS) . ' - ' . date('d M Y', $endUTS);
        } else {
            $formatted = date('d M', $startUTS) . ' - ' . date('d M Y', $endUTS);
        }
    } else {
        $formatted = date('d M Y', $startUTS) . ' - ' . date('d M Y', $endUTS);
    }
    
    return $formatted;
}