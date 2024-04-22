<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Money
{

    public function __construct()
    {
    }

    public function format($num)
    {
        return "Rp. " . number_format($num, 0, ',', '.');
    }
    public function hargaHomeFormat($num)
    {

        $hargaLen = strlen($num);
        $hargaHome = '';
        if ($hargaLen < 7) {
            $hargaHome = $this->format($num);
        } else {

            $digitJuta = $hargaLen - 6;
            $hargaHome = 'Rp. ' . substr($num, 0, $digitJuta);

            $sisaDigit = substr($num, $digitJuta, 2);
            // ambil dua digit jika dia tidak 0
            if (intval($sisaDigit) > 0) {
                $sisaDigit1 = substr($sisaDigit, 0, 1);
                $sisaDigit2 = substr($sisaDigit, 1, 1);
                $hargaHome = $hargaHome . ",$sisaDigit1";
                if (intval($sisaDigit2) > 0) {
                    $hargaHome = $hargaHome . "$sisaDigit2";
                }
            }
            // $jutaClass = ' <sup class="font-300 font-16" style="font-weight:bold;">Jt</sup>';
            $hargaHome = $hargaHome;
        }
        return $hargaHome;
    }

    public function hargaDiscountFormat($num)
    {

        $hargaLen = strlen($num);
        $hargaHome = '';
        if ($hargaLen < 7) {
            $hargaHome = $num;
        } else {

            $digitJuta = $hargaLen - 6;
            $hargaHome = substr($num, 0, $digitJuta);

            $sisaDigit = substr($num, $digitJuta, 2);
            // ambil dua digit jika dia tidak 0
            if (intval($sisaDigit) > 0) {
                $sisaDigit1 = substr($sisaDigit, 0, 1);
                $sisaDigit2 = substr($sisaDigit, 1, 1);
                $hargaHome = $hargaHome . ",$sisaDigit1";
                if (intval($sisaDigit2) > 0) {
                    $hargaHome = $hargaHome . "$sisaDigit2";
                }
            }
            // $jutaClass = ' <sup class="font-300 font-16" style="font-weight:bold;">Jt</sup>';
            $hargaHome = "$hargaHome Juta";
        }
        return $hargaHome;
    }

    public function hargaHomeRibu($number) {
        // Jika angka lebih dari atau sama dengan satu miliar
        if ($number >= 1000000000) {
            return number_format($number / 1000000000) . ' <sup class="font-300 font-16" style="font-weight:bold;">B</sup>';
        }
        // Jika angka lebih dari atau sama dengan satu juta
        elseif ($number >= 1000000) {
            return number_format($number / 1000000) . ' <sup class="font-300 font-16" style="font-weight:bold;">Jt</sup>';
        }
        // Jika angka lebih dari atau sama dengan ribuan
        elseif ($number >= 1000) {
            return number_format($number / 1000) . ' <sup class="font-300 font-16" style="font-weight:bold;">Rb</sup>';
        }
        // Jika angka kurang dari ribuan
        else {
            return number_format($number);
        }
    }
}
                                                
/* End of file Money.php */