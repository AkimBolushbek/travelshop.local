<?php

class Backcall extends MX_Controller {

    private $module = 'backcall';
    private $module_name = 'Поиск отеля';

    public function __construct() {
        parent::__construct();
        $this->load->model('backcall_model');
        $this->form_validation->set_message('required', 'Поле "%s" обязательно для заполения');
        $this->form_validation->set_message('valid_email', 'Поле "%s" должно содержать валидный E-mail адрес');
    }

    public function index() {
        $this->load->helper('url');

        if (!$this->session->userdata('logged')) {
            redirect('admin/login');
        } else {
            redirect('admin/main');
        }
    }

    public function savemail() {
        if (!$this->session->userdata('logged')) {
            redirect('admin/login');
        }
        if ($this->input->post('email')) {
            $email = $this->input->post('email');
            $this->backcall_model->save_email();
        }
    }

    public function view($for_front = false) {
        $data['module_name'] = $this->module_name;
        $data['module'] = $this->module;
        $data['email'] = $this->backcall_model->get_email();
        if (!$for_front) {
            $data['entries'] = $this->backcall_model->get();
        } else {
            $data['entries'] = $this->backcall_model->get('', true);
        }
        $this->load->view($this->module, $data);
    }

    public function send() {
        if ($this->input->post('do') == $this->module . 'Send') {
            $email = $this->backcall_model->get_email();
            $this->form_validation->set_rules('name', 'Имя', 'required|trim|xss_clean');
            $this->form_validation->set_rules('phone', 'Телефон', 'required|trim|xss_clean');

            $this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('front/backcall');
            } else {
                $this->backcall_model->set();
                    echo '<p style="margin:10px; font-weight:bold; text-align:center; color:green">Успех! Наш менеджер уже звонит вам!</p>';

            }
        } else {
            $this->load->view('front/backcall');
        }
    }

    public function more($id = null) {
        $data['title'] = 'Административная панель';
        $data['module_name'] = $this->module_name;
        $data['module'] = $this->module;
        $entry = $this->backcall_model->get($id);
        $data['entry'] = $entry;
        $this->load->view('more', $data);
    }

    public function get_unread_requests() {
        return $this->backcall_model->get_unread_requests();
    }

    public function setread() {
        if (!$this->session->userdata('logged')) {
            redirect('admin/login');
        }
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $this->backcall_model->update_request_read($id);
        }
    }

    public function delete($id) {
        $entry = $this->backcall_model->get($id);
        if (count($entry) > 0) {
            $this->backcall_model->delete($id);
            redirect('admin/' . $this->module);
        } else {
            die('Ошибка! Такой записи в базе не существует!');
        }
    }

    public function up($id) {
        $this->backcall_model->order($id, 'up');
    }

    public function down($id) {
        $this->backcall_model->order($id, 'down');
    }

}
