<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatable_Model extends CI_Model {

	function DataTable()
	{
		$status = $this->input->get('status');
		$params = '?status='.$status;
		$data = ['status' => $status];
		if ($this->input->post('length') != 1){
			$limit = $this->input->post('length');
			$offset = $this->input->post('start');
			// var_dump($offset);die;
			$data['limit'] = $limit;
			$data['offset'] = $offset;
			$params.= '&limit='.$limit.'&offset='.$offset;
		}

		if ($this->input->post('order')) {
			$column_order = [null,'title', 'category'];
			$params .= "&order_by=".$column_order[$this->input->post('order')['0']['column']]."&sort_by=".$this->input->post('order')['0']['dir'];
		}

		if ($this->input->post('search')['value']) {
			$params .= '&keyword='.$this->input->post('search')['value'];
		}
		$api = api('article'.$params, $data, 'GET');
		return $api;
	}
	

}

/* End of file Datatable_Model.php */
/* Location: ./application/models/Datatable_Model.php */