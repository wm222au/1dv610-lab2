<?php

namespace Helpers;


interface IDAL
{
    public function connect();
    public function disconnect();
    public function query($query);
}