<?php 

class Reader {

	private $data;

	private $current;

	public function __construct($url) {
		
		try {
			$swagger_content = file_get_contents($url);
		}
		catch (Exception $e) {
			die('could not load swagger file ' . $url);
		}

		try {
			$this->data = json_decode($swagger_content, true);
		} 
		catch (Exception $e) {
			die('error parsing json');
		}
	}

	public function getPath($path = null) {

		if (!isset($path)) {
			$this->current = $this->data['paths'];
			return $this;
		}
		$path_data = [];
		foreach ($this->data['paths'] as $k => $v) {
			if ($k == $path) { 
				$path_data[$k] = $v;
			}
		}
		$this->current = $path_data;
		return $this;
	}

	public function byType($type) {
//		print_r($this->current);
		$path_data = [];
		foreach ($this->current as $k => $v) {
			if (isset($v[$type])) {
				$path_data[$k] = $this->current[$k];
			}
		}
		$this->current = $path_data;
		return $this->current;
	}

}
