<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Tes extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}
		public function index()
    	{
    		$this->load->view('report/landscape');
    	}
		public function tesMpdf()
		{ 
			//load mPDF library
			$this->load->library('m_pdf');
			//load mPDF library
			//now pass the data//
			ob_start();
			$data['id'] = $this->session->userdata('role_id');
			$this->load->view('report/conten_tes',$data);
			$html = ob_get_contents();
			ob_end_clean();
			// this the the PDF filename that user will get to download
			$pdfFilePath ="mypdfName-".time()."-download.pdf";
			//actually, you can pass mPDF parameter on this load() function
			$pdf = $this->m_pdf->load();
			//generate the PDF!
			$pdf->WriteHTML($html);
			//offer it to user via browser download! (The PDF won't be saved on your server HDD)
			$pdf->Output();
		}
		public function tesHpdf(){
			ob_start();
			$data['od'] = $this->session->userdata('role_id');
			$this->load->view('report/conten_tes',$data);
			$html = ob_get_contents();
			ob_end_clean();
			require_once('./assets/html2pdf/html2pdf.class.php');
			$pdf = new HTML2PDF();
			$pdf->WriteHTML($html);
			$pdf->Output();
		}
		public function tesFpdf()
		{

			ob_start();
			$data['id'] = $this->session->userdata('role_id');
			$this->load->view('report/conten_tes',$data);
			$html = ob_get_contents();
			ob_end_clean();
			require_once APPPATH.'third_party/fpdf/PDF_HTML.php';
			$pdf = new PDF_HTML();
			// First page
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',16);
			$pdf->WriteHTML($html);
			$pdf->Output();
		}
	}
?>