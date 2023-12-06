<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!--<title> Drop Down Sidebar Menu | CodingLab </title>-->
    <link rel="stylesheet" href="loanForm.css">
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body class="zf-backgroundBg">
<?php include ('Empsidebar.php');?>

<section class="home-section">
  <div class="home-content">
    <span class="text">Loan Application Request</span>
  </div>
  <!-- Change or deletion of the name attributes in the input tag will lead to empty values on record submission-->
<div class="zf-templateWidth"><form action='https://forms.zohopublic.com/julyahannahtan/form/LeaveApplication/formperma/KmKad1qMo1JuUZY-DJNX5VA9qGs2ikC-lOtL_m0D3t8/htmlRecords/submit' name='form' method='POST' onSubmit='javascript:document.charset="UTF-8"; return zf_ValidateAndSubmit();' accept-charset='UTF-8' enctype='multipart/form-data' id='form'><input type="hidden" name="zf_referrer_name" value=""><!-- To Track referrals , place the referrer name within the " " in the above hidden input field -->
<input type="hidden" name="zf_redirect_url" value=""><!-- To redirect to a specific page after record submission , place the respective url within the " " in the above hidden input field -->
<input type="hidden" name="zc_gad" value=""><!-- If GCLID is enabled in Zoho CRM Integration, click details of AdWords Ads will be pushed to Zoho CRM -->
<div class="zf-templateWrapper"><!---------template Header Starts Here---------->

<p class="zf-frmDesc"></p>
<div class="zf-clearBoth"></div></li></ul><!---------template Header Ends Here---------->
<!---------template Container Starts Here---------->
<div class="zf-subContWrap zf-topAlign"><ul>
<!---------Name Starts Here----------> 
<li class="zf-tempFrmWrapper zf-name zf-namelarge"><label class="zf-labelName"> 
Name 
<em class="zf-important">*</em>
</label>
<div 
class="zf-tempContDiv zf-threeType"  
>
<div
class="zf-nameWrapper"  
>
<span> <input type="text" maxlength="255" name="Name_First" fieldType=7 placeholder=""/> <label>First</label>
 </span> 
 </span> </span>
<span> <input type="text" maxlength="255" name="Name_Last" fieldType=7 placeholder=""/> <label>Last</label>
 </span> 
 </span> </span>
<span> <input type="text" maxlength="255" name="Name_Middle" fieldType=7 placeholder=""/> <label>Middle Name</label>
 </span> 
 </span> </span>
<div class="zf-clearBoth"></div></div><p id="Name_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Name Ends Here----------> 
<!---------Email Starts Here---------->  
<li class="zf-tempFrmWrapper zf-large"><label class="zf-labelName"> 
Email 
<em class="zf-important">*</em>
</label>
<div class="zf-tempContDiv">
<span> <input fieldType=9  type="text" maxlength="255" name="Email" checktype="c5" value="" placeholder=""/></span> <p id="Email_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Email Ends Here---------->  
<!---------Number Starts Here---------->
<li class="zf-tempFrmWrapper zf-large"><label class="zf-labelName"> 
Phone Number 
</label>
<div class="zf-tempContDiv">
<span> <input type="text" name="Number" checktype="c2" value="" maxlength="18" placeholder=""/></span> <p id="Number_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Number Ends Here---------->
<!---------Dropdown Starts Here---------->
<li class="zf-tempFrmWrapper zf-large"><label class="zf-labelName">
Type of Loan
<em class="zf-important">*</em>
</label>
<div class="zf-tempContDiv">
<select class="zf-form-sBox" name="Dropdown" checktype="c1">
<option selected="true" value="-Select-">-Select-</option>
<option value="Philhealth">Philhealth</option>
<option value="SSS&#x20;Loan">SSS Loan</option>
<option value="Pag-ibig&#x20;Loan">Pag-ibig Loan</option>
</select><p id="Dropdown_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Dropdown Ends Here---------->
<!---------Multiple Line Starts Here---------->
<li class="zf-tempFrmWrapper zf-large"><label class="zf-labelName"> 
Reason for loan 
</label>
<div class="zf-tempContDiv">
<span> <textarea name="MultiLine" checktype="c1" maxlength="65535" placeholder=""></textarea> </span><p id="MultiLine_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Multiple Line Ends Here---------->
<!---------Description Starts Here---------->  
<li class="zf-tempFrmWrapper zf-note"><label class="zf-descFld"><div><b>Once the request is approved kindly proceed to the HR office. <span class="colour" style="color: rgb(255, 0, 0)">*</span></b><br /></div></label>
<div class="zf-clearBoth"></div></li><!---------Description Ends Here---------->  
</ul></div><!---------template Container Starts Here---------->
<ul><li class="zf-fmFooter"><button class="zf-submitColor" >Submit</button></li></ul></div><!-- 'zf-templateWrapper' ends --></form></div><!-- 'zf-templateWidth' ends -->
</div>
  </div>
<script type="text/javascript">var zf_DateRegex = new RegExp("^(([0][1-9])|([1-2][0-9])|([3][0-1]))[-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)[-](?:(?:19|20)[0-9]{2})$");
var zf_MandArray = [ "Name_First", "Name_Last", "Name_Middle", "Email", "Dropdown"]; 
var zf_FieldArray = [ "Name_First", "Name_Last", "Name_Middle", "Email", "Number", "Dropdown", "MultiLine"]; 
var isSalesIQIntegrationEnabled = false;
var salesIQFieldsArray = [];</script>

</body>
</html>