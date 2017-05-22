<link rel="stylesheet" href="main.css">
<?php
    require_once("db_config.php");
    require("switch_config.php"); 

 //Port Accept
   if ( isset($_POST['status']) && $_POST['status'] != ''&&($_POST['status']=="3")  && isset($_POST['port']) && $_POST['port'] != '') {
   	$port = $_POST['port'];
   	//echo"3";
	snmp2_set($ip220,$private,$oid3.".".$port,'i',"1");
       }
 //Port Suspend
    else if( isset($_POST['status']) && $_POST['status'] != ''  && isset($_POST['port']) && $_POST['port'] != ''){
       	 $status = $_POST['status'];
         $port = $_POST['port'];
	 //echo"1or2";
	 snmp2_set($ip220,$private,$oid4.".".$port,'i',$status);
	 }

    require("switch_config.php");
  
  //port ¿O«G©Î¨S«G
   echo" 
   	 <div>
	 <h2>3F_North</h2>
	 <div class=\"row\">
	"; 
   $ifOperstatus = snmp2_real_walk("$ip220","$private","$oid5");
   $suspend_Operstatus =  snmp2_real_walk("$ip220","$private","$oid");
   

		
   $sus_status = [];
   foreach($suspend_Operstatus as $key => $value){
   	$port_sus = explode("SNMPv2-SMI::enterprises.9.6.1.101.43.1.1.24.",$key);
   	$port_susstatus = explode("INTEGER: ",$value);
    	array_push($sus_status,$port_susstatus[1]);
   	}

   foreach($ifOperstatus as $key => $value){
        $port_num = explode("RFC1213-MIB::ifOperStatus.",$key);
        $port_operstatus = explode("INTEGER: ",$value);
        $lab = "SELECT `st_num` ,`lab`  FROM `switch220` WHERE `port` = '$port_num[1]'";
        $labs = mysql_query($lab);
	$row = mysql_fetch_array($labs);
	if($port_num[1]<=48){
		echo "
        	<div class=\"col-md-1\">
        	<table class=\"table table-bordered\"  >
        	<tr>
		<td data-toggle=\"tooltip\" data-placement=\"top\" title=\"$row[0]&nbsp;$row[1]\" align=\"center\">$port_num[1]</td>
		</tr>
		";
        

		if($port_operstatus[1]=="up(1)"){
		$port_operstatus[1]="1";
			
			echo"<tr><td bgcolor=\"green\"><div type=\"button\" class=\"btn btn-link btn-xs\" data-toggle=\"modal\" data-target=\"#myModal\" port_num=$port_num[1] port_value=$port_operstatus[1] style=\"display:block;\">&nbsp;</div></td>";
		}

		else if ($port_operstatus[1]=="down(2)"){

		
			if($sus_status[$port_num[1]-1]=="1"){
			$port_operstatus[1]="3";
			echo"<tr><td bgcolor=\"yellow\"><div type=\"button\" class=\"btn btn-link btn-xs\" data-toggle=\"modal\" data-target=\"#myModal\" port_num=$port_num[1] port_value=$port_operstatus[1] style=\"display:block;\">&nbsp;</div></td>";
			}
			else{
			$port_operstatus[1]="2";
			echo"<tr><td bgcolor=\"red\"><div type=\"button\" class=\"btn btn-link btn-xs\" data-toggle=\"modal\" data-target=\"#myModal\" port_num=$port_num[1] port_value=$port_operstatus[1] style=\"display:block;\">&nbsp;</div></td>";
			}
		}

		else
		echo"<tr><td>$port_operstatus[1]</td>";
	
		echo"
		</tr>	
		</table>
		</div>
		";
  	}
  }
   echo"
	</div>
	</div>
        
	
	<!-- Modal -->
	<div class=\"modal fade\" id=\"myModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
		<div class=\"modal-dialog\">
			<div class=\"modal-content\">
				<div class=\"modal-header\">
				<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
				<h4 class=\"modal-title\" id=\"myModalLabel\"><strong id=\"topic\"></strong>&nbsp;Port Change Status</h4>
				</div>
			<div class=\"modal-body\">
			<form role=\"form\" method=\"POST\">
				<div class=\"radio\">
				<label><input type=\"radio\" name=\"status\" value=\"1\"check_value=\"1\">UP</label>
				</div>
				<div class=\"radio\">
				<label><input type=\"radio\" name=\"status\" value=\"2\"check_value=\"2\">DOWN</label>
				</div>
				<div class=\"radio\">
				<label><input type=\"radio\" name=\"status\" value=\"3\"check_value=\"3\">Unsuspend</label>
				</div>
        			<input type=\"hidden\" name=\"port\">	
				</div>
			<div class=\"modal-footer\">
			<button type=\"button\" class=\"btn btn-hidden\" data-dismiss=\"modal\">Close</button>
			<button type=\"submit\" class=\"btn btn-primary\">Save changes</button>
			</form>
			</div>
			</div>
		</div>
	</div>
        
	
	<!-- onclick-->	
	<script>
	$(document).on('click','.btn-link',function(){
	$(\"input[name='status']\").prop(\"checked\",false);
	var id=$(this).attr('port_num');
	$(\"input[name='port']\").val(id);
	
	var id2=$(this).attr('port_value');
	$(\"input[check_value='\"+id2+\"']\").prop(\"checked\",true);
		
	$(\"#topic\").html(id);	
		}
	);
	</script>
	";
		
include("../bottom.php");   
?>

<script>
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();
});
</script>
