<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank
{

    public function getBankName($method)
    {
        $bankName = '';
        $icon = '';
        switch ($method) {
            case 'bca':
                $bankName = 'Bank Central Asia';
                $icon = base_url() . 'asset/images/icons/bank-bca.jpg';
                break;
            case 'bri':
                $bankName = 'Bank Rakyat Indonesia';
                $icon = base_url() . 'asset/images/icons/bank-bri.jpg';
                break;
            case 'bni':
                $bankName = 'Bank Negara Indonesia';
                $icon = base_url() . 'asset/images/icons/bank-bni.jpg';
                break;
            case 'bsi':
                $bankName = 'Bank Syariah Indonesia';
                $icon = base_url() . 'asset/images/icons/bank-bsi.jpg';
                break;
            case 'mandiri':
                $bankName = 'Bank Mandiri';
                $icon = base_url() . 'asset/images/icons/bank-mandiri.jpg';
                break;
            case 'cimb':
                $bankName = 'Bank CIMB Niaga';
                $icon = base_url() . 'asset/images/icons/bank-cimb.jpg';
                break;
            case 'permata':
                $bankName = 'Bank Permata';
                $icon = base_url() . 'asset/images/icons/bank-permata.jpg';
                break;
            case 'gopay':
                $bankName = 'Gopay';
                $icon = base_url() . 'asset/images/icons/gopay.jpg';
                break;
            case 'ovo':
                $bankName = 'OVO';
                $icon = base_url() . 'asset/images/icons/ovo.jpg';
                break;
            case 'spay':
                $bankName = 'Shopee Pay';
                $icon = base_url() . 'asset/images/icons/shopee-pay.jpg';
                break;
            case 'linkaja':
                $bankName = 'Liak Aja';
                $icon = base_url() . 'asset/images/icons/linkaja.jpg';
                break;
            case 'dana':
                $bankName = 'Dana';
                $icon = base_url() . 'asset/images/icons/dana.jpg';
                break;
            case 'alfamart':
                $bankName = 'Alfamart';
                $icon = base_url() . 'asset/images/icons/alfamart.jpg';
                break;
            case 'indomaret':
                $bankName = 'Indomaret';
                $icon = base_url() . 'asset/images/icons/indomaret.jpg';
                break;
            case 'alfamidi':
                $bankName = 'Alfamidi';
                $icon = base_url() . 'asset/images/icons/alfamidi.jpg';
                break;
            
            default:
                $bankName = 'unknown';
                $icon = 'unknown';
                break;
        }

        $data = [
            'bankName' => $bankName,
            'icon' => $icon,
        ];
        return $data;
    }
}