<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Whatsapp_callback extends CI_Controller
{

    public function webhook()
    {
        $this->load->model('whatsapp');
        if (!empty($_GET)) {
            $this->whatsapp->debugLog($_GET);
            //Verification Requests
            echo $this->whatsapp->verifyWebhook($_GET);
            return true;
        } else {
            //Event Notifications
            $payload = (file_get_contents('php://input'));
            $this->whatsapp->debugLog($payload);
        }
    }
    public function test()
    {
        $this->load->model('whatsapp');
        $this->whatsapp->sendTagihanPelunasan(70, 'hsloosfg');
        // $this->whatsapp->sendDpNotice(70);
    }
}
        
    /* End of file  Whatsapp_webhook.php */
