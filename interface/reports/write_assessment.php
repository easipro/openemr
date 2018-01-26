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
?>
