<?php

class Calculate {

    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct() {
        // Assign the CodeIgniter super-object
        $this->CI = & get_instance();
    }

    public function age($birthDate) {
        if (empty($birthDate)) {
            return null;
        }
        $birthDate = explode("-", $birthDate);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
        return $age;
    }

    public function dateDiff($date1, $date2) {
        $date1 = date_create($date1);
        $date2 = date_create($date2);
        // calculates the difference between DateTime objects 
        $interval = date_diff($date1, $date2);
        $days = $interval->days;
        if($date1 < $date2){
            $days= -$days;
        }
        return $days;
    }

    public function ageDiff($tanggalLahir, $tanggalPaket) {
        // Tanggal lahir
        $tanggal_lahir = new DateTime($tanggalLahir);

        // Tanggal sekarang
        $tanggal_paket = new DateTime($tanggalPaket);

        // Hitung selisih
        $selisih = $tanggal_lahir->diff($tanggal_paket);

        // Tampilkan umur
        $umur = $selisih->y;

        return $umur;

    }
}
