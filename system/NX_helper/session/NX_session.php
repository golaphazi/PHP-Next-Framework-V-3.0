<?php
namespace NX\Session\Apps;
use NX\Session\InterfaceApps\NX_Session_interface AS NX_Session_interface;
use NX\Cookie\InterfaceApps\NX_Cookie_interface AS NX_Cookie_interface;
use NX\Session\OS\InterfaceApps\NX_OS_info_interface AS NX_OS_info_interface;

class NX_Session Implements NX_Session_interface, NX_Cookie_interface, NX_OS_info_interface{
	
	private $result ='';
	private $element ='';
	
	/****==================
	=== Interface for session 
	=======================**/
	public function set_session($element, $name=''){
		if(is_array($element)){
			foreach($element AS $key=>$value){
				if(strlen($value) > 0){
					$this->unset_Session(array($key));
					$_SESSION[$key] = $value;
				}
			}
		  }else{
			  if(strlen(trim($element)) > 0 ){		  
				$this->unset_Session(array($element));
				$_SESSION[$element] = $name;
			  }
		  }
	}
	
	public function unset_Session($element){
		if(is_array($element)){
			foreach($element AS $value){
				if(strlen(trim($value)) > 0){
					if(isset($_SESSION[$value])){
						unset($_SESSION[$value]);
					}
				}
			}
		  }else{
				if(strlen(trim($element)) > 0){
					if(isset($_SESSION[$element])){
						unset($_SESSION[$element]);
					}
				}
		  }
	}
	
	public function get_session($element='', $set = ''){
		$this->result = '';
		if(strlen(trim($element)) > 0){
			$this->result = isset($_SESSION[$element]) ? $_SESSION[$element] : $set;
		}
		
	 return $this->result; 
	}
	
	public function sessionDestroy(){
		session_destroy();
	}
	
	/****==================
	=== Interface for session 
	=======================**/
	
	public function set_cookie($element, $file='',$time=''){
		if(is_array($element)){
			if(strlen($file) > 0){
				$time = ($file);
			}else{
				$time = (86400 * 30);
			}
			foreach($element AS $key=>$value){
				if(strlen(trim($value)) > 0){
					$this->unset_cookie(array($key));
					//setcookie($key, $value, time() + $time, "/");
					$cookiePath = "/";
					$cookieExpire = time()+(60*60*24);
					setcookie($key, $value, $cookieExpire,$cookiePath);
				}
			}
		}else{
			if(strlen(trim($element)) > 0){
				if(strlen($time) > 0){
					$time = ($time);
				}else{
					$time = (86400 * 30);
				}
				$this->unset_cookie(array($element));
				setcookie($element, $file, time() + $time, "/");
			}
		}
	}
	
	public function get_cookie($element='', $set = ''){
		
		$this->result = '';
		if(strlen(trim($element)) > 0){
			$this->result = isset($_COOKIE[$element]) ? $_COOKIE[$element] : $set;
		}
		
	 return $this->result;
	}
	
	public function unset_cookie($element){
		if(is_array($element)){
			foreach($element AS $value){
				if(strlen(trim($value)) > 0){
					if(isset($_COOKIE[$value])){
						unset($_COOKIE[$value]);
					}
				}
			}
		  }else{		  
			 if(strlen(trim($element)) > 0){
				 if(isset($_COOKIE[$element])){
					 unset($_COOKIE[$element]);
				 }
			 }
		  }
	}

	/****==================
	=== Interface for Operating System 
	=======================**/
	
	public function get_mac(){
		$string= exec('getmac');
		$mac=substr($string, 0, 17); 
		return $mac;
	}
	
	public function get_ip(){
		/*$client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
		if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        else if(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }
		
		return $ip;
		*/
		
		if (isset($_SERVER['HTTP_CLIENT_IP'])){
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		}else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else if(isset($_SERVER['HTTP_X_FORWARDED'])){
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		}else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		}else if(isset($_SERVER['HTTP_FORWARDED'])){
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		}else if(isset($_SERVER['REMOTE_ADDR'])){
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		}else{
			$ipaddress = 'UNKNOWN';
		}
		return $ipaddress;
	}
	
	public function get_ip_info($ip = ''){
		if(strlen($ip) > 0){
			$ip = $ip;
		}else{
			$ip = $this->get_ip();
		}
		return $ip;
	}
	public function get_latitude($ip=''){
		if(strlen($ip) > 0){
			$ip = $ip;
		}else{
			$ip = $this->get_ip();
		}
		$geoIP  = json_decode(file_get_contents("http://freegeoip.net/json/$ip"), true);
		if(array_key_exists('latitude', $geoIP)){
			return $geoIP['latitude'];
		}else{
			return 0;
		}
		
	}
	public function get_longitude($ip=''){
		if(strlen($ip) > 0){
			$ip = $ip;
		}else{
			$ip = $this->get_ip();
		}
		$geoIP  = json_decode(file_get_contents("http://freegeoip.net/json/$ip"), true);
		if(array_key_exists('longitude', $geoIP)){
			return $geoIP['longitude'];
		}else{
			return 0;
		}
	}
	
	public function iptocountry($ip='') {
		/*if(strlen($ip) > 0){
			$ip = $ip;
		}else{
			$ip = $this->get_ip();
		}
		$numbers = preg_split( "/\./", $ip);
		include("public/NX_flag/ip_files/".$numbers[0].".php");
		$code=($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);
		foreach($ranges as $key => $value){
			if($key<=$code){
				if($ranges[$key][0]>=$code){$two_letter_country_code=$ranges[$key][1];break;}
				}
		}
		if ($two_letter_country_code==""){$two_letter_country_code="unkown";}
		return $two_letter_country_code;*/
	}
	
	public function get_country($ip=''){
		/*if(strlen($ip) > 0){
			$ip = $ip;
		}else{
			$ip = $this->get_ip();
		}
		$country_name = '';
		$two_letter_country_code= $this->iptocountry($ip);
		if (file_exists('public/NX_flag/ip_files/countries.php')){
			include("public/NX_flag/ip_files/countries.php");
			
			$three_letter_country_code = $countries[$two_letter_country_code][0];
			$country_name = $countries[$two_letter_country_code][1];
			return $country_name;
		}else{
			return $country_name;
		}
		*/
	}
	public function get_OS(){
		$os_platform = 'Unknown';
		foreach($this->set_user_agent() as $regex => $value){ 
			if(preg_match(strtolower($regex), strtolower($this->getUserAgent()))){
				$os_platform = $value;
			}
		}   
		return $os_platform;
	}
	public function get_broswer(){
		$browser = 'Unknown';
		foreach($this->set_user_broswer() as $regex => $value){ 
			if(preg_match(strtolower($regex), strtolower($this->getUserAgent()))){
				$browser = $value;
			}
		}   
		return $browser;
	}
	
	public function getUserAgent(){
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
	 return $user_agent;
	}
	
	public function set_user_agent(){
		$platforms = array(
							'/windows nt 6.2/i' => 'Windows 8',
							'/windows nt 6.1/i' => 'Windows 7',
							'/Windows NT 6.1/i' => 'Windows 7',
							'/windows nt 6.0/i' => 'Windows Vista',
							'/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
							'/windows nt 5.1/i' => 'Windows XP',
							'/windows xp/i' => 'Windows XP',
							'/windows nt 5.0/i' => 'Windows 2000',
							'/windows me/i' => 'Windows ME',
							'/win98/i' => 'Windows 98',
							'/win95/i' => 'Windows 95',
							'/win16/i' => 'Windows 3.11',
							'/macintosh|mac os x/i' => 'Mac OS X',
							'/mac_powerpc/i' => 'Mac OS 9',
							'/linux/i' => 'Linux',
							'/ubuntu/i' => 'Ubuntu',
							'/iphone/i' => 'iPhone',
							'/ipod/i' => 'iPod',
							'/ipad/i' => 'iPad',
							'/android/i' => 'Android',
							'/blackberry/i' => 'BlackBerry',
							'/webos/i' => 'Mobile',
							'/windows nt 10.0/i'	=> 'Windows 10',
							'/windows nt 6.3/i'	=> 'Windows 8.1',
							'/windows nt 6.2/i'	=> 'Windows 8',
							'/windows nt 6.1/i'	=> 'Windows 7',
							'/windows nt 6.0/i'	=> 'Windows Vista',
							'/windows nt 5.2/i'	=> 'Windows 2003',
							'/windows nt 5.1/i'	=> 'Windows XP',
							'/windows nt 5.0/i'	=> 'Windows 2000',
							'/windows nt 4.0/i'	=> 'Windows NT 4.0',
							'/winnt4.0/i'			=> 'Windows NT 4.0',
							'/winnt 4.0/i'			=> 'Windows NT',
							'/winnt/i'				=> 'Windows NT',
							'/windows 98/i'		=> 'Windows 98',
							'/win98/i'				=> 'Windows 98',
							'/windows 95/i'		=> 'Windows 95',
							'/win95/i'				=> 'Windows 95',
							'/windows phone/i'			=> 'Windows Phone',
							'/windows/i'			=> 'Unknown Windows OS',
							'/android/i'			=> 'Android',
							'/blackberry/i'		=> 'BlackBerry',
							'/iphone/i'			=> 'iOS',
							'/ipad/i'				=> 'iOS',
							'/ipod/i'				=> 'iOS',
							'/os x/i'				=> 'Mac OS X',
							'/ppc mac/i'			=> 'Power PC Mac',
							'/freebsd/i'			=> 'FreeBSD',
							'/ppc/i'				=> 'Macintosh',
							'/linux/i'				=> 'Linux',
							'/debian/i'			=> 'Debian',
							'/sunos/i'				=> 'Sun Solaris',
							'/beos/i'				=> 'BeOS',
							'/apachebench/i'		=> 'ApacheBench',
							'/aix/i'				=> 'AIX',
							'/irix/i'				=> 'Irix',
							'/osf/i'				=> 'DEC OSF',
							'/hp-ux/i'				=> 'HP-UX',
							'/netbsd/i'			=> 'NetBSD',
							'/bsdi/i'				=> 'BSDi',
							'/openbsd/i'			=> 'OpenBSD',
							'/gnu/i'				=> 'GNU/Linux',
							'/unix/i'				=> 'Unknown Unix OS',
							'/symbian/i' 			=> 'Symbian OS'
						);
		return $platforms;
	}
	
	
	public function set_user_broswer(){
		$browsers = array(
						'/OPR/i'			=> 'Opera',
						'/Flock/i'			=> 'Flock',
						'/Edge/i'			=> 'Spartan',
						'/Chrome/i'		=> 'Chrome',
						'/Opera.*?Version/i'	=> 'Opera',
						'/Opera/i'			=> 'Opera',
						'/MSIE/i'			=> 'Internet Explorer',
						'/Internet Explorer/i'	=> 'Internet Explorer',
						'/Trident.* rv/i'	=> 'Internet Explorer',
						'/Shiira/i'		=> 'Shiira',
						'/Firefox/i'		=> 'Firefox',
						'/Chimera/i'		=> 'Chimera',
						'/Phoenix/i'		=> 'Phoenix',
						'/Firebird/i'		=> 'Firebird',
						'/Camino/i'		=> 'Camino',
						'/Netscape/i'		=> 'Netscape',
						'/OmniWeb/i'		=> 'OmniWeb',
						'/Safari/i'		=> 'Safari',
						'/Mozilla/i'		=> 'Mozilla',
						'/Konqueror/i'		=> 'Konqueror',
						'/icab/i'			=> 'iCab',
						'/Lynx/i'			=> 'Lynx',
						'/Links/i'			=> 'Links',
						'/hotjava/i'		=> 'HotJava',
						'/amaya/i'			=> 'Amaya',
						'/IBrowse/i'		=> 'IBrowse',
						'/Maxthon/i'		=> 'Maxthon',
						'/Ubuntu/i'		=> 'Ubuntu Web Browser',
						'/mobileexplorer/i'	=> 'Mobile Explorer',
						'/palmsource/i'		=> 'Palm',
					
						'/palmscape/i'			=> 'Palmscape',
						'/nokia/i'				=> 'Nokia',
						'/ericsson/i'			=> 'Ericsson',
						'/blackberry/i'		=> 'BlackBerry',
						'/motorola/i'			=> 'Motorola',

						'/motorola/i'		=> 'Motorola',
						'/nokia/i'			=> 'Nokia',
						'/palm/i'			=> 'Palm',
						'/iphone/i'		=> 'Apple iPhone',
						'/ipad/i'			=> 'iPad',
						'/ipod/i'			=> 'Apple iPod Touch',
						'/sony/i'			=> 'Sony Ericsson',
						'/ericsson/i'		=> 'Sony Ericsson',
						'/blackberry/i'	=> 'BlackBerry',
						'/cocoon/i'		=> 'O2 Cocoon',
						'/blazer/i'		=> 'Treo',
						'/lg/i'			=> 'LG',
						'/amoi/i'			=> 'Amoi',
						'/xda/i'			=> 'XDA',
						'/mda/i'			=> 'MDA',
						'/vario/i'			=> 'Vario',
						'/htc/i'			=> 'HTC',
						'/samsung/i'		=> 'Samsung',
						'/sharp/i'			=> 'Sharp',
						'/sie-/i'			=> 'Siemens',
						'/alcatel/i'		=> 'Alcatel',
						'/benq/i'			=> 'BenQ',
						'/ipaq/i'			=> 'HP iPaq',
						'/mot-/i'			=> 'Motorola',
						'/playstation portable/i'	=> 'PlayStation Portable',
						'/playstation 3/i'		=> 'PlayStation 3',
						'/playstation vita/i'  	=> 'PlayStation Vita',
						'/hiptop/i'		=> 'Danger Hiptop',
						'/nec-/i'			=> 'NEC',
						'/panasonic/i'		=> 'Panasonic',
						'/philips/i'		=> 'Philips',
						'/sagem/i'			=> 'Sagem',
						'/sanyo/i'			=> 'Sanyo',
						'/spv/i'			=> 'SPV',
						'/zte/i'			=> 'ZTE',
						'/sendo/i'			=> 'Sendo',
						'/nintendo dsi/i'	=> 'Nintendo DSi',
						'/nintendo ds/i'	=> 'Nintendo DS',
						'/nintendo 3ds/i'	=> 'Nintendo 3DS',
						'/wii/i'			=> 'Nintendo Wii',
						'/open web/i'		=> 'Open Web',
						'/openweb/i'		=> 'OpenWeb',

						'/android/i'		=> 'Android',
						'/symbian/i'		=> 'Symbian',
						'/SymbianOS/i'		=> 'SymbianOS',
						'/elaine/i'		=> 'Palm',
						'/series60/i'		=> 'Symbian S60',
						'/windows ce/i'	=> 'Windows CE',

						'/obigo/i'			=> 'Obigo',
						'/netfront/i'		=> 'Netfront Browser',
						'/openwave/i'		=> 'Openwave Browser',
						'/mobilexplorer/i'	=> 'Mobile Explorer',
						'/operamini/i'		=> 'Opera Mini',
						'/opera mini/i'	=> 'Opera Mini',
						'/opera mobi/i'	=> 'Opera Mobile',
						'/fennec/i'		=> 'Firefox Mobile',

						'/digital paths/i'	=> 'Digital Paths',
						'/avantgo/i'		=> 'AvantGo',
						'/xiino/i'			=> 'Xiino',
						'/novarra/i'		=> 'Novarra Transcoder',
						'/vodafone/i'		=> 'Vodafone',
						'/docomo/i'		=> 'NTT DoCoMo',
						'/o2/i'			=> 'O2',

						'/mobile/i'		=> 'Generic Mobile',
						'/wireless/i'		=> 'Generic Mobile',
						'/j2me/i'			=> 'Generic Mobile',
						'/midp/i'			=> 'Generic Mobile',
						'/cldc/i'			=> 'Generic Mobile',
						'/up.link/i'		=> 'Generic Mobile',
						'/up.browser/i'	=> 'Generic Mobile',
						'/smartphone/i'	=> 'Generic Mobile',
						'/cellphone/i'		=> 'Generic Mobile'
					);
		return $browsers;
	}
	
}
?>	