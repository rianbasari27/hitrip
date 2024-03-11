<?php
/*
|------------------------------------------------------------------
| Date Converter
|------------------------------------------------------------------
| Converting date format using language in codeigniter
| 
| Add code below to language directory in codeigniter
| application/language/indonesia/date_lang.php : 
| 
| $lang['month_name'] = array(1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
| $lang['day_name'] = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
| 
 */
require_once dirname(__FILE__) . '/HijriDateLib/hijri.class.php';
class Date
{
    public function gregorianToHijri($gregorianDate, $format = "Y-m-d")
    {
        if ($format != "Y-m-d") {
            $wrongFormat = date_create_from_format($format, $gregorianDate);
            $gregorianDate = $wrongFormat->format("Y-m-d");
        }
        $DateObj = new hijri\datetime($gregorianDate);
        $DateObj->langcode = 'en';
        return ($DateObj->format('_Y-_m-_d'));
    }

    public function getMusim($hijri = null) 
    {
        if ($hijri == null) {
            $musim = $this->getHijriYear();
        } else {
            $musim = $hijri ;
        }

        $awalMusim = new hijri\Calendar();
        $tglAwal = $awalMusim->HijriToGregorian($musim, "01", "01");
        $dateStartSeason = implode("-", $tglAwal);
        $dateStartSeason = date('Y-m-d', strtotime($dateStartSeason));

        $tglAkhir = $awalMusim->HijriToGregorian($musim + 1, "01", "01");
        $dateEndSeason = implode("-", $tglAkhir);
        $dateEndSeason = date('Y-m-d', strtotime($dateEndSeason . " -1 day"));

        $result = [
            "hijri" => $musim,
            "tglAwal" => $dateStartSeason,
            "tglAkhir" => $dateEndSeason
        ];

        return $result;
    }

    public function getHijriYear($date = null) {
        if ($date == null) {
            $date = date("Y-m-d");
        }
        $dateNow = $date;
        $DateObj = new hijri\datetime($dateNow);
        $DateObj->langcode = 'en';
        return ($DateObj->format('_Y'));

    }

    public function convert($new_format, $date, $lang = 'id')
    {
        // D	=	Mon through Sun
        // l	=	Sunday through Saturday
        // N	=	1 (for Monday) through 7 (for Sunday)
        // w	=	0 (for Sunday) through 6 (for Saturday)
        // F	=	January through December
        // M	=	Jan through Dec

        $timestamp = strtotime($date);
        if ($lang != 'en') {
            $app = &get_instance();
            $idiom = $app->config->item('language_id')[$lang];
            $app->lang->load('date', $idiom);

            $converted_date = date($new_format, $timestamp);
            if (strpos($new_format, 'F') !== FALSE) {
                $month_name = $app->lang->line('month_name');
                $month_global = date('F', $timestamp);
                $month_global_n = date('n', $timestamp);
                $month_id = $month_name[$month_global_n];
                $converted_date = str_replace($month_global, $month_id, $converted_date);
            }

            if (strpos($new_format, 'M') !== FALSE) {
                $month_name = $app->lang->line('month_name');
                $month_global2 = date('M', $timestamp);
                $month_global_n2 = date('n', $timestamp);
                $month_id2 = $month_name[$month_global_n2];
                $converted_date = str_replace($month_global2, substr($month_id2, 0, 3), $converted_date);
            }

            if (strpos($new_format, 'l') !== FALSE) {
                $day_name = $app->lang->line('day_name');
                $day_global = date('l', $timestamp);
                $day_global_n = date('w', $timestamp);
                $day_id = $day_name[$day_global_n];
                $converted_date = str_replace($day_global, $day_id, $converted_date);
            }

            if (strpos($new_format, 'D') !== FALSE) {
                $day_name = $app->lang->line('day_name');
                $day_global2 = date('D', $timestamp);
                $day_global_n2 = date('w', $timestamp);
                $day_id2 = $day_name[$day_global_n2];
                $converted_date = str_replace($day_global2, substr($day_id2, 0, 3), $converted_date);
            }
        } else {
            $converted_date = date($new_format, $timestamp);
        }

        return $converted_date;
    }
    public function getMonth($bulan)
    {
        switch ($bulan) {
            case 0:
                $bulan = "Semuanya";
                break;
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;
        }
        return $bulan;
    }
    public function convert_date_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }

    public function convert_romawi($tanggal)
    {
        $romawi = '';
        $angkaRomawi = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        );
        foreach ($angkaRomawi as $simbol => $nilai) {
            while ($tanggal >= $nilai) {
                $romawi .= $simbol;
                $tanggal -= $nilai;
            }
        }
        return $romawi;
    }
}
