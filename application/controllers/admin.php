<?php

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function bbs() {
        echo 'Hello World!';
    }

    public function comments($e=999) {
        echo $e;
        echo '看这里！';
    }
public function _remap($method)
{
    if ($method == 'index')
    {
        $this->$method();
    }
    else
    {
        $this->comments();
    }
}

public function _output($output)
{
    echo 333;
    echo $output;
}
}

?>