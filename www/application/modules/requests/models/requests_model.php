<?php

class Requests_model extends CI_Model {

    private $table_name = 'requests';
    private $redirect_url = 'requests';

    public function __construct() {
        $this->load->database();
    }

    public function get($id = null, $for_front = false) {
        if (!$for_front) {
            if ($id) {
                $query = $this->db->get_where($this->table_name, array('id' => $id));

                return $query->row_array();
            }
            $query = $this->db->get($this->table_name);
            if (count($query->result_array()) > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        }
    }

    public function get_email() {
        $query = $this->db->get('requests_email');
        if (count($query->row_array()) > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function save_email() {
        $data = array(
            'email' => $this->input->post('email')
        );
        $this->db->update('requests_email', $data);
    }

    public function get_unread_requests() {
        $query = $this->db->get_where($this->table_name, array('read' => '0'));
        if (count($query->result_array()) > 0) {
            return count($query->result_array());
        } else {
            return false;
        }
    }

    public function request_delete($id) {
        $this->db->delete($this->table_name, array('id' => $id));
    }

    public function update_request_read($id) {
        $data = array(
            'read' => 'on'
        );
        $this->db->where('id', $id);
        $this->db->update($this->table_name, $data);
    }

    public function get_by_url($url) {
        if ($url) {
            $query = $this->db->get_where($this->module, array('url' => $url));
            if ($query) {
                return $query->row_array();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_blogs($id = null) {
        if ($id) {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row_array();
        }
        $this->db->order_by('order', 'desc');
        $query = $this->db->get($this->table_name);
        if (count($query->result_array()) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_tags($page_id) {
        if ($page_id) {
            $query = $this->db->get_where('tags', array('page_id' => $page_id, 'object' => 'blog'));
            return $query->result_array();
        }
    }

    public function set() {

        date_default_timezone_set('Asia/Bishkek');
        $data = array(
            'name' => $this->input->post('name'),
            'country' => $this->input->post('country'),
            'rooms' => $this->input->post('rooms'),
            'price' => $this->input->post('price'),
            'text' => $this->input->post('text'),
            'email' => $this->input->post('email'),
            'email' => $this->input->post('email'),
            'date' => date('Y-m-d H:i:s'),
            'phone' => $this->input->post('phone'),
            'stars' => $this->input->post('stars'),
            'places' => $this->input->post('places'),
            'days' => $this->input->post('days'),
            'ip' => $this->input->ip_address(),
            'read' => 0
        );

        return $this->db->insert($this->table_name, $data);
    }

    public function delete($id) {
        $this->db->delete($this->table_name, array('id' => $id));
    }

    public function update($id, $image = null) {
        if (!$image) {
            $data = array(
                'name' => $this->input->post('name'),
                'title' => $this->input->post('title'),
                'desc' => $this->input->post('desc'),
                'keyw' => $this->input->post('keyw'),
                'text' => $this->input->post('text'),
                'date' => date('Y-m-d h:i:s', strtotime($this->input->post('date'))),
                'active' => $this->input->post('active')
            );
            $this->db->where('id', $id);
            $this->db->update($this->table_name, $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'title' => $this->input->post('title'),
                'desc' => $this->input->post('desc'),
                'keyw' => $this->input->post('keyw'),
                'text' => $this->input->post('text'),
                'date' => $this->input->post('date'),
                'active' => $this->input->post('active'),
                'image' => $image
            );

            $this->db->where('id', $id);
            $this->db->update($this->table_name, $data);
        }
    }

}
