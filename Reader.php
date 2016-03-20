<?php 

class Reader {

	private $data;

	private $current = [];

    private $current_path;

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
		return $this;
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
        $this->current_path = $path;
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
		return $this;
	}

	public function byKey($key) {
        if (!stristr($key, '/')) {
            throw new Exception('invalid key');
        }

		$paths = explode("/", $key);

        $obj = $this->iterate_heirachy($this->current[$this->current_path], $paths);
        $this->current = $obj;
        return $this;
	}

    public function iterate_heirachy($obj, $paths, $num = 0) {

        if ($num == count($paths)) {
            return $obj;
        }

        if (isset($obj[$paths[$num]])) {
            return $this->iterate_heirachy($obj[$paths[$num]], $paths, $num+1);
        }
        else {
            echo 'cannot navigate to ' . $paths[$num];
        }
    }

	public function get() {
		return $this->current;
	}

}
