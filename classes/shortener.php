<?php
  class Shortener {
   protected $db;

   public function __construct() {
    $this->db = new Mysqli('localhost', 'root', '', 'short');
   }

   public function generateCode($num) {
    return base_convert($num, 10, 36);
   }

   public function makeCode($url) {
    $url = trim($url);


	
	function parse_url_if_valid($url)
	{
		$arUrl = parse_url($url);
		$ret = null;

		if (!array_key_exists("scheme", $arUrl)
			|| !in_array($arUrl["scheme"], array("http", "https")))
			$arUrl["scheme"] = "http";

		if (array_key_exists("host", $arUrl) &&
            !empty($arUrl["host"]))
        $ret = sprintf("%s://%s%s", $arUrl["scheme"],
                        $arUrl["host"], $arUrl["path"]);

		else if (preg_match("/^\w+\.[\w\.]+(\/.*)?$/", $arUrl["path"]))
        $ret = sprintf("%s://%s", $arUrl["scheme"], $arUrl["path"]);

		if ($ret && empty($ret["query"]))
        $ret .= sprintf("?%s", $arUrl["query"]);

		return $ret;
	}
	
    if(!filter_var($url, FILTER_VALIDATE_URL)) 
		{
		return '';
		}
	
    $url = $this->db->escape_string($url);

    $exsists = $this->db->query("SELECT code FROM links WHERE url = '{$url}'");
	
	$ip = $_SERVER['REMOTE_ADDR'];

    if($exsists->num_rows) {
     return $exsists->fetch_object()->code;
    } else {
     $this->db->query("INSERT INTO links(url, created, creator_ip) VALUES('{$url}', NOW(), '{$ip}')");

     $code = $this->generateCode($this->db->insert_id);

     $this->db->query("UPDATE links SET code = '{$code}' WHERE url = '{$url}'");

     return $code;
    }
   }

   public function getUrl($code) {
    $code = $this->db->escape_string($code);
    $code = $this->db->query("SELECT url FROM links WHERE code = '$code'");

    if($code->num_rows) {
     return $code->fetch_object()->url;
    }

    return '';
   }

  }
?>