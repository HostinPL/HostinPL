<?php  
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class whois { 
 
var $port = 43; 
var $MAXLEN = 1024; 
 
// Тип запроса 
var $QUERY_TYPE = "domain";      
var $DEFAULT_SERVER = "whois.crsnic.net"; 
 
//Настрока повторных попыток 
var $MAX_RETRIES = 3; 
var $SLEEP_VAL = 1; 
var $RETRY = 0; 
 
var $FOUND = 0; // устанавливается в 0 если запись не найдена 
var $ERROR = 0; // устанавливает признак ошибки 
var $DATA_MIN = 8; //минимум данных свидетельствующих о том что сервер работает 
 
var $DATA_COUNT = 0; 
 
//Переменные. берутся из запроса 
var $ORGANIZATION; 
var $ORG_HANDLE; 
var $ORG_ADDRESS;       // массив 
var $DOMAIN_NAME; 
var $DOMAIN_STATUS;      
var $ADMIN;             // массив: "name", "nic" и "email" 
var $TECH;              // массив: "name", "nic" и "email" 
var $ZONE;              // массив: "name", "nic" и "email" 
var $BILLING; 
var $UPDATED; 
var $CREATED;            
var $DNS_NAME=array();          // массив с именами DNS серверов 
var $HANDLES;            
 
var $IP=""; 
//список серверов по зонам 
var $SERVER = array( 
"com"=>"whois.crsnic.net", 
"net"=>"whois.crsnic.net", 
"edu"=>"whois.educause.net", 
"org"=>"whois.publicinterestregistry.net", 
"arpa"=>"whois.arin.net", 
"ripe"=>"whois.ripe.net", 
"mil"=>"whois.nic.mil", 
"coop"=>"whois.nic.coop", 
"museum"=>"whois.museum", 
"biz"=>"whois.neulevel.biz", 
"info"=>"whois.afilias.net", 
"name"=>"whois.nic.name", 
"gov"=>"whois.nic.gov", 
"aero"=>"whois.information.aero", 
"ns"=>"whois.internic.net", 
"ip"=>"whois.ripe.net", 
"ad"=>"whois.ripe.net", 
"al"=>"whois.ripe.net", 
"am"=>"whois.ripe.net", 
"as"=>"whois.gdns.net", 
"at"=>"whois.nic.at", 
"au"=>"box2.aunic.net", 
"az"=>"whois.ripe.net", 
"ba"=>"whois.ripe.net", 
"be"=>"whois.dns.be", 
"bg"=>"whois.ripe.net", 
"br"=>"whois.nic.br", 
"by"=>"whois.ripe.net", 
"ca"=>"eider.cira.ca", 
"cc"=>"whois.nic.cc", 
"ch"=>"domex.switch.ch", 
"ck"=>"whois.ck-nic.org.ck", 
"cl"=>"nic.cl", 
"cn"=>"whois.cnnic.net.cn", 
"cx"=>"whois.nic.cx", 
"cy"=>"whois.ripe.net", 
"cz"=>"dc1.eunet.cz", 
"de"=>"whois.denic.de", 
"dk"=>"whois.dk-hostmaster.dk", 
"do"=>"ns.nic.do", 
"dz"=>"whois.ripe.net", 
"ee"=>"whois.ripe.net", 
"eg"=>"whois.ripe.net", 
"es"=>"whois.ripe.net", 
"fi"=>"whois.ripe.net", 
"fo"=>"whois.ripe.net", 
"fr"=>"winter.nic.fr", 
"ga"=>"whois.ripe.net", 
"gb"=>"whois.ripe.net", 
"ge"=>"whois.ripe.net", 
"gl"=>"whois.ripe.net", 
"gm"=>"whois.ripe.net", 
"gr"=>"estia.ics.forth.gr", 
"gs"=>"whois.adamsnames.tc", 
"hk"=>"whois.hkdnr.net.hk", 
"hr"=>"whois.ripe.net", 
"hu"=>"whois.nic.hu", 
"id"=>"muara.idnic.net.id", 
"ie"=>"whois.domainregistry.ie", 
"il"=>"whois.isoc.org.il", 
"in"=>"whois.ncst.ernet.in", 
"is"=>"horus.isnic.is", 
"it"=>"whois.nic.it", 
"jo"=>"whois.ripe.net", 
"jp"=>"whois.nic.ad.jp", 
"kg"=>"whois.domain.kg", 
"kh"=>"whois.nic.net.kh", 
"kr"=>"whois.krnic.net", 
"la"=>"whois.nic.la", 
"li"=>"domex.switch.ch", 
"lk"=>"arisen.nic.lk", 
"lt"=>"ns.litnet.lt", 
"lu"=>"whois.dns.lu", 
"lv"=>"whois.ripe.net", 
"ma"=>"whois.ripe.net", 
"mc"=>"whois.ripe.net", 
"md"=>"whois.ripe.net", 
"mm"=>"whois.nic.mm", 
"ms"=>"whois.adamsnames.tc", 
"mt"=>"whois.ripe.net", 
"mx"=>"whois.nic.mx", 
"nl"=>"whois.domain-registry.nl", 
"no"=>"ask.norid.no", 
"nu"=>"whois.worldnames.net", 
"nz"=>"akl-iis.domainz.net.nz", 
"pl"=>"nazgul.nask.waw.pl", 
"pt"=>"whois.ripe.net", 
"ro"=>"whois.rotld.ro", 
"ru"=>"whois.ripn.net", 
"se"=>"ear.nic-se.se", 
"sg"=>"qs.nic.net.sg", 
"sh"=>"whois.nic.sh", 
"si"=>"whois.arnes.si", 
"sk"=>"whois.ripe.net", 
"sm"=>"whois.ripe.net", 
"st"=>"whois.nic.st", 
"su"=>"whois.ripn.net", 
"tc"=>"whois.adamsnames.tc", 
"tf"=>"whois.adamsnames.tc", 
"th"=>"whois.thnic.net", 
"tj"=>"whois.nic.tj", 
"tn"=>"whois.ripe.net", 
"to"=>"whois.tonic.to", 
"tr"=>"whois.ripe.net", 
"tw"=>"whois.twnic.net", 
"tv"=>"whois.nic.tv", 
"ua"=>"whois.net.ua", 
"uk"=>"whois.nic.uk", 
"us"=>"whois.nic.us", 
"va"=>"whois.ripe.net", 
"vg"=>"whois.adamsnames.tc", 
"ws"=>"whois.worldsite.ws", 
"yu"=>"whois.ripe.net", 
"za"=>"apies.frd.ac.za", 
"xn--p1ag"=>"ru.whois.i-dns.net", 
"xn--p1ag"=>"ru.whois.i-dns.net", 
"xn--j1ae"=>"whois.i-dns.net", 
"xn--e1ap"=>"whois.i-dns.net", 
"xn--c1av"=>"whois.i-dns.net", 
"net.ru"=>"whois.ripn.net", 
"org.ru"=>"whois.ripn.net", 
"pp.ru"=>"whois.ripn.net", 
"spb.ru"=>"whois.relcom.ru", 
"msk.ru"=>"whois.relcom.ru", 
"ru.net"=>"whois.relcom.ru", 
"yes.ru"=>"whois.regtime.net", 
"uk.com"=>"whois.centralnic.com", 
"uk.net"=>"whois.centralnic.com", 
"gb.com"=>"whois.centralnic.com", 
"gb.net"=>"whois.centralnic.com", 
"eu.com"=>"whois.centralnic.com" 
                ); 
 
var $TLD; 
var $RAWINFO; 
var $DNSINFO; 
//обращение к WHOIS серверу 
function connect ($server) 
{ 
 while($this->RETRY <= $this->MAX_RETRIES) 
 { 
  $ptr=fsockopen($server, $this->port);  
  if($ptr>0) 
  { 
   $this->ERROR=0; 
   return($ptr); 
  }else 
   { 
    $this->ERROR++; 
    $this->RETRY++; 
    sleep($this->SLEEP_VAL); 
   } 
 } 
} 
 
//Получает данные и загружает их в массив 
function rawlookup ($query) 
{ 
 $array=array(); 
 $this->FOUND=1; 
 $query=strtolower(trim($query)); 
 if(strlen($query)<=2) 
 { 
  $this->ERROR=1; 
  return($array); 
 } 
 //устанавливаем сервер по умолчанию 
 $server=$this->DEFAULT_SERVER; 
 //пытаемся переназначить его 
 if($this->QUERY_TYPE=="domain") 
 { 
  ereg(".+\.(.+)\.{0,1}",$query,$backrefs); 
  if(isset($backrefs[1]) && strlen($backrefs[1])>0 && isset($this->SERVER[$backrefs[1]])) 
  { 
   $this->TLD=$backrefs[1]; 
   $server=$this->SERVER[$this->TLD]; 
  } 
 
 } 
 $ptr=$this->connect($server); 
 if($ptr) 
 { 
  $query .= "\n"; 
  fputs($ptr, $query); 
  $i=0; 
  while(!feof($ptr)) 
  { 
   $array[$i]=fgets($ptr,$this->MAXLEN); 
   $this->DATA_COUNT+=strlen(trim($array[$i])); 
   if(eregi("No match for", $array[$i]) || eregi("Not found", $array[$i]) || eregi("No entries found for", $array[$i])) 
   { 
    $this->FOUND=0; 
    break; 
   } 
   if(eregi("WHOIS database is down",$array[$i]) || eregi("Please wait a while and try again",$array[$i])) 
   { 
    $this->ERROR=1; 
    $this->FOUND=0; 
    break; 
   } 
   $i++; 
  } 
  fclose($ptr); 
  if($this->DATA_COUNT>$this->DATA_MIN && $this->ERROR==0 && $this->FOUND==1) 
  { 
   return($array); 
  } 
 } 
 //в случае ошибки возвращаем пустой массив 
 return (array()); 
} 
 
 
// парсинг результатов 
function parsezone ($array) 
{ 
 $result=array(); 
 if(!isset($array) || !is_array($array) || count($array)<=3) 
 { 
  $this->FOUND=0; 
  return $result; 
 } 
 $cnt=count($array); 
 $rescnt=0; 
 $i=0; 
 $isinfo=true; 
 while($i<$cnt) 
 { 
  if(!$isinfo) 
  { 
   $str=trim($array[$i]); 
   $result[$rescnt]=$str; 
   //Извлекаем настройки DNS 
   if(eregi("NAME SERVER", $str) || eregi("NSERVER", $str)) 
   { 
    $str=trim(substr($str, strpos($str, ":")+1)); 
    if($pos=strpos($str, " ")) 
    { 
     $str=substr($str, 0, $pos); 
    } 
    if(substr($str, -1)==".") 
    { 
     $str=substr($str, 0, -1); 
    } 
    $this->DNS_NAME[]=strtolower($str); 
   } 
   $rescnt++; 
  } 
  if(trim($array[$i])=="" && $isinfo) 
  { 
   $isinfo=false; 
  } 
  $i++; 
 } 
 return $result; 
} 
 
function zonelookup ($query) 
{ 
  $query=trim($query); 
  $this->RAWINFO=$this->rawlookup($query); 
  if($this->FOUND) 
  { 
     $this->RAWINFO=$this->parsezone($this->RAWINFO); 
  } 
  if($this->FOUND==0) 
  { 
   return; 
  } 
  if($this->dns_lookup($query)) 
  { 
   $this->IP=gethostbyname($query); 
   $this->build_dns($query); 
  } 
} 
 
function build_dns($query) 
{ 
 $cnt=0; 
// $temp=dns_get_record($query, "NS"); 
 foreach($this->DNS_NAME AS $dns) 
 { 
  $this->DNSINFO[$cnt]="NS: ".$dns."\tinternet address = ".gethostbyname($dns); 
  $cnt++; 
 } 
 if(getmxrr($query, $temp))  
 { 
  foreach($temp AS $dns) 
  { 
   $this->DNSINFO[$cnt]="MX: ".$dns."\tinternet address = ".gethostbyname($dns); 
   $cnt++; 
  } 
 } 
 
} 
function dns_lookup($query) 
{ 
  return checkdnsrr($query,"ANY"); 
} 
 
 
}; 
 
?>