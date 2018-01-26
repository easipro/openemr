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
					echo "<td>Start Assessment</td>";
				}else if($row['status']=='in-progress'){
					echo "<td>Continue Assessment</td>";
				}else if($row['status']=='completed'){
					echo "<td><i class='fa fa-check-circle-o'></i></td>";
				}
				echo "</tr>";
  		}
		echo "</table>";
  	}
	else
	{
		echo xlt("No Assignment to Display.");
	}
?>
