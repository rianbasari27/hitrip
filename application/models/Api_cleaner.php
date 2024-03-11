<?php
/*
Class untuk mengolah data mentah paket umroh dari database
untuk ditampilkan pada tabel ventour.co.id
*/

defined('BASEPATH') or exit('No direct script access allowed');

class Api_cleaner extends CI_Model
{

    /*
    Image retrieval masih hard-coded
    Apabila ingin menambahkan maskapai, add paket dan update paket harus dimodifikasi juga,
    karena nama-nama maskapai juga masih hard-coded.
    */
    public function getMaskapaiIcon($maskapai)
    {

        switch($maskapai){
            case 'SAUDIA':
                $url = base_url() . "/asset/appkit/images/icons/api/maskapai/saudia.png"; 
                break;

            case 'QATAR':
                $url = base_url() . "/asset/appkit/images/icons/api/maskapai/qatar.png"; 
                break;

            case 'OMAN':
                $url = base_url() . "/asset/appkit/images/icons/api/maskapai/oman.png"; 
                break;

            case 'EMIRATES':
                $url = base_url() . "/asset/appkit/images/icons/api/maskapai/emirates.png"; 
                break;

            case 'LION AIR':
                $url = base_url() . "/asset/appkit/images/icons/api/maskapai/lion-air.png"; 
                break;

            case 'SRILANKAN':
                $url = base_url() . "/asset/appkit/images/icons/api/maskapai/srilankan.png"; 
                break;

            case 'GARUDA INDONESIA':
                $url = base_url() . "/asset/appkit/images/icons/api/maskapai/garuda-indonesia.png"; 
                break;

            case 'ETIHAD':
                $url = base_url() . "/asset/appkit/images/icons/api/maskapai/etihad.png"; 
                break;
            
            case 'TURKISH AIRLINE':
                $url = base_url() . "/asset/appkit/images/icons/api/maskapai/turkish-airlines.png";
                break;

            default:
                $url = null;
        }

        return $url;
    }

    public function getHotel($input)
    {
        // 0: Mekah, 1: Madinah
        $result  = [];
        $default = 'Belum Tersedia';

        $hotels = array_map(function($hotel) {
            return $hotel->nama_hotel;
        }, $input);

        if(empty($hotels)){
            $result[] = $default;
            $result[] = $default;

        } else if(count($hotels) < 2) {
            $currentHotel = $hotels[0];

            if(strpos(strtolower($currentHotel),"madinah")){
                $result[] = $default;
                $result[] = $currentHotel;

            } else {
                $result[] = $currentHotel;
                $result[] = $default;
            }

        } else {
            if(strpos(strtolower($hotels[0]),"madinah")){
                $result[] = $hotels[1];
                $result[] = $hotels[0];

            } else {
                return $hotels;
            }
        }

        return $result;
    }


}