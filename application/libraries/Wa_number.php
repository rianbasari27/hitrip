<?php 

class Wa_number {

    public function convert($number) {
        $number = preg_replace('/[^0-9]/', '', $number);
        if (substr($number, 0, 1) === '0') {
            $number = '+62' . substr($number, 1);
        }
        else if ($number === null || $number === '') {
            $number = '-';
        }
        else if (substr($number, 0, 1) !== '+' && substr($number, 0, 2) !== '62') {
            $number = '+62' . $number;
        }
        else if (substr($number, 0, 2) === '62') {
            $number = '+' . $number;
        }
        return $number;
    }

}

?>