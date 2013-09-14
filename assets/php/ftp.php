<?php

function endsWith($haystack,$needle) {
    return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
}

function startsWith($haystack,$needle) {
    return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
}

class FTP {
	
	protected $host;
	protected $user;
	protected $password;
	protected $port;
	
	protected $connection;
	
	public function __construct($host, $user, $password, $port=21) {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->port = $port;
		
		$this->connect();
	}
	
	private function connect() {
		$this->connection = ftp_connect($this->host, $this->port);
		ftp_login($this->connection, $this->user, $this->password);
	}
	
	public function cd($directory) {
		return ftp_chdir($this->connection, $directory);
	}
	
	public function dir() {
		return ftp_pwd($this->connection);
	}
	
	public function ls($path = ".", $show = false) {
		$files = array();
        $contents = ftp_nlist($this->connection, $path);
        $a = 0;

        if(count($contents)){
            foreach($contents as $line){
				if (!$show && startsWith($line, ".")) {
					continue;
				}
				
				$files[$a]['name'] = $line;
				$files[$a]['dir'] = ftp_size($this->connection, $line) == -1;
				$files[$a]['link'] = substr($this->dir(), 0, strlen($this->dir()) - 1) . $line;
				$a++;
            }
        }
		
		usort($files, array("FTP", "sort_file"));
        return $files;
	}
	
	public function mkdir($dirname) {
		return ftp_mkdir($this->connection, $dirname);
	}
	
	public function rmdir($dirname) {
		return ftp_rmdir($this->connection, $dirname);
	}
	
	public function get($remote, $local) {
		return ftp_get($this->connection, $remote, $local, FTP_BINARY);
	}
	
	public function put($local, $remote) {
		return ftp_put($this->connection, $remote, $local, FTP_BINARY);
	}
	
	public function exec($command) {
		return ftp_exec($this->connection, $command);
	}
	
	public function rename($remote, $name) {
		return ftp_rename($this->connection, $remote, $name);
	}
	
	public function close() {
		return ftp_close($this->connection);
	}
	
	public static function sort_file($a, $b) {
	
		if ($a['dir'] == $b['dir']) {
			return strcasecmp($a['name'], $b['name']);
		}
		
		return $a['dir'] ? -1 : ($b['dir'] ? 1 : 0);
	}
}
?>