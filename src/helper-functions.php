<?php

function ax_date_today()
{
    $cutOffTime = env('NEO_CUT_OFF_TIME', 8);
    if (date('H:i:s') < $cutOffTime) {
        return date('Y-m-d', strtotime('yesterday'));
    } else {
        return date('Y-m-d');
    }
}