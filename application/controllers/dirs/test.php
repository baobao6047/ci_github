<?php
class Test extends CI_Controller
{
    public function index()
    {
        echo 'this index';
        echo '<br/>';
        $RTR = &load_class ( 'Router', 'core' );
        $d = $RTR->fetch_directory ();
        $class = $RTR->fetch_class();
        $m = $RTR->fetch_method();
        print_r($class);
        echo '<br>';
        echo $d;
        echo '<br>';
        echo $m;
        die;
    }
}
