<?php

namespace ESalnikov\Intetics\Controller;

class AbstractController
{
    public function render(string $template, array $params = [])
    {
        extract($params);
        ob_start();

        require_once '../templates/' . $template;

        echo ob_get_clean();
    }

}
