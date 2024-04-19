<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cinema extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// memanggil model dengan nama M_User dan di rename menjadi user
		$this->load->model('M_Cinema', 'cinema');
	}

	public function index()
	{
		$data = [
			'title'  => 'Cinema',
			'page'   => 'cinema/v_cinema',
			'cinema' => $this->cinema->getAllCinema()
		];

		$this->load->view('index', $data);
	}

	public function add()
	{
		$data = [
			'title' => 'Cinema User',
			'page'  => 'cinema/v_addCinema'
		];

		$this->load->view('index', $data);
	}

	public function store()
	{
		$this->form_validation->set_rules('namaCinema', 'Nama Cinema', 'required', [
			'required' => 'Nama cinema tidak boleh kosong!'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->add();
		} else {
			$namaCinema = $this->input->post('namaCinema');

			$data = [
				'namaCinema' => $namaCinema
			];

			$insert = $this->cinema->addCinema($data);

			if ($insert) {
				$this->session->set_flashdata('sukses', 'Data berhasil disimpan');

				redirect('cinema', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan!');

				redirect('cinema', 'refresh');
			}
		}
	}

	public function edit($id)
	{
		$cinema = $this->cinema->getOneCinema($id);

		$data = [
			'title'  => 'Edit Cinema',
			'page'   => 'cinema/v_editCinema',
			'cinema' => $cinema
		];

		$this->load->view('index', $data);
	}
}

/* End of file Cinema.php */
