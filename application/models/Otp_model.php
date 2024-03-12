<?php

class Otp_model extends CI_Model {

    public function send($nomor) {
        $nomor = $this->db->escape_str($nomor);
        
        if ($nomor) {
            $this->db->where('nomor', $nomor);
            $this->db->delete('otp');
            
            $curl = curl_init();
            $otp = rand(100000, 999999);
            $waktu = time();
            $insData = [
                "otp" => $otp,
                "waktu" => $waktu,
                "nomor" => $nomor
            ];
            
            $this->db->insert('otp', $insData);
            
            $data = [
                'target' => $nomor,
                'message' => "Your OTP : " . $otp
            ];

            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    "Authorization: EUMdmsnreExj!jVogP@B",
                )
            );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_URL, "https://api.fonnte.com/send");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            curl_close($curl);
            return true ; 
        }

        return true ; 
    }

    public function verifikasiOtp($otp, $nomor) {
        $otp = $this->db->escape_str($otp);
        $nomor = $this->db->escape_str($nomor);
        $this->db->where('nomor', $nomor);
        $this->db->where('otp', $otp);
        $result = $this->db->get('otp')->row();
        if ($result) {
            if (time() - $result->waktu <= 60) {
                $data = [
                    'color' => 'green',
                    'title' => 'Selamat',
                    'message' => 'Berhasil mendaftarkan account.',
                ];
            } else {
                $data = [
                    'color' => 'red',
                    'title' => 'Mohon Maaf',
                    'message' => 'Kode OTP sudah expired, silakan request kembali.',
                ];
            }
        } else {
            $data = [
                'color' => 'red',
                'title' => 'Mohon Maaf',
                'message' => 'Kode OTP Salah !!',
            ];
        }

        return $data ;
    }
}