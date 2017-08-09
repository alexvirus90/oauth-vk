<?
class Auth_Vk {
	
	private $code;
	private $token;
	private $uid;
	
	public function __construct() {
		
		require "config.php";
	}
	
	public function set_code($code) {
		$this->code = $code;
	}
	
	public function set_token($token) {
		$this->token = $token;
	}
	
	public function set_uid($id) {
		$this->uid = $id;
	}
	
	public function redirect($url) {
		header('HTTP/1.1 301 Moved Permanently');
		header("Location:".$url);
		exit();
	}
	
	public function get_token() {
		if(!$this->code) {
			exit("Не верный код");
		}
		
		$ku = curl_init();
		$query = "client_id=".APP_ID."&client_secret=".APP_SECRET."&code=".$this->code."&redirect_uri=".REDIRECT_URI;
		curl_setopt($ku,CURLOPT_URL,URL_ACCESS_TOKEN."?".$query);
		curl_setopt($ku,CURLOPT_RETURNTRANSFER,TRUE);
		
		$result = curl_exec($ku);
		curl_close($ku);
		
		$ob = json_decode($result);
		if($ob->access_token) {
			$this->set_token($ob->access_token);
			$this->set_uid($ob->user_id);
			return TRUE;
		}
		elseif($ob->error) {
			$_SESSION['error'] = "Ошибка";
			return FALSE;
		}
	}
	
	public function get_user() {
		if(!$this->token) {
			exit('Wrong code');
		}
		
		if(!$this->uid) {
			exit('Wrong code');
		}
		
		$query = "uids=".$this->uid."&fields=first_name,last_name,nickname,screen_name,sex,bdate,city,country,timezone,photo,photo_medium,photo_big,has_mobile,rate,contacts,education,online,counters&access_token=".$this->token;
//echo $query;

		$kur = curl_init();

		

		curl_setopt($kur, CURLOPT_URL, URL_GET_USER."?".$query);

		curl_setopt($kur, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($kur, CURLOPT_SSL_VERIFYHOST, false);

		curl_setopt($kur,CURLOPT_RETURNTRANSFER,TRUE);

		

		$result2 = curl_exec($kur);
		
		curl_close($kur);

		$_SESSION['user'] = json_decode($result2);

		$this->redirect("http://t-platform.xyz");

	}
	
}
?>