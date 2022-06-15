<?php 


	function _assets($url = null)
	{
		if ($url) {
			return base_url('admin-page'.$url);
		}else{
			return base_url('admin-page');
		}
	}

	function api($url, $data, $type)
	{
	    $url = "http://127.0.0.1:8000/api/".$url;
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    if ($data) {
		    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	    }
	    curl_setopt($ch, CURLOPT_URL, $url);
	    //  curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10000);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    $result = curl_exec($ch);
	    curl_close($ch);
	    return json_decode($result, true);
	}

	function getErrorValidation()
	{
		$CI = &get_instance();

		$forms = $CI->input->post();
		$response = [];
		foreach ($forms as $key => $value) {
			if ($key != 'id') {
				$response[$key] = form_error($key);
			}
		}
		return $response;
	}

 ?>