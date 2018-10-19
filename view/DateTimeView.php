<?php

namespace View;

class DateTimeView
{

    public function show()
    {
        date_default_timezone_set('Europe/Stockholm');

        $timeString = date('l') . ', the ' . date('dS') . ' of ' . date('F') . ' ' . date('Y') . ', The time is ' . date('G:i:s');

        return '<p>' . $timeString . '</p>';
    }
}
