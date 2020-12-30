<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Book extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Book_model', 'book');

        //Do your magic here
    }

    public function index_get()
    {
        $id = $this->get('id', true);
        $tahun = $this->get('tahun', true);
        if ($id === null & $tahun == null) {
            $p = $this->get('page', true);
            $list = $this->book->get(null, null, null,null);
            $total_data = $this->book->count();
            if ($p === null) {
                $data = [
                    'status' => true,
                    'page' => $p,
                    'total_data' => $total_data,
                    'data' => $list
                ];
                $this->response($data, RestController::HTTP_OK);
            } else {
                $p = (empty($p) ? 1 : $p);
                $total_data = $this->book->count();
                $total_page = ceil($total_data / 10);
                $start = ($p - 1) * 10;
                $list = $this->book->get(null, null, 10, $start);
                if ($list) {
                    $data = [
                        'status' => true,
                        'page' => $p,
                        'total_data' => $total_data,
                        'total_page' => $total_page,
                        'data' => $list
                    ];
                } else {
                    $data = [
                        'status' => false,
                        'message' => 'Data tidak ditemukan'
                    ];
                }
                $this->response($data, RestController::HTTP_OK);
            }
        } else {
            $data = $this->book->get($id, $tahun);
            if ($data) {
                $this->response(['status' => true, 'data' => $data], RestController::HTTP_OK);
            } else {
                $this->response(['status' => false, 'message' => ' tidak ditemukan'], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'judul_buku' => $this->post('judul_buku', true),
            'pengarang' => $this->post('pengarang', true),
            'tahun_terbit' => $this->post('tahun_terbit', true)
        ];
        $simpan = $this->book->add($data);
        if ($simpan['status']) {
            $this->response(['status' => true, 'message' => $simpan['data'] . ' Data telah ditambahkan'], RestController::HTTP_CREATED);
        } else {
            $this->response(['status' => false, 'message' => $simpan['message']], RestController::HTTP_INTERNAL_ERROR);
        }
    }

    public function index_put()
    {
        $data = [
            'judul_buku' => $this->put('judul_buku', true),
            'pengarang' => $this->put('pengarang', true),
            'tahun_terbit' => $this->put('tahun_terbit', true)
        ];
        $id = $this->put('id', true);
        if ($id === null) {
            $this->response(['status' => false, 'message' => 'Masukkan ID yang akan dirubah'], RestController::HTTP_BAD_REQUEST);
        }
        $simpan = $this->book->update($id, $data);
        if ($simpan['status']) {
            $status = (int)$simpan['data'];
            if ($status > 0)
                $this->response(['status' => true, 'message' => $simpan['data'] . ' Data telah dirubah'], RestController::HTTP_OK);
            else
                $this->response(['status' => false, 'message' => 'Tidak ada data yang dirubah'], RestController::HTTP_BAD_REQUEST);
        } else {
            $this->response(['status' => false, 'message' => $simpan['message']], RestController::HTTP_INTERNAL_ERROR);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id', true);
        if ($id === null) {
            $this->response(['status' => false, 'message' => 'Masukkan ID yang akan dihapus'], RestController::HTTP_BAD_REQUEST);
        }
        $delete = $this->book->delete($id);
        if ($delete['status']) {
            $status = (int)$delete['data'];
            if ($status > 0)
                $this->response(['status' => true, 'message' => $id . ' data telah dihapus'], RestController::HTTP_OK);
            else
                $this->response(['status' => false, 'message' => 'Tidak ada data yang dihapus'], RestController::HTTP_BAD_REQUEST);
        } else {
            $this->response(['status' => false, 'message' => $delete['message']], RestController::HTTP_INTERNAL_ERROR);
        }
    }
}
        
    /* End of file  book.php */
