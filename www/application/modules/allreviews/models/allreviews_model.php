<?php

class Allreviews_model extends CI_Model {

    private $table_name = 'allreviews';
    private $redirect_url = 'allreviews';

    public function __construct() {
        $this->load->database();
    }

    public function get($id = false, $for_front = false, $tour_id = false) {
        if (!$for_front) {
            if ($id) {
                $query = $this->db->get_where($this->table_name, array('id' => $id));

                return $query->row_array();
            }
            $this->db->order_by('order', 'desc');
            $this->db->order_by('date', 'asc');
            $query = $this->db->get($this->table_name);
            if (count($query->result_array()) > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        } else {
            if ($id) {
                $query = $this->db->get_where($this->table_name, array('id' => $id, 'active' => 'on'));

                return $query->row_array();
            }
            $this->db->select('*');
            $this->db->from($this->table_name);
            $this->db->order_by('order', 'desc');
            $this->db->order_by('date', 'desc');
            $this->db->limit(5);
            $this->db->where('active','on');
            $query = $this->db->get();
           
            if (count($query->result_array()) > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        }
    }

    public function order($id, $direction) {
        $query = $this->db->get_where($this->table_name, array('id' => $id));
        $category = $query->row_array();
        $order = $category['order'];
        if ($direction == 'up') {
            $order++;
        } elseif ($direction == 'down') {
            $order--;
        }
        $data = array(
            'order' => $order,
        );

        $this->db->where('id', $id);
        $this->db->update($this->table_name, $data);
        redirect('admin/' . $this->redirect_url);
    }

    public function getForMainPage() {
        $query = $this->db->order_by("date", "desc")->get_where($this->table_name, array('active' => 'on'), 9);
        $feedbackList = $query->result_array();
        return array_reverse($feedbackList);
    }

    public function getForPagination($startFrom) {
        $query = $this->db->order_by("date", "desc")->get_where($this->table_name, array('active' => 'on'), 5, $startFrom);
        return $query->result_array();
    }

    public function getForFullList() {
//        SELECT q.name, q.cost
//        FROM (SELECT name, cost FROM test ORDER BY name DESC LIMIT 10) q
//        ORDER BY q.name ASC;
        $query = $this->db->order_by("date", "asc")->get_where($this->table_name, array('active' => 'on'));
        return $query->result_array();
    }

    public function get_for_slider() {
        $query = $this->db->order_by("order", "desc")->order_by("date", "desc")->get_where($this->table_name, array('active' => 'on', 'in_slider' => 'on'));
        return $query->result_array();
    }

    public function get_email() {
        $query = $this->db->get($this->table_name . '_email');
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
        $this->db->update($this->table_name . '_email', $data);
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

    public function set() {

        date_default_timezone_set('Asia/Bishkek');
        $data = array(
            'name' => $this->input->post('name'),
            'text' => nl2br($this->input->post('text')),
            'date' => date('Y-m-d H:i:s'),
            'ip' => $this->input->ip_address(),
            'read' => 0
        );

        return $this->db->insert($this->table_name, $data);
    }

    public function update($id) {
        $data = array(
            'active' => $this->input->post('active'),
            'in_slider' => $this->input->post('in_slider'),
            'text' => nl2br($this->input->post('text')),
            'name' => $this->input->post('name')
        );

        $this->db->where('id', $id);
        $this->db->update($this->table_name, $data);
    }

    public function delete($id) {
        $this->db->delete($this->table_name, array('id' => $id));
    }

    public function get_ajax($start = null){
        $query = $this->db->query("SELECT * FROM `$this->table_name` WHERE `active`='on' ORDER BY `date` DESC, `order` DESC   LIMIT $start, 5");
        return $query->result_array();
    }
}
