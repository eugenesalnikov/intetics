<?php

namespace ESalnikov\Intetics\Transport;

abstract class Sender
{
    abstract public function sendMessage(string $data);

}
