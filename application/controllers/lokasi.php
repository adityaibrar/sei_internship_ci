<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lokasi extends CI_Controller
{
    private $api_url;

    public function __construct()
    {
        parent::__construct();
        $this->api_url = 'http://localhost:8080/lokasi'; // URL endpoint API
        $this->load->helper('url');
    }

    // Menampilkan daftar lokasi
    public function index()
    {
        $response = $this->fetch_data_from_api($this->api_url);
        $data['lokasi'] = json_decode($response, true); // Decode JSON response

        $this->load->view('lokasi/list_lokasi', $data);
    }

    // Menampilkan form untuk menambahkan lokasi
    public function form()
    {
        $this->load->view('lokasi/create_lokasi');
    }

    // Menangani request untuk membuat lokasi baru
    public function create()
    {
        $json_input = file_get_contents('php://input');
        $data = json_decode($json_input, true);

        // Validasi input JSON
        if (empty($data['namaLokasi']) || empty($data['negara']) || empty($data['provinsi']) || empty($data['kota'])) {
            $response = [
                'status' => 'error',
                'message' => 'Semua field harus diisi'
            ];
            echo json_encode($response);
            return;
        }

        // Mengirim data ke API
        $response = $this->send_request_to_api($this->api_url, 'POST', $data);

        // Menangani response dari API
        echo json_encode($response);
    }

    // Menampilkan form untuk mengedit lokasi
    public function edit($id)
    {
        $response = $this->fetch_data_from_api($this->api_url . '/' . $id);
        $data['lokasi'] = json_decode($response, true);

        $this->load->view('lokasi/edit_lokasi', $data);
    }

    // Menangani request untuk memperbarui lokasi
    public function update($id)
    {
        $json_input = file_get_contents('php://input');
        $data = json_decode($json_input, true);

        // Validasi input JSON
        if (empty($data['namaLokasi']) || empty($data['negara']) || empty($data['provinsi']) || empty($data['kota'])) {
            $response = [
                'status' => 'error',
                'message' => 'Semua field harus diisi'
            ];
            echo json_encode($response);
            return;
        }

        // Mengirim data ke API
        $response = $this->send_request_to_api($this->api_url . '/' . $id, 'PUT', $data);

        // Menangani response dari API
        echo json_encode($response);
    }

    // Menangani request untuk menghapus lokasi
    public function delete($id)
    {
        // Mengirim request delete ke API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . '/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        // Menangani response dari API
        if ($response === FALSE) {
            $response = [
                'status' => 'error',
                'message' => 'Gagal menghapus lokasi'
            ];
        } else {
            $response = json_decode($response, true);
        }

        echo json_encode($response);
    }

    // Method untuk mengambil data dari API
    private function fetch_data_from_api($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    // Method untuk mengirim request ke API
    private function send_request_to_api($url, $method, $data = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($method == 'POST' || $method == 'PUT') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        }

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
