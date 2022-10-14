<!DOCTYPE html>
<?php 
	
	ini_set('display_errors', 1); 
	error_reporting(E_ALL);
    include_once 'scripts.php';
?>
<html lang="en">
<head>
    <link href="src/preloader.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['SERVER_ADDR']; ?>/apps/images/mail-logo-128.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Campaign</title>
    <link type="text/css" href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="../../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="../../css/theme.css" rel="stylesheet" media="screen" title="main">
	<link type="text/css" href="../../images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
    <script src="../../scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="../../scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../scripts/flot/jquery.flot.js" type="text/javascript"></script>
    <script src="scripts.js" type="text/javascript"></script>
    <link href="src/jquery.eatoast.css" rel="stylesheet" type="text/css">
    <script src="src/jquery.eatoast.js"></script>
    <script src="scroll-top/quicknav.js"></script>
    <link rel="stylesheet" href="scroll-top/stylest.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	


	
    <link href="../../css/select2.min.css" rel="stylesheet" />
	    <script src="../../scripts/select2.min.js"></script>
	
	<script>


</script>


   <script>
   
   
   $(document).ready(function() {
	  
    $('#header_format').textareafullscreen({
        overlay: true, // Overlay
        maxWidth: '80%', // Max width
        maxHeight: '80%' // Max height
    });
	    $('#html_body').textareafullscreen({
    });

});
       </script>
	   
	      <script>
$(document).keypress(function(e) {
    var keyCode = e.keyCode;
	 if(keyCode == 43){
     check_test_auto();
    }
});
       </script>
	   
      <script>
	  
	  
	  
        $(document).ready(function() {
			$("#offer").select2();
			$("#sponsor").select2();
			$("#server_body").select2();
			$("#domain_body").select2();
			$("#news").select2();
			$("#isp").select2();
			$("#country").select2();
			$("#country_code").select2();
			<?php
			
			
			$_SESSION['previous'] = basename($_SERVER['PHP_SELF']);
				$globaldomain		=	$_SERVER['HTTP_HOST'];
	            $serverPath			=	'http://'.$globaldomain;
				if(!isset($_GET['edit_campaign'])){
					echo "select_server_body(".$_SESSION['id-server'].");";
					echo "select_domains_body(".$_SESSION['id-server'].");";
					echo "select_server_vmta(".$_SESSION['id-server'].");";
					echo "select_theme();";
					//echo "show_vmtas();";
				}
			?>
	
			// setInterval(function(){ 
			
    // haloo(); 
// }, 5000);
			
            show_sponsors();
            show_news();
			show_countries();
			show_countries_code();
            show_isps();
            body2();
			GetSelectedText();
			OnSelectInput(input);
			OnSelectInput1(input);
			moreFields();
		    show_domains();

        } );
		
	
    </script>
	


<script>
function color(color) {
    document.forms[0].test_emails_to.style.background = color;
}

function colors(color) {
	var x=document.getElementById("test_emails_to").value;
	if(x==""){
    document.forms[0].test_emails_to.style.background = color;
	
	}else
	
	    document.forms[0].test_emails_to.style.background = 'Aquamarine';
		

	
}

</script>
<script>
window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = 'Sure?';
    }

    // For Safari
    return 'Sure?';
};
</script>
<script src="textareafullscreen/jquery.textareafullscreen.js"></script>
<link rel="stylesheet" href="textareafullscreen/textareafullscreen.css">

</head>
<body>
	<script src="src/preloader.js" type="text/javascript"></script>
	<div class="navbar navbar-fixed-top">
	<br>	<br><br>
        <div class="navbar-inner navbar-fixed-top">
            <div class="container">
                <?php include("../inc.top_menu.php");  ?>
			</div>
        </div><!-- /navbar-inner -->
	</div><!-- /navbar -->

    <div class="wrapper">
        <div class="container">
            <div class="row">
            <form class="form-horizontal row-fluid" id="sendform" name="sendform" method="POST" action="" target="frame">
			
			
                <div class="span6">
                    <div class="content">
					
					      <div class="module" >
                            <div class="module-head">
							
							
							<h3>Offer & Sponsor & Isp &nbsp <span class="refresh">&nbsp;<i href="#myModal1" class='fa fa-floppy-o icon-white' title='Save offer' role='button' data-toggle='modal' style='cursor: pointer;' onclick=''></i>&nbsp;&nbsp;<i href='' class='fa fa-upload icon-white' title='upload offer' role='button' data-toggle='modal' style='cursor: pointer;' onclick="" id="load_campaign"></i>&nbsp;&nbsp;<i class="icon-chevron-down icon-white refresh" id="Collapsible1" style="cursor: pointer;" onclick="Collapsible();"></i></span></h3>
							</div>


                            <div class="module-body" id="Collapsible">
												
							<div class="alert" style="display:none" id="message_sponosor_offer">	
								<strong>Warning!</strong> Select sponsor & offer ^^
							</div>
							<div class="alert alert-error" style="display:none" id="message_error_sponsor_offer">
								<strong>Oh snap!</strong> Something is wrong :( Please contact your support.
							</div>
							<div class="alert alert-success" style="display:none"  id="message_success_sponsor_offer_store" >
								<strong>Well done!</strong> The campaign is stored :)
							</div>
							<div class="alert alert-success" style="display:none"  id="message_success_sponsor_offer_load" >
								<strong>Well done!</strong> The campaign is loaded :)
							</div>
				
                                <div class="form-horizontal row-fluid">
								
								                                    <div class="control-group">
                                        <label class="control-label" for="basicinput">Country</label>
                                        <div class="controls">
                              <select tabindex="1" data-placeholder="Select here.."  id="country_code" name="country" class="span10 select2" onchange="show_offers();reset_datalist_component();">
                                                <option value="0">Select here..</option>
                                            </select>
                                            <span class="help-inline"><i class="icon-refresh icon-white refresh" title="Refresh" style="cursor: pointer;" onclick="show_countries_code();show_offers();"></i></span>
                                        </div>
                                    </div>
								
								
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Sponsor :</dt></label>
                                        <div class="controls">
                                            <select tabindex="1" data-placeholder="Select here.." id="sponsor" name="sponsor" class="span10" onchange="show_offers();">
                                                <option value="0">Select here..</option>
                                            </select>
                                            <span class="help-inline"><i class="icon-refresh icon-white refresh" title="Refresh" style="cursor: pointer;" onclick="show_sponsors();show_offers();"></i></span>
                                        </div>
                                    </div>
									

                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Offer :</dt></label>
                                        <div class="controls">
                                            <select tabindex="1" data-placeholder="Select here.." id="offer" name="offer" class="span10" onchange="javascript: show_details_offer();">
                                                <option value="0">Select here..</option>
                                            </select>
                                            <span class="help-inline"><i class="icon-refresh icon-white refresh" title="Refresh" style="cursor: pointer;" onclick="show_offers();"></i></span>&nbsp &nbsp <i id="fspinner" class="fa fa-spinner fa-spin" style="font-size:16px"></i>
											
                                        </div>
																				<div class="control-group" id="details_offer" style="display:none">
												<!-- div class="span4"></div -->
												<div class="span8" style="padding: 21px;">
												<label class="">
													Accepting Traffic in <span class="label label-info" id="days_traffics">Mon,Tue,Wed,Thu,Fr,Sat,Sun</span>
												</label> 
												<label class="">
													Geo-targeting  <span class="label label-success" id="geos">US,AU,NZ</span>
												</label> 
												<label class="">
													Suppression <span class="label label-important" id="daysleft"> 6 Days left</span>
													
												</label>
												</div>
												<input type="hidden" name="daysleft_suppression"   id="daysleft_suppression" />
										</div>
                                    </div>
									

                                </div>
                            </div>
                        </div>
					
					
                        <div class="module">
						
						
                            <div class="module-head"><h3>Header & Creative Setting <div class="processing" id="processing"></div></h3></div>
                            <div class="module-body">
                                <div class="alert" id="message-warning">
                                    <button type="button" class="close" onclick="close_message_warning();">×</button>
                                    <strong>Warning!</strong> Please verify your data
                                </div>
                                <div class="alert" id="message-warning-custom">
                                    <button type="button" class="close" onclick="close_message_warning_custom();">×</button>
                                    <strong>Warning!</strong> <span id="message-custom"></span>
                                </div>
								   <div class="alert" id="message-done-custom">
                                    <button type="button" class="close" onclick="close_message_done_custom();">×</button>
                                    <strong>Done!</strong> <span id="message-custom1"></span>
                                </div>

                                <div class="alert alert-error" id="message-error">
                                    <button type="button" class="close" onclick="close_message_error();">×</button>
                                    <strong>Error!</strong> There was an error while executing your request
                                </div><br/>
                                <div class="form-horizontal row-fluid">
								
								
								
										<div class="control-group">
											<label class="control-label" for="basicinput"><dt>From Name :</dt></label>
											<div class="controls">
												<div class="input-append">
					<input type="text" id="from_name"  name="from_name" value="[Server] - [Ip]" placeholder="" >
					<span class="add-on"><i href='#get_from' class='icon-search' title='Show from' role='button' data-toggle='modal' style='cursor: pointer;' onclick='subject_from_vide();show_subject_from();'></i>&nbsp;</span>
					<span class="add-on"><i href='#text-encoder' class='icon-qrcode icon-white' title='Show from' role='button' data-toggle='modal' style='cursor: pointer;' onclick='get_text_encode();'></i>&nbsp;</span>
					<!--<span class="help-inline"><i href='#text-encoder' class='icon-qrcode icon-white' title='Encoder' role='button' data-toggle='modal' style='cursor: pointer;' onclick='get_text_encode();'></i></span>-->
												</div>
											</div>
										</div>
										
																				<div class="control-group">
											<label class="control-label" for="basicinput"><dt>Subject :</dt></label>
											<div class="controls">
												<div class="input-append">
					<input type="text" id="subject" name="subject" value="[Ip]" placeholder=""  >
					                       <span class="add-on"><i href='#get_subject' class='icon-search' title='Show subject' role='button' data-toggle='modal' style='cursor: pointer;' onclick='subject_from_vide();show_subject_from1();'></i></span>
										   <span class="add-on"><i href='#text-encoder1' class='icon-qrcode icon-white' title='Show subject' role='button' data-toggle='modal' style='cursor: pointer;' onclick='get_text_encode1()'></i></span>
                                          <!-- <span class="help-inline"><i href='#text-encoder1' class='icon-qrcode icon-white' title='Encoder' role='button' data-toggle='modal' style='cursor: pointer;' onclick='get_text_encode1()'></i></span>-->
                                            <span class="help-inline"><i href='#subject-info' class='icon-info-sign icon-white' title='Infos' role='button' data-toggle='modal' style='cursor: pointer;' onclick=''></i></span>
												</div>
											</div>
										</div>
								

                 
									                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Test Emails To :</dt></label>
                                        <div class="controls">
                                            <input type="text" onblur="colors('white')" onkeydown="color('Aquamarine')" id="test_emails_to" name="test_emails_to" placeholder="Email1;Email2;Email3..." class="span10">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>From Email :</dt></label>
                                        <div class="controls">
                                            <input type="text" id="from_email" name="from_email" value="info@[Domain]" placeholder="" class="span10">
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>
									
									
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Reply Email :</dt></label>
                                        <div class="controls">
                                            <input type="text" id="reply_email" name="reply_email" value="" placeholder="" class="span10">
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Bounce Email :</dt></label>
                                        <div class="controls">
                                            <input type="text" id="bounce_email" name="bounce_email" value="return" placeholder="" class="span10">
                                            <span class="help-inline"><i href='#bounceemail-info' class='icon-info-sign icon-white' title='Infos' role='button' data-toggle='modal' style='cursor: pointer;' onclick=''></i></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput" ><dt>Return Path :</dt></label>
                                        <div class="controls">
                                            <input type="text" id="return_path" name="return_path" value="[Domain]" placeholder="" class="span10">
                                            <span class="help-inline"><i href='#returnpath-info' class='icon-info-sign icon-white' title='Infos' role='button' data-toggle='modal' style='cursor: pointer;' onclick=''></i></span>
                                        </div>
                                    </div>
									<br><br>
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Received :</dt></label>
                                        <div class="controls">
                                            <input type="text" style="margin:auto;width:100%;overflow:scroll;overflow-x:hidden;border:1px solid #ddd;background-color:#f1f1f1;zoom:1;" id="received" name="received" value="by [Domain] id [Random(aN,12)] for <[To]>; [SMTPDate] (envelope-from <[FromEmail]>)" placeholder="" class="span10">
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>
                                  <!--/  <div class="control-group">
                                        <label class="control-label" for="basicinput">X-Mailer</label>
                                        <div class="controls">
                                            <select tabindex="1" data-placeholder="Select here.." id="xmailer" name="xmailer" class="span5">
                                                <option value='Alife12' selected="">Alife12</option>
                                                <option value='AlphaPlus'>AlphaPlus</option>
                                                <option value='AWeber 4.0'>AWeber 4.0</option>
                                                <option value='Bingo v1.0'>Bingo v1.0</option>
                                                <option value='Everest V1.6'>Everest V1.6</option>
                                                <option value='Feedball v1.0'>Feedball v1.0</option>
                                                <option value='My-Prog 2.2'>My-Prog 2.2</option>
                                                <option value='OutLow v5.9'>OutLow v5.9</option>
                                                <option value='SetupMail'>SetupMail</option>
                                                <option value='SlomoV2.3'>SlomoV2.3</option>
                                                <option value='SonicV3.1'>SonicV3.1</option>
                                                <option value='StuffMailV8.00'>StuffMailV8.00</option>
                                                <option value='SuperMax'>SuperMax</option>
                                            </select>
                                        </div>
                                    </div>-->
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Header Number :</dt></label>
                                        <div class="controls">
                                            <select tabindex="1" data-placeholder="Select here.." id="header_nbr" name="header_nbr" class="span4" onchange="get_header_format()">
                                                <option value="0" selected>Header 0</option>
                                                <option value="1" >Header 1</option>
                                                <option value="2" >Header 2</option>
                                                <option value="3" >Header 3</option>
                                                <option value="4" >Header 4</option>
                                                <option value="5" >Header 5</option>
                                                <option value="6" >Header 6</option>
                                                <option value="7" >Header 7</option>
                                                <option value="8" >Header 8</option>
                                            </select>
                                            <span class="help-inline"><a href="#headerformat-info" role="button" class="btn btn-primary" data-toggle="modal" onclick=""><i class="icon-envelope-alt icon-white"></i>&nbsp;Header Format</a></span>
                                        </div>
                                    </div>
									
       <div class="control-group">
      <label class="control-label" for="basicinput"><dt>Header :</dt></label>
<div class="controls">
<textarea  class="span11" rows="6" id="header_format" spellcheck="false" name="header_format">
Subject: [Subject]
From: [FromName] <[FromEmail]>
Reply-to: <[ReplyEmail]>
To: [To]
Sender: <[FromEmail]>
Return-Path: <[FromEmail]>
Content-Type: text/html
Date: [SMTPDate]</textarea>
</div>
         </div>
									 <div class="control-group">
                                        <label class="control-label">PlaceHolders</label>
                                        <div class="controls">
                                            <textarea class="span12"  rows="4" id="placeholders" name="placeholders" placeholder="placeholder 1                                                                     placeholder n"></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Domain : </dt></label>
                                        <div class="controls">
										
										
										
																				 <select tabindex="1" data-placeholder="Select here.." id="server_body" name="server_body" class="span4" onchange="show_domains();">
                                                <option value="0">Select here..</option>
                                            </select>
                                            <span class="help-inline"><i class="icon-refresh icon-white refresh" title="Refresh" style="cursor: pointer;" onclick="select_server_body(<?php echo $_SESSION['id-server'];?>);select_domains_body(<?php echo $_SESSION['id-server'];?>);"></i></span>
											&nbsp;&nbsp;
                                            <select tabindex="1" data-placeholder="Select here.." id="domain_body" name="domain_body" class="span6">
                                                <option value="0">Select here..</option>
                                            </select>
                                            <span class="help-inline"><i class="icon-refresh icon-white refresh" title="Refresh" style="cursor: pointer;" onclick="select_domains_body(<?php echo $_SESSION['id-server'];?>);"></i></span>
                                       
									   

                                       
										
										</div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Redirect Type :</dt></label>
                                        <div class="controls">
                                            <select tabindex="1" data-placeholder="Select here.." id="redirect_type" name="redirect_type" class="span6">
                                                <option value="0">Normal Link</option>
                                                <option value="1">Short Link</option>
                                             <option value="2">Encode B64</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"><dt>Include Open Tracker :</dt></label>
                                        <div class="controls">
                                            <label class="radio inline">
                                                <input type="radio" name="open_tracker" id="open_tracker_yes" value="1" onclick="" checked=""  >Yes
                                            </label> 
                                            <label class="radio inline">
                                                <input type="radio" name="open_tracker" id="open_tracker_no" value="0" onclick="">No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"><dt>Message Body Type :</dt></label>
                                        <div class="controls">
                                            <label class="radio inline">
                                                <input type="radio" name="body_type" id="textbody" value="0" onclick="body1();"><span class='label label-warning'>Text</span>
                                            </label> 
                                            <label class="radio inline">
                                                    <input type="radio" name="body_type" id="htmlbody" value="1" onclick="body2();" checked=""><span class='label label-success'>Html</span>
                                            </label> 
                                            <label class="radio inline">
                                                    <input type="radio" name="body_type" id="multipartbody" value="2" onclick="body3();"><span class='label label-info'>Multipart (text/html)</span>
													                                            <span class="help-inline"><i href='#returnpath-info1' class='icon-info-sign icon-white' title='Infos' role='button' data-toggle='modal' style='cursor: pointer;' onclick=''></i></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="control-group" id="source_text">
                                            <textarea class="span12" rows="15" id="text_body"  name="text_body">Text Here
                                            </textarea>
                                    </div>
									


									
<div class="control-group" id="source_html">
<label class="control-label" for="basicinput"><dt>Creative :</dt></label>

<div class="controls">								  
<textarea class="span15" rows="12" id="html_body" name="html_body">
<html>
<body>
<center>
<a href="http://[Domain]/[OfferPage]" style="text-decoration: none;">
<font SIZE="4" color="#70ADEF">Federal Fund Rates have dropped</font></a>
<br><br>
<a href="http://[Domain]/[OfferPage]">
<img src="http://[Domain]/img1.jpg"/></a>
<br><br>
<a href="http://[Domain]/[OfferUnsub]">
<img src="http://[Domain]/img2.jpg"/></a>
<br><br>
<a href="http://[Domain]/[ServerUnsub]">
<img src="http://[Domain]/unsb.jpg"/></a>
</center>
</body>
</html>

<style>
</style>
</textarea>
</div>

</div>
                            <div class="control-group">
                                        <div class="controls">
  
                                        </div>
                                    </div>
									
									<div class="control-group">
										<label class="control-label">Negative(s) : </label>
										<div class="controls">
											<select tabindex="1" data-placeholder="Select here.." id="archive_negatives" name="archive_negative"  class="select2">
												<option value="0">Select here ... </option>
											</select>
											<span class="help-inline"><i class="icon-refresh icon-white refresh" title="Refresh" style="cursor: pointer;" onclick="get_list_negatives();"></i></span>
										</div>
									</div>
								
																		<div class="control-group">
                                        <label class="control-label">Upload Negative : </label>
                                        <div class="controls">
                                            <input type="file" id="upload_negative" name="upload_negative"  class="span6" accept="text/plain">
                                            <div class="span8" id="loading_negative" style="display:none">Loading .... </div>
											<div class="alert alert-success" style="display:none"  id="message_success_upload_negative" >
													<strong>Well done!</strong> The negative is uploaded :)
											</div>
                                        </div>
									
                                    </div>	
																		 <div class="control-group">
                                        <label class="control-label">Add New Tags : </label>
                                        <div class="controls">
                                            <textarea class="span12" rows="5" id="new_tags" name="add_new_tags" placeholder="[Tag]:value                                                                     [Tag]:value"></textarea>
                                        </div>
                                    </div>
									
									<br>
									
									<div class="controls">
                                    <div class="control-group">

                                        <button class="btn btn-info btn-xs" type="button" id="advanced_setting_btn" onclick=""><i class="icon-cog icon-white"></i>&nbsp;Advanced Setting &nbsp;<i class="icon-chevron-down" ></i></button>&nbsp;
										<a href="#modal-generate_links" role="button" class="btn btn-success btn-xs" data-toggle="modal"><i class="menu-icon icon-link"></i>&nbsp;Generate Links</a>&nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; 
										<a href="#modal-preview" role="button" class="btn btn-warning btn-xs" data-toggle="modal" onclick="preview();"><i class="icon-picture icon-white"></i>&nbsp;View</a>

                                    </div>
									      </div>
										  <br><br>
                                    <div class="control-group">
                                    </div>
                                    <div id="advanced_setting_panel">
                                    <div class="control-group">
                                        <label class="control-label">Additional Negative :</label>
                                        <div class="controls">
                                            <label class="radio inline">
                                                <input type="radio" name="additional_negative_active" id="additional_negative_active_no" value="0" onclick="" checked=""><span class='label label-important'>No</span>
                                            </label>
                                            <label class="radio inline">
                                                    <input type="radio" name="additional_negative_active" id="additional_negative_active_yes" value="1" onclick=""><span class='label label-success'>Yes</span>
                                            </label>
                                        </div>
                                    </div>
                                        <div class="control-group">
                                        <label class="control-label">Repeat :</label>
                                        <div class="controls">
                                            <input type="text" id="repeat_negative" name="repeat_negative" placeholder="" value="1" class="span3">
                                            <button class="btn btn-danger" type="button" id="repeat_negative_btn" onclick="calculate_negative_size();"><i class="icon-retweet icon-white"></i>&nbsp;calculate Size</button>
                                            <span class="help-inline" id="size_result"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Negative :</label>
                                        <div class="controls">
                                            <textarea class="span12" rows="10" id="additional_negative" name="additional_negative"></textarea>
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label">Save Hotmail Sender:</label>
                                        <div class="controls">
                                            <label class="radio inline">
                                                <input type="radio" name="save_hotmail_sender_data_active" id="save_hotmail_sender_data_active_no" value="0" onclick="" checked=""><span class='label label-important'>No</span>
                                            </label>
                                            <label class="radio inline">
                                                    <input type="radio" name="save_hotmail_sender_data_active" id="save_hotmail_sender_data_active_yes" value="1" onclick=""><span class='label label-success'>Yes</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Test Multiple :</label>
                                        <div class="controls">
											<table>
												<tr>
													<td>
														<label class="radio inline">
															<input type="radio" name="multiple_type" id="test_multiple_type_none" value="0" onclick="check_test_multiple_type()" checked=""><span class='label label-important'>None</span>
														</label> 
													</td>
													<td>&nbsp;
														<label class="radio inline">
																<input type="radio" name="multiple_type" id="" value="1" onclick="check_test_multiple_type()">From Domain
														</label>
													</td>
													<td>&nbsp;
														<label class="radio inline">
																<input type="radio" name="multiple_type" id="" value="2" onclick="check_test_multiple_type()">Return Path
														</label>
													</td>
												<tr>
												<tr>
													<td>
														<label class="radio inline">
																<input type="radio" name="multiple_type" id="" value="3" onclick="check_test_multiple_type()">Domain Creative
														</label>
													</td>
													<td>&nbsp;
														<label class="radio inline">
																<input type="radio" name="multiple_type" id="" value="4" onclick="check_test_multiple_type()">Body
														</label>
													</td>
													<td>&nbsp;
														<label class="radio inline">
																<input type="radio" name="multiple_type" id="" value="5" onclick="check_test_multiple_type()">Group ID
														</label>
													</td>
												<tr>
																								<tr>
												<td>
														<label class="radio inline">
																<input type="radio" name="multiple_type" id="" value="6" onclick="check_header_enable_test()">Header
														</label>
													</td>
												</tr>
											</table>
                                        </div>
                                    </div>
																		 <div class="control-group" style="display:none" id="tag_upload_headers">
                                        <label class="control-label" for="basicinput">Upload headers </label>
                                        <div class="controls">
                                            <input type="file" id="upload_headers" name="upload[]"  class="span6" multiple="multiple">
                                            <div class="span8" id="loading" style="display:none">Loading .... </div>
											<div id="loadedfiles" style="height:100px;overflow-y: scroll;display:none" ></div>
											
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Values</label>
                                        <div class="controls">
                                            <textarea class="span12" rows="10" id="test_multiple_values" name="multiple_values"></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Send Multiple :</label>
                                        <div class="controls">
											<table>
												<tr>
													<td>
														<label class="radio inline">
															<input type="radio" name="send_multiple_type" id="send_multiple_type_none" value="0" onclick="check_send_multiple_type()" checked=""><span class='label label-important'>None</span>
														</label> 
													</td>
													<td>&nbsp;
														<label class="radio inline">
																<input type="radio" name="send_multiple_type" id="" value="1" onclick="check_send_multiple_type()">From Domain
														</label> 
													</td>
													<td>&nbsp;
														<label class="radio inline">
																<input type="radio" name="send_multiple_type" id="" value="2" onclick="check_send_multiple_type()">Return Path
														</label>
													</td>
												<tr>
												<tr>
													<td>
														<label class="radio inline">
																<input type="radio" name="send_multiple_type" id="" value="3" onclick="check_send_multiple_type()">Domain Creative
														</label>
													</td>
													<td>&nbsp;
														<label class="radio inline">
																<input type="radio" name="send_multiple_type" id="" value="5" onclick="check_send_multiple_type()">Group ID
														</label>
													</td>
													<td>&nbsp;
														<label class="radio inline">
																<input type="radio" name="send_multiple_type" id="" value="6" onclick="check_send_multiple_type()">Subject
														</label>
													</td>
												<tr>
																										<tr>
												<td>
														<label class="radio inline">
																<input type="radio" name="send_multiple_type" id="" value="7" onclick="check_header_enable_send()">Header
														</label>
													</td>
												</tr>
											</table>
                                        </div>
                                    </div>
									                                    <div class="control-group">
                                        <label class="control-label">Rotate per</label>
                                        <div class="controls">
                                            <input type="text" id="send_rotate_values" name="send_rotate_values"  value="1" placeholder="" class="span3">
                                        </div>
                                    </div>
									<div class="control-group" style="display:none" id="tag_upload_headers_send">
                                        <label class="control-label" for="basicinput">Upload headers </label>
                                        <div class="controls">
                                            <input type="file" id="upload_headers_send" name="upload[]"  class="span6"   multiple="multiple">
                                            <div class="span8" id="loading_send_headers" style="display:none">Loading .... </div>
											<div id="loadedfiles_send" style="height:100px;overflow-y: scroll;display:none" ></div>
											
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Values :</label>
                                        <div class="controls">
                                            <textarea class="span12" rows="10" id="send_multiple_values" name="send_multiple_values"></textarea>
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label">Astuce Tag :</label>
                                        <div class="controls">
                                            <label class="radio inline">
                                                <input type="radio" name="astuce_tag_active" id="astuce_tag_active_no" value="0" onclick="" checked=""><span class='label label-important'>No</span>
                                            </label>
                                            <label class="radio inline">
                                                    <input type="radio" name="astuce_tag_active" id="astuce_tag_active_yes" value="1" onclick=""><span class='label label-success'>Yes</span>
                                            </label>
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label">Email Addresses :</label>
                                        <div class="controls">
											<textarea class="span12" rows="10" id="astuce_tag_email_address" name="astuce_tag_email_address"></textarea>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--/.content-->
                </div><!--/.span6-->
<!-- **************************************************************************** -->
                <div class="span6">


                    <div class="content">
                        <div class="module">
                            <div class="module-head"><h3>MTAs / IPs / Domains <span class="refresh">&nbsp;<i href='#search-vmtas' class='icon-search icon-white' title='Search & Select VMTAs' role='button' data-toggle='modal' style='cursor: pointer;' onclick=''></i>&nbsp;<i href='#edit-vmtas' class='icon-edit icon-white' title='Edit vmtas' role='button' data-toggle='modal' style='cursor: pointer;' onclick='show_vmtas_editable();'></i>&nbsp;<i class="icon-refresh icon-white" title="Refresh" style="cursor: pointer;" onclick="<?php echo "select_server_vmta(".$_SESSION['id-server'].");"; ?>"></i></span></h3></div>
                            <div class="module-body">
                                <div class="form-horizontal row-fluid">
									<div class="control-group">
                                        <input type="text" id="search_server" name="" placeholder="Search server" onkeyup="search_server_instant();" class="span3">
										<input type="text" id="search_vmta" name="" placeholder="Search vmta" onkeyup="search_vmta_instant();" class="span9">
                                    </div>
                                    <div class="control-group">
																			<div class="span3">
										<span class="refresh">
											&nbsp;&nbsp;<i href='#search-servers' id="search_vmtas_icon" class='icon-search icon-white' title='Search & Select Servers' role='button' data-toggle='modal' style='cursor: pointer;' onclick=''></i>
											&nbsp;&nbsp;<i class='icon-th-large icon-white' title='Show Pmtas' style='cursor: pointer;'  onclick="show_pmtas_servers();" ></i>
											&nbsp;&nbsp;<i  class='icon-ok icon-white' title='Select All Vmtas' role='button' data-toggle='modal' style='cursor: pointer;' onclick='server_selectall();'></i>
											&nbsp;&nbsp;<i  class='icon-remove icon-white' title='Unselect All Servers' role='button' data-toggle='modal' style='cursor: pointer;' onclick='server_unselectall();'></i></span>
											</div>
											<div class="span9" style="margin:0px !important;"> <span class="refresh">
											&nbsp;&nbsp;<i class='icon-th-large icon-white' title='Show Pmtas' style='cursor: pointer;'  onclick="show_pmtas_vmtas();" ></i>
											&nbsp;&nbsp;<i href='#search-vmtas' id="search_vmtas_icon" class='icon-search icon-white' title='Search & Select VMTAs' role='button' data-toggle='modal' style='cursor: pointer;' onclick=''></i>
											&nbsp;&nbsp;<i href='#edit-vmtas' class='icon-edit icon-white' title='Edit vmtas' role='button' data-toggle='modal' style='cursor: pointer;' onclick='show_vmtas_editable();'></i>
											&nbsp;&nbsp;<i class='icon-exchange icon-white' title='Switch VMTAS' style='cursor: pointer;'  onclick="exchange_vmtas();" ></i>
											&nbsp;&nbsp;<i  class='icon-ok icon-white' title='Select All Vmtas' role='button' data-toggle='modal' style='cursor: pointer;' onclick='vmta_selectall();'></i>
											&nbsp;&nbsp;<i  class='icon-remove icon-white' title='Unselect All Vmtas' role='button' data-toggle='modal' style='cursor: pointer;' onclick='vmta_unselectall();'></i></span>
										</div>
										<!-- Servers -->
                                        <select tabindex="1" data-placeholder="Select here.." id="server" name="servers[]"  size="15" multiple class="span3" ondblclick="myFunction1();" onchange="show_vmtas();">
                                        </select>
										<!-- VMTAs -->
										<select tabindex="1" data-placeholder="Select here.." id="vmta" name="vmtas[]" size="15" multiple class="span9" ondblclick="vmta_selectall();" onchange="vmta_select_count();">
                                        </select><br>
										<font size="1" id="server_count" class="span3" style="margin-left: 0px;">No Server Selected</font>
										<font size="1" id="vmta_count" class="span6" style="margin-left: 3px;">No Vmta Selected</font>

                                    </div>
									<div class="control-group">
										<label class="radio inline">
											<input type="radio" name="search_vmta_type" id="search_vmta_type_all" value="0" ><span class='label label-info'>All VMTAs</span>
										</label> 
										<label class="radio inline">
												<input type="radio" name="search_vmta_type" id="search_vmta_type_valid" value="1" checked=""><span class='label label-success'>VMTAs with valid rDNS</span>
										</label> 
										<label class="radio inline">
												<input type="radio" name="search_vmta_type" id="search_vmta_type_fake" value="2" ><span class='label label-warning'>VMTAs with fake rDNS</span>
										</label>
																				<div class="dropdown" style="float: right;margin-right: 10px;margin-top: 5px;">
											<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Options&nbsp;<span class="caret"></span>
											</button>
											<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
											<li><a href="#" onclick="server_selectall();">Select all servers</a></li>
											<li><a href="#" onclick="server_unselectall();">Unselect all servers</a></li>
											<li><a href="#" onclick="vmta_selectall();">Select all vmtas</a></li>
											<li><a href="#" onclick="vmta_unselectall();">Unselect all vmtas</a></li>
											<li role="separator" class="divider"></li>
											<li><a href='#search-vmtas' role='button' data-toggle='modal'>Search & select vmtas</a></li>
											<li><a href='#edit-vmtas' role='button' data-toggle='modal' onclick='show_vmtas_editable();'>Edit vmtas</a></li>
											</ul>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--/.content-->
                </div><!--/.span6-->
<!-- **************************************************************************** -->

<!-- **************************************************************************** -->
                <div class="span6">
                    <div class="content">
                        <div class="module">
                            <div class="module-head"><h3>Data Lists <i class="icon-refresh icon-white refresh" title="Refresh" style="cursor: pointer;" onclick="show_data_lists();"></i><div class="processing" id="processing2"></div></h3></div>
							
                            <div class="module-body">
                                <div class="form-horizontal row-fluid">
																										                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>ISP :</dt></label>
                                        <div class="controls">
                                            <select tabindex="1" data-placeholder="Select here.." id="isp" name="isp" class="span5" onchange="show_data_lists();">
                                                <option value="0">Select here..</option>
                                            </select>
                                            <span class="help-inline"><i class="icon-refresh icon-white refresh" title="Refresh" style="cursor: pointer;" onclick="show_isps();show_data_lists();"></i></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Data Provider :</dt></label>
                                        <div class="controls">
                                            <select tabindex="1" data-placeholder="Select here.." id="news" name="news" class="span10" onchange="show_data_lists();">
                                                <option value="0">Select here..</option>
                                            </select>
                                            <span class="help-inline"><i class="icon-refresh icon-white refresh" title="Refresh" style="cursor: pointer;" onclick="show_news();show_data_lists();"></i></span>
                                        </div>
                                    </div>
									
									
									<div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Country :</dt></label>
                                        <div class="controls">
                                            <select tabindex="1" data-placeholder="Select here.." id="country" name="country" class="span7" onchange="show_country_flag();update_list_count();">
                                                <option value="0">Select here..</option>
                                            </select>
											<span class="help-inline"><i class="icon-refresh icon-white refresh" title="Refresh" style="cursor: pointer;" onclick="update_list_count();"></i></span>
                                            <span style="cursor: pointer; width: 32px; height: 32px;" class="help-inline" title="Refresh" onclick="show_countries();show_data_lists();">
											<div id="country-flag" class=""></div></span>
                                        </div>
                                    </div>
									
									
									

                                    <div class="control-group">
                                        <label class="control-label"><dt>Data Lists :</dt></label>
                                        <div class="controls" id="data-list">
                                            <label class='radio'><span class='label label-important'>No Data Selected</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--/.content-->
                </div><!--/.span6-->
<!-- **************************************************************************** -->
                <div class="span6">
                    <div class="content">
                        <div class="module">
                            <div class="module-head"><h3>Send & Test Setting</h3></div>
                            <div class="module-body">
                                <div class="form-horizontal row-fluid">

                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Test After :</dt></label>
                                        <div class="controls">
                                            <input type="text" value="100" id="test_period" name="test_period" placeholder="" class="span5">
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>
									
																	<div class="control-group">
                                        <label class="control-label" for="basicinput">Batch </label>
                                        <div class="controls">
											<input type="text" id="xbatch" name="xbatch"  value="1" placeholder="Number of emails" class="span5">
											<span class='label label-info'>Nbr <small>(Emails)</small></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput">X-Delay</label>
                                        <div class="controls">
											<input type="text" id="xdelay" name="xdelay" placeholder="In seconds" value="1" class="span5">
											<span class='label label-info'>In second(s)</span>
                                        </div>
                                    </div>
									
									
                                 <!--   <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>X-Delay :</dt></label>
                                        <div class="controls">
                                            <select tabindex="1" data-placeholder="Select here.." id="xdelay" name="xdelay" class="span5">
                                                <option value='0'selected>0</option>
												<option value='1000'>1000</option>
												<option value='3000'>3000</option>
                                                <option value='5000'>5000</option>
                                                <option value='10000'>10000</option>
                                                <option value='15000'>15000</option>
                                                <option value='20000'>20000</option>
                                                <option value='30000'>30000</option>
                                                <option value='50000'>50000</option>
                                                <option value='70000'>70000</option>
                                                <option value='100000'>100000</option>
                                                <option value='150000'>150000</option>
                                                <option value='300000'>300000</option>
                                                <option value='400000'>400000</option>
                                                <option value='500000'>500000</option>
                                                <option value='800000'>800000</option>
                                                <option value='1000000'>1000000</option>
												<option value='1500000'>1500000</option>
												<option value='2000000' selected>2000000</option>
                                            </select>
											&nbsp 200000 = 2 sec
                                        </div>
                                    </div>-->
									
									
									
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Rotate IPs :</dt></label>
                                        <div class="controls">
                                            <input type="text" id="change_ip" value="1" name="change_ip" placeholder="" class="span5">
                                        </div>
                                    </div>
																		<div class="control-group">
                                        <label class="control-label" for="basicinput">Repeat Campaign</label>
                                        <div class="controls">
											<input type="text" id="repeat" name="repeat" placeholder="" value="1" class="span5">
								
											<span class='label label-info'>Time(s)</span>
                                        </div>
                                    </div>
									
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><dt>Offset :</dt></label>
                                        <div class="controls">
                                            <input type="text" onkeyup="moreFields();"  value="0" id="data_from" name="data_from" placeholder="" class="span5">
                                            <span class="help-inline">List Limit :&nbsp;&nbsp;</span>
                                            <input type="text" id="data_count" value="1" name="data_count" placeholder="" class="span4">
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label"><dt>Clean bounce :</dt></label>
                                        <div class="controls">
                                            <label class="radio inline">
                                                <input type="radio" name="open_tracker1" id="open_tracker_yes1" value="1" onclick="" checked=""  >Yes
                                            </label> 
                                            <label class="radio inline">
                                                <input type="radio" name="open_tracker1" id="open_tracker_no1" value="0" onclick="">No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="control-group">
										 <label class="control-label"><span class='label label-important'>Reporting Output :</span></label>
                                        <div class="controls">
                                            <iframe class="span12" name="frame"  id="frame" scrolling="yes" frameborder="0" style="height: 333px; "></iframe>
                                        </div>
                                    </div>
                                    <!--div class="control-group">
                                        <button class="btn btn-primary" type="button" onclick="check_test_auto();"><i class="icon-bookmark icon-white"></i>&nbsp;Test Auto</button>&nbsp&nbsp
                                        <button class="btn btn-info" type="button" onclick="test_campaign();"><i class="icon-share icon-white"></i>&nbsp;Test Campaign</button>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                        <button class="btn btn-success" type="button" onclick="check_send_campaign();"><i class="icon-envelope icon-white"></i>&nbsp;Send Campaign</button>
                                    </div-->
									
										<nav class="quick-nav">
    <a class="quick-nav-trigger" href="javascript:;">
        <span aria-hidden="true"></span>
    </a>
    <ul>
        <li>
            <a href="javascript:;" class="submit-form" >
                <span onclick="check_test_auto();">Test Auto</span>
                <i class="icon-bookmark icon-white"></i>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="submit-form" >
                <span onclick="test_campaign();">Test Campaign</span>
                <i class="icon-share icon-white"></i>
            </a>
        </li>
		        <li>
            <a href="javascript:;" class="submit-form" >
                <span onclick="check_send_campaign();">Send Campaign</span>
                <i class="icon-envelope icon-white"></i>
            </a>
        </li>
    </ul>
    <span aria-hidden="true" class="quick-nav-bg"></span>
</nav>
<div class="quick-nav-overlay"></div>
                                </div>
                            </div>
                        </div>
                    </div><!--/.content-->
                </div><!--/.span6-->
                
            </form>
            </div>
        </div><!--/.container-->
    </div><!--/.wrapper-->

    <div class="footer">
        <div class="container">
            <b class="copyright">Copyright &copy; 2019 </b> All rights reserved.
        </div>
    </div>
    
    <!-- Modal -->
    <div id="modal-preview" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Preview</h3>
      </div>
        <div class="alert" id="message-warning-custom-2">
            <button type="button" class="close" onclick="close_message_warning_custom_2();">×</button>
            <strong>Warning!</strong> <span id="message-custom-2">Please select the domain of creative</span>
        </div>
      <div class="modal-body" id="preview">
        <p></p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div>
	
	    <!-- Modal -->
    <div id="modal-generate_links" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Generate Redirect </h3>
      </div>
	  

                            <div class="module-body">
                                <div class="alert" id="message-warning1">
                                    <button type="button" class="close" onclick="close_message_warning();">×</button>
                                    <strong>Warning!</strong> Please verify your data
                                </div>

                                <div class="alert alert-success" id="message-success">
                                    <button type="button" class="close" onclick="close_message_success();">×</button>
                                    <strong>Done!</strong> Redirert has been created successfully
                                </div>
                                <form class="form-horizontal row-fluid" name="redirect_form" method="POST" action=""> 
               




                                    <div class="control-group">
                                        <label class="control-label" for="basicinput">Offer Page</label>
                                        <div class="controls">
                                            <input type="text" id="offer_page" name="offer_page" placeholder="" value="" class="span9" readonly="readonly">
                                            <span class="help-inline"><button class="btn btn-success" type="button" name="link1" onclick="copy_link1();"><i class="icon-copy icon-white"></i></button></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput">Offer Unsubscribe</label>
                                        <div class="controls">
                                            <input type="text" id="offer_unsubscribe" name="offer_unsubscribe" placeholder="" value="" class="span9" readonly="readonly">
                                            <span class="help-inline"><button class="btn btn-success" type="button" name="link2" onclick="copy_link2();"><i class="icon-copy icon-white"></i></button></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput">Server Unsubscribe</label>
                                        <div class="controls">
                                            <input type="text" id="server_unsubscribe" name="server_unsubscribe" placeholder="" value="" class="span9" readonly="readonly">
                                            <span class="help-inline"><button class="btn btn-success" type="button" name="link3" onclick="copy_link3();"><i class="icon-copy icon-white"></i></button></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button class="btn btn-primary" type="button" name="submit" onclick="create_redirect();"><i class="icon-link icon-white"></i>&nbsp;Generate Links</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div>
	
    
    <!-- Modal -->
    <div id="subject-info" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Subject infos</h3>
        </div>
        <div class="modal-body">
			<p><strong>[Server]</strong> Return Server name</p>	
            <p><strong>[Domain]</strong> Return RDNS</p>
            <p><strong>[Ip]</strong> Return IP of VMTA</p>
            <p><strong>[Vmta]</strong> Show VMTA name</p>
            <p><strong>[FromEmail]</strong> Return From Email of sender</p>
            <p><strong>[ReturnPath]</strong> Return ReturnPath</p>
            <p><strong>[To]</strong> Return recipient Email</p>
            <p><strong>[Fname]</strong> Return ID of recipient Email</p>
            <p><strong>[Random(param1,param2)]</strong> Return random value<br> param1: type (ex. A or a or AN or aN or N) A=uppercase  a=lowercase  N=digital<br> param2: size (ex. 5) </p>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
     </div>
    
	    <!-- Modal -->
    <div id="get_from" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">From Lines:</h3>
        </div>

        <div class="modal-body">
						                                <div class="alert" id="message-warning2">
                                    <button type="button" class="close" onclick="close_message_warning();">×</button>
                                    <strong>Warning!</strong> Please select the offre of sponsor
                                </div>
		<p>

<textarea class="span5"  rows="8" id="text_get_from" onselect="OnSelectInput (this)">
</textarea></p>
		<font size="1" id="vmta_count">(*) Select from and click 'OK' &nbsp <div class="processing" id="processing1"></div></font>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">OK</button>
        </div>
     </div>


	    <!-- Modal -->
    <div id="get_pmtas" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Selected PMTA:</h3>
        </div>

        <div class="modal-body">

                                    <div class="control-group">
										<!-- VMTAs -->
										<div data-placeholder="Select here.." id="vmta1" name="vmtas[]" size="30" multiple class="span5" ondblclick="" onchange="">
                                        </div><br>
                                    </div>
		
		



        </div>
		
		
        <div class="modal-footer">
          <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">OK</button>
        </div>
     </div>
	 
	 
	 

	 
	 
	 	    <!-- Modal -->
    <div id="get_subject" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Subjects:</h3>
		  
        </div>
        <div class="modal-body">
								                                <div class="alert" id="message-warning3">
                                    <button type="button" class="close" onclick="close_message_warning();">×</button>
                                    <strong>Warning!</strong> Please select the offre of sponsor
                                </div>
				<p>
				
<textarea class="span5" rows="8" id="text_get_subject" onselect="OnSelectInput1 (this)">
</textarea></p>
		<font size="1" id="vmta_count">(*) Select Subject and click 'OK' &nbsp <div class="processing" id="processing2"></div></font>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">OK</button>
        </div>
     </div>
	
	
    <!-- Modal -->
    <div id="bounceemail-info" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Bounce Email infos</h3>
        </div>
        <div class="modal-body">
            <p><strong>[Dynamique]</strong> Return dynamique value contains the recipient domain + unique ID + recipient ID (ex. user@hotmail.com become hotmail.com.10513724975758.user ) </p>
            <p><strong>[DomainAbstract]</strong> Return abstract domain name of host name </p>
            <p><strong>[CampaignID]</strong> Return Campaign ID </p>
            <p><strong>[Random(param1,param2)]</strong> Return random value<br> param1: type (ex. A or a or AN or aN or N) A=uppercase  a=lowercase  N=digital<br> param2: size (ex. 5) </p>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
     </div>
    
    <!-- Modal -->
    <div id="returnpath-info" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Return Path infos</h3>
        </div>
        <div class="modal-body">
            <p><strong>[Empty]</strong> Empty Return Path</p>
            <p><strong>[ListID].[UserID].[Domain]</strong> Variable Return Path (SpamTraps)</p>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
     </div>
	 
	     <!-- Modal -->
    <div id="returnpath-info1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Html Tags</h3>
        </div>
        <div class="modal-body">
            <p><strong>Offer Page : </strong> http://[Domain]/[OfferPage]</p>
		    <p><strong>Offer Unsubscribe : </strong> http://[Domain]/[OfferUnsub]</p>
		    <p><strong>Server Unsubscribe : </strong> http://[Domain]/[ServerUnsub]</p>
		    <p><strong>Track Open : </strong>  http://[Domain]/[TrackOpen]</p>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
     </div>
	 
	 
    
    <!-- Modal -->
    <div id="headerformat-info" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Header Format</h3>
        </div>
        <div class="modal-body">
            <p><strong>Subject:</strong> [Subject]</p>
            <p><strong>From:</strong> [FromName] <[FromEmail]> or [__From]</p>
			<p><strong>PlaceHolder:</strong> [PlaceHolder] </p>
            <p><strong>To:</strong> [To]</p>
            <p><strong>Reply-To:</strong> <[ReplyEmail]></p>
            <p><strong>Date:</strong> [SMTPDate]</p>
			<p><strong>Date:</strong> [DateHung] ==> Y.M.D</p>
            <p><strong>MIME-Version:</strong> 1.0</p>
            <p><strong>X-Originating-IP:</strong> [Ip]</p>
            <p><strong>Message-ID:</strong> [UniqueID].[CampaignID].[ListID].[UserID].[Random(AN,20)]@[Domain] or [__bounce]</p>
            <p><strong>Content-Type:</strong> text/html</p>
            <p><strong>Content-Type:</strong> text/plain;</p>
            <p><strong>Content-Type:</strong> text/html; charset="iso-8859-1"</p>
            <p><strong>Content-Type:</strong> text/html; charset=us-ascii;</p>
            <p><strong>Content-Transfer-Encoding:</strong> 7bit</p>
            <p><strong>Content-Transfer-Encoding:</strong> quoted-printable</p>
			<p><strong>[Subject]</strong></p>
			<p><strong>[FromName]</strong></p>
			<p><strong>[Server]</strong></p>
			<p><strong>[FromEmail]</strong></p>
			<p><strong>[From]</strong></p>
			<p><strong>[To]</strong></p>
			<p><strong>[ReplyEmail]</strong></p>
			<p><strong>[ReturnPath]</strong></p>
			<p><strong>[SMTPDate]</strong></p>
			<p><strong>[Date]</strong></p>
			<p><strong>[UniqueID]</strong></p>
			<p><strong>[BounceEmail]</strong></p>
			<p><strong>[Ip]</strong></p>
			<p><strong>[Domain]</strong></p>
			<p><strong>[DomainAbstract]</strong></p>
			<p><strong>[XSmfbl]</strong></p>
			<p><strong>[Fname]</strong></p>
			<p><strong>[FnameDomain]</strong></p>
			<p><strong>[XMailer]</strong></p>
			<p><strong>[ATo]</strong></p>
			<p><strong>[Vmta]</strong></p>
			<p><strong>[Empty]</strong></p>
			<p><strong>[CampaignID]</strong></p>
			<p><strong>[Negative]</strong></p>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
     </div>

	<!-- Modal -->
    <div id="create-vmta" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Create VMTA </h3>
        </div>
		<div class="modal-body">
			<div class="alert" id="message-warning-vmta">
				<button type="button" class="close" onclick="close_message_warning_vmta();">×</button>
				<strong>Warning!</strong> Please verify your data
			</div>
			<div class="alert" id="message-warning-custom-vmta">
				<button type="button" class="close" onclick="close_message_warning_custom_vmta();">×</button>
				<strong>Warning!</strong> <span id="message-custom-vmta"></span>
			</div>
			<div class="alert alert-error" id="message-error-vmta">
				<button type="button" class="close" onclick="close_message_error_vmta();">×</button>
				<strong>Error!</strong> There was an error while executing your request
			</div>
			<div class="alert alert-success" id="message-success-vmta">
				<button type="button" class="close" onclick="close_message_success_vmta();">×</button>
				<strong>Done!</strong> VMTA has been created successfully
			</div>
			<form class="form-horizontal row-fluid" name="" method="POST" action=""> 
				<div class="control-group">
					<label class="control-label" for="basicinput">VMTA Name</label>
					<div class="controls">
						<input type="text" id="name_vmta" name="name_vmta" placeholder="No spaces or special characters" class="span8">
						<span class="help-inline"><button class="btn btn-success" type="button" name="" onclick="generate_name();"><i class="icon-retweet icon-white"></i>&nbsp;Generate</button></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="basicinput">IP Addresses</label>
					<div class="controls">
						<select tabindex="1" data-placeholder="Select here.." id="address_ip_vmta" name="address_ip_vmta[]" size="10" multiple class="span8" style="float: left;" onchange="ip_select_count();"></select>
						<span class="" style="float: left;">&nbsp;&nbsp;<i class="icon-refresh icon-white refresh" title="Refresh" style="cursor: pointer;" onclick="show_ips();"></i></span><br/>
						&nbsp;&nbsp;<font size="1" id="ip_count">No Vmta Selected</font>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="basicinput">Host Name</label>
					<div class="controls">
						<input type="text" id="host_name_vmta" name="host_name_vmta" placeholder="" class="span8">
						<span class="help-inline"></span>
					</div>
				</div>
			</form>
		</div>
        <div class="modal-footer">
		  <span class="processing" id="processing_vmta" style="float: left; margin-bottom: -20px;"></span> 
		  <button class="btn btn-primary" type="button" name="submit" onclick="add_vmta();"><i class="icon-pencil icon-white"></i>&nbsp;Create VMTA</button>
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
     </div>
	 <!-- Modal -->
	 <!--div id="confirm-reset-vmtas" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		  <h3 id="myModalLabel">Confirmation</h3>
		</div>
		<div class="modal-body">
		  <p>You're about to Reset all Virtual MTAs in this Server</p>
		</div>
		<div class="modal-footer">
		  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		  <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true" onclick="reset_vmtas()">Confirm</button>
		</div>
	  </div-->
    
	
	
	
    <!-- Modal -->
    <div id="edit-vmtas" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Edit VMTAs</h3>
        </div>
        <div class="modal-body">
            <p>
                <div class="control-group">
                    <label class="control-label">Sort by</label>
                    <div class="controls">
                        <label class="checkbox inline"><input type="checkbox" id='edit-vmta-name' name="vmta_option" value="0" onclick="show_vmtas_editable();" checked>VMTA Name</label>
                        <label class="checkbox inline"><input type="checkbox" id='edit-vmta-ip' name="vmta_option" value="1" onclick="show_vmtas_editable();" checked>IP Address</label>
                        <label class="checkbox inline"><input type="checkbox" id='edit-vmta-host' name="vmta_option" value="2" onclick="show_vmtas_editable();" checked>Host Name</label>
                    </div>
                </div>

            </p>
          <p><textarea class="span5" rows="10" id="edit_vmtas_area"></textarea></p>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
     </div>
    
    <!-- Modal -->
    <div id="search-vmtas" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Search VMTAs</h3>
        </div>
        <div class="modal-body">
            <p>
                <div class="control-group">
                    <label class="control-label">Search by</label>
                    <div class="controls">
						<label class="checkbox inline"><input type="checkbox" id='search-server-name' name="vmta_option" value="0" onclick="" checked>Server Name</label>
                        <label class="checkbox inline"><input type="checkbox" id='search-vmta-name' name="vmta_option" value="1" onclick="" checked>VMTA Name</label>
                        <label class="checkbox inline"><input type="checkbox" id='search-vmta-ip' name="vmta_option" value="2" onclick="" checked>IP Address</label>
                        <label class="checkbox inline"><input type="checkbox" id='search-vmta-host' name="vmta_option" value="3" onclick="" checked>Host Name</label>
                    </div>
                </div>

            </p>
          <p><textarea class="span5" rows="10" id="search_vmtas_area"></textarea></p>
          <font size="1" id="vmta_count">(*) Each value in a row</font>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true" onclick="search_vmtas();">Search</button>
        </div>
     </div>

	 <!-- Modal -->
    <div id="text-encoder" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Text Encoder</h3>
        </div>
        <div class="modal-body">
            <p><textarea class="span5" rows="5" id="text-encoder-input"></textarea></p>
			<p><button class="btn btn-success" type="button" onclick="text_encode()">Encode UTF8</button></p>
			<p><textarea class="span5" rows="5" id="text-encoder-output"></textarea></p>
        </div>
        <div class="modal-footer">
		<button class="btn btn-primary" data-dismiss="modal" onclick="getencode();" aria-hidden="true">OK</button>
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
     </div>
	 
	 
	 	 <!-- Modal -->
    <div id="text-encoder1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Text Encoder</h3>
        </div>
        <div class="modal-body">
            <p><textarea class="span5" rows="5" id="text-encoder-input1"></textarea></p>
			<p><button class="btn btn-success" type="button" onclick="text_encode1()">Encode</button></p>
			<p><textarea class="span5" rows="5" id="text-encoder-output1"></textarea></p>
        </div>
        <div class="modal-footer">
		<button class="btn btn-primary" data-dismiss="modal" onclick="getencode1();" aria-hidden="true">OK</button>
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
     </div>

	 <!-- Modal -->
	<div id="confirm-test-auto" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		  <h3 id="myModalLabel">Confirmation</h3>
		</div>
		<div class="modal-body">
		  <p>You're about to Test using <strong>Test Multiple</strong></p>
		</div>
		<div class="modal-footer">
		  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		  <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true" onclick="test_auto();">Confirm</button>
		</div>
	 </div>
	 
	 
	 	 <!-- Modal -->
	<div id="test-auto-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		  <h3 id="myModalLabel">Test auto</h3>
		</div>
		<div class="modal-body">
		  <p>Test has been sent <strong>successfully.</strong></p>
		</div>
		<div class="modal-footer">
		  <button class="btn" data-dismiss="modal" aria-hidden="true">OK</button>
		  
		</div>
	 </div>
	 
	 
	   <!-- Modal -->
  <div class="modal fade" id="myModal_test_auto" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Test Auto</h4>
        </div>
        <div class="modal-body">
          <p>Check Reporting Output ....</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
  	   <!-- Modal -->
  <div class="modal fade" id="myModal_test_Campaign" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Test Campaign</h4>
        </div>
        <div class="modal-body">
          <p>Check Reporting Output ....</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
	 

	 <!-- Modal -->
	<div id="confirm-send-campaign" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		  <h3 id="myModalLabel">Confirmation</h3>
		</div>
		<div class="modal-body">
		  <p>You're about to Send Campaign using <strong>Send Multiple</strong></p>
		</div>
		<div class="modal-footer">
		  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		  <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true" onclick="send_campaign();">Confirm</button>
		</div>
	 </div>
	 
       <!-- Modal -->
    <div id="myModal1" class="modal hide fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Confirmation</h3>
      </div>
      <div class="modal-body">
        <p>You're about to save offer <strong></p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <!--button class="btn btn-primary" data-dismiss="modal" aria-hidden="true" onclick="save_offer();">Save offer</button-->
		<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true" onclick="" id="store_campaign" >Save offer</button>
      </div>
    </div>	 
	
	
	

	 
	 
<script type="text/javascript">
// create the back to top button
$('body').prepend('<a href="#" class="back-to-top">Back to Top</a>');

var amountScrolled = 200;

$(window).scroll(function() {
	if ( $(window).scrollTop() > amountScrolled ) {
		$('a.back-to-top').fadeIn('slow');
	} else {
		$('a.back-to-top').fadeOut('slow');
	}
});

$('a.back-to-top, a.simple-back-to-top').click(function() {
	$('html, body').animate({
		scrollTop: 0
	}, 400);
	return false;
});
</script>
    
    

	
</body>
</html>

<?php
    if(isset($_GET['edit_campaign'])){
        echo "<script>edit_campaign(".$_GET['edit_campaign'].")</script>";
        //echo "<script>alert(".$_GET['edit_campaign'].")</script>";
    }
?>
