<?php

$ip220 = "192.168.1.220";
$ip230 = "192.168.1.230";
$ip240 = "192.168.1.240";
$private = "passwd";
$oid = "1.3.6.1.4.1.9.6.1.101.43.1.1.24";   //port suspend  status
$oid2 = "1.3.6.1.4.1.9.6.1.101.43.1.1.24";  //recover suspended port
$oid4 = "1.3.6.1.2.1.2.2.1.7"; //ifAdminStatus port  up down status
$oid5 = "1.3.6.1.2.1.2.2.1.8";//ifOperStatus
$oid3 = "1.3.6.1.4.1.9.6.1.101.43.1.1.27"; // port suspend admin 

//ifAdminStatus
//$ifAdminstatus = snmp2_real_walk("$ip","$private","$oid4");
//print_r($ifAdminstatus); 

//ifOperStatus
//$ifOperstatus = snmp2_real_walk("$ip","$private","$oid5");
// print_r($ifOperstatus); 

//suspend
//$suspend_Operstatus =  snmp2_real_walk("$ip","$private","$oid");
//print_r($suspend_operstatus);
							    
/*
//port suspend
foreach($suspend_Operstatus as $key => $value){
$port_sus = explode("SNMPv2-SMI::enterprises.9.6.1.101.43.1.1.24.",$key);
$port_susstatus = explode("INTEGER: ",$value);
echo $port_sus[1].":";
echo $port_susstatus[1]."\n";
}
*/
/*
//port ¶}±Ò©ÎÃö³¬
foreach($ifAdminstatus as $key => $value){
$port_num = explode("RFC1213-MIB::ifAdminStatus.",$key);
$port_adminstatus = explode("INTEGER: ",$value);
echo $port_num[1].":";
echo $port_adminstatus[1]."\n";
}
*/

?>
