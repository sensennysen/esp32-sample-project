<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!--<title> Drop Down Sidebar Menu | CodingLab </title>-->
    <link rel="stylesheet" href="leaveForm.css">
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body class="zf-backgroundBg">
<?php include ('Empsidebar.php');?>

<section class="home-section">
  <div class="home-content">
    <span class="text">Leave Application Request</span>
  </div>
  <!-- Change or deletion of the name attributes in the input tag will lead to empty values on record submission-->
<div class="zf-templateWidth"><form action="./LeaveRequest/leaveApp.php" name='form' method='POST' onSubmit='javascript:document.charset="UTF-8"; return zf_ValidateAndSubmit();' accept-charset='UTF-8' enctype='multipart/form-data' id='form'><input type="hidden" name="zf_referrer_name" value=""><!-- To Track referrals , place the referrer name within the " " in the above hidden input field -->
<input type="hidden" name="zf_redirect_url" value=""><!-- To redirect to a specific page after record submission , place the respective url within the " " in the above hidden input field -->
<input type="hidden" name="zc_gad" value=""><!-- If GCLID is enabled in Zoho CRM Integration, click details of AdWords Ads will be pushed to Zoho CRM -->

<?php
        require './LeaveRequest/vendor/autoload.php';
        define("DATABASE","demo_hris");
        
        class DatabaseConnection
        {
            private $server = "mysql:host=localhost;dbname=".DATABASE;
            private $user = "root";
            private $pass = "";
            private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
            protected $con;
            
            public function connect()
            {
                try {
                    $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
                    return $this->con;
                } catch (PDOException $e) {
                    echo "There is an error: " . $e->getMessage();
                }
            }
        }
        
        class LeaveApplication extends DatabaseConnection
        {
            public function submitLeaveApplication($data)
            {
                // Your leave application submission logic here
            }
        }
        
        // Create an instance of the LeaveApplication class and call the submitLeaveApplication method with the form data
        $leaveApplication = new LeaveApplication();
        $result = $leaveApplication->submitLeaveApplication($_POST);
        echo $result;
      ?>
<div class="zf-templateWrapper"><!---------template Header Starts Here---------->

<p class="zf-frmDesc"></p>
<div class="zf-clearBoth"></div></li></ul><!---------template Header Ends Here---------->
<!---------template Container Starts Here---------->
<div class="zf-subContWrap zf-topAlign"><ul>
<!---------Dropdown Starts Here---------->
<li class="zf-tempFrmWrapper zf-large"><label class="zf-labelName">
Type of Leave
<em class="zf-important">*</em>
</label>
<div class="zf-tempContDiv">
<select class="zf-form-sBox" name="leave_type" checktype="c1">
<option selected="true" value="-Select-">-Select-</option>
<option value="Philhealth">Personal Leave</option>
<option value="SSS&#x20;Loan">Sick Leave</option>
<option value="Pag-ibig&#x20;Loan">Vaction Leave</option>
</select><p id="Dropdown_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Dropdown Ends Here---------->
<!---------Multiple Line Starts Here---------->
<li class="zf-tempFrmWrapper zf-large"><label class="zf-labelName"> 
Reason for leave
</label>
<div class="zf-tempContDiv">
<span> <textarea name="reason" checktype="c1" maxlength="65535" placeholder=""></textarea> </span><p id="MultiLine_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Multiple Line Ends Here---------->
<!---------Description Starts Here---------->  
<li class="zf-tempFrmWrapper zf-note"><label class="zf-descFld"><div><b>Once the request is approved kindly proceed to the HR office. <span class="colour" style="color: rgb(255, 0, 0)">*</span></b><br /></div></label>
<div class="zf-clearBoth"></div></li><!---------Description Ends Here---------->  
</ul></div><!---------template Container Starts Here---------->
<ul><li class="zf-fmFooter"><button class="zf-submitColor" >Submit</button></li></ul></div><!-- 'zf-templateWrapper' ends --></form></div><!-- 'zf-templateWidth' ends -->
</div>
  </div>
<script type="text/javascript">var zf_DateRegex = new RegExp("^(([0][1-9])|([1-2][0-9])|([3][0-1]))[-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)[-](?:(?:19|20)[0-9]{2})$");
var zf_MandArray = ["Dropdown"]; 
var zf_FieldArray = [ "Dropdown", "MultiLine"]; 
var isSalesIQIntegrationEnabled = false;
var salesIQFieldsArray = [];</script>

</body>
</html>