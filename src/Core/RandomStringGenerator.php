<?php

namespace ESalnikov\Intetics\Core;

class RandomStringGenerator
{
    public function generate()
    {
        return base64_encode(random_bytes(10));
    }
}
