<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Strings
{

    public function __construct()
    {
    }
    function generateRandom($length = 5)
    {
        // return substr(str_shuffle(str_repeat($x = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);

        return rand(pow(10, $length - 1), pow(10, $length) - 1);
    }
}
                                                
/* End of file string.php */
