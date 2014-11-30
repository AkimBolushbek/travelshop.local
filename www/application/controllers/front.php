<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Front extends MX_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function main() {
        $data['title'] = 'TravelShop';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('pages/main', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function contacts() {
        $data['title'] = 'Контаты';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('pages/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function tours() {
        $data['title'] = 'Туры за рубеж';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('pages/tours', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function tour($url) {
        $tour = Modules::run('tours/get_by_url', $url);
        $hotel = Modules::run('hotels/get', $tour['hotel_id'], true);
        $tour_images = Modules::run('tours/get_images', $tour['id'], true);
        $hotel_images = Modules::run('hotels/get_images', $hotel['id'], true);
        if ($tour) {
            $data['title'] = $tour['name'];
            $data['url'] = $url;
            $data['entry'] = $tour;
            $data['tour_images'] = $tour_images;
            $data['hotel_images'] = $hotel_images;
            if ($tour['hotel_id']) {
                $data['hotel'] = $hotel;
            } else {
                $data['hotel'] = 'Нет';
            }
            $this->load->view('templates/metahead', $data);
            $this->load->view('templates/head', $data);
            $this->load->view('pages/tour', $data);
            $this->load->view('templates/contacts', $data);
            $this->load->view('templates/footer', $data);
        } else {
            show_404();
        }
    }

    public function vises() {
        $data['title'] = 'Визовые услуги';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('pages/vises', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function belay() {
        $data['title'] = 'Медицинаская страховка';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('pages/belay', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function reservation() {
        $data['title'] = 'Онлайн бронирование';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('pages/reservation', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function blog() {
        $data['title'] = 'Блог';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('pages/blog', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

    public function news() {
        $data['title'] = 'Новости';
        $this->load->view('templates/metahead', $data);
        $this->load->view('templates/head', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('pages/news', $data);
        $this->load->view('templates/contacts', $data);
        $this->load->view('templates/footer', $data);
    }

}
