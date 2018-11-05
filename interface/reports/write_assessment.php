<?php
// +-----------------------------------------------------------------------------+
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
//
// A copy of the GNU General Public License is included along with this program:
// openemr/interface/login/GnuGPL.html
// For more information write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
// Author:   Shiqiang Tao <shiqiang.tao@uky.edu>
//
// +------------------------------------------------------------------------------+
//SANITIZE ALL ESCAPES
$sanitize_all_escapes=true;
//

//STOP FAKE REGISTER GLOBALS
$fake_register_globals=false;
//

require_once("../globals.php");
require_once("$srcdir/patient.inc");
require_once("$srcdir/formatting.inc.php");
require_once "$srcdir/options.inc.php";
require_once "$srcdir/formdata.inc.php";
$formOID = $_POST['formOID'];
$formName = $_POST['formName'];
$expiration = $_POST['expiration'];
$assessmentOID = $_POST['assessmentOID'];
$uid = $_POST['uid'];
$status = $_POST['status'];
?>

<?php
    // echo "<script>console.log( 'Debug Objects: " . $formOID . "' );</script>";
    

    $query = "INSERT INTO assessments (form_oid, form_name, user_id, deadline, patient_id, assessment_oid, status)
              VALUES('$formOID', '$formName', 1, '$expiration', '$pid', '$assessmentOID', '$status')";
    sqlStatement($query);

		$to = "strongtsq@gmail.com";
    
    $subject = "New measurement ready for you";
    
    $message = '<html><body>';
		$message .= '<table style="border-radius:4px;border:1px #dceaf5 solid" align="center" border="0" cellpadding="0" cellspacing="0">'
		$message .= '<tbody><tr><td>'
		$message .= '<table style="line-height:25px" align="center" border="0" cellpadding="10" cellspacing="0">'
		$message .= '<tbody><tr>'
		$message .= '<td style="color:#444444;border-collapse:collapse;font-size:11pt;font-family:proxima_nova,\'Open Sans\',\'Lucida Grande\',\'Segoe UI\',Arial,Verdana,\'Lucida Sans Unicode\',Tahoma,\'Sans Serif\';max-width:700px" align="left" valign="top" width="700">'

		$message .= 'Dear John!<br>Dr. Admin has ordered a measurement for you: <b>'
		$message .= $formName
		$message .= '</b><br><b>Your measurement will close after '
		$message .= $expiration
		$message .= ' ,</b> so please log in and complete it before then.'
		$message .= '<center><a style="border-radius:3px;font-size:15px;color:white;border:1px #1373b5 solid;text-decoration:none;padding:14px 7px 14px 7px;width:210px;max-width:210px;font-family:proxima_nova,\'Open Sans\',\'lucida grande\',\'Segoe UI\',arial,verdana,\'lucida sans unicode\',tahoma,sans-serif;margin:6px auto;display:block;background-color:#007ee6;text-align:center" href="128.163.202.60/openemr/patients" target="_blank">Go to EasiPRO</a></center><br>If you need help or have any questions, please call us toll free at 859.218.4962 or email us at easipro@uky.edu.<br>Thanks,<br>EasiPRO Team</td></tr></tbody></table>'
		$message .= '</td></tr></tbody></table>'
		$message .= '</body></html>';

    $headers = "From: EasiPRO@uky.edu\r\n";
		$headers .= "Reply-To: EasiPRO@uky.edu\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
    mail($to, $subject, $message, $headers);

?>
