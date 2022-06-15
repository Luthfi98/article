<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_General extends CI_Model {

	function get($table, $where = null)
	{
		if ($where) {
			$this->db->where($where);
		}
		return $this->db->get($table);
	}


	function insert($table, $data)
	{
		return $this->db->insert($table, $data);
	}

	function update($table, $data, $primary)
	{
		return $this->db->update($table, $data, $primary);
	}

	function delete($table, $where)
	{
		return $this->db->delete($table, $where);
	}	

}

/* End of file Model_General.php */
/* Location: ./application/models/Model_General.php */