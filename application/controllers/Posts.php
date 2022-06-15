<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$publish = api('article?status=Publish', null, 'GET');
		$draft = api('article?status=Draft', null, 'GET');
		$trash = api('article?status=Trash', null, 'GET');

		$data = [
			'title' => 'All Posts',
			'publish' => $publish ? $publish['total'] : 0,
			'draft' => $draft ? $draft['total'] : 0,
			'trash' => $trash ? $trash['total'] : 0,
		];
		$this->template->load("templates/adminPage", 'pages/posts/list-data', $data);	
	}

	function getData()
	{
		if ($this->input->is_ajax_request()) {
			$status = $this->input->get('status');
			$params = '?status='.$status;
			$data = ['status' => $status];
			if (@$_POST['length'] != 1){
				$limit = @$_POST['length'];
				$offset = @$_POST['start'];
				// var_dump($offset);die;
				$data['limit'] = $limit;
				$data['offset'] = $offset;
				$params.= '&limit='.$limit.'&offset='.$offset;
			}

			if (@$_POST['search']['value']) {
				$params .= '&keyword='.@$_POST['search']['value'];
			}
			$api = api('article'.$params, $data, 'GET');
			$data = [];
			$no = @$_POST['start'];
			if ($api) {
				foreach ($api['data'] as $article) {
					$no++;
					$row = [];
					$row[] = $no . ".";
					$row[] = $article['title'];
					$row[] = $article['category'];
					if ($status == 'Trash') {
						$row[] = '
		                        <a href="'.base_url("posts/restore/".$article['id']).'" class="btn btn-warning text-light  btn-sm mr-1">
		                        	Restore
		                        </a>
						';
					}else{

						$row[] = '
		                        <a href="'.base_url("posts/edit/".$article['id']).'" class="btn btn-primary shadow btn-sm sharp mr-1">
		                        	<svg class="icon me-2">
		                        	  <use xlink:href="'._assets().'/vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
		                        	</svg></a>
		                        <a href="'.base_url("posts/delete/".$article['id']).'" class="btn btn-danger text-light  btn-sm mr-1">
		                        	<svg class="icon me-2">
					                <use xlink:href="'._assets().'/vendors/@coreui/icons/svg/free.svg#cil-trash"></use>
					              </svg>
		                        </a>
						';
					}
				 //  ';
					$data[] = $row;
				}
			}
			$output = [
				'draw' => @$_POST['draw'],
				'recordsTotal' => $api ? $api['total'] : 0,
				'recordsFiltered' => $api ? $api['total'] : 0,
				'data' => $data,
			];
			echo json_encode($output);
		}
	}


	public function delete($id)
	{
		$api = api('article/'.$id, null, 'GET')['data']['article'];
		$data = [
			'title' => $api['title'],
			'content' => $api['content'],
			'category' => $api['category'],
			'status' => "Trash",
		];
		$insert = api('article/'.$id, $data, "POST");
		redirect('posts','refresh');
	}

	public function restore($id)
	{
		$api = api('article/'.$id, null, 'GET')['data']['article'];
		$data = [
			'title' => $api['title'],
			'content' => $api['content'],
			'category' => $api['category'],
			'status' => "Draft",
		];
		$insert = api('article/'.$id, $data, "POST");
		redirect('posts','refresh');
	}

	function new()
	{
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[20]|max_length[200]');
			$this->form_validation->set_rules('content', 'Content', 'trim|required|min_length[200]');
			$this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[3]');
			$this->form_validation->set_error_delimiters('', '');
			if ($this->form_validation->run()) {
				$data = [
					'title' => $this->input->post('title'),
					'content' => $this->input->post('content'),
					'category' => $this->input->post('category'),
					'status' => $this->input->post('status'),
				];
				$insert = api('article', $data, "POST");

				$response['error'] = getErrorValidation();
				$response['status'] = true;
				$response['alert'] = 'Successfully Added Article';
			}else{
				$response['error'] = getErrorValidation();
				$response['status'] = false;
				$response['alert'] = 'Failed Added Article';
			}

			echo json_encode($response);
		}else{
			$data = ['title' => "Add New Article"];
			$this->template->load("templates/adminPage", 'pages/posts/add-data', $data);	
		}
	}

	public function edit($id)
	{
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[20]|max_length[200]');
			$this->form_validation->set_rules('content', 'Content', 'trim|required|min_length[200]');
			$this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[3]');
			$this->form_validation->set_error_delimiters('', '');
			if ($this->form_validation->run()) {
				$data = [
					'title' => $this->input->post('title'),
					'content' => $this->input->post('content'),
					'category' => $this->input->post('category'),
					'status' => $this->input->post('status'),
				];
				$insert = api('article/'.$id, $data, "POST");
				$response['error'] = getErrorValidation();
				$response['status'] = true;
				$response['alert'] = 'Successfully Updated Article';
			}else{
				$response['error'] = getErrorValidation();
				$response['status'] = false;
				$response['alert'] = 'Failed Updated Article';
			}

			echo json_encode($response);
		}else{
			$data = [
				'title' => "Edit Article",
				'data' => api('article/'.$id, null, 'GET')['data']['article']
			];
			$this->template->load("templates/adminPage", 'pages/posts/edit-data', $data);	
		}	
	}


	public function preview()
	{

		$params = '?status=Publish';
			// if (@$_POST['length'] != 1){
			// 	$limit = @$_POST['length'];
			// 	$offset = @$_POST['start'];
			// 	// var_dump($offset);die;
			// 	$params.= '&limit='.$limit.'&offset='.$offset;
			// }

			// if (@$_POST['search']['value']) {
			// 	$params .= '&keyword='.@$_POST['search']['value'];
			// }

			$api = api('article'.$params, null, 'GET');


			$rowperpage = $this->input->post('length') ? $this->input->post('length') : 9 ;
			$this->load->library('pagination');
			$choice = $api['total'] / $rowperpage;
	        $config["num_links"] = floor($choice);

			$config = [
				'base_url' 		=> base_url('posts/preview'),
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
			$data = [
				'pagination' => $this->pagination->create_links(),
				'title' => "Preview Article",
				'data' => $api['data']
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

/* End of file Posts.php */
/* Location: ./application/controllers/Posts.php */