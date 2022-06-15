<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preview extends CI_Controller {

	public function index()
	{

	$params = '?status=Publish';
		$api = api('article'.$params, null, 'GET');
		if ($api) {
			$rowperpage = $this->input->post('length') ? $this->input->post('length') : 9 ;
			$this->load->library('pagination');
			$choice = $api['total'] / $rowperpage;
	        $config["num_links"] = floor($choice);

			$config = [
				'base_url' 		=> base_url('preview'),
				'total_rows'	=> $api['total'],
				'per_page'		=> $rowperpage,
				'use_page_numbers' => TRUE,
				'full_tag_open' 	=> '<ul class="pagination justify-content-center">',
				'first_link' 		=> 'First',
				'last_link' 		=> 'Last',
				'next_link' 		=> 'Next',
				'prev_link' 		=> 'Prev',
				'num_tag_open' 		=> '<li class=" page-item page-link">',
				'num_tag_close' 	=> '</li>',
				'cur_tag_open' 		=> '<li class="active page-item"><a href="#" class="page-link" title="">',
				'cur_tag_close' 	=> '</a></li>',
				'next_tag_open' 	=> '<li class="page-item page-link">',
				'next_tag_close' 	=> '</li>',
				'prev_tag_open'		=> '<li class="page-item page-link">',
				'prev_tag_close' 	=> '</li>',
				'first_tag_open' 	=> '<li class="page-item page-link">',
				'first_tag_close' 	=> '</li>',
				'last_tag_open' 	=> '<li class="page-item page-link">',
				'last_tag_close'	=> '</li>',
				'full_tag_close' 	=> '</ul>',
			];

			$this->pagination->initialize($config);
			$start = $this->uri->segment(3) ? $this->uri->segment(3) * $rowperpage - $rowperpage : 0;
			$limit = $config['per_page'];

			$params .= '&limit='.$limit."&offset=".$start;
			$api = api('article'.$params, null, 'GET');
		}else{

		}


		$data = [
			'pagination' => $api ? $this->pagination->create_links() : null,
			'title' => "Preview Article",
			'data' => $api ? $api['data'] : null
		];
		$this->template->load("templates/adminPage", 'pages/posts/preview-data', $data);
	}


	public function detail($id)
	{
		$data = [
			'title' => "Detail Article",
			'data' => api('article/'.$id, null, 'GET')['data']['article']
		];
		$this->template->load("templates/adminPage", 'pages/posts/detail-preview', $data);
	}

}

/* End of file Preview.php */
/* Location: ./application/controllers/Preview.php */