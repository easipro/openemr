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
// GET FORM DATA Syntax
// $from_date = fixDate($_POST['form_from_date'], date('Y-m-d'));
// $to_date = fixDate($_POST['form_to_date'], date('Y-m-d'));
?>
<html>
    <!-- HTML Head -->
    <head>
        <?php html_header_show(); ?>
        <title><?php echo xlt('PRO'); ?></title>
        <script type="text/javascript" src="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-min-1-3-2/index.js"></script>
        <link rel='stylesheet' href='<?php echo $css_header ?>' type='text/css'>
        <style>
            .dm-ed-in-1 {
                height: 35px;
                width: 100%;
                background-color: #E7ECF2;
                border-bottom: thin solid #C0C0C0;
                padding: 5px 0; z-index: 100;
            }
            .dm-ed-in-1 h3 {
                color: rgb(8, 102, 198);
                font-size: 20px; float: left;
                line-height: 0px;
            }
            .panel-padding{
                padding: 10px;
            }
        
            .panel-bordered{
                border: 1px solid #c8c8c8;
                border-color: rgba(0,0,0,0.2);
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            .dm-ed-in-4 {
                display: none;
            }
            .dm-ed-in-5 {
                margin-left: 10%;
                margin-top: 3%;
            }
            .dm-ed-in-6 {
                width: 20% !important;
            }
            .dm-ed-in-7 {
                font-size: 12px;
            }
            .dm-ed-in-8 {
                width: 60%;
                margin-left: 10%;
                margin-top: 40px;
                border: 1px solid #CCCCCC;
                text-align:center;
                padding: 30px;
                font-size: 15px;
                font-weight: bold;
                background: #f7f7f7;
            }
            .dm-ed-in-9 {
                line-height:30px;
            }
            ul.ext-tab-head li {
                border-bottom: 2px solid #faffff;
                color: #222222;
                cursor: pointer;
                display: inline-block;
                font-size: 14px;
                margin-bottom: 0;
                padding: 3px 5px;
                text-decoration: none;
                background-color: #f6f6f6;
                color: #333333;
            }
            ul.ext-tab-head li.child-active {
                border-bottom: 2px solid #003366;
                background-color: #007fff;
                color: #ffffff;
            }
        </style>
    </head>
    <!-- HTML Body -->
    <body class="body_top">
        <div class="dm-ed-in-1">
            <h3><?php echo xlt('Patient Reported Outcomes') ?></h3>
        </div>
        <div class="clear"></div>
        <div>
            <ul class="ext-tab-head">
                <li class="child-active ext-enc"><?php echo xlt('Existing Forms'); ?></li>
                <li class="ext-proc"><?php echo xlt('Add New Form'); ?></li>
            </ul>
            <hr>
        </div>
        <div class="dm-ed-in-3 dm-ed-in-5 panel-padding panel-bordered">
            <?php
                $query1 = "SELECT ee.*,CONCAT_WS(' ',u1.lname, u1.fname) AS provider,u2.organization AS facility
                           FROM external_encounters AS ee
                           LEFT JOIN users AS u1 ON u1.id = ee.ee_provider_id
                           LEFT JOIN users AS u2 ON u2.id = ee.ee_facility_id
                           WHERE ee.ee_pid = ?";
                $res1 = sqlStatement($query1, array($pid));
                while ($row1 = sqlFetchArray($res1)) {
                    $records1[] = $row1;
                }
            ?>
            <?php if (!empty($records1)) { ?>
                <table width="100%;">
                    <tr class="dm-ed-in-9">
                        <td class="dm-ed-in-6"><label><?php echo xlt('Name'); ?></label></td>
                        <td class="dm-ed-in-6"><label><?php echo xlt('Deadline'); ?></label></td>
                        <td class="dm-ed-in-6"><label><?php echo xlt('Status'); ?></label></td>
                        <td class="dm-ed-in-6"><label><?php echo xlt('Ordered By'); ?></label></td>
                    </tr>
                    <?php foreach ($records1 as $value1) { ?>
                        <tr>
                            <td><span class="dm-ed-in-7"><?php echo oeFormatShortDate($value1['ee_date']); ?></span></td>
                            <td><span class="dm-ed-in-7"><?php echo htmlspecialchars($value1['ee_encounter_diagnosis'], ENT_NOQUOTES); ?></span></td>
                            <td><span class="dm-ed-in-7"><?php echo htmlspecialchars($value1['provider'], ENT_NOQUOTES); ?></span></td>
                            <td><span class="dm-ed-in-7"><?php echo htmlspecialchars($value1['facility'], ENT_NOQUOTES); ?></span></td>
                        </tr>
                    <?php } ?>
                </table>   
            <?php }?>

            <?php if (empty($records1)) { ?>
                <div class="dm-ed-in-8">
                    <?php echo xlt('Nothing to display'); ?>
                </div>
            <?php } ?>
        </div>
        <div class="dm-ed-in-4 dm-ed-in-5 panel-padding panel-bordered">
           <a href="#" onclick="alert('a');listForms();alert('b')">List Forms</a>
           |
           <a href="#" onclick="orderForm()">Order Form</a>
           <hr>

        </div>
        
        <!-- Javascript goes here -->
        <script>

            $(document).ready(function() {
                $('.ext-tab-head li').click(function() {
                    $('.ext-tab-head li').removeClass("child-active");
                    $(this).addClass("child-active");
                });
                $('.ext-enc').click(function() {
                    $('.dm-ed-in-4').hide();
                    $('.dm-ed-in-3').show();
                });
                $('.ext-proc').click(function() {
                    $('.dm-ed-in-3').hide();
                    $('.dm-ed-in-4').show();
                });
            });

            function listForms() {
                $.ajax({
                    url: Server + "/2014-01/Forms/.json",
                    cache: false,
                    type: "POST",
                    data: "",
                    dataType: "json",

                    beforeSend: function(xhr) {
                        var bytes = Crypto.charenc.Binary.stringToBytes("BBD62935-F76F-4EC8-8834-BDAA75DAD8AB:9A35D313-E7BC-41C9-8933-3A3D73953F73");
                        var base64 = Crypto.util.bytesToBase64(bytes);
                        xhr.setRequestHeader("Authorization", "Basic " + base64);
                    },

                    success: function(data) { 
                        var container = document.getElementById("all-forms");
                        var forms = data.Form;
                        for (var i=0; i < forms.length; i++) {
                            var myform = document.createElement("div");
                            myform.innerHTML = forms[i].OID + " : " + forms[i].Name + "";
                            container.appendChild(myform);
                        }
                    },
                
                    error: function(jqXHR, textStatus, errorThrown) {
                        document.write(jqXHR.responseText + ':' + textStatus + ':' + errorThrown);
                    }
                })

            }
        </script>
    </body>
</html>