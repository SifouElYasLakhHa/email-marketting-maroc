	<?php
   include_once '../account/session.php';
   
   if(isset($_GET['action'])){
    $action=$_GET['action'];
    if($action=='get_servers')get_servers();
	if($action=='get_servers_edit')get_servers_edit();
    if($action=='get_domains')get_domains();
    if($action=='get_vmtas')get_vmtas();
	// if($action=='comment')comment();
	if($action=='delete_comment')delete_comment();
	if($action=='get_ip_server')get_ip_server();
    if($action=='save_offer')save_offer();
	if($action=='edit_offer')edit_offer();
	if($action=='get_vmtas2')get_vmtas2();
	if($action=='get_vmtas_edit')get_vmtas_edit();
    if($action=='get_sponsors')get_sponsors();
	if($action=='get_subject_from')get_subject_from();
    if($action=='get_offers')get_offers();
    if($action=='get_news')get_news();
	if($action=='get_theme_mailer')get_theme_mailer();
    if($action=='update_theme')update_theme();
    if($action=='update_theme1')update_theme1();
    if ($action == 'upload_negative') upload_negative();
	if($action=='create_redirect')create_redirect();
	if($action=='Collapsible')Collapsible();
    if($action=='get_isps')get_isps();
    if($action=='get_data_lists')get_data_lists();
	if($action=='get_by_data_lists')get_by_data_lists();
	if($action=='get_data_lists_edit')get_data_lists_edit();
	if($action=='get_countries')get_countries();
	if($action=='get_countries_code')get_countries_code();
	if($action=='get_country_flag')get_country_flag();
	if($action=='get_ips')get_ips();
	if($action=='get_mailers')get_mailers();
	if($action=='add_vmta')add_vmta();
	if($action=='reset_vmtas')reset_vmtas();
    if($action=='show')show();
	if($action=='show1')show1();
    if($action=='edit')edit();
	if($action == 'store_campaign') store_campaign();
	if($action == 'load_campaign') load_campaign();
	if($action == 'loadedfiles') loadedfiles();
	if($action == 'list_negatives') list_negatives();
	if($action=='show_pmta_monitor')show_pmta_monitor();
    if($action=='stop_campaign')stop_campaign();
    if($action=='get_real_sent')get_real_sent();
    if($action=='get_real_status')get_real_status();
	if($action=='stop_process')stop_process();
	if($action=='text_encode')text_encode();
	if($action=='update_list_count')update_list_count();
	if ($action == 'get_campaigns_monitor_data') get_campaigns_monitor_data();
	if ($action == 'get_campaigns_count_by_status') get_campaigns_count_by_status();
	if ($action == 'get_campaign') get_campaign();
   }
   
   
   
function get_campaign()
{
	$request = "SELECT DISTINCT C.id
						, C.date_send
						, AM.username
						, O.sid as offer_id
						, O.name AS offer_name
						, DN.name AS news_name
						, DI.name AS isp_name
						, CO.code AS country_code
						, C.test_emails_to AS test_emails
						, C.test_period
						, C.xbatch
						, C.xdelay
						, C.data_from
						, CONCAT_WS('@', C.bounce_email, C.return_path) AS campaign_return
						, C.data_count
						, C.data_eliminated
						, C.data_processed
						, C.status
						, C.from_name
						, C.subject
						, C.from_email
						, C.header_format
						, C.html_body
						, C.link_type
						, CC.deleted_bounce AS bounce
						, CC.delivered AS delivered
						, DL.name AS lists
					FROM
					campaign C
						JOIN campaign_data_list CBL ON (C.id = CBL.id_campaign)
						JOIN data_list DL ON (CBL.id_data_list = DL.id )
						JOIN campaign_server CS ON (C.id = CS.id_campaign)
						JOIN account_mailer AM ON (C.id_mailer=AM.id)
						JOIN offer O ON (C.id_offer=O.id)
						JOIN data_news DN ON (C.id_news=DN.id)
						JOIN data_isp DI ON (C.id_isp=DI.id)
						JOIN country CO ON (C.id_country=CO.id)
						LEFT JOIN campaign_counts CC ON (C.id = CC.id_campaign )
				WHERE C.id={$_GET['id_campaign']}";

	$query = bd::query($request);

	/*$query = bd::query("SELECT campaign.id, campaign.date_send, campaign.id_offer, campaign.id_news, campaign.id_isp, campaign.data_from, campaign.data_count, campaign.data_sent, campaign.status, offer.name as offer_name, data_news.name as news_name, data_isp.name as isp_name, account_mailer.username FROM campaign, offer, data_news, data_isp, account_mailer WHERE campaign.id_mailer=account_mailer.id && campaign.id_server='{$_SESSION['id-server']}' && campaign.id_offer=offer.id && campaign.id_news=data_news.id && campaign.id_isp=data_isp.id ORDER BY campaign.date_send DESC LIMIT 0,10");*/
	$row = mysql_fetch_object($query);
	if(!$row)
		return;

	$campaign_vmtas_details = get_campaign_vmtas($_GET['id_campaign']);
	$row_array = (array)$row;
	$row_array['servers_details'] = $campaign_vmtas_details;
	$row = (object)$row_array;
	echo json_encode($row);
}

function get_campaign_vmtas($id_campaign) {
	$data = array();
	$request = "SELECT
				S.name, GROUP_CONCAT(SV.address_ip SEPARATOR ', ') AS ips
				FROM `campaign_server_vmta` CSV
				join `server_vmta` SV on CSV.id_vmta=SV.id
				join `server` S on SV.id_server=S.id
				WHERE CSV.`id_campaign`=$id_campaign GROUP BY SV.id_server";
	$query = bd::query($request);
	while ($row = mysql_fetch_object($query)) {
		$data[] = $row;
	}

	return $data;
}
   
   
function list_negatives()
{

	$mailer_id = $_SESSION['id-mailer'];
	$path = __DIR__ . "/upload_negative/$mailer_id/"; //server path


	if (!file_exists($path)) {
		mkdir($path, 0777);
		echo json_encode(array());
	} else {
		$files = glob($path . '*'); // get all file names
		$names = array();
		foreach ($files as $file) { // iterate files
			if (is_file($file))
				array_push($names, end(explode('/', $file)));
		}

		echo json_encode($names);
	}
}


function store_campaign()
{

	$sponsor_id = $_POST['sponsor_id'];
	$offer_id = $_POST['offer_id'];
	$from_name = $_POST['from_name'];
	$subject = $_POST['subject'];
	$from_email = $_POST['from_email'];
	$reply_email = $_POST['reply_email'];
	$bounce_email = $_POST['bounce_email'];
	$return_path = $_POST['return_path'];
	$received = $_POST['received'];
	$xmailer = $_POST['xmailer'];
	$header_nbr = $_POST['header_nbr'];
	$header_format = $_POST['header_format'];
	$server_body = $_POST['server_body'];
	$domain_body = $_POST['domain_body'];
	$redirect_type = $_POST['redirect_type'];
	$open_tracker = $_POST['open_tracker'];
	$body_type = $_POST['body_type'];
	$text_body = $_POST['text_body'];
	$html_body = $_POST['html_body'];
	$new_tags = $_POST['new_tags'];
	$servers = $_POST['servers'];
	$vmtas = $_POST['vmtas'];
	$id_news = $_POST['id_news'];
	$id_isp = $_POST['id_isp'];
	$test_emails_to = $_POST['test_emails_to'];
	$test_period = $_POST['test_period'];
	$xdelay = $_POST['xdelay'];
	$change_ip = $_POST['change_ip'];
	$data_from = $_POST['data_from'];
	$data_count = $_POST['data_count'];

	$mailer_id = $_SESSION['id-mailer'];


	$create_json_format = array(
		"sponsor_id" => $sponsor_id,
		"offer_id" => $offer_id,
		"from_name" => $from_name,
		"subject" => $subject,
		"from_email" => $from_email,
		"reply_email" => $reply_email,
		"bounce_email" => $bounce_email,
		"return_path" => $return_path,
		"received" => $received,
		"xmailer" => $xmailer,
		"header_nbr" => $header_nbr,
		"header_format" => $header_format,
		"server_body" => $server_body,
		"domain_body" => $domain_body,
		"redirect_type" => $redirect_type,
		"open_tracker" => $open_tracker,
		"body_type" => $body_type,
		"text_body" => $text_body,
		"html_body" => $html_body,
		"new_tags" => $new_tags,
		"servers" => $servers,
		"vmtas" => $vmtas,
		"id_news" => $id_news,
		"id_isp" => $id_isp,
		"test_emails_to" => $test_emails_to,
		"test_period" => $test_period,
		"xdelay" => $xdelay,
		"change_ip" => $change_ip,
		"data_from" => $data_from,
		"data_count" => $data_count
	);


	$path = __DIR__ . "/store_campaigns/$mailer_id/"; //server path
	if (!file_exists($path)) {
		mkdir($path, 0777);
	}

	$newfile_to_store = $mailer_id . "_" . $sponsor_id . "_" . $offer_id . ".txt";
	$path .= $newfile_to_store;
	$contents = json_encode($create_json_format);
	file_put_contents($path, $contents);
	echo json_encode(array("result" => "The file is changed"));
}

function load_campaign()
{

	$sponsor_id = $_POST['sponsor_id'];
	$offer_id = $_POST['offer_id'];
	$mailer_id = $_SESSION['id-mailer'];

	$path_load_file = __DIR__ . "/store_campaigns/$mailer_id/" . $mailer_id . "_" . $sponsor_id . "_" . $offer_id . ".txt";

	if (!file_exists($path_load_file)) {
		echo json_encode(array("exist" => "no"));
	} else {
		$myfile = fopen($path_load_file, 'rt');
		flock($myfile, LOCK_SH);
		$read = file_get_contents($path_load_file);
		fclose($myfile);
		echo $read;
	}
}


function loadedfiles()
{

 	$path_mailer = __DIR__ . "/upload_headers/{$_SESSION['id-mailer']}";

	if ($_GET['type'] == 'test') {
		$path_folder = $path_mailer . "/test/"; //server path
	} else {
		$path_folder = $path_mailer . "/send/";
	}

	if (!file_exists($path_mailer)) {
		mkdir($path_mailer, 0777);
	}

	if (!file_exists($path_folder)) {
		mkdir($path_folder, 0777);
	} else {
		//	$files = glob($path. '*'); // get all file names
		//	foreach($files as $file){ // iterate files
		//	  if(is_file($file))
		//		unlink($file); // delete file
		//	}
		//echo "The old files are deleted";
	}
	
	$return_message = [];
	$files_name = [];
	$message = "";
	$return = [];

	foreach ($_FILES as $key) {

		if ($key['error'] == UPLOAD_ERR_OK) {
			//$name =  preg_replace('/\s+/', '', $key['name'])

			$name_file = explode(".", $key["name"])[0];
			$ext_file  = explode(".", $key["name"])[1];

			$name = $name_file . "_" . generateRandomString(6) . ".txt";

			$temp = $key['tmp_name'];
			$size = ($key['size'] / 100000) . "Kb";
			if (move_uploaded_file($temp, $path_folder . $name)) {
				$message .= "Uploaded";
			} else {
				$message .= "File was not uploaded";
			}
			$message .= "
                <div>
                    <h12><strong>File Name: $name</strong></h2><br />
                    <h12><strong>Size: $size</strong></h2>
                    <hr>
                </div>
                ";
		} else {
			$message .= $key['error'];
		}
		array_push($files_name, $name);
	}
	array_push($return_message, $message);
	$return["html"] = $return_message;
	$return["names"] = join("\r", $files_name);

	echo json_encode($return);
}



function generateRandomString($length = 10)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}


function upload_negative()
{

	$mailer_id = $_SESSION['id-mailer'];
	$path = __DIR__ . "/upload_negative/$mailer_id/"; //server path

	if (!file_exists($path)) {
		mkdir($path, 0777);
	} else {
		//$files = glob($path. '*'); // get all file names
		/*foreach($files as $file){ // iterate files
		  if(is_file($file))
			unlink($file); // delete file
		}
		*/
		//echo "The old files are deleted";
	}

	if ($_FILES['file']['name'] != '') {
		$test = explode('.', $_FILES['file']['name']);
		$extension = end($test);
		$name = $test[0];
		$name = $name . "_" . $mailer_id . "_" . date("YdM") . '.' . $extension;

		$location = $path . $name;
		move_uploaded_file($_FILES['file']['tmp_name'], $location);

		echo 'Uploaded !';
	}
}


   function Update_list_count(){
	  $ok=0;

      $query_data_list=bd::query("SELECT id,data_table FROM data_list WHERE id={$_GET["id_data_list"]}");
	  $query_data_isp=bd::query("SELECT id,regex FROM data_isp");
	  if(!$query_data_list)$ok=1;
	  if(!$query_data_isp)$ok=1;

	  $array_data_list=array();
	  $array_data_isp=array();

	  while($row_data_list=mysql_fetch_array($query_data_list)){
			$array_data_list[]=$row_data_list;
	  }

	  while($row_data_isp=mysql_fetch_array($query_data_isp)){
			$array_data_isp[]=$row_data_isp;
	  }

	  foreach($array_data_list as $value_data_list){
		    
			$query=bd::query("UPDATE data_list_count SET count_total=(SELECT COUNT(id) FROM {$value_data_list["data_table"]}) WHERE id_data_list={$value_data_list["id"]}");
			if(!$query)$ok=1;
			foreach($array_data_isp as $value_data_isp){
     $query=bd::query("UPDATE data_isp_count SET count_total=(SELECT COUNT(id) FROM {$value_data_list["data_table"]} WHERE email_address REGEXP '{$value_data_isp["regex"]}' and id_country='{$_GET["country"]}') WHERE id_data_list={$value_data_list["id"]} AND id_isp={$value_data_isp["id"]}");
				if(!$query)$ok=1;
			}
	   }
	   echo $ok;
   }
   
   
   
   function save_offer(){
            $id_server_main=$_SESSION["id-server"];
            $id_mailer=$_SESSION['id-mailer'];
		    $from_name=$_POST['from_name'];
            $subject=$_POST['subject'];
            $from_email=$_POST['from_email'];
            $reply_email=$_POST['reply_email'];
            $bounce_email=$_POST['bounce_email'];
            $return_path=$_POST['return_path'];
            $received=$_POST['received'];
            $xmailer=$_POST['xmailer'];
            $header_nbr=$_POST['header_nbr'];
            $header_format=$_POST['header_format'];
            $server_body=$_POST['server_body'];
            $domain_body=$_POST['domain_body'];
            $redirect_type=$_POST['redirect_type'];
            $open_tracker=$_POST['open_tracker'];
            $body_type=$_POST['body_type'];
            $text_body=$_POST['text_body'];
            $html_body=$_POST['html_body'];
			$additional_negative_active=$_POST['additional_negative_active'];
            $repeat_negative=$_POST['repeat_negative'];
            $additional_negative=$_POST['additional_negative'];
			$save_hotmail_sender_data_active=$_POST['save_hotmail_sender_data_active'];
            $send_multiple_type=$_POST['send_multiple_type'];
            $send_multiple_values=$_POST['send_multiple_values'];
            $send_rotate_values=$_POST['send_rotate_values'];
			$astuce_tag_active=$_POST['astuce_tag_active'];
			$astuce_tag_email_address=$_POST['astuce_tag_email_address'];
			$servers=$_POST['servers'];
			$vmtas=$_POST['vmtas'];
			$sponsor=$_POST['sponsor'];
            $offer=$_POST['offer'];
			$news=$_POST['news'];
            $isp=$_POST['isp'];
            $data_lists=$_POST['data_lists'];
		    $test_emails_to=$_POST['test_emails_to'];
            $test_period=$_POST['test_period'];
            $xdelay=$_POST['xdelay'];
            $change_ip=$_POST['change_ip'];
            $data_from=$_POST['data_from'];
            $data_count=$_POST['data_count'];
			$test_emails_to_x=$test_emails_to;
            $test_emails_to= explode(';', $test_emails_to);
			$message='';
            if($body_type==0){
            $message = $text_body;
            }elseif ($body_type==1) {
            $message = $html_body;
            }elseif($body_type==2){
                $message = ''; 
                $message.="--{text}".chr(10);                       
                $message.=$text_body.chr(10);                  
                $message.="--{html}".chr(10);               
                $message.=$html_body.chr(10);
            }
            $message_tmp = $message;
            $message = str_replace("[Domain]",$domain_body,$message);
			// $from_name_x=addslashes($from_name);
            // $subject_x=addslashes($subject);
            // $header_format_x=addslashes($header_format);
            // $text_body_x=addslashes($text_body);
            // $html_body_x=addslashes($html_body);
			
			$from_name_x=$from_name;
            $subject_x=$subject;
            $header_format_x=$header_format;
            $text_body_x=$text_body;
            $html_body_x=$html_body;
			
			
			$header_nbr=$save_hotmail_sender_data_active;

			
			// bd::query("INSERT INTO piw VALUES($id_mailer,$offer,'$from_email')");
			
				$res=bd::query("INSERT INTO save_offer VALUES(
				 NULL,
				 $id_server_main,
				 $id_mailer,
				'$from_name_x',
				'$subject_x',
				'$from_email',
				'$reply_email',
				'$bounce_email',
				'$return_path',
				'$received',
				'$xmailer',
				 $header_nbr,
				'$header_format_x',
				 $server_body,
				'$domain_body',
				 $redirect_type,
				 $open_tracker,
				 $body_type,
				'$text_body_x',
				'$html_body_x',
				 $sponsor,
				 $offer,
				 $news,
				 $isp,
				'$test_emails_to_x',
				 $test_period,
				 $xdelay,
				 $change_ip,
				 $data_from,
				 $data_count,
				 0,
				 0,
				'Starting',
				now()
				)");

   }
   
   
      function edit_offer(){
      $data=array();

      $query = bd::query("SELECT * FROM save_offer WHERE id_offer='{$_GET["id_offer"]}' AND id_mailer='{$_SESSION['id-mailer']}' ORDER BY id DESC");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }

      function update_theme(){
      $query = bd::query("UPDATE account_mailer  set theme_name='../../css/theme.css' where id={$_SESSION['id-mailer']}  ");
   }
   
         function update_theme1(){
      $query = bd::query("UPDATE account_mailer  set theme_name='../../css/theme1.css' where id={$_SESSION['id-mailer']}  ");
   }
 
    function create_redirect(){
	    $id_server_main=$_SESSION["id-server"];
        $id_mailer=$_SESSION['id-mailer'];
        $id_sponsor=$_POST["id_sponsor"];
        $id_offer=$_POST["id_offer"];
        $id_server=$_POST["id_server"];
        $domain=$_POST["domain"];

		$link1="http://[Domain]/[OfferPage]";
		$link2="http://[Domain]/[OfferUnsub]";
		$link3="http://[Domain]/[ServerUnsub]";

		$php_file="wrap.php";
		$redirect_page_ol="app/redirection/".$php_file."?track=".'A1XC-1XR'.$id_mailer.'XM'.$id_server_main.'XS'.$id_server.'XV0XN'.$id_sponsor.'XO'.$id_offer.'XW0XP0XL0XU0XT1X';
		$redirect_page_ou="app/redirection/".$php_file."?track=".'A1XC-1XR'.$id_mailer.'XM'.$id_server_main.'XS'.$id_server.'XV0XN'.$id_sponsor.'XO'.$id_offer.'XW0XP0XL0XU0XT2X';
		$redirect_page_su="app/redirection/".$php_file."?track=".'A1XC-1XR'.$id_mailer.'XM'.$id_server_main.'XS'.$id_server.'XV0XN'.$id_sponsor.'XO'.$id_offer.'XW0XP0XL0XU0XT3X';

		$link1 = str_replace(array("[Domain]","[OfferPage]"),array($domain,"app/wrap/".base64_encode($redirect_page_ol)),$link1);
		$link2 = str_replace(array("[Domain]","[OfferUnsub]"),array($domain,"app/wrap/".base64_encode($redirect_page_ou)),$link2);
		// $link3 = str_replace(array("[Domain]","[ServerUnsub]"),array($domain,"app/wrap/".base64_encode($redirect_page_su)),$link3);
				$link3 = str_replace(array("[Domain]","[ServerUnsub]"),array($domain,"app/unsub/optdown.php/".base64_encode($redirect_page_ou)),$link3);

		echo $link1.'|'.$link2.'|'.$link3;
   }
 
   
      // function comment(){
      // $data=array();
      // $query = bd::query("SELECT message from comment where id_mailer='{$_SESSION['id-mailer']}' and status='Delivered' ORDER BY id DESC");
      // while ($row = mysql_fetch_object($query)) {
          // $data[]=$row;
      // }
      // echo json_encode($data);
   // }
   

         // function delete_comment(){
			    // $date_red=date('Y-m-d h:i:s');
       // $query = bd::query("UPDATE comment SET status='Red',date_red='$date_red' WHERE id_mailer='{$_SESSION['id-mailer']}' ");

   // }
   
   
   function get_servers(){
      $data=array();
      $query = bd::query("SELECT S.id, S.name ,S.main_ip FROM server S,permission_mailer_server PMS  WHERE S.active=1 AND S.status='Available' AND PMS.id_mailer={$_SESSION['id-mailer']} AND PMS.id_server=S.id and S.name NOT LIKE 'Client' and S.name NOT LIKE 'master'  ORDER BY S.id ASC");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }
   
   
            // function get_offers(){
      // $data=array();
      // $query = bd::query("SELECT o.id,o.name FROM offer o,permission_mailer_offers PMo WHERE o.id_sponsor='{$_GET["sponsor"]}' &&  o.active='1' AND PMo.id_mailer={$_SESSION['id-mailer']} AND PMo.id_offer=o.id ORDER BY o.id ASC");
      // while ($row = mysql_fetch_object($query)) {
          // $data[]=$row;
      // }
      // echo json_encode($data);
   // }
   
  
  function get_offers()
{
	$data = array();
	$sponsor = $_GET["sponsor"];
	$country = $_GET["country"];

	// $query = "SELECT distinct o.id,o.name,o.days_traffic,o.geo_targeting,o.suppression_status FROM permission_mailer_offers as PMo offer as o inner join offer_countries as oc on o.id=oc.id_offer WHERE active='1'";


$query = "SELECT distinct o.id,o.name,o.days_traffic,o.geo_targeting,o.suppression_status FROM offer o,permission_mailer_offers PMo,offer_countries oc WHERE o.active='1' AND PMo.id_mailer={$_SESSION['id-mailer']} AND PMo.id_offer=o.id and o.id=oc.id_offer";
	if (intval($sponsor) > 0)
		$query .= " && o.id_sponsor='{$sponsor}'";

	if (intval($country) > 0)
		$query .= " && oc.id_country='{$country}'";

	$res = bd::query($query);


	while ($row = mysql_fetch_object($res)) {
		$data[] = $row;
	}

	echo json_encode($data);
}
   
   
      // function get_offers(){
      // $data=array();
      // $query = bd::query("SELECT id,name FROM offer WHERE id_sponsor='{$_GET["sponsor"]}' &&  active='1'");
      // while ($row = mysql_fetch_object($query)) {
          // $data[]=$row;
      // }
      // echo json_encode($data);
   // }
   
   

   
   

   
   
   
      function get_theme_mailer(){
      $data=array();
      $query = bd::query("SELECT theme_name from account_mailer where id={$_SESSION['id-mailer']}  ");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }
   
   
   function get_domains(){
      $data=array();
      $query = bd::query("SELECT host_name FROM server_vmta WHERE id_server='{$_GET["server"]}' && active='1' && id_mailer=0");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }
   

   
   
   function get_vmtas()
   {
      $data=array();
      $query = bd::query("SELECT V.id,V.name,V.address_ip,V.host_name,S.main_ip FROM server_vmta V,server S WHERE V.id_server='{$_SESSION['id-server']}' && V.active='1' and S.id = V.id_server");
      while ($row = mysql_fetch_object($query)) 
	  {
          $data[]=$row;
      }
      echo json_encode($data);
   }
   
   function get_sponsors(){
      $data=array();
      $query = bd::query("SELECT id,name FROM sponsor WHERE active='1'");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }
   
   
   function get_subject_from(){
      $data=array();
	  $id_offer=$_GET["id_offer"];
      $query = bd::query("SELECT sid,froms,subjects FROM offer WHERE id=$id_offer ");
	  while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }
   

   
   // function get_news(){
      // $data=array();
      // $query = bd::query("SELECT id,name FROM data_news WHERE active='1'");
      // while ($row = mysql_fetch_object($query)) {
          // $data[]=$row;
      // }
      // echo json_encode($data);
   // }

   
         function get_news(){
      $data=array();
      $query = bd::query("SELECT dn.id,dn.name FROM data_news dn,permission_mailer_News pdn WHERE dn.active='1' AND pdn.id_mailer={$_SESSION['id-mailer']} AND pdn.id_News=dn.id ORDER BY dn.id DESC ");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }
   
   
   function get_countries(){
      $data=array();
      $query = bd::query("SELECT id, name FROM country where id<>0");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }


   function get_countries_code(){
      $data=array();
      $query = bd::query("SELECT id,code FROM country where id<>0");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }

   function get_country_flag(){
      $data=array();
      $query = bd::query("SELECT flag_lg FROM country WHERE id={$_GET["country"]}");
      $row=mysql_fetch_array($query);
      echo $row['flag_lg'];
   }
   
   function get_isps(){
      $data=array();
      $query = bd::query("SELECT id,name FROM data_isp WHERE active='1'");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }
   
   
      function get_ip_server(){
      $data=array();
      $query = bd::query("SELECT main_ip FROM server WHERE name like '{$_GET["id"]}' ");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }
   
   
   
   function get_data_lists(){
      $data=array();
      if(!empty($_GET["news"]) && !empty($_GET["isp"])  ){
		$query = bd::query("SELECT DL.id,DL.name,DIC.count_total FROM data_list DL, data_isp_count DIC WHERE DL.id_news={$_GET["news"]} && DL.active=1 && DL.id=DIC.id_data_list && DIC.id_isp={$_GET["isp"]}");
		while ($row = mysql_fetch_object($query)) {
            $data[]=$row;
        }
		echo json_encode($data);
      }
   }
   
   
   
   
   
      function get_by_data_lists(){
      $data=array();
      if(!empty($_GET["news"]) && !empty($_GET["isp"])  ){
		$query = bd::query("SELECT DL.id,DL.name,DIC.count_total FROM data_list DL, data_isp_count DIC WHERE DL.id_news={$_GET["news"]} && DL.active=1 && DL.id=DIC.id_data_list && DIC.id_isp={$_GET["isp"]}");
		while ($row = mysql_fetch_object($query)) {
            $data[]=$row;
        }
		echo json_encode($data);
      }
   }
   
   

   function calculate_data_isp(){
      $query = bd::query("SELECT regex FROM data_isp WHERE id={$_GET["isp"]}");
      $row=  mysql_fetch_array($query);
      $regexisp=$row['regex'];
      $query = bd::query("SELECT id,data_table FROM data_list WHERE id_news='{$_GET["news"]}' && data_table!='' && active='1' ");
      while($row=mysql_fetch_row($query)){
          bd::query("UPDATE data_list set count_isp=(select count(*) from $row[1] where email_address REGEXP '$regexisp') where id='$row[0]' ");
      } 
   }

   function get_ips(){
      $data=array();
      $query = bd::query("SELECT address_ip FROM server_vmta WHERE id_server='{$_SESSION['id-server']}' && host_type='0' && active='1'");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }

   function verify_name_vmta($id,$name,$id_server){
       $query = bd::query("SELECT * FROM server_vmta where name like '$name' && id_server='{$_SESSION['id-server']}' && id!='$id'");
       if(mysql_num_rows($query)>0){
           return true;
       }
       return false;
   }

   function add_vmta(){
        $name=trim($_POST["name"]);
        $address_ips=$_POST["address_ips"];
        $host_name=$_POST["host_name"];
        $active=1;
        $date_add=date('Y-m-d h:i:s');
        $date_set=date('Y-m-d h:i:s');
        
        $ok='0';
		$name_inital=$name;
		$address_ips=explode(';', $address_ips);
		foreach($address_ips as $address_ip){
			$cpt=1;	
			while(verify_name_vmta('0',$name,$id_server)){
				$cpt++;
				$name=$name_inital.$cpt;
			}

			$vmta_config_file = fopen($_SERVER["DOCUMENT_ROOT"]."/apps/mailer/server/vmta/config.d/vmtas1.txt", "a+");
			if($vmta_config_file){
				$vMtaString =   "<virtual-mta $name>\r\n";
				$vMtaString.=   "\tsmtp-source-ip $address_ip\r\n";
				$vMtaString.=   "\thost-name $host_name\r\n"; 
				$vMtaString.=   "</virtual-mta>\r\n\n";
				$rep=bd::query("INSERT INTO server_vmta VALUES (NULL, '{$_SESSION['id-server']}', '$name', '$address_ip', '$address_ip', '$host_name', '1', '$active', '$date_add', '$date_set');");
				if($rep){
					fwrite($vmta_config_file, $vMtaString);
				}else{
					$ok='Error data base';
				}
			}else{
			   $ok="Unable to open VMTA config file !";
			}
		}

		if($ok=='0'){
			exec("sudo /etc/init.d/pmta reload",$output,$report);
			if($report!='0'){
				$ok="Cannot reload PowerMTA !";
			}
		}
        echo $ok;
   }

   function reset_vmtas(){
		$ok='0';
		$vmta_config_file = fopen($_SERVER["DOCUMENT_ROOT"]."/apps/mailer/server/vmta/config.d/vmtas1.txt", "a+");
		if($vmta_config_file){
			$rep=bd::query("DELETE FROM server_vmta where id_server={$_SESSION['id-server']} && host_type='1'");
			if($rep){
				ftruncate($vmta_config_file, 0);
				exec("sudo /etc/init.d/pmta reload",$output,$report);
			}else{
				$ok='Error data base';
			}
		}else{
		   $ok="Unable to open VMTA config file !";
		}
		echo $ok;
   }
    
	function show(){
		  $concat='';
		  
		  	$team_info = $_SESSION["team_info"];

	if ($team_info != "noteam") {
		$team_name = explode(";", $team_info)[1];
	} else {
		$team_name = $team_info; // noteam
	}

	if ($_GET["id_server"] != 'all') {
		$concat .= " AND S.id={$_GET["id_server"]}";
	} else {
		$concat .= "";
	}

	if ($_GET["id_mailer"] != 'all') {
		$concat .= " AND C.id_mailer={$_GET["id_mailer"]}";
	} else if ($_GET["id_mailer"] == 'all' && ($_SESSION['is_admin'] == "Active") && ($team_name == 'Root')) {
		$concat .= "";
	} else if ($_GET["id_mailer"] == 'all' && in_array(intval($_SESSION['id-mailer']), explode(",", $_SESSION["ids_team"]))) {
		$concat .= " AND C.id_mailer in (" . $_SESSION['ids_team']  . ")";
	} else {
		$concat .= "";
	}
		  
		  
		  
		  // if($_GET["id_server"]!=0){
			// $concat.=" AND C.id_server={$_GET["id_server"]}";
		  // }
		  // if($_GET["id_mailer"]!=0){
			// $concat.=" AND C.id_mailer={$_GET["id_mailer"]}";
		  // }
		  if($_GET["id_sponsor"]!=0){
			$concat.=" AND C.id_sponsor={$_GET["id_sponsor"]}";
		  }
		  if($_GET["id_offer"]!=0){
			$concat.=" AND C.id_offer={$_GET["id_offer"]}";
		  }
		  if($_GET["id_news"]!=0){
			$concat.=" AND C.id_news={$_GET["id_news"]}";
		  }
		  if($_GET["id_isp"]!=0){
			$concat.=" AND C.id_isp={$_GET["id_isp"]}";
		  }
		  if($_GET["status"]!="0"){
			$concat.=" AND C.status='{$_GET["status"]}'";
		  }

		  	if ($_GET["link_type"] != "-1") {
        $concat .= " AND C.link_type='{$_GET["link_type"]}'";
    }
	
	
	
			  	// $concat .= " GROUP BY C.id ORDER BY C.id DESC";
		  $concat.=" ORDER BY C.id DESC LIMIT 0,{$_GET['nb_rows']}";
		  
		  $data=array();
		  if($_SESSION['id-mailer']!="22554754" ){
		  // $query = bd::query("SELECT C.id, C.date_send, S.name AS name_server,AM.username, O.name AS offer_name, DN.name AS news_name, DL.name AS name_data_list,  DI.name AS isp_name, C.data_from, C.data_count, C.data_processed,C.data_delivered, C.status FROM campaign C, server S,account_mailer AM, offer O, data_news DN, data_list DL, campaign_data_list CDL , data_isp DI, campaign_server CS WHERE CS.id_server=S.id AND CS.id_campaign=C.id AND CDL.id_campaign=C.id AND DL.id=CDL.id_data_list AND C.id_mailer=AM.id AND C.id_offer=O.id AND C.id_news=DN.id AND C.id_isp=DI.id AND (C.date_send BETWEEN '{$_GET["date_from"]}' AND '{$_GET["date_to"]}')$concat");  
		  		  // $query = bd::query("SELECT  ifnull((select count(id_campaign) from report_bounce_hard where id_campaign = C.id),'0') As ResultFound, C.id, C.date_send, S.name AS name_server,AM.username, O.name AS offer_name, DN.name AS news_name, DL.name AS name_data_list,  DI.name AS isp_name, C.data_from, C.data_count, C.data_processed,C.data_delivered, C.status FROM campaign C, server S,account_mailer AM, offer O, data_news DN, data_list DL, campaign_data_list CDL , data_isp DI, campaign_server CS WHERE CS.id_server=S.id AND CS.id_campaign=C.id AND CDL.id_campaign=C.id AND DL.id=CDL.id_data_list AND C.id_mailer=AM.id AND C.id_offer=O.id AND C.id_news=DN.id AND C.id_isp=DI.id AND (C.date_send BETWEEN '{$_GET["date_from"]}' AND '{$_GET["date_to"]}')$concat");  
				  
		  $query = bd::query("SELECT  CC.deleted_bounce As ResultFound, C.id, C.date_send, S.name AS name_server,AM.username, O.name AS offer_name, DN.name AS news_name, DL.name AS name_data_list,  DI.name AS isp_name, C.data_from, C.data_count, C.data_processed,C.data_delivered, C.status FROM campaign_counts CC, campaign C, server S,account_mailer AM, offer O, data_news DN, data_list DL, campaign_data_list CDL , data_isp DI, campaign_server CS WHERE CS.id_server=S.id AND CS.id_campaign=C.id AND CC.id_campaign=C.id AND CDL.id_campaign=C.id AND DL.id=CDL.id_data_list AND C.id_mailer=AM.id AND C.id_offer=O.id AND C.id_news=DN.id AND C.id_isp=DI.id AND (C.date_send BETWEEN '{$_GET["date_from"]}' AND '{$_GET["date_to"]}')$concat");  	  
		  
		  }else 
     	  $query = bd::query("SELECT C.id, C.date_send, S.name AS name_server,AM.username, O.name AS offer_name, DN.name AS news_name, DI.name AS isp_name, C.data_from, C.data_count, C.data_processed,C.data_delivered, C.status FROM campaign C, server S,account_mailer AM, offer O, data_news DN, data_list DL, campaign_data_list CDL, data_isp DI, campaign_server CS WHERE CS.id_server=S.id AND CS.id_campaign=C.id AND CDL.id_campaign=C.id AND DL.id=CDL.id_data_list AND C.id_server_body=S.id AND AM.id={$_SESSION['id-mailer']} AND C.id_mailer={$_SESSION['id-mailer']} AND C.id_offer=O.id AND C.id_news=DN.id AND C.id_isp=DI.id AND (C.date_send BETWEEN '{$_GET["date_from"]}' AND '{$_GET["date_to"]}')$concat");
		  
		/*$query = bd::query("SELECT C.id, C.date_send, S.name AS name_server,AM.username, O.name AS offer_name, DN.name AS news_name, DI.name AS isp_name, C.data_from, C.data_count, C.data_processed, C.status FROM campaign C, server S,account_mailer AM, offer O, data_news DN, data_isp DI WHERE C.id_server=S.id AND C.id_mailer=AM.id AND C.id_offer=O.id AND C.id_news=DN.id AND C.id_isp=DI.id AND (C.date_send BETWEEN '{$_GET["date_from"]}' AND '{$_GET["date_to"]}')$concat");*/
		/*$query = bd::query("SELECT campaign.id, campaign.date_send, campaign.id_offer, campaign.id_news, campaign.id_isp, campaign.data_from, campaign.data_count, campaign.data_sent, campaign.status, offer.name as offer_name, data_news.name as news_name, data_isp.name as isp_name, account_mailer.username FROM campaign, offer, data_news, data_isp, account_mailer WHERE campaign.id_mailer=account_mailer.id && campaign.id_server='{$_SESSION['id-server']}' && campaign.id_offer=offer.id && campaign.id_news=data_news.id && campaign.id_isp=data_isp.id ORDER BY campaign.date_send DESC LIMIT 0,10");*/
		while ($row = mysql_fetch_object($query)) {
			$data[]=$row;
		}
		echo json_encode($data);
	}
	
	
		function show1(){
		  $concat='';
		  		  if($_GET["id_server"]!=0){
			$concat.=" AND C.id_server={$_GET["id_server"]}";
		  }
		  if($_GET["id_mailer"]!=0){
			$concat.=" AND C.id_mailer={$_GET["id_mailer"]}";
		  }
		  if($_GET["id_sponsor"]!=0){
			$concat.=" AND C.id_sponsor={$_GET["id_sponsor"]}";
		  }
		  if($_GET["id_offer"]!=0){
			$concat.=" AND C.id_offer={$_GET["id_offer"]}";
		  }
		  if($_GET["id_news"]!=0){
			$concat.=" AND C.id_news={$_GET["id_news"]}";
		  }
		  if($_GET["id_isp"]!=0){
			$concat.=" AND C.id_isp={$_GET["id_isp"]}";
		  }
		  if($_GET["status"]!="0"){
			$concat.=" AND C.status='{$_GET["status"]}'";
		  }
          $id_dep=$_GET["id_dep"];
		  $concat.=" ORDER BY C.id DESC LIMIT 0,{$_GET['nb_rows']}";
		  
		  $data=array();
		  if($_SESSION['id-mailer']=="2" || $_SESSION['id-mailer']=="4" ){
		  $query = bd::query("SELECT C.id, C.date_send, S.name AS name_server,AM.username, O.name AS offer_name, DN.name AS news_name, DI.name AS isp_name, C.data_from, C.data_count, C.data_processed, C.status FROM campaign C, server S,account_mailer AM, offer O, data_news DN, data_isp DI WHERE C.id_server=S.id AND C.id_mailer=AM.id AND C.id_offer=O.id AND C.id_news=DN.id AND C.id_isp=DI.id AND C.id=$id_dep $concat");  
		  }else 
     	  $query = bd::query("SELECT C.id, C.date_send, S.name AS name_server,AM.username, O.name AS offer_name, DN.name AS news_name, DI.name AS isp_name, C.data_from, C.data_count, C.data_processed, C.status FROM campaign C, server S,account_mailer AM, offer O, data_news DN, data_isp DI WHERE C.id_server=S.id AND AM.id={$_SESSION['id-mailer']} AND C.id_mailer={$_SESSION['id-mailer']} AND C.id_offer=O.id AND C.id_news=DN.id AND C.id_isp=DI.id AND C.id=$id_dep $concat");
		  
		/*$query = bd::query("SELECT C.id, C.date_send, S.name AS name_server,AM.username, O.name AS offer_name, DN.name AS news_name, DI.name AS isp_name, C.data_from, C.data_count, C.data_processed, C.status FROM campaign C, server S,account_mailer AM, offer O, data_news DN, data_isp DI WHERE C.id_server=S.id AND C.id_mailer=AM.id AND C.id_offer=O.id AND C.id_news=DN.id AND C.id_isp=DI.id AND (C.date_send BETWEEN '{$_GET["date_from"]}' AND '{$_GET["date_to"]}')$concat");*/
		/*$query = bd::query("SELECT campaign.id, campaign.date_send, campaign.id_offer, campaign.id_news, campaign.id_isp, campaign.data_from, campaign.data_count, campaign.data_sent, campaign.status, offer.name as offer_name, data_news.name as news_name, data_isp.name as isp_name, account_mailer.username FROM campaign, offer, data_news, data_isp, account_mailer WHERE campaign.id_mailer=account_mailer.id && campaign.id_server='{$_SESSION['id-server']}' && campaign.id_offer=offer.id && campaign.id_news=data_news.id && campaign.id_isp=data_isp.id ORDER BY campaign.date_send DESC LIMIT 0,10");*/
		while ($row = mysql_fetch_object($query)) {
			$data[]=$row;
		}
		echo json_encode($data);
	}
   
   function edit(){
      $data=array();

      $query = bd::query("SELECT * FROM campaign WHERE id='{$_GET["id_campaign"]}'");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }
   
   
      function show_pmta_monitor(){
      $data=array();

      $query = bd::query("SELECT s.main_ip AS main_ip FROM campaign_server c, server s WHERE c.id_campaign='{$_GET["id_campaign"]}' and s.id=c.id_server");
      while ($row = mysql_fetch_object($query)) {
          $data[]=$row;
      }
      echo json_encode($data);
   }

   
   
   function stop_campaign(){
		$id_campaign=$_GET["id_campaign"];
		$campaign_status_file = fopen($_SERVER["DOCUMENT_ROOT"]."/apps/mailer/campaign/instance/campaign_status_".$id_campaign, "w");
		ftruncate($campaign_status_file,0);
		fseek($campaign_status_file,0);
		fwrite($campaign_status_file, 'Stopped');
		fclose($campaign_status_file);

        /*$res=bd::query("select status from campaign where id='{$_GET["id_campaign"]}'");
        $rowstatus= mysql_fetch_array($res);
        if($rowstatus['status']=='Sending'){
            $res = bd::query("UPDATE campaign set status='Stopped' where id='{$_GET["id_campaign"]}'");
            if($res){
                echo "Campaign {$_GET["id_campaign"]} Stopped";
            }else{
                echo "There was an error Stopping your Campaign";
            }
        }else{
            echo "You cannot stop this Campaign! Try again";
        }*/
		
	// $id_campaign = $_GET["id_campaign"];
    // $res = bd::query("select pid from campaign where id='{$id_campaign}'");
    // $row = mysql_fetch_array($res);
    // $pid = $row['pid'];

	// exec('kill ' . $pid, $output, $report);
	// echo $report;
    // if($report != '0')
		// return;
	// $campaign_status_file = fopen($_SERVER["DOCUMENT_ROOT"] . "/apps/mailer/campaign/instance/campaign_status_" . $id_campaign, "w");
	// $campaign_sent_file = fopen($_SERVER["DOCUMENT_ROOT"] . "/apps/mailer/campaign/instance/campaign_sent_" . $id_campaign, "r");
	// $data_processed = trim(fgets($campaign_sent_file));
	// fclose($campaign_sent_file);
	// $res = bd::query("UPDATE campaign set data_processed=$data_processed where id=$id_campaign");
	// ftruncate($campaign_status_file, 0);
	// fseek($campaign_status_file, 0);
	// fwrite($campaign_status_file, 'Stopped');
	// fclose($campaign_status_file);

	$res = bd::query("select status from campaign where id='{$id_campaign}'");
	$rowstatus = mysql_fetch_array($res);
	if ($rowstatus['status'] == 'Sending') {
		$res = bd::query("UPDATE campaign set status='Stopped' where id='{$id_campaign}'");
	}
		
		
   }
   
   function get_real_sent(){
	   $res=bd::query("select status,data_processed from campaign where id='{$_GET["id_campaign"]}'");
	   $rowsent= mysql_fetch_array($res);
	   if($rowsent['status']=='Sending'){
		   $campaign_sent_file = fopen($_SERVER["DOCUMENT_ROOT"]."/apps/mailer/campaign/instance/campaign_sent_".$_GET["id_campaign"], "r");
		   echo trim(fgets($campaign_sent_file));
		   fclose($campaign_sent_file);
	   }else{
		   echo $rowsent['data_processed'];
	   }
   }
   
   function get_real_status(){
       $res=bd::query("select status from campaign where id='{$_GET["id_campaign"]}'");
       $rowstatus= mysql_fetch_array($res);
       echo $rowstatus['status'];
   }

   function RandomPrefix($length){
        $random= "";
        srand((double)microtime()*1000000);
        $data = "bc";
        $data .= "adeijklmnopqrstuvwxyz";
        $data .= "fgh";
        for($i = 0; $i < $length; $i++){
            $random .= substr($data, (rand()%(strlen($data))), 1);
        }
        return $random;
    }


	//////////////// TEST GLOBAL ///////////////////

	function get_vmtas2(){
        $data=array();
        $servers  =   arraykeysToInSqlClause($_GET['server']);
        $query = bd::query("SELECT V.id,V.name,V.address_ip,V.host_name,V.id_mailer,S.id as id_server,S.name as name_server,S.main_ip FROM server_vmta V,server S WHERE S.id=V.id_server and  id_server in $servers && S.active=1 && V.active=1 && V.id_mailer IN (0,{$_SESSION['id-mailer']})");

        while ($row = mysql_fetch_object($query)) {
            $data[]=$row;
        }
        echo json_encode($data);
	}

	function arraykeysToInSqlClause($p_arra_keys){
        $strKeys		=	'';
        foreach($p_arra_keys as $key):
                $strKeys	=	$strKeys.','.$key;
        endforeach;
        $strKeys		=	substr($strKeys,1);
        $strKeys		=	'('.$strKeys.')';
        return $strKeys;
	}

	function get_servers_edit(){
        $data=array();
		$query = bd::query("SELECT id_server FROM campaign_server WHERE id_campaign={$_GET["id_campaign"]}");
		while ($row = mysql_fetch_object($query)) {
			$data[]=$row;
		}
	    echo json_encode($data);
	}

	function get_vmtas_edit(){
        $data=array();
		$query = bd::query("SELECT id_vmta FROM campaign_server_vmta WHERE id_campaign={$_GET["id_campaign"]}");
		while ($row = mysql_fetch_object($query)) {
			$data[]=$row;
		}
	    echo json_encode($data);
	}
	
	

	function get_data_lists_edit(){
        $data=array();
		$query = bd::query("SELECT id_data_list FROM campaign_data_list WHERE id_campaign={$_GET["id_campaign"]}");
		while ($row = mysql_fetch_object($query)) {
			$data[]=$row;
		}
	    echo json_encode($data);
	}



	// function get_mailers(){
        // $data=array();
		// $query = bd::query("SELECT id,username FROM account_mailer WHERE status='Active'");
		// while ($row = mysql_fetch_object($query)) {
			// $data[]=$row;
		// }
	    // echo json_encode($data);
	// }
	
	function get_mailers()
{
	$data = array();
	//	$query = bd::query("SELECT id,username FROM account_mailer WHERE status='Active' AND id={$_SESSION['id-mailer']}");
	//echo $_SESSION['id-mailer']; exit;

	$team_info = $_SESSION["team_info"];

	if ($team_info != "noteam") {
		$team_name = explode(";", $team_info)[1];
	} else {
		$team_name = $team_info; // noteam
	}

	if (($_SESSION['is_admin'] == "Active")  && ($team_name == 'Root')) {
		$query = bd::query("SELECT id,username FROM account_mailer WHERE status='Active'");
	} else if (in_array(intval($_SESSION['id-mailer']), explode(",", $_SESSION["ids_team"]))) {
		$query = bd::query("SELECT id,username FROM account_mailer WHERE status='Active' AND id in (" . $_SESSION["ids_team"] . ")");
	} else { }



	while ($row = mysql_fetch_object($query)) {
		$data[] = $row;
	}
	echo json_encode($data);
}
	

	function stop_process(){
		exec('kill '.$_POST["pid"],$output,$report);
		echo $report;
	}

	function text_encode(){
		echo '=?UTF-8?b?'.base64_encode($_GET["inputtext"]).'=?=';
	}
	
	
		function text_encode1(){
		echo '=?UTF-8?b?'.base64_encode($_GET["inputtext"]).'=?=';
	}


// function get_campaigns_monitor_data()
// {
	// $data = array();
	// $concat = '';
	// $id_mailer = isset($_GET["id_mailer"]) ? $_GET["id_mailer"] : NULL;
	// $query = "";
	// $group_by = "";
	// $team_info = $_SESSION["team_info"];

	  	// if ($team_info != "noteam") {
		// $team_name = explode(";", $team_info)[1];
	// } else {
		// $team_name = $team_info;
	// }

	// if ($id_mailer && $id_mailer != 'all') {
		// $query = "SELECT hour(C.`date_send`) AS hour, count(C.id) AS campaigns_count
			  // FROM `campaign` C
			  // WHERE (C.date_send BETWEEN '{$_GET["date_from"]}' AND '{$_GET["date_to"]}')
			  // AND C.id_mailer={$id_mailer}";

		// $group_by = " GROUP BY hour(C.`date_send`) ORDER BY hour(C.`date_send`) ASC";
	// }
	// else if ($_GET["id_mailer"] == 'all') {
		// $query = "SELECT AM.username AS name_mailer, AM.id AS id_mailer, count(C.id) AS campaigns_count
				  // FROM `campaign` C
				  // JOIN `account_mailer` AM ON C.id_mailer = AM.id
				  // WHERE (C.date_send BETWEEN '{$_GET["date_from"]}' AND '{$_GET["date_to"]}')";

		// $group_by = " GROUP BY C.id_mailer ORDER BY campaigns_count DESC";
	// }
	// else if ($id_mailer == 'all') {
		// $query = "SELECT AM.username AS name_mailer, AM.id AS id_mailer, count(C.id) AS campaigns_count
				  // FROM `campaign` C
				  // JOIN `account_mailer` AM ON C.id_mailer = AM.id
				  // WHERE (C.date_send BETWEEN '{$_GET["date_from"]}' AND '{$_GET["date_to"]}')";

		// $group_by = " GROUP BY C.id_mailer ORDER BY campaigns_count DESC";
	// } else {
		// return;
	// }

	// $query .= $concat .= $group_by;

	// $res = bd::query($query);

	// if ($id_mailer && $id_mailer != 'all') {
		// while ($row = mysql_fetch_object($res)) {
			// array_push($data, array("data" => intval($row->campaigns_count), "hour" => $row->hour . ":00h", "label" => $row->hour . ":00h : " .  intval($row->campaigns_count)));
		// }
	// } else {
		// while ($row = mysql_fetch_object($res)) {
			// array_push($data, array("data" => intval($row->campaigns_count), "id_mailer" => $row->id_mailer, "label" => $row->name_mailer . "(#ID:" . $row->id_mailer . ") : " .  intval($row->campaigns_count)));
		// }
	// }

	// if (count($data) == 0) {
        // array_push($data, array("data" => 0, "id_mailer" => 0, "label" => "Nothing : 0"));
	// }

	// echo json_encode($data);
// }

function get_campaigns_monitor_data()
{
	$data = array();
	$concat = '';
	$id_mailer = isset($_GET["id_mailer"]) ? $_GET["id_mailer"] : NULL;
	$query = "";
	$group_by = "";
	$team_info = $_SESSION["team_info"];

	if ($team_info != "noteam") {
		$team_name = explode(";", $team_info)[1];
	} else {
		$team_name = $team_info; // noteam
	}

	if ($id_mailer && $id_mailer != 'all') {
		$query = "SELECT hour(C.`date_send`) AS hour, count(C.id) AS campaigns_count
			  FROM `campaign` C
			  WHERE (C.date_send BETWEEN '{$_GET["date_from"]}' AND '{$_GET["date_to"]}')
			  AND C.id_mailer={$id_mailer}";

		$group_by = " GROUP BY hour(C.`date_send`) ORDER BY hour(C.`date_send`) ASC";
	}
	else if ($_GET["id_mailer"] == 'all' && ($_SESSION['is_admin'] == "Active") && ($team_name == 'Root')) {
		$query = "SELECT AM.username AS name_mailer, AM.id AS id_mailer, count(C.id) AS campaigns_count
				  FROM `campaign` C
				  JOIN `account_mailer` AM ON C.id_mailer = AM.id
				  WHERE (C.date_send BETWEEN '{$_GET["date_from"]}'{$_GET["date_to"]}')";

		$group_by = " GROUP BY C.id_mailer ORDER BY campaigns_count DESC";
	}
	else if ($id_mailer == 'all' && in_array(intval($_SESSION['id-mailer']), explode(",", $_SESSION["ids_team"]))) {
		//ADD ID MAILER FILTER AND CHANGE GROUP BY TO HOURS INSTEAD  OF MAILER
		$query = "SELECT AM.username AS name_mailer, AM.id AS id_mailer, count(C.id) AS campaigns_count
				  FROM `campaign` C
				  JOIN `account_mailer` AM ON C.id_mailer = AM.id
				  WHERE (C.date_send BETWEEN '{$_GET["date_from"]}'{$_GET["date_to"]}')
				  AND C.id_mailer in (" . $_SESSION['ids_team']  . ")";

		$group_by = " GROUP BY C.id_mailer ORDER BY campaigns_count DESC";
	} else {
		return;
	}

	$query .= $concat .= $group_by;

	$res = bd::query($query);

	if ($id_mailer && $id_mailer != 'all') {
		while ($row = mysql_fetch_object($res)) {
			array_push($data, array("data" => intval($row->campaigns_count), "hour" => $row->hour . ":00h", "label" => $row->hour . ":00h : " .  intval($row->campaigns_count)));
		}
	} else {
		while ($row = mysql_fetch_object($res)) {
			array_push($data, array("data" => intval($row->campaigns_count), "id_mailer" => $row->id_mailer, "label" => $row->name_mailer . "(#ID:" . $row->id_mailer . ") : " .  intval($row->campaigns_count)));
		}
	}

	if (count($data) == 0) {
        array_push($data, array("data" => 0, "id_mailer" => 0, "label" => "Nothing : 0"));
	}

	echo json_encode($data);
}

function get_campaigns_count_by_status()
{
	$data = array();
	$concat = '';
	$id_mailer = isset($_GET["id_mailer"]) ? $_GET["id_mailer"] : NULL;
	// $ids_team_members = isset($_GET["team"]) ? $_GET["team"] : NULL;
	// $id_sponsor = isset($_GET["id_sponsor"]) ? $_GET["id_sponsor"] : NULL;
	// $id_offer = isset($_GET["id_offer"]) ? $_GET["id_offer"] : NULL;
	$team_info = $_SESSION["team_info"];

	if ($team_info != "noteam") {
		$team_name = explode(";", $team_info)[1];
	} else {
		$team_name = $team_info; // noteam
	}

	if ($id_mailer && $id_mailer != 'all') {
		//ADD ID MAILER FILTER AND CHANGE
		$concat .= " AND C.id_mailer={$id_mailer}";
	} else if($_GET["id_mailer"] == 'all' && ($_SESSION['is_admin'] == "Active") && ($team_name == 'Root')) {
		$concat .= "";
    } else if ($id_mailer == 'all' && in_array(intval($_SESSION['id-mailer']), explode(",", $_SESSION["ids_team"]))) {
		$concat .= "AND C.id_mailer in (" . $_SESSION['ids_team']  . ")";
	} else {
		return;
	}

	$concat .= " GROUP BY C.status ORDER BY campaigns_count DESC";
	
	$query = "SELECT C.status, count(C.id) AS campaigns_count
			  FROM `campaign` C
			  WHERE (C.date_send BETWEEN '{$_GET["date_from"]}' AND '{$_GET["date_to"]}')" . $concat;
	
	$res = bd::query($query);
	
	while ($row = mysql_fetch_object($res)) {
		array_push($data, array("data" => intval($row->campaigns_count), "label" => $row->status . " : " . intval($row->campaigns_count)));
	}

	if (count($data) == 0) {
        array_push($data, array("data" => 0, "label" => "Nothing : 0"));
	}

	echo json_encode($data);
}