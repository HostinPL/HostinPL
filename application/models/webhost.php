<?
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
 class webhostModel extends Model {

		public function createWebhost($data) {
		
		$sql = "INSERT INTO `webhost` SET ";
		$sql .= "`user_id` = '" . (int)$data['user_id'] . "', ";
		$sql .= "`location_id` = '" . (int)$data['location_id'] . "', ";
		$sql .= "`web_password` = '" . $data['web_password'] . "', ";
		$sql .= "`web_domain` = '" . $data['web_domain'] . "', ";
		$sql .= "`tarif_id` = '" . (int)$data['tarif_id'] . "', ";
		$sql .= "`web_status` = '" . (int)$data['web_status'] . "', ";
		$sql .= "`web_date_reg` = NOW(), ";
		$sql .= "`web_date_end` = NOW() + INTERVAL " . (int)$data['web_months'] . " MONTH";
		$this->db->query($sql);

		$return=$this->db->getLastId();		
		return $return;
	}
			public function installWebhost($webid,$password,$domain) {
		
	$this->add_user_hid($this->config->isproot, $this->config->isppass, 'ws'.$webid,$password, $this->user->getEmail());
	$this->add_domain($this->config->isproot, $this->config->isppass, 'ws'.$webid, $domain, $this->user->getEmail());

			}
	public function show_databases($hid_user, $hid_pass){
	
$url = "https://".$this->config->ispdomain."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&out=xml&func=db";

# echo $url;
# exit();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Get the response and close the channel.
$response = curl_exec($ch);
curl_close($ch);
echo $response;

}
public function add_databases($root, $rootpass, $db_name, $hid_user, $db_uname, $db_upass,$rhost){


$url = "https://".$this->config->ispdomain."/manager/ispmgr?authinfo=".$root.":".$rootpass."&out=xml&func=db.edit";

$add_db["sok"] = "yes";
$add_db["elid"] = "";

$add_db["name"] =  $db_name; #- Имя базы..
$add_db["dbtype"] =  "MySQL"; #- Тип базы данных..
$add_db["owner"] =  $hid_user; #- Владелец..
$add_db["dbencoding"] = "utf8"; #- Кодировка..
#$add_db["dbuser"] =  ""; #- Пользователь..
$add_db["dbusername"] =  $db_uname; #- Новый пользователь..
$add_db["dbpassword"] =  $db_upass; #- Пароль..
$add_db["dbconfirm"] =  $db_upass; #- Подтверждение..
if($rhost == true){
$add_db["dbuserhost"] =  "1"; #- Удалённый доступ.
}





 foreach( $add_db as $k => $v )
    {
     $url .= '&'.$k.'='.urlencode($v);
    }
# echo $url;
# exit();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Get the response and close the channel.
$result = curl_exec($ch);
curl_close($ch);
echo $result;
return $result;
}
public function delete_databases($hid_user, $hid_pass, $databases){

$url = "https://".$this->config->ispdomain."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&out=xml&func=db.delete";

# echo $url;
# exit();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$delete_databases["elid"] = $databases;

foreach( $delete_databases as $k => $v )
    {
     $url .= '&'.$k.'='.urlencode($v);
    }
// Get the response and close the channel.
$response = curl_exec($ch);
curl_close($ch);
echo $response;

}
function add_domain($root, $rootpass, $hid_user, $domainwww, $email){
$url = "https://".$this->config->ispdomain."/manager/ispmgr?authinfo=".$root.":".$rootpass."&out=xml&func=wwwdomain.edit";

$add_domain["sok"] = "yes";
$add_domain["elid"] = "";

$add_domain["domain"] = $domainwww;
$add_domain["alias"] = "www.".$domainwww;
$add_domain["docroot"] = "/www/".$domainwww;
$add_domain["owner"] = $hid_user;
#add_domain["version"].

$add_domain["ip"] = $this->config->ispdomain;
#ip6 - IPv6-адрес. Параметр зависим от возможности ipv6..
#pool - Пул приложений. Параметр зависим от возможности windows..
$add_domain["admin"] = $email;
$add_domain["charset"] = "UTF-8";
$add_domain["index"] = "index.php";
#autosubdomain - Авто поддомены. Параметр зависим от возможности asd..

#Возможные значения :.
$add_domain["asdnone"] = "on";
#asddir = "/var/www/".$hid_user."/data/www/".$domainwww;
#asdsubdir - В поддиректории WWW домена.
$add_domain["php"] = "phpfcgi";

#Возможные значения :.
#phpnone - Нет поддержки PHP.
#phpmod - PHP как модуль Apache.
#phpcgi - PHP как CGI.
$add_domain["phpfcgi"] = "on";
#- PHP как FastCGI.
$add_domain["cgi"] = "on" ;
#Cgi-bin. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности cgi..
#wsgi - wsgi-scripts. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности wsgi..
#ssi - SSI. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности ssi..

#ssiext - Расширения файлов SSI. Параметр зависим от возможности ssi..
#frp - FrontPage. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности frp..

#fppasswd - Пароль для FrontPage. Параметр зависим от возможности frp..
#ror - Ruby on rails. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности ror..

#ssl - SSL. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности ssl..

#sslport - SSL порт. Параметр зависим от возможности ssl..
#cert - SSL сертификат. Параметр зависим от возможности ssl..
#switchispmgr - Отключить ISPmanager. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".).
$add_domain["logrequests"] = "on";

 foreach( $add_domain as $k => $v )
    {
     $url .= '&'.$k.'='.urlencode($v);
    }
$curl = curl_init();  
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                            'Content-Type:application/json'
                                        ));
$result = curl_exec($curl); // run the whole process  
curl_close($curl);   
			return $result;  
}
function add_user_hid($root, $rootpass, $hid_user, $hid_password, $hid_email){
$url = "https://".$this->config->ispdomain."/manager/ispmgr?authinfo=".$root.":".$rootpass."&out=xml&func=user.edit";

$add_user["sok"] = "yes";
$add_user["name"] = $hid_user;
$add_user["passwd"] = $hid_password;
$add_user["confirm"] = $hid_password;
$add_user["owner"] = $hid_user;
$add_user["ip"] = $this->config->ispdomain;
#$add_user["ip6"] = "";
#$add_user["domain"] = $domain;
$add_user["preset"] = "Hosting"; // Shablon user hosting
$add_user["email"] = $hid_email;
$add_user["welcome"] = "on";
#$add_user["shell"] = ;
#$add_user["ssl"] = ;
$add_user["cgi"] = "on";
#$add_user["wsgi"] = WSGI. ;
#$add_user["ssi"] = SSI.;
#$add_user["phpmod"] =;
#$add_user["phpcgi"] =;
$add_user["phpfcgi"] =  "on";
#$add_user["safemode"] =  ;
$add_user["disklimit"] = "800"; # в Мегабайтах
$add_user["ftplimit"] ="5";
$add_user["maillimit"] = "5";
$add_user["domainlimit"] = "5";
$add_user["webdomainlimit"] = "5";
#$add_user["maildomainlimit"] = "10000";
$add_user["baselimit"] = "4";
$add_user["baseuserlimit"] = "3";
$add_user["bandwidthlimit"] = "500";
$add_user["cpulimit"] = "256";
$add_user["memlimit"] = "256";
#$add_user["proclimit"] = "100000";
#$add_user["mysqlquerieslimit"] = "100000000";
#$add_user["mysqlupdateslimit"] = "100000000";
#$add_user["mysqlconnectlimit"] = "100000000";
#$add_user["mysqluserconnectlimit"] = "100000000";
#$add_user["maxclientsvhost"] = "100000000";
#$add_user["mailrate"] = "100000000";

 foreach( $add_user as $k => $v )
   {
     $url .= '&'.$k.'='.urlencode($v);
 }
$curl = curl_init();  
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                            'Content-Type:application/json'
                                        ));
$result = curl_exec($curl); // run the whole process  
curl_close($curl);   
			return $result; 
}


# ROOT ROOT_PASS HID_USER
# deactivate_user_hid("root", "root_pass", "hid_user");
public function deactivate_user_hid($root, $rootpass, $hid_user){


$url = "https://".$this->config->ispdomain."/manager/ispmgr?authinfo=".$root.":".$rootpass."&out=xml&func=user.disable";

$delete_user_hid["elid"] = $hid_user;


 foreach( $delete_user_hid as $k => $v )
   {
     $url .= '&'.$k.'='.urlencode($v);
 }
// echo $url;
// exit();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Get the response and close the channel.
$response = curl_exec($ch);
curl_close($ch);
echo $response;

}
public function activate_user_hid($root, $rootpass, $hid_user){


$url = "https://".$this->config->ispdomain."/manager/ispmgr?authinfo=".$root.":".$rootpass."&out=xml&func=user.enable";

$delete_user_hid["elid"] = $hid_user;


 foreach( $delete_user_hid as $k => $v )
   {
     $url .= '&'.$k.'='.urlencode($v);
 }
// echo $url;
// exit();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Get the response and close the channel.
$response = curl_exec($ch);
curl_close($ch);
echo $response;

}
public function add_wordpress($hid_user, $hid_pass, $domainwww, $blog_pass, $blog_email, $blog_title, $db_name, $db_user, $db_pass){

$url = "https://".$this->config->ispdomain."/manager/ispmgr";

$post = "accept=on";
#$add_wordpress["accept"] = "on";
$add_wordpress["authinfo"] = $hid_user.":".$hid_pass;
$add_wordpress["db_satisf_obj"] = "MySQL";
$add_wordpress["domain"] = $domainwww;
$add_wordpress["path"] = "";
$add_wordpress["pkg"] = "WordPress";
$add_wordpress["setting_admin_name"] = "admin";
$add_wordpress["setting_admin_passwordgen"] = "";
$add_wordpress["setting_admin_password"] = $blog_pass;
$add_wordpress["setting_admin_password_confirmgen"] = "";
$add_wordpress["setting_admin_password_confirm"] = $blog_pass;
$add_wordpress["setting_admin_email"] = $blog_email;
$add_wordpress["setting_title"] = urlencode($blog_title);
$add_wordpress["setting_locale"] = "en-US";
$add_wordpress["req_main_dbtype"] = "MySQL";
$add_wordpress["req_main_dbname"] = $db_name;
$add_wordpress["req_main_dbuser"] = $db_user;
$add_wordpress["req_main_dbpassgen"] = "";
$add_wordpress["req_main_dbpass"] = $db_pass;
$add_wordpress["req_main_dbpass_confirmgen"] = "";
$add_wordpress["req_main_dbpass_confirm"] = $db_pass;
$add_wordpress["func"] = "webaps.setting";
$add_wordpress["elid"] = "";
$add_wordpress["sback"] = "";
$add_wordpress["sok"] = "ok";


foreach( $add_wordpress as $k => $v )
    {
     $post .= '&'.$k.'='.urlencode($v);
    }

# echo $post;
# exit();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; ru)");
curl_setopt($ch , CURLOPT_REFERER , "https://".$this->config->ispdomain."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&func=webaps.setting&accept=on&db_satisf_obj=MySQL&domain=".urlencode($domain)."&path=&pkg=WordPress" );

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

$response = curl_exec($ch);
curl_close($ch);

# Sparsit na slovo "error" esli netu to TRUE!!!
echo $response;

}
public function show_domaindns($hid_user, $hid_pass){

$url = "https://".$this->config->ispdomain."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&out=xml&func=domain";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
echo $response;

}
public function delete_domaindns($hid_user, $hid_pass, $domaindns){

$url = "https://".$this->config->ispdomain."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&out=xml&func=domain.sublist.delete";

#func=domain.delete&extop=on&elid=domaindns4.ru&sok=ok

$delete_domain["sok"] = "ok";
$delete_domain["elid"] = $domaindns;
$delete_domain["extop"] = "on";




foreach( $delete_domain as $k => $v )
    {
     $url .= '&'.$k.'='.urlencode($v);
    }
# echo $url;
# exit();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Get the response and close the channel.
$response = curl_exec($ch);
curl_close($ch);
echo $response;

}
public function add_domaindns($hid_user, $hid_pass, $domaindns){

$url = "https://".$this->config->ispdomain."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&out=xml&func=domain.edit";


$add_domaindns["elid"] = "";
$add_domaindns["sok"] = "yes";



$add_domaindns["name"] = $domaindns; #- Доменное имя. 
$add_domaindns["ip"] = $this->config->ispdomain; #- IP-адрес. 
$add_domaindns["ns"] = "ns1.fastvps.ru ns2.fastvps.ru"; #- Серверы имён. (Одно или несколько значений, разделенных пробелом) 
#$add_domaindns["mx"] = ""; #- Почтовые серверы. (Одно или несколько значений, разделенных пробелом) 
#$add_domaindns["owner"] = $hid_user; #- Владелец. 

#$add_domaindns["webdomain"] = ""; #- Создать WWW домен. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности www. 
#$add_domaindns["maildomain"] = "";  #- Создать почтовый домен. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности email. 
#$add_domaindns["buy"] = "";  #- Купить домен. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности domainmarket.



 foreach( $add_domaindns as $k => $v )
    {
     $url .= '&'.$k.'='.urlencode($v);
    }
# echo $url;
# exit();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Get the response and close the channel.
$response = curl_exec($ch);
curl_close($ch);
echo $response;

}
public function add_cron($hid_user, $hid_pass, $min, $hour, $mday, $month, $wday, $name, $hideout){

$url = "https://".$this->config->ispdomain."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&out=xml&func=cron.edit&elid=".$hid_user."&period=custom&min=".$min."&hour=".$hour."&mday=".$mday."&month=".$month."&wday=".$wday."&name=".$name."&hideout=on&sok=ok";

foreach( $add_cron as $k => $v )
    {
     $url .= '&'.$k.'='.urlencode($v);
    }

# echo $url;
# exit();

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);





$response = curl_exec($ch);
curl_close($ch);
echo $response;

}
	public function updateWebhost($webid, $data = array()) {
		$sql = "UPDATE `webhost`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `web_id` = '" . (int)$webid . "'";
		$query = $this->db->query($sql);
	}
	public function extendWebhost($webid, $month, $fromCurrent) {
		$sql = "UPDATE `webhost` SET web_date_end = ";
		if($fromCurrent)
			$sql .= "NOW()";
		else
			$sql .= "web_date_end";
		$sql .= "+INTERVAL " . (int)$month . " MONTH WHERE web_id = '" . (int)$webid . "'";
		
		$this->db->query($sql);
	}
public function getWebhosts($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `webhost`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON webhost.user_id=users.user_id";
					break;
				case "web_tarifs":
					$sql .= " ON webhost.tarif_id=web_tarifs.tarif_id";
					break;
				case "locations":
					$sql .= " ON webhost.location_id=locations.location_id";
					break;
			}
		}
		
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		
		if(!empty($sort)) {
			$count = count($sort);
			$sql .= " ORDER BY";
			foreach($sort as $key => $value) {
				$sql .= " $key " . $value;
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		
		if(!empty($options)) {
			if ($options['start'] < 0) {
				$options['start'] = 0;
			}
			if ($options['limit'] < 1) {
				$options['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$options['start'] . "," . (int)$options['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
public function getWebhostById($webid, $joins = array()) {
		$sql = "SELECT * FROM `webhost`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON webhost.user_id=users.user_id";
					break;
				case "web_tarifs":
					$sql .= " ON webhost.tarif_id=web_tarifs.tarif_id";
					break;
				case "locations":
					$sql .= " ON webhost.location_id=locations.location_id";
					break;
			}
		}
		$sql .=  " WHERE `web_id` = '" . (int)$webid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
public function getTotalWebhosts($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `webhost`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		$query = $this->db->query($sql);
		return $query->row['count'];
	}	
}
?>