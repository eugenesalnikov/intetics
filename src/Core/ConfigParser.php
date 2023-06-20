<?php

namespace ESalnikov\Intetics\Core;

class ConfigParser
{
    public function parse()
    {
        return parse_ini_file('../config/config.ini');
    }
}
