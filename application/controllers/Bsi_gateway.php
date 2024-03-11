<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bsi_gateway extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('bsi_model');
        $request = file_get_contents('php://input');
        $this->bsi_model->debugLog($request);
        $this->json = json_decode($request, true);
    }

    public function inquiry()
    {
        $this->bsi_model->validateInquiryData($this->json);
        $response = $this->bsi_model->startInquiry($this->json);
        $response_inquiry = json_encode($response);
        $this->bsi_model->debugLog('RESPONSE: ' . $response_inquiry);
        header('Content-Type: application/json');
        echo $response_inquiry;
        exit();
    }
    public function payment()
    {
        $this->bsi_model->validatePaymentData($this->json);
        $response = $this->bsi_model->startPayment($this->json);
        $response_payment = json_encode($response);
        $this->bsi_model->debugLog('RESPONSE: ' . $response_payment);
        header('Content-Type: application/json');
        echo $response_payment;
        exit();
    }
}
        
    /* End of file  bsi_gateway.php */
