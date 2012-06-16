<?php
class PushComponent extends Component {
	
	public $isDevelopment = true;
	public $maxMessageLength = 120;
	
	private $___message = '';
	private $___badge = '';
	private $___extra = '';
	private $___sound = 'default';

	private $___releasePem = 'pushRelease.pem';
	private $___releasePassWord = 'pass';

	private $___developmentPem = 'pushDevelopment.pem';
	private $___developmentPassWord = 'pass';
	
	
	public function push($token) {
		
		$pem  = ($this->isDevelopment)? $this->___developmentPem : $this->___releasePem;
		$pass = ($this->isDevelopment)? $this->___developmentPassWord : $this->___releasePassWord;
		$path = ($this->isDevelopment)? 'gateway.sandbox.push.apple.com' : 'gateway.push.apple.com';

		if (!$token || !$this->___message) {
			return false;
		}
		
		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', ROOT.DS.APP_DIR.DS.'Vendor'.DS.$pem);
		stream_context_set_option($ctx, 'ssl', 'passphrase', $pass);
				
		$fp = stream_socket_client('ssl://'.$path.':2195' 
						,$err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

		if (!$fp) {
				return false;
		}
		
		$body['aps']['alert'] = $message;
		$body['aps']['sound'] = $this->___sound;

		if ($this->___badge) {
			$body['aps']['badge'] = intval($this->___badge);
		}
		
		if ($this->___extra) {
			$body = array_merge($body, $this->___extra);
		}

		$payload = $this->___makePayload($body);

		$msg = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;

		$result = fwrite($fp, $msg, strlen($msg));
		
		fclose($fp);
		
		if (!$result) {
				return false;
		} else {
				return true;
		}
	}
	
	public function setMessge($str) {
	
		if ($this->maxMessageLength) {
			$message = mb_strimwidth($this->___message, 0, $this->maxMessageLength, "...","UTF-8");
		}
	
		$this->__message = $str;
	}
	
	public function setBadge($num) {
	
		$this->___badge = $num;
	}

	public function setSound($str) {
		
		$this->___sound = $str;
	}
	
	public function setExtra($key, $value) {
		
		$this->___extra[$key] = $value;	
	}
	
	private function ___makePayload($body) {
		
		$en = json_encode($body);
		$en = $this->___unicode_encode_emoji($en);
		$en = $this->___unicode_encode($en);

		return $en;	
	}
	
	private function ___unicode_encode_emoji($str) {
		
		$emoji = array(
			"\\\ud83d\\\ude04",
			"\\\ud83d\\\ude0a",
			"\\\ud83d\\\ude03",
			"\\\ud83d\\\ude09",
			"\\\ud83d\\\ude0d",
			"\\\ud83d\\\ude18",
			"\\\ud83d\\\ude1a",
			"\\\ud83d\\\ude33",
			"\\\ud83d\\\ude0c",
			"\\\ud83d\\\ude01",
			"\\\ud83d\\\ude1c",
			"\\\ud83d\\\ude1d",
			"\\\ud83d\\\ude12",
			"\\\ud83d\\\ude0f",
			"\\\ud83d\\\ude13",
			"\\\ud83d\\\ude14",
			"\\\ud83d\\\ude1e",
			"\\\ud83d\\\ude16",
			"\\\ud83d\\\ude25",
			"\\\ud83d\\\ude30",
			"\\\ud83d\\\ude28",
			"\\\ud83d\\\ude23",
			"\\\ud83d\\\ude22",
			"\\\ud83d\\\ude2d",
			"\\\ud83d\\\ude02",
			"\\\ud83d\\\ude32",
			"\\\ud83d\\\ude31",
			"\\\ud83d\\\ude20",
			"\\\ud83d\\\ude21",
			"\\\ud83d\\\ude2a",
			"\\\ud83d\\\ude37",
			"\\\ud83d\\\udc7f",
			"\\\ud83d\\\udc7d",
			"\\\ud83d\\\udc9b",
			"\\\ud83d\\\udc99",
			"\\\ud83d\\\udc9c",
			"\\\ud83d\\\udc97",
			"\\\ud83d\\\udc9a",
			"\\\ud83d\\\udc94",
			"\\\ud83d\\\udc93",
			"\\\ud83d\\\udc98",
			"\\\ud83c\\\udf1f",
			"\\\ud83d\\\udca2",
			"\\\ud83d\\\udca4",
			"\\\ud83d\\\udca8",
			"\\\ud83d\\\udca6",
			"\\\ud83c\\\udfb6",
			"\\\ud83c\\\udfb5",
			"\\\ud83d\\\udd25",
			"\\\ud83d\\\udca9",
			"\\\ud83d\\\udc4d",
			"\\\ud83d\\\udc4e",
			"\\\ud83d\\\udc4c",
			"\\\ud83d\\\udc4a",
			"\\\ud83d\\\udc4b",
			"\\\ud83d\\\udc50",
			"\\\ud83d\\\udc46",
			"\\\ud83d\\\udc47",
			"\\\ud83d\\\udc49",
			"\\\ud83d\\\udc48",
			"\\\ud83d\\\ude4c",
			"\\\ud83d\\\ude4f",
			"\\\ud83d\\\udc4f",
			"\\\ud83d\\\udcaa",
			"\\\ud83d\\\udeb6",
			"\\\ud83c\\\udfc3",
			"\\\ud83d\\\udc6b",
			"\\\ud83d\\\udc83",
			"\\\ud83d\\\udc6f",
			"\\\ud83d\\\ude46",
			"\\\ud83d\\\ude45",
			"\\\ud83d\\\udc81",
			"\\\ud83d\\\ude47",
			"\\\ud83d\\\udc8f",
			"\\\ud83d\\\udc91",
			"\\\ud83d\\\udc86",
			"\\\ud83d\\\udc87",
			"\\\ud83d\\\udc85",
			"\\\ud83d\\\udc66",
			"\\\ud83d\\\udc67",
			"\\\ud83d\\\udc69",
			"\\\ud83d\\\udc68",
			"\\\ud83d\\\udc76",
			"\\\ud83d\\\udc75",
			"\\\ud83d\\\udc74",
			"\\\ud83d\\\udc71",
			"\\\ud83d\\\udc72",
			"\\\ud83d\\\udc73",
			"\\\ud83d\\\udc77",
			"\\\ud83d\\\udc6e",
			"\\\ud83d\\\udc7c",
			"\\\ud83d\\\udc78",
			"\\\ud83d\\\udc82",
			"\\\ud83d\\\udc80",
			"\\\ud83d\\\udc63",
			"\\\ud83d\\\udc8b",
			"\\\ud83d\\\udc44",
			"\\\ud83d\\\udc42",
			"\\\ud83d\\\udc40",
			"\\\ud83d\\\udc43",
			"\\\ud83c\\\udf19",
			"\\\ud83c\\\udf00",
			"\\\ud83c\\\udf0a",
			"\\\ud83d\\\udc31",
			"\\\ud83d\\\udc36",
			"\\\ud83d\\\udc2d",
			"\\\ud83d\\\udc39",
			"\\\ud83d\\\udc30",
			"\\\ud83d\\\udc3a",
			"\\\ud83d\\\udc38",
			"\\\ud83d\\\udc2f",
			"\\\ud83d\\\udc28",
			"\\\ud83d\\\udc3b",
			"\\\ud83d\\\udc37",
			"\\\ud83d\\\udc2e",
			"\\\ud83d\\\udc17",
			"\\\ud83d\\\udc35",
			"\\\ud83d\\\udc12",
			"\\\ud83d\\\udc34",
			"\\\ud83d\\\udc0e",
			"\\\ud83d\\\udc2b",
			"\\\ud83d\\\udc11",
			"\\\ud83d\\\udc18",
			"\\\ud83d\\\udc0d",
			"\\\ud83d\\\udc26",
			"\\\ud83d\\\udc24",
			"\\\ud83d\\\udc14",
			"\\\ud83d\\\udc27",
			"\\\ud83d\\\udc1b",
			"\\\ud83d\\\udc19",
			"\\\ud83d\\\udc20",
			"\\\ud83d\\\udc1f",
			"\\\ud83d\\\udc33",
			"\\\ud83d\\\udc2c",
			"\\\ud83d\\\udc90",
			"\\\ud83c\\\udf38",
			"\\\ud83c\\\udf37",
			"\\\ud83c\\\udf40",
			"\\\ud83c\\\udf39",
			"\\\ud83c\\\udf3b",
			"\\\ud83c\\\udf3a",
			"\\\ud83c\\\udf41",
			"\\\ud83c\\\udf43",
			"\\\ud83c\\\udf42",
			"\\\ud83c\\\udf34",
			"\\\ud83c\\\udf35",
			"\\\ud83c\\\udf3e",
			"\\\ud83d\\\udc1a",
			"\\\ud83c\\\udf8d",
			"\\\ud83d\\\udc9d",
			"\\\ud83c\\\udf8e",
			"\\\ud83c\\\udf92",
			"\\\ud83c\\\udf93",
			"\\\ud83c\\\udf8f",
			"\\\ud83c\\\udf86",
			"\\\ud83c\\\udf87",
			"\\\ud83c\\\udf90",
			"\\\ud83c\\\udf91",
			"\\\ud83c\\\udf83",
			"\\\ud83d\\\udc7b",
			"\\\ud83c\\\udf85",
			"\\\ud83c\\\udf84",
			"\\\ud83c\\\udf81",
			"\\\ud83d\\\udd14",
			"\\\ud83c\\\udf89",
			"\\\ud83c\\\udf88",
			"\\\ud83d\\\udcbf",
			"\\\ud83d\\\udcc0",
			"\\\ud83d\\\udcf7",
			"\\\ud83d\\\udcbb",
			"\\\ud83c\\\udfa5",
			"\\\ud83d\\\udcfa",
			"\\\ud83d\\\udcf1",
			"\\\ud83d\\\udce0",
			"\\\ud83d\\\udcbd",
			"\\\ud83d\\\udcfc",
			"\\\ud83d\\\udd0a",
			"\\\ud83d\\\udce2",
			"\\\ud83d\\\udce3",
			"\\\ud83d\\\udcfb",
			"\\\ud83d\\\udce1",
			"\\\ud83d\\\udd0d",
			"\\\ud83d\\\udd13",
			"\\\ud83d\\\udd12",
			"\\\ud83d\\\udd11",
			"\\\ud83d\\\udd28",
			"\\\ud83d\\\udca1",
			"\\\ud83d\\\udcf2",
			"\\\ud83d\\\udce9",
			"\\\ud83d\\\udceb",
			"\\\ud83d\\\udcee",
			"\\\ud83d\\\udec0",
			"\\\ud83d\\\udebd",
			"\\\ud83d\\\udcba",
			"\\\ud83d\\\udcb0",
			"\\\ud83d\\\udd31",
			"\\\ud83d\\\udeac",
			"\\\ud83d\\\udca3",
			"\\\ud83d\\\udd2b",
			"\\\ud83d\\\udc8a",
			"\\\ud83d\\\udc89",
			"\\\ud83c\\\udfc8",
			"\\\ud83c\\\udfc0",
			"\\\ud83c\\\udfbe",
			"\\\ud83c\\\udfb1",
			"\\\ud83c\\\udfc4",
			"\\\ud83c\\\udfbf",
			"\\\ud83c\\\udfca",
			"\\\ud83c\\\udfc6",
			"\\\ud83d\\\udc7e",
			"\\\ud83c\\\udfaf",
			"\\\ud83c\\\udc04",
			"\\\ud83c\\\udfac",
			"\\\ud83d\\\udcdd",
			"\\\ud83d\\\udcd6",
			"\\\ud83c\\\udfa8",
			"\\\ud83c\\\udfa4",
			"\\\ud83c\\\udfa7",
			"\\\ud83c\\\udfba",
			"\\\ud83c\\\udfb7",
			"\\\ud83c\\\udfb8",
			"\\\ud83d\\\udc5f",
			"\\\ud83d\\\udc61",
			"\\\ud83d\\\udc60",
			"\\\ud83d\\\udc62",
			"\\\ud83d\\\udc55",
			"\\\ud83d\\\udc54",
			"\\\ud83d\\\udc57",
			"\\\ud83d\\\udc58",
			"\\\ud83d\\\udc59",
			"\\\ud83c\\\udf80",
			"\\\ud83c\\\udfa9",
			"\\\ud83d\\\udc51",
			"\\\ud83d\\\udc52",
			"\\\ud83c\\\udf02",
			"\\\ud83d\\\udcbc",
			"\\\ud83d\\\udc5c",
			"\\\ud83d\\\udc84",
			"\\\ud83d\\\udc8d",
			"\\\ud83d\\\udc8e",
			"\\\ud83c\\\udf75",
			"\\\ud83c\\\udf7b",
			"\\\ud83c\\\udf7a",
			"\\\ud83c\\\udf78",
			"\\\ud83c\\\udf76",
			"\\\ud83c\\\udf74",
			"\\\ud83c\\\udf54",
			"\\\ud83c\\\udf5f",
			"\\\ud83c\\\udf5d",
			"\\\ud83c\\\udf5b",
			"\\\ud83c\\\udf71",
			"\\\ud83c\\\udf63",
			"\\\ud83c\\\udf59",
			"\\\ud83c\\\udf58",
			"\\\ud83c\\\udf5a",
			"\\\ud83c\\\udf5c",
			"\\\ud83c\\\udf72",
			"\\\ud83c\\\udf5e",
			"\\\ud83c\\\udf73",
			"\\\ud83c\\\udf62",
			"\\\ud83c\\\udf61",
			"\\\ud83c\\\udf66",
			"\\\ud83c\\\udf67",
			"\\\ud83c\\\udf82",
			"\\\ud83c\\\udf70",
			"\\\ud83c\\\udf4e",
			"\\\ud83c\\\udf4a",
			"\\\ud83c\\\udf49",
			"\\\ud83c\\\udf53",
			"\\\ud83c\\\udf46",
			"\\\ud83c\\\udf45",
			"\\\ud83c\\\udfeb",
			"\\\ud83c\\\udfe0",
			"\\\ud83c\\\udfe2",
			"\\\ud83c\\\udfe3",
			"\\\ud83c\\\udfe5",
			"\\\ud83c\\\udfe6",
			"\\\ud83c\\\udfea",
			"\\\ud83c\\\udfe9",
			"\\\ud83c\\\udfe8",
			"\\\ud83d\\\udc92",
			"\\\ud83c\\\udfec",
			"\\\ud83c\\\udf07",
			"\\\ud83c\\\udf06",
			"\\\ud83c\\\udfe7",
			"\\\ud83c\\\udfef",
			"\\\ud83c\\\udff0",
			"\\\ud83c\\\udfed",
			"\\\ud83d\\\uddfc",
			"\\\ud83d\\\uddfb",
			"\\\ud83c\\\udf05",
			"\\\ud83c\\\udf03",
			"\\\ud83d\\\uddfd",
			"\\\ud83c\\\udf08",
			"\\\ud83c\\\udfa1",
			"\\\ud83c\\\udfa2",
			"\\\ud83d\\\udea2",
			"\\\ud83d\\\udea4",
			"\\\ud83d\\\ude80",
			"\\\ud83d\\\udeb2",
			"\\\ud83d\\\ude99",
			"\\\ud83d\\\ude97",
			"\\\ud83d\\\ude95",
			"\\\ud83d\\\ude8c",
			"\\\ud83d\\\ude93",
			"\\\ud83d\\\ude92",
			"\\\ud83d\\\ude91",
			"\\\ud83d\\\ude83",
			"\\\ud83d\\\ude89",
			"\\\ud83d\\\ude84",
			"\\\ud83d\\\ude85",
			"\\\ud83c\\\udfab",
			"\\\ud83d\\\udea5",
			"\\\ud83d\\\udea7",
			"\\\ud83d\\\udd30",
			"\\\ud83c\\\udfb0",
			"\\\ud83d\\\ude8f",
			"\\\ud83d\\\udc88",
			"\\\ud83c\\\udfc1",
			"\\\ud83c\\\udf8c",
			"\\\ud83c\\\uddef\\\ud83c\\\uddf5",
			"\\\ud83c\\\uddf0\\\ud83c\\\uddf7",
			"\\\ud83c\\\udde8\\\ud83c\\\uddf3",
			"\\\ud83c\\\uddfa\\\ud83c\\\uddf8",
			"\\\ud83c\\\uddeb\\\ud83c\\\uddf7",
			"\\\ud83c\\\uddea\\\ud83c\\\uddf8",
			"\\\ud83c\\\uddee\\\ud83c\\\uddf9",
			"\\\ud83c\\\uddf7\\\ud83c\\\uddfa",
			"\\\ud83c\\\uddec\\\ud83c\\\udde7",
			"\\\ud83c\\\udde9\\\ud83c\\\uddea",
			"\\\ud83c\\\udd97",
			"\\\ud83c\\\udd95",
			"\\\ud83d\\\udd1d",
			"\\\ud83c\\\udd99",
			"\\\ud83c\\\udd92",
			"\\\ud83c\\\udfa6",
			"\\\ud83c\\\ude01",
			"\\\ud83d\\\udcf6",
			"\\\ud83c\\\ude35",
			"\\\ud83c\\\ude33",
			"\\\ud83c\\\ude50",
			"\\\ud83c\\\ude39",
			"\\\ud83c\\\ude2f",
			"\\\ud83c\\\ude3a",
			"\\\ud83c\\\ude36",
			"\\\ud83c\\\ude1a",
			"\\\ud83c\\\ude37",
			"\\\ud83c\\\ude38",
			"\\\ud83c\\\ude02",
			"\\\ud83d\\\udeb9",
			"\\\ud83d\\\udebb",
			"\\\ud83d\\\udeba",
			"\\\ud83d\\\udebc",
			"\\\ud83d\\\udead",
			"\\\ud83c\\\udd7f",
			"\\\ud83d\\\ude87",
			"\\\ud83d\\\udebe",
			"\\\ud83d\\\udd1e",
			"\\\ud83c\\\udd94",
			"\\\ud83d\\\udc9f",
			"\\\ud83c\\\udd9a",
			"\\\ud83d\\\udcf3",
			"\\\ud83d\\\udcf4",
			"\\\ud83d\\\udcb9",
			"\\\ud83d\\\udcb1",
			"\\\ud83d\\\udd2f",
			"\\\ud83c\\\udd70",
			"\\\ud83c\\\udd71",
			"\\\ud83c\\\udd8e",
			"\\\ud83c\\\udd7e",
			"\\\ud83d\\\udd32",
			"\\\ud83d\\\udd34",
			"\\\ud83d\\\udd33",
			"\\\ud83d\\\udd5b",
			"\\\ud83d\\\udd50",
			"\\\ud83d\\\udd51",
			"\\\ud83d\\\udd52",
			"\\\ud83d\\\udd53",
			"\\\ud83d\\\udd54",
			"\\\ud83d\\\udd55",
			"\\\ud83d\\\udd56",
			"\\\ud83d\\\udd57",
			"\\\ud83d\\\udd58",
			"\\\ud83d\\\udd59",
			"\\\ud83d\\\udd5a",
		);
	
		foreach($emoji as $one) {
			$str = preg_replace_callback("/".$one."/", array(get_class($this), '___encode_callback_emoji'), $str);
		}
	
		return $str;
	}
	
	private function ___encode_callback_emoji($matches) {
		
		$char = mb_convert_encoding(pack("H*", str_replace('\u', '', $matches[0])), "UTF-8", "UTF-16");
		
		return $char;
	}
	
	private function ___unicode_encode($str) {

		return preg_replace_callback("/\\\\u([0-9a-zA-Z]{4})/", array(get_class($this), '___encode_callback'), $str);
	}
	
	private function ___encode_callback($matches) {
	
		$char = mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UTF-16");
		
		return $char;
	}
	
}