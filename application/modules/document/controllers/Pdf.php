<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		// $this->load->model("pdf_model");
		require_once('TCPDF/tcpdf.php');
		
	}

	public function index()
	{
		
	}

	public function print_dar()
	{
		$data['darcode'] = $this->input->post('darcode');
		$this->load->library("TCPDF/tcpdf");
		$this->load->view("print_dar",$data);
	}














}

/* End of file Pdf.php */
/* Location: ./application/modules/Document/controllers/Pdf.php */


?>