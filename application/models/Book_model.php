<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Book_model extends CI_Model
{

    public function get($id = null, $limit = 5, $offset = 0)
    {
        if ($id === null) {
            return $this->db->get('tb_buku', $limit, $offset)->result();
        } else {
            return $this->db->get_where('tb_buku', ['id' => $id])->result_array();
        }
    }
    public function count()
    {
        return $this->db->get('tb_buku')->num_rows();
    }
    public function add($data)
    {
        try {
            $this->db->insert('tb_buku', $data);
            $error = $this->db->error();
            if (!empty($error['code'])) {
                throw new Exception('Terjadi kesalahan: ' . $error['message']);
                return false;
            }
            return ['status' => true, 'data' => $this->db->affected_rows()];
        } catch (Exception $ex) {
            return ['status' => false, 'msg' => $ex->getMessage()];
        }
    }

    public function update($id, $data)
    {
        try {
            $this->db->update('tb_buku', $data, ['id' => $id]);
            $error = $this->db->error();
            if (!empty($error['code'])) {
                throw new Exception('Terjadi kesalahan: ' . $error['message']);
                return false;
            }
            return ['status' => true, 'data' => $this->db->affected_rows()];
        } catch (Exception $ex) {
            return ['status' => false, 'msg' => $ex->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $this->db->delete('tb_buku', ['id' => $id]);
            $error = $this->db->error();
            if (!empty($error['code'])) {
                throw new Exception('Terjadi kesalahan: ' . $error['message']);
                return false;
            }
            return ['status' => true, 'data' => $this->db->affected_rows()];
        } catch (Exception $ex) {
            return ['status' => false, 'msg' => $ex->getMessage()];
        }
    }
}
                        
/* End of file book_model.php */
