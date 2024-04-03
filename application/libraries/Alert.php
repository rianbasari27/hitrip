<?php

class Alert
{

    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI = &get_instance();
    }

    public function set($type, $value)
    {
        $this->CI->session->set_flashdata('alert_type', $type);
        $this->CI->session->set_flashdata('alert_message', $value);
        if ($type == 'danger' || $type == 'warning') {
            $this->CI->session->set_flashdata('alert_icon', 'fas fa-exclamation-triangle');
        } else {
            $this->CI->session->set_flashdata('alert_icon', 'fas fa-check');
        }
    }
    public function setJamaah($color, $title, $message)
    {
        if ($color == 'green') {
            $icon = '<i class="fa fa-check font-18"></i>';
        } else if ($color == 'blue') {
            $icon = '<i class="fa fa-cog font-18"></i>';
        } else if ($color == 'yellow') {
            $icon = '<i class="fa fa-exclamation-triangle font-18"></i>';
        } else {
            $icon = '<i class="fa fa-times-circle font-18"></i>';

        }
        $alert = [
            'color' => $color,
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
        ];
        // echo '<pre>';
        // print_r($alert);
        // exit();
        $this->CI->session->set_flashdata('alert', $alert);
    }

    public function toastAlert($color, $message)
    {
        if ($color == 'green') {
            $icon = '<i class="fa fa-circle-check me-2"></i>'; 
        } else if ($color == 'red') {
            $icon = '<i class="fa fa-circle-exclamation me-2"></i>';
        } else {
            $icon = '<i class="fa fa-times-circle me-2"></i>';
        }
        $toast = [
            'color' => $color,
            'icon' => $icon,
            'message' => $message,
        ];
        // echo '<pre>';
        // print_r($alert);
        // exit();
        $this->CI->session->set_flashdata('toast', $toast);
    }
}
