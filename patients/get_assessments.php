<?php
/**
 * Patient Portal Amendments
 *
 * Copyright (C) 2014 Ensoftek
 *
 * LICENSE: This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://opensource.org/licenses/gpl-license.php>;.
 *
 * @package OpenEMR
 * @author  Hema Bandaru <hemab@drcloudemr.com>
 * @link    http://www.open-emr.org
 */
require_once("verify_session.php");

$query = "SELECT *
         FROM assessments
         WHERE patient_id=?";
$res = sqlStatement($query, array($pid) );
if ( sqlNumRows($res) > 0 ) { ?>
	<table class="class1">
		<tr class="header">
			<th><?php echo xlt('Name'); ?></th>
			<th><?php echo xlt('Deadline (CST)'); ?></th>
			<th><?php echo xlt('Status'); ?></th>
			<th><?php echo xlt(''); ?></th>
		</tr>
	<?php
  		$even = false;
  		while ($row = sqlFetchArray($res)) {
  			if ( $even ) {
  				$class = "class1_even";
  				$even = false;
  			} else {
  				$class="class1_odd";
  				$even=true;
				}
				echo "<tr class='".$class."'>";
				echo "<td>".text($row['form_name'])."</td>";
				echo "<td>".text($row['deadline'])."</td>";
				echo "<td>".text($row['status'])."</td>";
				if($row['status']=='ordered'){
					echo "<td><a href='#' onclick='startAssessment(".text("'".$row['assessment_oid']."'").")>Start Assessment</a></td>";
				}else if($row['status']=='in-progress'){
					echo "<td>Continue Assessment</td>";
				}else if($row['status']=='completed'){
					echo "<td><i class='fa fa-check-circle'></i></td>";
				}
				echo "</tr>";
  		}
		echo "</table>";
  	}
	else
	{
		echo xlt("No Assignment to Display.");
	}
	echo "<div id='Content'></div>"
?>

<script>

	var Server = "https://www.assessmentcenter.net/ac_api";
  
  function selectResponse(obj){
		renderScreen(obj)
  }
 
	function renderScreen(obj){
		$.ajax({
			url: Server + document.getElementById("UID").value + ".json",
			cache: false,
			type: "POST",
			data: "ItemResponseOID=" + obj.name + "&Response=" + obj.id,
			dataType: "json",
			
			beforeSend: function(xhr) {
				var bytes = Crypto.charenc.Binary.stringToBytes(document.getElementById("txtRegistration").value + ":" + document.getElementById("txtToken").value);
				var base64 = Crypto.util.bytesToBase64(bytes);
				xhr.setRequestHeader("Authorization", "Basic " + base64);
			},
	
	success: function(data) { 

	if(data.DateFinished !=''){
		document.getElementById("Content").innerHTML = "You have finished the assessment.<br /> Thank you";
		document.getElementById("btnStart").disabled = true;
		return
	}
	var screen ="";

			for(var j=0; j < data.Items[0].Elements.length; j++){
			
				if(typeof(data.Items[0].Elements[j].Map) == 'undefined'){
					screen = screen +"<div style=\'height: 30px\' >" +  data.Items[0].Elements[j].Description + "</div>"
				}else{
				
					for(var k=0; k < data.Items[0].Elements[j].Map.length; k++){
						screen = screen + "<div style=\'height: 50px\' ><input type=\'button\' class='btn-submit' id=\'" + data.Items[0].Elements[j].Map[k].Value + "\' name=\'" + data.Items[0].Elements[j].Map[k].ItemResponseOID + "\' value=\'" + data.Items[0].Elements[j].Map[k].Description +  "\' onclick=selectResponse(this) />"    + "</div>"; 
					}
				
				}
			
			}
	document.getElementById("Content").innerHTML = screen;

	},
	
	error: function(jqXHR, textStatus, errorThrown){
		//document.write(jqXHR.responseText + ':' + textStatus + ':' + errorThrown);
		document.write("An error occurred");
	}
	}

	)

}

function startAssessment(assessmentOID){
	$.ajax({
		url: Server + "/2014-01/Participants/" + assessmentOID + ".json",
		cache: false,
		type: "POST",
		data: "",
		dataType: "json",
		
		beforeSend: function(xhr) {
			var bytes = Crypto.charenc.Binary.stringToBytes("BBD62935-F76F-4EC8-8834-BDAA75DAD8AB:9A35D313-E7BC-41C9-8933-3A3D73953F73");
      var base64 = Crypto.util.bytesToBase64(bytes);
      // alert(base64);
      xhr.setRequestHeader("Authorization", "Basic " + base64);
		},
		
		success: function(data) { 
			var screen ="";
			for(var j=0; j < data.Items[0].Elements.length; j++){
				if(typeof(data.Items[0].Elements[j].Map) == 'undefined'){
						screen = screen + "<div style=\'height: 30px\' >" + data.Items[0].Elements[j].Description + "</div>"
					}else{
						for(var k=0; k < data.Items[0].Elements[j].Map.length; k++){
							screen = screen + "<div style=\'height: 50px\' ><input type=\'button\' class='btn-submit' id=\'" + data.Items[0].Elements[j].Map[k].Value + "\' name=\'" + data.Items[0].Elements[j].Map[k].ItemResponseOID + "\' value=\'" + data.Items[0].Elements[j].Map[k].Description +  "\' onclick=selectResponse(this) />"    + "</div>"; 
						}
					}
				}
			document.getElementById("Content").innerHTML = screen;
		},
		
		error: function(jqXHR, textStatus, errorThrown){
			//document.write(jqXHR.responseText);
			document.write("An error occurred");
		}
	})
}
         
</script>
