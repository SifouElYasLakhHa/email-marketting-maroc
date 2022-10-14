<?php 

$header_nbr=$_GET["header_nbr"];
$body_type=$_GET["body_type"];
$header="";
switch ($header_nbr){
	case 1:
           if($body_type==1){
                //$header.="Content-Type: text/html".chr(10);
             //   $header.="Content-Transfer-Encoding: 7bit".chr(10);
           }elseif($body_type==2){
                $header.='Content-Type: multipart/alternative; boundary="----=NextPart-__Uniqid"'.chr(10);
           }
              $header.="Subject: [Subject]".chr(10);
              $header.="From: [FromName] <[FromEmail]>".chr(10);
              $header.="Reply-to: <[ReplyEmail]>".chr(10);
              $header.="To: [To]".chr(10);
              $header.="Content-Type: text/html".chr(10);
              $header.="Date: [SMTPDate]".chr(10);
              $header.="X-Mail-From: [__bounce]".chr(10);
              $header.="From: [__From]".chr(10);
              //  $header.="Subject: [Subject]".chr(10);
              //  $header.="From: __From".chr(10);
              //  $header.="Reply-To: __Reply-To".chr(10);
              //  $header.="To: __To".chr(10);
              //  $header.="Subject: __Subject".chr(10);
              //  $header.="X-Mail-From: __Bounce".chr(10);
              //  $header.="X-RCPT-To: __To".chr(10);
              //  $header.="X-Mailer: __X-Mailer".chr(10);
              //  $header.="Date: __smtpDate".chr(10);
		   
		   
              if($body_type==2){
                     $header.=chr(10);
                     $header.="This is a multi-part message in MIME format.".chr(10);
                     $header.="------=NextPart-__Uniqid".chr(10);
                     $header.='Content-Type: text/plain; charset="iso-8859-1"'.chr(10);
                     $header.="Content-Transfer-Encoding: quoted-printable".chr(10);
                     $header.=chr(10);
                     $header.="__textMessage";
                     $header.=chr(10)."------=NextPart-__Uniqid".chr(10);
                     $header.='Content-Type: text/html; charset="iso-8859-1"'.chr(10);
                     $header.="Content-Transfer-Encoding: quoted-printable".chr(10);
                     $header.=chr(10);
                     $header.="__htmlMessage";
                     $header.=chr(10)."------=NextPart-__Uniqid--".chr(10);	
              }
           break;
       case 2:
           $header.="From: __From".chr(10);
           $header.="To: __To".chr(10);
           $header.="Subject: __Subject".chr(10);
           $header.="MIME-Version: 1.0".chr(10);
           if($body_type==1){
           	$header.='Content-Type: text/html; charset="ISO-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: 7bit".chr(10);
           }elseif($body_type==2){
		   	$header.='Content-Type: multipart/alternative; boundary="----=NextPart-__Uniqid"'.chr(10);
		   }
           $header.="List-Unsubscribe: <mailto:leave-__Chr(__Rand(97,122))__Chr(__Rand(98,122))@__Bounce_dn>".chr(10);
           $header.="Message-Id: <LYRIS-__Chr(__Rand(97,122)).__Chr(__Rand(98,122))-__Date@__Bounce_dn>".chr(10);
           $header.="Return-Path: __Bounce".chr(10);
           $header.="Date: __smtpDate".chr(10);
		   if($body_type==2){
		   	$header.=chr(10);
            $header.="This is a multi-part message in MIME format.".chr(10);
           	$header.="------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/plain; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__textMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/html; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__htmlMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid--".chr(10);	
           }
           break;
    case 3:
           $header.="Reply-To: __Reply-To".chr(10);
           $header.="Bounces_to: __Bounce".chr(10);
           $header.="Message-ID: <__Chr(__Rand(97,122))__Chr(__Rand(98,122)).__X-Mailer@__From_dn>".chr(10);
           $header.="X-BFI: __Chr(__Rand(97,122))__Chr(__Rand(98,122))".chr(10);
           $header.="From: __From".chr(10);
           $header.="Subject: __Subject".chr(10);
           $header.="To: __To".chr(10);
           $header.="MIME-Version: 1.0".chr(10);
           if($body_type==1){
           	$header.='Content-Type: text/html; charset="ISO-8859-1"'.chr(10);
           }elseif($body_type==2){
		   	$header.='Content-Type: multipart/alternative; boundary="----=NextPart-__Uniqid"'.chr(10);
		   }
           $header.="Return-Path: __Bounce".chr(10);
           $header.="Date: __smtpDate".chr(10);
		   if($body_type==2){
		   	$header.=chr(10);
            $header.="This is a multi-part message in MIME format.".chr(10);
           	$header.="------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/plain; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__textMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/html; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__htmlMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid--".chr(10);	
           }
           break;
    case 4:
           $header.="Message-ID: <__Rand(10,100).__Rand(10,100).0.__Rand(1000,9999).__Chr(__Rand(97,122))__Chr(__Rand(98,122))@__X-Mailer>".chr(10);
           if($body_type==1){
           	$header.='Content-Type: text/html; charset="ISO-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: 8bit".chr(10);
           }elseif($body_type==2){
		   	$header.='Content-Type: multipart/alternative; boundary="----=NextPart-__Uniqid"'.chr(10);
		   }
           $header.="To: __To".chr(10);
           $header.="From: __From".chr(10);
           $header.="Sender: __From_nm@__From_dn".chr(10);
           $header.="X-Loop: __From_nm@__From_dn".chr(10);
           $header.="X-Mailer: __X-Mailer".chr(10);
           $header.="X-Unsubscribe: <mailto:leave-__Rand(10000,100000).-.__Rand(10000,100000).__Chr(__Rand(97,122))__Chr(__Rand(98,122))@__From_dn>".chr(10);
           $header.="X_Id: __Chr(__Rand(97,122)).__Chr(__Rand(97,122)):__Date:__To/__Chr(__Rand(98,122))__Chr(__Rand(99,122))".chr(10);
           $header.="Subject: __Subject".chr(10);
           $header.="Return-Path: __Chr(__Rand(97,122))__Chr(__Rand(98,122))@__Bounce_dn".chr(10);
           $header.="Date: __smtpDate".chr(10);
		   if($body_type==2){
		   	$header.=chr(10);
            $header.="This is a multi-part message in MIME format.".chr(10);
           	$header.="------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/plain; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__textMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/html; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__htmlMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid--".chr(10);	
           }
           break;
   case 5:
   	       $header.="Subject: __Subject".chr(10);
           $header.="From: __From".chr(10);       
           $header.="Reply-To: <__Reply-To>".chr(10);
           $header.="To: __To".chr(10);     
           $header.="xprior: Low".chr(10);  
           $header.="msprior: Normal".chr(10); 
           $header.="xdelay: 150000".chr(10); 
           $header.="xmailer: __X-Mailer".chr(10);
           if($body_type==1){
           	$header.="Content-Type: text/html; charset=us-ascii;\r\nContent-Disposition: inline".chr(10);
           }elseif($body_type==2){
		   	$header.='Content-Type: multipart/alternative; boundary="----=NextPart-__Uniqid"'.chr(10);
		   }
           $header.="Date: __smtpDate".chr(10);
		   if($body_type==2){
		   	$header.=chr(10);
            $header.="This is a multi-part message in MIME format.".chr(10);
           	$header.="------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/plain; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__textMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/html; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__htmlMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid--".chr(10);	
           }
           break;
   case 6:
    	   $header.="Message-ID: <29986454.1180728024697.__X-Mailer@__From_dn>".chr(10);
           $header.="From: __From".chr(10);
           $header.="Reply-To: __Reply-To".chr(10);
           $header.="To: __To".chr(10);
           $header.="Subject: __Subject".chr(10);
           $header.="Mime-Version: 1.0".chr(10);
           if($body_type==1){
           	$header.='Content-Type: text/html; charset="ISO-8859-1"'.chr(10);
           }elseif($body_type==2){
		   	$header.='Content-Type: multipart/alternative; boundary="----=NextPart-__Uniqid"'.chr(10);
		   }
           $header.="x-mid: __Rand(100000,999999)".chr(10);
           $header.="Return-Path: __Bounce".chr(10);
           $header.="Date: __smtpDate".chr(10);
		   if($body_type==2){
		   	$header.=chr(10);
            $header.="This is a multi-part message in MIME format.".chr(10);
           	$header.="------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/plain; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__textMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/html; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__htmlMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid--".chr(10);	
           }
           break;
   case 7 :
   		   $header.="Date: __smtpDate".chr(10);
           $header.="Subject: __Subject".chr(10);
           $header.="From: __From".chr(10);
           $header.="Reply-to: __Reply-To".chr(10);
           $header.="To: __To".chr(10);
           $header.="X-Mailer: __X-Mailer".chr(10);
           $header.="MIME-Version: 1.0".chr(10);
           if($body_type==1){
           	$header.="Content-Type: text/html; charset=us-ascii;\r\nContent-Disposition: inline".chr(10);
           }elseif($body_type==2){
		   	$header.='Content-Type: multipart/alternative; boundary="----=NextPart-__Uniqid"'.chr(10);
		   }
		   if($body_type==2){
		   	$header.=chr(10);
            $header.="This is a multi-part message in MIME format.".chr(10);
           	$header.="------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/plain; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__textMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/html; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__htmlMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid--".chr(10);	
           }
            break;

        case 8 :
                        $header.="X-Mailer: PHPMailer [version 1.73]".chr(10);
                        $header.="X-Mailer: phplist v2.11.3".chr(10);
                        $header.="From: __From".chr(10);
                        $header.="Precedence: bulk".chr(10);
                        $header.="MIME-Version: 1.0".chr(10);
                        $header.="List-Unsubscribe: <mailto:listunsub@__Bounce_dn>".chr(10);
                        $header.="To: *!me@gmail-smpt-out".chr(10);
                        $header.="Subject: __Subject".chr(10);
			#$header.="mail from: bnc_dn@jae3.info.co8".chr(10);
                        $header.="In-Reply-To: __To".chr(10);
                        $header.="References: __To".chr(10);
                        $header.="X-ListMember: __To".chr(10);

                        $header.="X-Abuse-Reports-To: abuse@__Bounce_dn".chr(10);

            break;

  default :
           $header.="Subject: __Subject".chr(10);
           $header.="From: __From".chr(10);
           $header.="Reply-to: <__Reply-To>".chr(10);
           $header.="To: __To".chr(10);
           $header.="X-Originating-IP: __Ip".chr(10);  
           if($body_type==1){
           	$header.="Content-Type: text/html; charset=us-ascii;\r\nContent-Disposition: inline".chr(10);
           }elseif($body_type==2){
		   	$header.='Content-Type: multipart/alternative; boundary="----=NextPart-__Uniqid"'.chr(10);
		   }
           $header.="Date: __smtpDate".chr(10);
		   if($body_type==2){
		   	$header.=chr(10);
            $header.="This is a multi-part message in MIME format.".chr(10);
           	$header.="------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/plain; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__textMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid".chr(10);
           	$header.='Content-Type: text/html; charset="iso-8859-1"'.chr(10);
           	$header.="Content-Transfer-Encoding: quoted-printable".chr(10);
           	$header.=chr(10);
           	$header.="__htmlMessage";
           	$header.=chr(10)."------=NextPart-__Uniqid--".chr(10);	
           }
           break;
        }
        
        echo $header;
      
