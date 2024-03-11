<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Token
{

    public function __construct()
    {
    }

    public function generate_tokens()
    {
        $selector = bin2hex($this->generateRandomString(16));
        $validator = bin2hex($this->generateRandomString(32));

        return [
            'selector' => $selector,
            'validator' => $validator,
            'token' => $selector . ':' . $validator
        ];
    }
    public function generateRandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
    public function parse_token($token)
    {
        $parts = explode(':', $token);

        if ($parts && count($parts) == 2) {
            return [$parts[0], $parts[1]];
        }
        return null;
    }
}
                                                
/* End of file Token.php */
