<?php

namespace View;

class DateTimeView implements View
{

    public function toHTML(): string
    {
        date_default_timezone_set('Europe/Stockholm');

        $timeString = date('l') . ', the ' . date('dS') . ' of ' . date('F') . ' ' . date('Y') . ', The time is ' . date('G:i:s');

        return '<p>' . $timeString . '</p>';
    }
}
