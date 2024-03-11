<?php

class Secret_key
{

    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    // public function __construct()
    // {
    //     // Assign the CodeIgniter super-object
    //     $this->CI = &get_instance();
    // }

    public function generate($id)
    {
        $id_secret = md5($id . 'ventourapp');
        $result = $id . '_' . $id_secret ;

        return $result ;
    }

    public function validate($id_secret) {
        $pos = strpos($id_secret, '_');
        $id = substr($id_secret,0,$pos);
        $secret_key = substr($id_secret, $pos+1);
        $secret_id = md5($id.'ventourapp');

        if ($secret_id == $secret_key) {
            return $id ;
        } else {
            return false ;
        }
    }
}
