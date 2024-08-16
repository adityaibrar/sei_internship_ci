<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proyek extends CI_Controller
{
    private $api;

    public function __construct()
    {
        parent::__construct();
        $this->api = 'http://localhost:8080/proyek';
        $this->load->helper('url');
    }

    // Menampilkan daftar proyek
    public function index()
    {
        $response = $this->fetch_data_from_api($this->api);

        if ($response === FALSE) {
            $data['error'] = 'Error fetching data';
        } else {
            $data['proyek'] = json_decode($response, true); // Decode JSON response
        }

        $this->load->view('proyek/list', $data);
    }

    // Menampilkan form untuk menambah proyek baru
    public function create()
    {
        // Ambil data lokasi untuk dropdown
        $lokasi_response = $this->fetch_data_from_api('http://localhost:8080/lokasi');
        $data['lokasi'] = json_decode($lokasi_response, true);

        $this->load->view('proyek/proyek_create', $data);
    }

    // Menangani request untuk menambah proyek baru
    public function store()
    {
        $json_input = file_get_contents('php://input');
        $data = json_decode($json_input, true);

        // Validasi input JSON
        if (empty($data['namaProyek']) || empty($data['client']) || empty($data['tglMulai']) || empty($data['tglSelesai']) || empty($data['pimpinanProyek']) || empty($data['keterangan'])) {
            $response = [
                'status' => 'error',
                'message' => 'Semua field harus diisi'
            ];
            echo json_encode($response);
            return;
        }

        // Mengirim data ke API
        $response = $this->send_request_to_api($this->api, 'POST', $data);

        // Menangani response dari API
        echo json_encode($response);
    }

    public function edit($id)
    {
        $response = $this->fetch_data_from_api($this->api . '/' . $id);
        $data['proyek'] = json_decode($response, true);

        // Ambil data lokasi untuk dropdown
        $lokasi_response = $this->fetch_data_from_api('http://localhost:8080/lokasi');
        $data['lokasi'] = json_decode($lokasi_response, true);

        $this->load->view('proyek/proyek_edit', $data);
    }

    // Menangani request untuk memperbarui proyek
    public function update($id)
    {
        $json_input = file_get_contents('php://input');
        $data = json_decode($json_input, true);

        // Validasi input JSON
        if (empty($data['namaProyek']) || empty($data['client']) || empty($data['tglMulai']) || empty($data['tglSelesai']) || empty($data['pimpinanProyek']) || empty($data['keterangan'])) {
            $response = [
                'status' => 'error',
                'message' => 'Semua field harus diisi'
            ];
            echo json_encode($response);
            return;
        }

        // Mengirim data ke API
        $response = $this->send_request_to_api($this->api . '/' . $id, 'PUT', $data);

        // Menangani response dari API
        echo json_encode($response);
    }

    // Menangani request untuk menghapus proyek
    public function delete($id)
    {
        $response = $this->send_request_to_api($this->api . '/' . $id, 'DELETE');

        if ($response === FALSE) {
            $response = [
                'status' => 'error',
                'message' => 'Gagal menghapus proyek'
            ];
        } else {
            $response = json_decode($response, true);
        }

        echo json_encode($response);
    }

    // Method untuk mengambil data dari API
    private function fetch_data_from_api($url)
    {
        return file_get_contents($url);
    }

    // Method untuk mengirim request ke API
    private function send_request_to_api($url, $method, $data = [])
    {
        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\n",
                'method'  => $method,
                'content' => json_encode($data)
            ]
        ];

        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        return $response;
    }
}
