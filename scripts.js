$(document).ready(function(){
    //get_header_format();
    razmessage();
    razadvanced();

    $("#advanced_setting_btn").click(function(){
        $("#advanced_setting_panel").slideToggle();
    });
    
    $("#additional_body").click(function(){
        var myWindow = window.open("", "MsgWindow", "width=500, height=700");
        myWindow.document.write("<textarea rows='20' cols='10' id='html_additional_body' name='html_additional_body'></textarea>");
        
    });
	
	
	
	 $('#store_campaign').click(function (e) {
        e.preventDefault();
        var sponsor_id = $('#sponsor').val();
        var offer_id = $('#offer').val();

        if (sponsor_id == '0' || offer_id == '0') {
            $('#message_sponosor_offer').show();
            $('#message_sponosor_offer').fadeOut(3000);
            return false;
        }

        $('#processing_campaing').show();

        // Get header info
        var from_name = $('#from_name').val();
        var subject = $('#subject').val();
        var from_email = $('#from_email').val();
        var reply_email = $('#reply_email').val();
        var bounce_email = $('#bounce_email').val();
        var return_path = $('#return_path').val();
        var received = $('#received').val();
        var xmailer = $('#xmailer').val();
        var header_nbr = $('#header_nbr').val();
        var header_format = $('#header_format').val();
        var server_body = $('#server_body').val();
        var domain_body = $('#domain_body').val();
        var redirect_type = $('#redirect_type').val();
        var open_tracker = $('input:radio[name=open_tracker]:checked').val();
        var body_type = $('input:radio[name=body_type]:checked').val();

        // Get Creative info
        var text_body = $("#text_body").val();
        var html_body = $("#html_body").val();
        var new_tags = $("#new_tags").val();

        // Get selected server & vmta

        var selected_servers = [];
        var selected_vmtas = [];

        $('#server option:selected').each(function () {
            selected_servers.push($(this).val());
        });

        $('#vmta option:selected').each(function () {
            selected_vmtas.push($(this).val());
        });


        // Get Data info
        var id_news = $('#news').val();
        var id_isp = $('#isp').val();

        // Test & Data interval
        var test_emails_to = $("#test_emails_to").val();
        var test_period = $("#test_period").val();
        var xdelay = $("#xdelay").val();
        var change_ip = $("#change_ip").val();
        var data_from = $("#data_from").val();
        var data_count = $("#data_count").val();

        $.ajax({
            url: 'scripts.php?action=store_campaign',
            type: 'post',
            data: {
                sponsor_id: sponsor_id,
                offer_id: offer_id,
                from_name: from_name,
                subject: subject,
                from_email: from_email,
                reply_email: reply_email,
                bounce_email: bounce_email,
                return_path: return_path,
                received: received,
                xmailer: xmailer,
                header_nbr: header_nbr,
                header_format: header_format,
                server_body: server_body,
                domain_body: domain_body,
                redirect_type: redirect_type,
                open_tracker: open_tracker,
                body_type: body_type,
                text_body: text_body,
                html_body: html_body,
                new_tags: new_tags,
                servers: selected_servers,
                vmtas: selected_vmtas,
                id_news: id_news,
                id_isp: id_isp,
                test_emails_to: test_emails_to,
                test_period: test_period,
                xdelay: xdelay,
                change_ip: change_ip,
                data_from: data_from,
                data_count: data_count

            },
            success: function (data) {
                $('#message_success_sponsor_offer_store').show();
                $('#message_success_sponsor_offer_store').fadeOut(3000);
                $('#processing_campaing').hide();
            },
            error: function () {
                $('#message_error_sponsor_offer').show();
                $('#message_error_sponsor_offer').fadeOut(3000);
                $('#processing_campaing').hide();
            }

        });


    });

    $('#load_campaign').click(function (e) {
        e.preventDefault();

        var sponsor_id = $('#sponsor').val();
        var offer_id = $('#offer').val();

        if (sponsor_id == '0' || offer_id == '0') {
            $('#message_sponosor_offer').show();
            $('#message_sponosor_offer').fadeOut(3000);
            return false;
        }

        $('#processing_campaing').show();

        $.ajax({
            url: 'scripts.php?action=load_campaign',
            type: 'post',
            data: {
                sponsor_id: sponsor_id,
                offer_id: offer_id
            },
            success: function (data) {
                var list = JSON.parse(data);

                $("#from_name").val(list.from_name);
                $("#subject").val(list.subject);
                $("#from_email").val(list.from_email);
                $("#reply_email").val(list.reply_email);
                $("#bounce_email").val(list.bounce_email);
                $("#return_path").val(list.return_path);
                $("#received").val(list.received);
                $("#xmailer").val(list.xmailer).change();
                $("#header_nbr").val(list.header_nbr);
                $("#header_format").val(list.header_format);

                select_server_body(list.server_body);
                select_domain_body_edit(list.server_body, list.domain_body);

                $("#redirect_type").val(list.redirect_type).change();
                $("#redirect_type > option[value=" + list.redirect_type + "]").prop("selected", true);
                $('input:radio[name=open_tracker][value=' + list.open_tracker + ']').attr('checked', true);
                $('input:radio[name=body_type][value=' + list.body_type + ']').attr('checked', true);
                if (list.body_type == 0) body1();
                if (list.body_type == 1) body2();
                if (list.body_type == 2) body3();
                $("#text_body").text(list.text_body);
                $("#html_body").text(list.html_body);
                $("#new_tags").text(list.new_tags);

                // select servers & vmta

                $("#server").val(list.servers).change();

                if (list.vmtas == null) {
                    list.vmtas = [];
                }

                alert("Loaded!");

                for (var i = 0; i < list.vmtas.length; i++) {
                    $("#vmta option[value='" + list.vmtas[i] + "']").prop("selected", true);
                }

                $("#news").val(list.id_news).change();
                $("#isp").val(list.id_isp).change();

                $("#test_emails_to").val(list.test_emails_to);
                $("#test_period").val(list.test_period);
                $("#xdelay").val(list.xdelay);
                $("#change_ip").val(list.change_ip);
                $("#data_from").val(list.data_from);
                $("#data_count").val(list.data_count);

                $('#message_success_sponsor_offer_load').show();
                $('#message_success_sponsor_offer_load').fadeOut(3000);
                $('#processing_campaing').hide();
            },
            error: function () {
                $('#message_error_sponsor_offer').show();
                $('#message_error_sponsor_offer').fadeOut(3000);
                $('#processing_campaing').hide();
            }

        });


    });
	
	
	
	


	$("#search_vmta_type_all").click(function(){
		search_vmta_type();
	});
	$("#search_vmta_type_valid").click(function(){
		search_vmta_type();
	});
	$("#search_vmta_type_fake").click(function(){
		search_vmta_type();
	});

	$("#repeat_negative").prop('disabled', true);
	$("#repeat_negative_btn").prop('disabled', true);
	$("#additional_negative").prop('disabled', true);
	
	$("#additional_negative_active_no").change(function(){
		$("#repeat_negative").prop('disabled', true);
		$("#repeat_negative_btn").prop('disabled', true);
		$("#additional_negative").prop('disabled', true);
	});
	$("#additional_negative_active_yes").change(function(){
		$("#repeat_negative").prop('disabled', false);
		$("#repeat_negative_btn").prop('disabled', false);
		$("#additional_negative").prop('disabled', false);
	});

	$("#test_multiple_values").prop('disabled', true);
	$("#send_rotate_values").prop('disabled', true);
	$("#send_multiple_values").prop('disabled', true);
	$("#astuce_tag_email_address").prop('disabled', true);

	$("#astuce_tag_active_no").change(function(){
		$("#astuce_tag_email_address").prop('disabled', true);
	});
	$("#astuce_tag_active_yes").change(function(){
		$("#astuce_tag_email_address").prop('disabled', false);
	});
	
	
	    $("#upload_headers").change(function (e) {
        var myfiles = document.getElementById("upload_headers");
        var files = myfiles.files;
        var data = new FormData();
        $("#loadedfiles").empty();
        $("#loading").show();
        $("#loadedfiles").hide();
        $("#test_multiple_values").empty();

        for (i = 0; i < files.length; i++) {
            data.append('file' + i, files[i]);
        }


        $.ajax({
            url: 'scripts.php?action=loadedfiles&type=test',
            type: 'POST',
            contentType: false,
            data: data,
            processData: false,
            cache: false
        }).done(function (data) {
            var json_obj = $.parseJSON(data);
            $("#loadedfiles").append(json_obj.html[0]);
            $("#test_multiple_values").val(json_obj.names);
            $("#loading").hide();
            $("#loadedfiles").show();

        });
    });
	
	    $("#upload_headers_send").change(function (e) {
        var myfiles = document.getElementById("upload_headers_send");
        var files = myfiles.files;
        var data = new FormData();
        $("#loadedfiles_send").empty();
        $("#loading_send_headers").show();
        $("#loadedfiles_send").hide();
        $("#send_multiple_values").empty();

        for (i = 0; i < files.length; i++) {
            data.append('file' + i, files[i]);
        }

        $.ajax({
            url: 'scripts.php?action=loadedfiles&type=send',
            type: 'POST',
            contentType: false,
            data: data,
            processData: false,
            cache: false
        }).done(function (data) {
            var json_obj = $.parseJSON(data);
            $("#loadedfiles_send").append(json_obj.html[0]);
            $("#send_multiple_values").val(json_obj.names);
            $("#loading_send_headers").hide();
            $("#loadedfiles_send").show();

        });
    });

	
	    $("#upload_negative").change(function (e) {

        var file_data = $('#upload_negative').prop('files')[0];
        var form_data = new FormData();

        form_data.append('file', file_data);

        $.ajax({
            url: 'scripts.php?action=upload_negative',
            type: 'POST',
            contentType: false,
            data: form_data,
            processData: false,
            cache: false,
            beforeSend: function () {
                $("#loading_negative").show();
            },
            success: function (data) {
                //var json_obj = $.parseJSON(data);
                $("#loading_negative").hide();
                $("#message_success_upload_negative").show();
                $("#message_success_upload_negative").fadeOut(3000);
            }
        });
    });

});


    var handleQuickNavs = function ()
    {
        if ($('.quick-nav').length > 0) 
        {
            var stretchyNavs = $('.quick-nav');
            
            stretchyNavs.each(function () 
            {
                var stretchyNav = $(this), stretchyNavTrigger = stretchyNav.find('.quick-nav-trigger');

                stretchyNavTrigger.on('click', function (event) {
                    event.preventDefault();
                    stretchyNav.toggleClass('nav-is-visible');
                });
            });

            $(document).on('click', function (event) 
            {
                (!$(event.target).is('.quick-nav-trigger') && !$(event.target).is('.quick-nav-trigger span')) && stretchyNavs.removeClass('nav-is-visible');
            });
        }
    };




    $('.charset_input').change(function () {

        var charset = $(this).val();

        if (charset == 'utf-8') {
            $(this).siblings('.encoding_input').removeAttr('disabled');
        }
        else {
            $(this).siblings('.encoding_input').val("0").change();
            $(this).siblings('.encoding_input').attr('disabled', 'disabled');
        }

    });
	



	function exchange_vmtas() {

    var selected_vmtas = [];

    $("#vmta option:selected").each(function () {
        selected_vmtas.push($(this).val());
    });

    $("#vmta option").prop("selected", true);

    $("#vmta option").each(function () {
        if ($.inArray($(this).val(), selected_vmtas) > -1) {
            $("#vmta option[value='" + $(this).val() + "']").prop('selected', false);
        }
    });

    vmta_select_count();
}


function get_list_negatives() {
    var html = "<option value='0'> Select here ...</option>";
    $.ajax({
        url: 'scripts.php?action=list_negatives',
        type: 'get',
        success: function (data) {
            var list = JSON.parse(data);
            for (var i = 0; i < list.length; i++) {
                html += "<option value='" + list[i] + "'>" + list[i] + "</option>";
            }
            $("#archive_negatives").html(html);
        }
    });
}


function haloo(){
    $.ajax({
        url: 'scripts.php?action=comment',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            for (var i = 0; i < list.length; i++) {
               
				$li="<i class='icon-warning-sign'></i> "+list[i].message;
$.toast.success({
	animate: 'slide',
	autoclose: true,
	closeBtn: true,
	style: 'warn',
	text: $li
});	

    } 

        }
    });
}


function show_pmtas_servers() {
    var selected = [];
    $('#server option:selected').each(function () {
        selected.push($(this).attr('data-ip') + ":" + $(this).text());
    });
    if (selected.length) {
        window.open("../pmta/show_pmtas.php?servers=" + selected.join(","), '_blank');
    }
    else {
        alert("Please select any Server");
    }
}

// function show_pmtas_servers() {
    // var selected = [];
    // var ip, server, server_info;

    // $('#server option:selected').each(function () {

        // server_info = $(this).val();
        // ip = server_info[0];
        // server_name = $(this).text();
        // selected.push(ip + ":" + server_name);
    // });

    // selected = unique(selected);


    // if (selected.length) {
        // window.open("../pmta/show_pmtas.php?servers=" + selected.join(","), '_blank');
    // }
    // else {
        // alert("Please select any Vmta");
    // }
// }



function unique(list) {
    var result = [];
    $.each(list, function (i, e) {
        if ($.inArray(e, result) == -1) result.push(e);
    });
    return result;
}


function show_pmtas_vmtas() {
    var selected = [];
    var ip, server, server_info;

    $('#vmta option:selected').each(function () {

        server_info = $(this).val().split(";");
        ip = server_info[0];
        server_name = server_info[6];
        selected.push(ip + ":" + server_name);
    });

    selected = unique(selected);


    if (selected.length) {
        window.open("../pmta/show_pmtas.php?servers=" + selected.join(","), '_blank');
    }
    else {
        alert("Please select any Vmta");
    }
}




function razmessage(){
  $("#fspinner").hide();
  $("#message-warning").hide();
  $("#message-warning1").hide();
  $("#message-warning2").hide();
  $("#message-warning3").hide();
  $("#message-warning-custom").hide();
  $("#message-done-custom").hide();
  $("#message-warning-custom-2").hide();
  $("#message-error").hide();
  $("#message-error1").hide();
  $("#message-success").hide();
  
  $("#message-warning-vmta").hide();
  $("#message-warning-custom-vmta").hide();
  $("#message-error-vmta").hide();
  $("#message-success-vmta").hide();
}


function close_message_warning(){
    $("#message-warning").slideUp("slow");
	    $("#message-warning1").slideUp("slow");
			    $("#message-warning2").slideUp("slow");
							    $("#message-warning3").slideUp("slow");
}

function close_message_warning_custom(){
    $("#message-warning-custom").slideUp("slow");
}

function close_message_done_custom(){
    $("#message-done-custom").slideUp("slow");
}

function close_message_warning_custom_2(){
    $("#message-warning-custom-2").slideUp("slow");
}

function close_message_error(){
    $("#message-error").slideUp("slow");
	    $("#message-error1").slideUp("slow");
}

function close_message_success(){
    $("#message-success").slideUp("slow");
}

function close_message_warning_vmta(){
    $("#message-warning-vmta").slideUp("slow");
}

function close_message_warning_custom_vmta(){
    $("#message-warning-custom-vmta").slideUp("slow");
}

function close_message_error_vmta(){
    $("#message-error-vmta").slideUp("slow");
}

function close_message_success_vmta(){
    $("#message-success-vmta").slideUp("slow");
}

function processing_show(){
    $("#processing").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%;'>&nbsp;&nbsp;Processing...&nbsp;&nbsp;</div></div>");
    $("#processing").show();
}

function processing_hide(){
    $("#processing").hide();
}

function processing_show1(){
    $("#processing1").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%;'>&nbsp;&nbsp;Processing...&nbsp;&nbsp;</div></div>");
    $("#processing1").show();
}



function processing_hide1(){
    $("#processing1").hide();
}


function processing_show2(){
    $("#processing2").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%;'>&nbsp;&nbsp;Processing...&nbsp;&nbsp;</div></div>");
    $("#processing2").show();
}



function processing_hide2(){
    $("#processing2").hide();
}

function processing_show_vmta(){
    $("#processing_vmta").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%;'>&nbsp;&nbsp;Processing...&nbsp;&nbsp;</div></div>");
    $("#processing_vmta").show();
}

function processing_hide_vmta(){
    $("#processing_vmta").hide();
}

function razadvanced(){
    $("#advanced_setting_panel").hide();
}

function razbody(){
    $("#source_text").hide();
    $("#source_html").hide(); 
}

function body1(){ 
     razbody();
     $("#source_text").fadeIn(); 
}
function body2(){ 
     razbody();
     $("#source_html").fadeIn(); 
}
function body3(){ 
     razbody();
     $("#source_text").fadeIn();   
     $("#source_html").fadeIn(); 
}




function formatBytes(bytes) {
    if(bytes < 1024) return bytes + " Bytes";
    else if(bytes < 1048576) return(bytes / 1024).toFixed(3) + " KB";
    else if(bytes < 1073741824) return(bytes / 1048576).toFixed(3) + " MB";
    else return(bytes / 1073741824).toFixed(3) + " GB";
}

function calculate_negative_size(){
    var negative=$("#additional_negative").val();
    var count=$("#repeat_negative").val();
    if(count>0){
        var bytes=negative.length;
        $("#size_result").text(formatBytes(bytes*count));
    }else{
        $("#size_result").text('Incorrect number');
    }
}


function check_test_multiple_type(){
	if($("#test_multiple_type_none").is(':checked')){
		$("#test_multiple_values").prop('disabled', true);
	}else{
		$("#test_multiple_values").prop('disabled', false);
	}
}

function check_header_enable_test() {
    if ($("#test_multiple_type_none").is(':checked')) {
        $("#tag_upload_headers").hide();
        $("#test_multiple_values").prop('disabled', true);
    } else {
        $("#tag_upload_headers").show();
        $("#test_multiple_values").prop('disabled', false);
    }
}

function check_header_enable_send() {
    if ($("#send_multiple_type_none").is(':checked')) {
        $("#tag_upload_headers_send").hide();
        $("#send_multiple_values").prop('disabled', true);
    } else {
        $("#tag_upload_headers_send").show();
        $("#send_rotate_values").prop('disabled', false);
        $("#send_multiple_values").prop('disabled', false);
    }
}

function check_send_multiple_type(){
	if($("#send_multiple_type_none").is(':checked')){
		$("#send_rotate_values").prop('disabled', true);
		$("#send_multiple_values").prop('disabled', true);
	}else{
		$("#send_rotate_values").prop('disabled', false);
		$("#send_multiple_values").prop('disabled', false);
	}
}

function copy_link1(){
    $("#offer_page").focus().select();
	var input  = document.getElementById("offer_page");
	input.select();
    document.execCommand("copy");
}

function copy_link2(){
    $("#offer_unsubscribe").focus().select();
		     var input  = document.getElementById("offer_unsubscribe");
	   input.select();
       document.execCommand("copy");
}

function copy_link3(){
    $("#server_unsubscribe").focus().select();
			     var input  = document.getElementById("server_unsubscribe");
	   input.select();
       document.execCommand("copy");
}

function check_data(){
   if(document.getElementById("sponsor").value==="0")return false;
   if(document.getElementById("offer").value==="0")return false;
   if(document.getElementById("server").value==="0")return false;
   if(document.getElementById("domain_body").value==="0")return false;
   return true;
}



function update_list_count(){
	// var e = document.getElementById("country");
    // var st = e.options[e.selectedIndex].text;
	var st = document.getElementById("country").value;
	
	// alert(st);
	
	var checkedValue = document.querySelector('.checkbox1:checked').value;
	if(checkedValue==""){
	}else{
	processing_show2();	
	}
	
	// processing_show();
    $.ajax({
        url: 'scripts.php?action=update_list_count',
        type: 'get',
		data: {
            id_data_list: document.querySelector('.checkbox1:checked').value,
			country: st
        },
        success: function(data) {
			
			var str=data.replace(/(\r\n|\n|\r)/gm,"");
		
			
			if(str.indexOf('0') > -1){ 
			show_data_lists();

			}
			
			if(str.indexOf('1') > -1){ 
			show_data_lists();

			}
			processing_hide2();
			// refresh();
			
		},
		error: function() {
			$("#message-error").slideDown("slow");
			setTimeout(function(){close_message_error();},3000);
			// processing_show();
		}
    });

}



   function save_offer(){

      if(document.getElementById("offer").value==0){
	  $("#message-custom").text("Please select offer to save!");
      $("#message-warning-custom").slideDown("slow");
      setTimeout(function(){close_message_warning_custom();},3000);
		  
	  }else
      document.getElementById("sendform").action = "scripts.php?action=save_offer";
      document.forms["sendform"].submit();
	  $("#message-custom1").text("offer has been saved successfully");
      $("#message-done-custom").slideDown("slow");
      setTimeout(function(){close_message_done_custom();},3000);
	 

}

function load_offer(){
    processing_show();
    $.ajax({
        url: 'scripts.php?action=edit_offer',
        type: 'get',
        data: {
            id_offer: document.getElementById("offer").value,
        },
        success: function(data) {
			processing_hide();
            var list = JSON.parse(data);
            if(list.length==0){
                $("#message-custom").text("You don't have save this offer before!");
                $("#message-warning-custom").slideDown("slow");
                setTimeout(function(){close_message_warning_custom();},3000);
            }else{
                $("#from_name").val(list[0].from_name);
                $("#subject").val(list[0].subject);
				$("#test_emails_to").val(list[0].test_emails_to);
                $("#from_email").val(list[0].from_email);
                $("#reply_email").val(list[0].reply_email);
                $("#bounce_email").val(list[0].bounce_email);
                $("#return_path").val(list[0].return_path);
                $("#received").val(list[0].received);
                $("#xmailer").val(list[0].xmailer);
                $("#header_nbr").val(list[0].header_nbr);
                $("#header_format").val(list[0].header_format);
                select_server_body(list[0].id_server_body);
				select_domain_body_edit(list[0].id_server_body,list[0].domain_body);
                $("#redirect_type").val(list[0].redirect_type);
                $('input:radio[name=open_tracker][value='+list[0].open_tracker+']').attr('checked', true);
                $('input:radio[name=body_type][value='+list[0].body_type+']').attr('checked', true);
                if(list[0].body_type==0)body1();
                if(list[0].body_type==1)body2();
                if(list[0].body_type==2)body3();
                $("#text-encoder-input").text(list[0].text_body);
                $("#html_body").text(list[0].html_body);
				show_servers_edit(id);

                select_sponsor(list[0].id_sponsor);
                select_offer(list[0].id_offer,list[0].id_sponsor);

                select_news(id,list[0].id_news);
                select_isp(id,list[0].id_isp);
                //show_data_lists_edit(id);
				//show_data_lists();

                $("#test_emails_to").val(list[0].test_emails_to);
                $("#test_period").val(list[0].test_period);
                $("#xdelay").val(list[0].xdelay);
                $("#change_ip").val(list[0].change_ip);
                $("#data_from").val((+list[0].data_sent) + (+list[0].data_from) + (+1));
                $("#data_count").val((+list[0].data_count) - (+list[0].data_sent)); 
            }   
            processing_hide();
        },
        error: function() {
            $("#message-error").slideDown("slow");
            processing_hide();
        }
    });
}



function create_redirect(){
    if(check_data()){

        $.ajax({
            url: 'scripts.php?action=create_redirect',
            type: 'post',
            data: {
                id_sponsor: document.getElementById("sponsor").value,
                id_offer: document.getElementById("offer").value,
                id_server: document.getElementById("server").value,
                domain : document.getElementById("domain_body").value,
            },
            success: function(data) {
                var str=data.replace(/(\r\n|\n|\r)/gm,"");
                if(str==="1"){ 
                    $("#message-error1").slideDown("slow");
                    setTimeout(function(){close_message_error();},3000);
                }else{
                    str=str.split('|');
                    $("#offer_page").val(str[0].replace("	",""));
                    $("#offer_unsubscribe").val(str[1]);
                    $("#server_unsubscribe").val(str[2]);
                    $("#message-success").slideDown("slow");
                    setTimeout(function(){close_message_success();},3000);
     
                }
                processing_hide();
            },
            error: function() {
                $("#message-error1").slideDown("slow");
                setTimeout(function(){close_message_error();},3000);
            }
            
        }); 
    }else{
        $("#message-warning1").slideDown("slow");
        setTimeout(function(){close_message_warning();},3000);
    }
}


function subject_from_vide(){
//var kh="";
//$("#text_get_from").text(kh);
}


   function show_subject_from(){
	    $("#message-warning2").hide();
	   processing_show1();
    $.ajax({
        url: 'scripts.php?action=get_subject_from',
        type: 'get',
        data: {
            id_offer: document.getElementById('offer').value
        },
        success: function(data) {
			
			// document.getElementById("from_name").value="sdsd";
            var list = JSON.parse(data);
             if(list.length==0){
				 $("#text_get_from").prop('disabled', true);
				  $("#message-warning2").slideDown("slow");
				          setTimeout(function(){close_message_warning();},3000);
				 processing_hide1();
            }else{
				$("#text_get_from").prop('disabled', false);
				$("#text_get_from").text(list[0].froms);
				processing_hide1();
            }   
			
        }
    });
}





   function show_subject_from1(){
	   	    $("#message-warning3").hide();
	   processing_show2();
	   
    $.ajax({
        url: 'scripts.php?action=get_subject_from',
        type: 'get',
        data: {
            id_offer: document.getElementById('offer').value
        },
        success: function(data) {
            var list = JSON.parse(data);
             if(list.length==0){
				$("#text_get_subject").prop('disabled', true);
				  $("#message-warning3").slideDown("slow");
				          setTimeout(function(){close_message_warning();},3000);  
				 processing_hide2();
            }else{
				$("#text_get_subject").prop('disabled', false);
                $("#text_get_subject").text(list[0].subjects);
				processing_hide2();
            }   
			
        }
    });
}


function Collapsible(){
  
  if($("#Collapsible1").hasClass('icon-chevron-down icon-white refresh')){

	    $("#Collapsible").slideUp();
		$("#Collapsible1").addClass('icon-chevron-up icon-white refresh');
        $("#Collapsible1").removeClass('icon-chevron-down icon-white refresh').addClass('icon-chevron-up icon-white refresh');
	  
  }else{
	  
	  $("#Collapsible").slideDown();
	  $("#Collapsible1").addClass('icon-chevron-down icon-white refresh');
	          $("#Collapsible1").removeClass('icon-chevron-up icon-white refresh').addClass('icon-chevron-down icon-white refresh');
  }
}



 
function moreFields(){

	var x=document.getElementById("data_from").value;
	var regex=/^[a-zA-Z]+$/;
    if (!x.match(regex))
    {
	$("#data_count").prop('disabled', false);
    }
	    if (x=="")
    {
	$("#data_count").prop('disabled', true);
	document.getElementById("data_count").value="";
    }
	}
	



function GetSelectedText () {
var selText = "";
if (window.getSelection) {  // all browsers, except IE before version 9
if (document.activeElement && 
(document.activeElement.tagName.toLowerCase () == "textarea" || 
document.activeElement.tagName.toLowerCase () == "input")) 
{
var text = document.activeElement.value;
selText = text.substring (document.activeElement.selectionStart, 
document.activeElement.selectionEnd);
}
else {
var selRange = window.getSelection ();
selText = selRange.toString ();
}} 
return selText;
}
function OnSelectInput (input) {
            selText = GetSelectedText ();
         document.getElementById("from_name").value = selText;
        }
		
		function OnSelectInput1 (input) {
            selText = GetSelectedText ();
         document.getElementById("subject").value = selText;
        }

		
		

function get_header_format(){
    $("#header_format").text("");
    $("#header_format").text("Waiting for extracting Headers Format...");         
    $.ajax({
        url: 'header_format.php',
        type: 'get',
        data: {
            header_nbr: document.getElementById('header_nbr').value,
            body_type: '1'
        },
        success: function(data) {
            $("#header_format").text(data);          
        }
    });
}




function vmta_select_count(){
    var nbvmtas=$('#vmta option:selected').length;
    var str='';
    if(nbvmtas==0){
        str='No Vmta selected';
    }
    if(nbvmtas==1){
        str=nbvmtas+' Vmta selected';
    }
    if(nbvmtas>1){
        str=nbvmtas+' Vmtas selected';
    }
    $("#vmta_count").text(str);
}

function server_select_count(){
    var nbvmtas=$('#server option:selected').length;
    var str='';
    if(nbvmtas==0){
        str='No Server selected';
    }
    if(nbvmtas==1){
        str=nbvmtas+' Server selected';
    }
    if(nbvmtas>1){
        str=nbvmtas+' Servers selected';
    }
    $("#server_count").text(str);
}

function server_selectall(){
    $("#server option").each(function(){
		$("#server option[value='"+ $(this).val() +"']").prop('selected', true);
	});
	show_vmtas();
    server_select_count();
}

function server_unselectall(){
    $('#server option:selected').prop('selected', false);
	show_vmtas();
    server_select_count();
}

function vmta_selectall(){
    $("#vmta option").each(function(){
		$("#vmta option[value='"+ $(this).val() +"']").prop('selected', true);
	});
    vmta_select_count();
}

function vmta_unselectall(){
    $('#vmta option:selected').prop('selected', false);
    vmta_select_count();
}

function refresh(){
    processing_show();
	
	$("#button-run").attr("disabled", true);
	
	    //FILL THE CAMPAIGNS MONITORING CHART & CAMPAIGNS COUNT BY STATUS BASED ON NEW VALUE OF MAILER FILER
    get_campaigns_monitor_data();
    get_campaigns_count_by_status();

    $.ajax({
        url: 'scripts.php?action=show',
        type: 'get',
		data: {
            date_from: document.getElementById('from_yy').value+'-'+document.getElementById('from_mm').value+'-'+document.getElementById('from_dd').value+' 00:00:00 ',
            date_to: document.getElementById('to_yy').value+'-'+document.getElementById('to_mm').value+'-'+document.getElementById('to_dd').value+' 23:59:59 ',
			id_server: document.getElementById('server').value,
			id_mailer: document.getElementById('mailer').value,
			id_sponsor: document.getElementById('sponsor').value,
			id_offer: document.getElementById('offer').value,
			id_news: document.getElementById('news').value,
			id_isp: document.getElementById('isp').value,
			status: document.getElementById('status').value,
			nb_rows: document.getElementById('rows').value
        },
        success: function(data) {
            var list = JSON.parse(data);
            var color="";
            $('#show').dataTable().fnClearTable();
            for (var i = 0; i < list.length; i++) {
                switch(list[i].status){
                    case 'Starting': color='info';get_real_sent(list[i].id);break;
                    case 'Sending': color='warning';get_real_sent(list[i].id);break;
                    case 'Stopped': color='important';break;
                    case 'Finished': color='success';break;
                    default : color='';
                }
				
				// switch (list[i].link_type) {
                    // case '0': link_type_color = 'important'; link_type='Short link'; break;
                    // case '1': link_type_color = 'success'; link_type='Default link'; break;
                    // default: link_type_color = 'dark'; link_type='Not defined';;
                // }
				
                $('#show').dataTable().fnAddData([ 
                    list[i].id,
					list[i].name_server,
					list[i].username,
                    list[i].offer_name,
                    "<i href='#subject-info' class='menu-icon icon-list' title='"+list[i].news_name+"' role='button' data-toggle='modal' style='cursor: pointer;' onclick=''></i>"+"&nbsp;&nbsp;"+list[i].name_data_list,
                    list[i].isp_name,
                    list[i].data_from+"-"+list[i].data_count,
                    "<div style='color:#6D6BF6;' id='idc-sent"+list[i].id+"'>"+list[i].data_processed+"</div>",
			        "<div style='color:#6D6BF6;' id='idc-sent"+list[i].id+"'>"+list[i].data_delivered+"</div>",
					"<div style='color:#FC2D00;' id='idc-sent"+list[i].id+"'>"+list[i].ResultFound+"</div>",
					list[i].date_send,
                    "<div class='center' id='idc-status"+list[i].id+"'><span class='badge badge-"+color+"'>"+list[i].status+"</span></div>",
					// "<div class='center' id='idc-status" + list[i].id + "'><span class='badge badge-" + link_type_color + "'>" + link_type + "</span></div>",
                    "<i class='icon-refresh icon-white' title='Refresh' style='cursor: pointer;' onclick='get_real_sent("+list[i].id+");'></i>&nbsp;&nbsp;<i href='#myModal' class='icon-off icon-white' title='Stop' role='button' data-toggle='modal' style='cursor: pointer;' onclick='confirm_campaign("+list[i].id+");'></i>&nbsp;&nbsp;<i class='icon-edit icon-white' title='Edit' style='cursor: pointer;' onclick="+"window.open('send.php?edit_campaign="+list[i].id+""+"')></i>&nbsp;&nbsp;<i class='icon-signal icon-white' title='Stats' style='cursor: pointer;' onclick="+"window.open('../reportss/campaign.php?id_campaign="+list[i].id+""+"')></i>&nbsp;&nbsp;&nbsp;<i class='icon-cog icon-white' title='Show PMTA' style='cursor: pointer;' onclick='show_pmta_monitor("+list[i].id+");')></i>&nbsp;&nbsp;<i class='icon-list-alt icon-white' style='cursor: pointer;' title='Show Campaign details' onclick='show_campaign_details(\""+list[i].id+"\");'></i>" 
                    //"<i class='icon-refresh icon-white' title='Refresh' style='cursor: pointer;' onclick='get_real_sent("+list[i].id+");'></i>&nbsp;&nbsp;<i class='icon-off icon-white' title='Stop' style='cursor: pointer;' onclick='stop_campaign("+list[i].id+");'></i>&nbsp;&nbsp;<i class='icon-edit icon-white' title='Edit' style='cursor: pointer;' onclick="+"location.href='edit.php?id_campaign='"+"></i>&nbsp;&nbsp;<i class='icon-signal icon-white' title='Stats' style='cursor: pointer;' onclick=''></i>" 
                ]);
            }
			$("#button-run").removeAttr("disabled", true);
            processing_hide();

        },
        error: function() {
            $("#message-error").slideDown("slow");
            processing_hide();
        }
    });
}

function show_campaign_details(id) {
    /** GET DETAILS CAMPAIGN DATA FROM DB & DISPLAY THEM */
    //SHOW MODAL WITH LOADER
    $("#campaignDetailsModal").modal('show');
    //REINITIALIZE THE DATA VALUES TO LOADER BY DEFAULT TO ERASE DATA OF THE OLD CAMPAIGN
    $("#campainDetails_id, #campainDetails_status, #campainDetails_linktype, #campainDetails_datesend, #campainDetails_mailer, #campainDetails_offername, #campainDetails_country, #campainDetails_news, #campainDetails_datalist, #campainDetails_isp, #campainDetails_from, #campainDetails_fromemail, #campainDetails_return, #campainDetails_header, #campainDetails_subject, #campainDetails_server, #campainDetails_htmlbody").html("<img src='/images/loading.gif' width='20' height='20'>");
    
    //GET DATA FROM DB
    $.ajax({
        url: 'scripts.php?action=get_campaign',
        type: 'get',
        data: {
            id_campaign: id
        },
        success: function(data) {
            if(!data)
            {
                $("#campaignDetailsModal").modal('hide');
                return;
            }
            var campaign_data = JSON.parse(data);
            var status_color = "";
            var link_type_color = "";
            var link_type = "";
            //STATUS COLOR
            switch (campaign_data.status) {
                case 'Starting': status_color = 'info'; break;
                case 'Sending': status_color = 'warning'; break;
                case 'Stopped': status_color = 'important'; break;
                case 'Finished': status_color = 'success'; break;
                default: status_color = "";
            }
            //LINK TYPE BADGE COLOR AND NAME
            switch (campaign_data.link_type) {
                case '0': link_type_color = 'important'; link_type='Short link'; break;
                case '1': link_type_color = 'success'; link_type='Default link'; break;
                default: link_type_color = 'dark'; link_type='Not defined';;
            }

            $("#campainDetails_id").html(campaign_data.id);
            $("#campainDetails_status").html("<div class='center'><span class='badge badge-" + status_color + "'>" + campaign_data.status + "</span></div>");
            $("#campainDetails_linktype").html("<div class='center'><span class='badge badge-" + link_type_color + "'>" + link_type + "</span></div>");
            $("#campainDetails_datesend").html(campaign_data.date_send);
            $("#campainDetails_mailer").html(campaign_data.username);
            $("#campainDetails_offername").html(campaign_data.offer_name);
            $("#campainDetails_country").html(campaign_data.country_code);
            $("#campainDetails_news").html(campaign_data.news_name);
            $("#campainDetails_datalist").html(campaign_data.lists);
            $("#campainDetails_isp").html(campaign_data.isp_name);
            $("#campainDetails_testemails").html(campaign_data.test_emails);
            $("#campainDetails_testperiod").html(campaign_data.test_period);
            $("#campainDetails_batch").html(campaign_data.xbatch);
            $("#campainDetails_xdelay").html(campaign_data.xdelay);
            $("#campainDetails_datafrom").html(campaign_data.data_from);
            $("#campainDetails_datacount").html(campaign_data.data_count);
            $("#campainDetails_dataeliminated").html(campaign_data.data_eliminated);
            $("#campainDetails_from").html(campaign_data.from_name);
            $("#campainDetails_fromemail").html(campaign_data.from_email);            
            $("#campainDetails_return").html(campaign_data.campaign_return);
            $("#campainDetails_header").html("<textarea rows='10' style='width:90%;'>"+campaign_data.header_format+"</textarea>");
            $("#campainDetails_subject").html(campaign_data.subject);

            //CAMPAIGN SERVERS DETAILS
            var servers_summary = '';
            if(campaign_data.servers_details)
            {
                campaign_data.servers_details.forEach(element => {
                    servers_summary += element.name + "<br>-&nbsp;&nbsp;&nbsp;" + element.ips + "<br>";
                });
            }
            $("#campainDetails_server").html(servers_summary);

            var iframe = $('<iframe></iframe>');
            $("#campainDetails_htmlbody").html("").append(iframe);
            
            var frameDoc = iframe[0].contentWindow.document;
            frameDoc.open();
            frameDoc.write(campaign_data.html_body);
            frameDoc.close();

        },
        error: function() {

        }
    });
    
}


function refresh1(){
    processing_show();
	$("#button-run").attr("disabled", true);
    $.ajax({
        url: 'scripts.php?action=show1',
        type: 'get',
		data: {
            date_from: document.getElementById('from_yy').value+'-'+document.getElementById('from_mm').value+'-'+document.getElementById('from_dd').value+' 00:00:00 ',
            date_to: document.getElementById('to_yy').value+'-'+document.getElementById('to_mm').value+'-'+document.getElementById('to_dd').value+' 23:59:59 ',
			id_server: document.getElementById('server').value,
			id_mailer: document.getElementById('mailer').value,
			id_sponsor: document.getElementById('sponsor').value,
			id_offer: document.getElementById('offer').value,
			id_news: document.getElementById('news').value,
			id_isp: document.getElementById('isp').value,
			status: document.getElementById('status').value,
			nb_rows: document.getElementById('rows').value,
			id_dep: document.getElementById('id_dep').value
        },
        success: function(data) {
            var list = JSON.parse(data);
            var color="";
            $('#show').dataTable().fnClearTable();
            for (var i = 0; i < list.length; i++) {
                switch(list[i].status){
                    case 'Starting': color='info';get_real_sent(list[i].id);break;
                    case 'Sending': color='warning';get_real_sent(list[i].id);break;
                    case 'Stopped': color='important';break;
                    case 'Finished': color='success';break;
                    default : color='';
                }
                $('#show').dataTable().fnAddData([ 
                    list[i].id,
					list[i].date_send,
					list[i].name_server,
					list[i].username,
                    list[i].offer_name,
                    list[i].news_name,
                    list[i].isp_name,
                    list[i].data_from+"-"+list[i].data_count,
                    "<div id='idc-sent"+list[i].id+"'>"+list[i].data_processed+"</div>",
                    "<div class='center' id='idc-status"+list[i].id+"'><span class='badge badge-"+color+"'>"+list[i].status+"</span></div>",
                    "<i class='icon-refresh icon-white' title='Refresh' style='cursor: pointer;' onclick='get_real_sent("+list[i].id+");'></i>&nbsp;&nbsp;<i href='#myModal' class='icon-off icon-white' title='Stop' role='button' data-toggle='modal' style='cursor: pointer;' onclick='confirm_campaign("+list[i].id+");'></i>&nbsp;&nbsp;<i class='icon-edit icon-white' title='Edit' style='cursor: pointer;' onclick="+"location.href='send.php?edit_campaign="+list[i].id+"'"+"></i>&nbsp;&nbsp;<i class='icon-signal icon-white' title='Stats' style='cursor: pointer;' onclick="+"location.href='../report/campaign.php?id_campaign="+list[i].id+"'"+"></i>" 
                    //"<i class='icon-refresh icon-white' title='Refresh' style='cursor: pointer;' onclick='get_real_sent("+list[i].id+");'></i>&nbsp;&nbsp;<i class='icon-off icon-white' title='Stop' style='cursor: pointer;' onclick='stop_campaign("+list[i].id+");'></i>&nbsp;&nbsp;<i class='icon-edit icon-white' title='Edit' style='cursor: pointer;' onclick="+"location.href='edit.php?id_campaign='"+"></i>&nbsp;&nbsp;<i class='icon-signal icon-white' title='Stats' style='cursor: pointer;' onclick=''></i>" 
                ]);
            }
			$("#button-run").removeAttr("disabled", true);
            processing_hide();

        },
        error: function() {
            $("#message-error").slideDown("slow");
            processing_hide();
        }
    });
}



function confirm_campaign(id_campaign){
    $("#stop-campaign-id").html(id_campaign);
}

function stop_campaign(id_campaign){
    processing_show();
    $("#idc-status"+id_campaign+"").html("<span class='badge badge-info'>Stopping</span>");
    $.ajax({
        url: 'scripts.php?action=stop_campaign',
        type: 'get',
        data: {
            id_campaign: id_campaign
        },
        success: function(data) {
            var str=data.replace(/(\r\n|\n|\r)/gm,"");
            //alert(str);
            get_real_sent(id_campaign);
            get_real_status(id_campaign);
            processing_hide();
        },
        error: function() {
            $("#message-error").slideDown("slow");
            processing_hide();
        }
    });
}



function edit_campaign(id){
    processing_show();
    $.ajax({
        url: 'scripts.php?action=edit',
        type: 'get',
        data: {
            id_campaign: id
        },
        success: function(data) {
            var list = JSON.parse(data);
            if(list.length==0){
                $("#message-custom").text("You don't have permission to edit campaigns of other Servers!");
                $("#message-warning-custom").slideDown("slow");
                setTimeout(function(){close_message_warning_custom();},3000);
            }else{
                $("#from_name").val(list[0].from_name);
                $("#subject").val(list[0].subject);
                $("#from_email").val(list[0].from_email);
                $("#reply_email").val(list[0].reply_email);
                $("#bounce_email").val(list[0].bounce_email);
                $("#return_path").val(list[0].return_path);
                $("#received").val(list[0].received);
                $("#xmailer").val(list[0].xmailer);
                $("#header_nbr").val(list[0].header_nbr);
                $("#header_format").val(list[0].header_format);
                select_server_body(list[0].id_server_body);
				select_domain_body_edit(list[0].id_server_body,list[0].domain_body);
                $("#redirect_type").val(list[0].redirect_type);
                $('input:radio[name=open_tracker][value='+list[0].open_tracker+']').attr('checked', true);
                $('input:radio[name=body_type][value='+list[0].body_type+']').attr('checked', true);
                if(list[0].body_type==0)body1();
                if(list[0].body_type==1)body2();
                if(list[0].body_type==2)body3();
                $("#text-encoder-input").text(list[0].text_body);
                $("#html_body").text(list[0].html_body);
				show_servers_edit(id);

                select_sponsor(list[0].id_sponsor);
                select_offer(list[0].id_offer,list[0].id_sponsor);

                select_news(id,list[0].id_news);
                select_isp(id,list[0].id_isp);
                //show_data_lists_edit(id);
				//show_data_lists();

                $("#test_emails_to").val(list[0].test_emails_to);
                $("#test_period").val(list[0].test_period);
                $("#xdelay").val(list[0].xdelay);
                $("#change_ip").val(list[0].change_ip);
                // $("#data_from").val((+list[0].data_sent) + (+list[0].data_from) + (+1));
                // $("#data_count").val((+list[0].data_count) - (+list[0].data_sent)); 
				$("#data_from").val(list[0].data_from);
                $("#data_count").val(list[0].data_count); 
            }   
            processing_hide();
        },
        error: function() {
            $("#message-error").slideDown("slow");
            processing_hide();
        }
    });
}

function show_pmta_monitor(id_campaign){
  
    $.ajax({
        url: 'scripts.php?action=show_pmta_monitor',
        type: 'get',
        data: {
            id_campaign: id_campaign
        },
        success: function(data) {
            var list = JSON.parse(data);

		for (var i = 0; i < list.length; i++) {
        window.open("http://"+list[i].main_ip+":8080/");
						}
            
        },
        error: function() {
            $("#message-error").slideDown("slow");
            processing_hide();
        }
    });
}


function get_real_sent(id_campaign){ 
    processing_show();
    $.ajax({
        url: 'scripts.php?action=get_real_sent',
        type: 'get',
        data: {
            id_campaign: id_campaign
        },
        success: function(data) {
            var str=data.replace(/(\r\n|\n|\r)/gm,"");
            $("#idc-sent"+id_campaign+"").text(str);
            processing_hide();
        },
        error: function() {
            $("#message-error").slideDown("slow");
            processing_hide();
        }
    });
    get_real_status(id_campaign);
}

function get_real_status(id_campaign){
    processing_show();
    $.ajax({
        url: 'scripts.php?action=get_real_status',
        type: 'get',
        data: {
            id_campaign: id_campaign
        },
        success: function(data) {
            var str=data.replace(/(\r\n|\n|\r)/gm,"");
            var color;
            switch (str){
                case 'Starting': color="important";break;
                case 'Sending': color="important";break;
                case 'Stopped': color="important";break;
                case 'Finished': color="important";break;
                default : color='';
            }
            $("#idc-status"+id_campaign+"").html("<span class='badge badge-"+color+"'>"+str+"</span>");
            processing_hide();
        },
        error: function() {
            $("#message-error").slideDown("slow");
            processing_hide();
        }
    });
    
}

function preview(){
    close_message_error();
    var domain=document.getElementById("domain_body").value;
    if(domain==="0"){
        $("#message-warning-custom-2").show();
    }else{
        var creative=document.getElementById("html_body").value;
        var res=creative.split('[Domain]').join(domain);
        $("#preview").html(res);
        $("#message-warning-custom-2").hide();
    }
}


function check_test_auto(){
		$('#test_auto-success').modal({
			show: 'false'
		});
}

function check_test_auto(){
	if($("#test_multiple_type_none").is(':checked')){
		test_auto();
	}else{
		$('#confirm-test-auto').modal({
			show: 'false'
		});
	}
}

function test_auto(){
    document.getElementById("sendform").action = "socket.php?action=testauto";
    document.forms["sendform"].submit();
			$('#myModal_test_auto').modal({
			show: 'false'
		});
		


}

function test_campaign(){
    document.getElementById("sendform").action = "socket.php?action=testcampaign";
    document.forms["sendform"].submit();
	

			$('#myModal_test_Campaign').modal({
			show: 'false'
		});
}

// function check_send_campaign(){
	// if($("#send_multiple_type_none").is(':checked')){
		// send_campaign();
	// }else{
		//$('#confirm-send-campaign').modal({
		//	show: 'false'
		//});
		// send_campaign();
	// }
// }

function check_send_campaign(){
	if($("#send_multiple_type_none").is(':checked')){

		send_campaign();
					var x= parseInt(document.getElementById("data_count").value,10);
	var y= parseInt(document.getElementById("data_from").value,10);
	var z=x+y;
	
    document.getElementById("data_from").value=z;
	// document.getElementById("data_count").value="0";
	}else{
		$('#confirm-send-campaign').modal({
			show: 'false'
		});
	}
}

function send_campaign(){
	
    document.getElementById("sendform").action = "socket.php?action=sendcampaign";
    document.forms["sendform"].submit();
	

	
	
}

function select_server_body(id){
    var html= "<option value='0' disabled=''>Waiting for extracting Servers...</option>";
    $("#server_body").html(html);
    $.ajax({
        url: 'scripts.php?action=get_servers',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+ "' data-ip='" + list[i].main_ip + "'>"+list[i].name+"</option>";
            }
            $("#server_body").html(html);
            $('#server_body option[value=' + id + ']').attr('selected', 'selected');
        }
    });
}


function select_theme(){
	
    $.ajax({
        url: 'scripts.php?action=get_theme_mailer',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
   $('link[title="main"]').attr('href', list[0].theme_name);
        }
    });
	
/*<![CDATA[*/
    jQuery(function($)
    {
        $('body').on('click', '.change-style-menu-item', function()
        {
            $('link[title="main"]').attr('href', $(this).attr('rel'));
        });
    });
/*]]>*/
}

function select_theme1(){
	
    $.ajax({
        url: 'scripts.php?action=update_theme',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
   $('link[title="main"]').attr('href', list[0].theme_name);
        }
    });
	
/*<![CDATA[*/
    jQuery(function($)
    {
        $('body').on('click', '.change-style-menu-item', function()
        {
            $('link[title="main"]').attr('href', $(this).attr('rel'));
        });
    });
/*]]>*/
}
function select_theme2(){
	
    $.ajax({
        url: 'scripts.php?action=update_theme1',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
   $('link[title="main"]').attr('href', list[0].theme_name);
        }
    });
	
/*<![CDATA[*/
    jQuery(function($)
    {
        $('body').on('click', '.change-style-menu-item', function()
        {
            $('link[title="main"]').attr('href', $(this).attr('rel'));
        });
    });
/*]]>*/
}



function select_domains_body(id){
    var html= "<option value='0' disabled=''>Waiting for extracting Domains...</option>";
    $("#domain_body").html(html);
    $.ajax({
        url: 'scripts.php?action=get_domains',
        type: 'get',
        data: {
            server: id
        },
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].host_name+"'>"+list[i].host_name+"</option>";
            }
            $("#domain_body").html(html);          
        }
    });
}

function select_domain_body_edit(id,domain){
    var html= "<option value='0' disabled=''>Waiting for selecting Domain...</option>";
    $("#domain_body").html(html);
    $.ajax({
        url: 'scripts.php?action=get_domains',
        type: 'get',
        data: {
            server: id
        },
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].host_name+"'>"+list[i].host_name+"</option>";
            }
            $("#domain_body").html(html);
			$("#domain_body").val(domain);
			//$('#domain_body option[value=' + domain + ']').attr('selected', 'selected');
			//document.getElementById("domain_body").value = domain;
			//$("#domain_body option[value='"+ domain +"']").prop('selected', true);
			//document.getElementById("orange").selected = "true";
        }
    });
}

function show_domains(){
    var html= "<option value='0' disabled=''>Waiting for extracting Domains...</option>";
    $("#domain_body").html(html);
    $.ajax({
        url: 'scripts.php?action=get_domains',
        type: 'get',
        data: {
            server: document.getElementById("server_body").value
        },
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].host_name+"'>"+list[i].host_name+"</option>";
            }
            $("#domain_body").html(html);          
        }
    });
}

/*function show_vmtas()
{
    var html= "<option value='0' disabled=''>Waiting for extracting VMTAs...</option>";
    $("#vmta").html(html);
    $.ajax({
        url: 'scripts.php?action=get_vmtas',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "";
            for (var i = 0; i < list.length; i++) {
				html += "<option value='"+list[i].main_ip+";"+list[i].name+";"+list[i].address_ip+";"+list[i].host_name+";"+list[i].id+"'>"+list[i].name+" | "+list[i].address_ip+" | "+list[i].host_name+"</option>";
            }
            $("#vmta").html(html);
        }
    });
}*/

function search_vmtas(){
    $("#vmta option:selected").prop("selected", false);
    var values=$("#search_vmtas_area").val();
    if(values.trim()!==''){
        values=values.split('\n');
        var value='';
        var searchrow='';
        var searchstr='';
        for(var i=0;i<values.length;i++){
            value=values[i].trim();
            $('#vmta option').each(function() {
                searchrow=($(this).text()).split(' | ');
                searchstr='';

                if($("#search-server-name").is(':checked')){
                    searchstr += searchrow[0];
                }
				if($("#search-vmta-name").is(':checked')){
					if($("#search-server-name").is(':checked')){
                        searchstr +=";";
                    }
                    searchstr += searchrow[1];
                }
                if($("#search-vmta-ip").is(':checked')){
                    if($("#search-server-name").is(':checked') || $("#search-vmta-name").is(':checked')){
                        searchstr +=";";
                    }
                    searchstr+=searchrow[2];
                }
                if($("#search-vmta-host").is(':checked')){
                    if($("#search-server-name").is(':checked') || $("#search-vmta-name").is(':checked') || $("#search-vmta-ip").is(':checked')){
                        searchstr +=";";
                    }
                    searchstr+=searchrow[3];
                }
                if(searchstr.toLowerCase().match(value.toLowerCase())){
                   $("#vmta option[value='"+ $(this).val() +"']").prop('selected', true);
                }
            });
        } 
    }
    vmta_select_count();
}

function show_vmtas_editable(){ 
    var text= "Waiting for extracting VMTAs";
    $("#edit_vmtas_area").val(text);
	var result='';
	var vmta_name='';
	var vmta_ip='';
	var vmta_host='';
	var ligne='';
	
	

	$("#vmta option").each(function(){
		str=$(this).val().split(";");
		vmta_name=str[1];
		vmta_ip=str[2];
		vmta_host=str[3];
		ligne='';
		


		if($("#edit-vmta-name").is(':checked')){
			ligne += vmta_name;
			
		}

		if($("#edit-vmta-ip").is(':checked')){
			if($("#edit-vmta-name").is(':checked')){
				ligne +=";";
			}
			ligne+=vmta_ip;
		}
		if($("#edit-vmta-host").is(':checked')){
			if($("#edit-vmta-name").is(':checked') || $("#edit-vmta-ip").is(':checked')){
				ligne +=";";
			}
			ligne+=vmta_host;
		}
		result+=ligne+'\n';

	});

	$("#edit_vmtas_area").val(result.trim());
}

function select_vmtas(vmtas){
    var html= "<option value='0' disabled=''>Waiting for selecting VMTAs...</option>";
    $("#vmta").html(html);
    $.ajax({
        url: 'scripts.php?action=get_vmtas',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "";
            var str_vmta=vmtas.split(';');
            var selected="";
            for (var i = 0; i < list.length; i++) {
                selected="";
                for(var vmta in str_vmta){
                    if(str_vmta[vmta]==list[i].id){
                        selected="selected";
                    }
                }
                html += "<option value='"+list[i].id+";"+list[i].name+";"+list[i].address_ip+";"+list[i].host_name+"' "+selected+">"+list[i].name+" | "+list[i].address_ip+" | "+list[i].host_name+"</option>";
            }
            $("#vmta").html(html);          
        }
    });
}

function show_sponsors(){
    var html= "<option value='0' disabled=''>Waiting for extracting Sponsors...</option>";
    $("#sponsor").html(html);
    $.ajax({
        url: 'scripts.php?action=get_sponsors',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";

            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            }
            $("#sponsor").html(html);          
				   
        }
    });
}




function select_sponsor(id){
    var html= "<option value='0' disabled=''>Waiting for selecting Sponsor...</option>";
    $("#sponsor").html(html);
    $.ajax({
        url: 'scripts.php?action=get_sponsors',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            }
            $("#sponsor").html(html); 
            $('#sponsor option[value=' + id + ']').attr('selected', 'selected');

        }
    });
}

// function show_offers(){
		    // $("#fspinner").show();
		    // $('#details_offer').hide();
			
    // var html= "<option value='0' disabled=''>Waiting for extracting Offers...</option>";
    // $("#offer").html(html);
    // $.ajax({
        // url: 'scripts.php?action=get_offers',
        // type: 'get',
        // data: {
            // sponsor: document.getElementById("sponsor").value
        // },
        // success: function(data) {
            // var list = JSON.parse(data);
            // var html = "<option value='0'>Select here...</option>";
            // for (var i = 0; i < list.length; i++) {
                // html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            // }
            // $("#offer").html(html);      
    // $("#fspinner").hide();			
        // }
    // });
// }
function show_offers() {
    var html = "<option value='0' disabled=''>Waiting for extracting Offers...</option>";

    $('#details_offer').hide();

    $("#offer").html(html);

    selected_sponsor = !$("#sponsor").val() ? 0 : $("#sponsor").val();
    selected_country = !$("#country_code").val() ? 0 : $("#country_code").val();
	

    if (selected_sponsor == 0 || selected_country == 0) {
        $("#offer").html("<option value='0'>Select here...</option>");
        return;
    }

    $.ajax({
        url: 'scripts.php?action=get_offers',
        type: 'get',
        data: {
            sponsor: selected_sponsor,
            country: selected_country
        },
        success: function (data) {
			
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            var note_suppression;
            var fromDate = CurrentDate();
			
            for (var i = 0; i < list.length; i++) {

                suppression_status = list[i].suppression_status.split(/[><]/);
                str_date = new Date(new Date(suppression_status[2]).getTime() + (7 * 24 * 60 * 60 * 1000));
                toDate = str_date.getFullYear() + "-" + (str_date.getMonth() + 1) + "-" + (str_date.getDate());

                diff = new Date(Date.parse(toDate) - Date.parse(fromDate));

                days = diff / 1000 / 60 / 60 / 24;
                days = Math.floor(parseFloat(days));


                if (days => 0) {
                    note_suppression = days + " day(s) left";
                }

                if (days < 0) {
                    note_suppression = "Have expired " + Math.abs(days) + " day(s) ago !!, Stopped it";
                }

                html += "<option  data-numbdays='" + days + "' data-daystraffics='" + list[i].days_traffic + "' data-geos='" + list[i].geo_targeting + "' data-daysleft='" + note_suppression + "'  value='" + list[i].id + "'>" + list[i].name + "</option>";

            }
            $("#offer").html(html);
        }
		,
        error: function () {
alert("no offers");
        }
    });
}

function CurrentDate() {
    var tdate = new Date(new Date().getTime() + (1 * 24 * 60 * 60 * 1000));
    var dd = tdate.getDate(); //yields day
    var MM = tdate.getMonth(); //yields month
    var yyyy = tdate.getFullYear(); //yields year
    var currentDate = yyyy + "-" + (MM + 1) + "-" + dd;

    return currentDate;
}

function show_details_offer() {

    var daystraffics = $("#offer option:selected").attr('data-daystraffics');
    var geos = $("#offer option:selected").attr('data-geos');
    var daysleft = $("#offer option:selected").attr('data-daysleft');

    if (daystraffics == 'null') {
        daystraffics = "Pending";
    }

    if (geos == 'null') {
        geos = "Pending";
    }

    $("#days_traffics").html(daystraffics);
    $("#geos").html(geos);
    $("#daysleft").html(daysleft);
    $('#daysleft_suppression').val(daysleft);

    $('#details_offer').slideDown();

}



function select_offer(id,id_sponsor){
    var html= "<option value='0' disabled=''>Waiting for selecting Offer...</option>";
    $("#offer").html(html);
    $.ajax({
        url: 'scripts.php?action=get_offers',
        type: 'get',
        data: {
            sponsor: id_sponsor
        },
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            }
            $("#offer").html(html);
            $('#offer option[value=' + id + ']').attr('selected', 'selected');
        }
    });
}

function show_news(){
    var html= "<option value='0' disabled=''>Waiting for extracting News...</option>";
    $("#news").html(html);
    $.ajax({
        url: 'scripts.php?action=get_news',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            }
            $("#news").html(html);          
        }
    });
}

function select_news(id_campaign,id_news){
    var html= "<option value='0' disabled=''>Waiting for selecting News...</option>";
    $("#news").html(html);
    $.ajax({
        url: 'scripts.php?action=get_news',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            }
            $("#news").html(html); 
            $('#news option[value=' + id_news + ']').attr('selected', 'selected');
        }
    });
}


function reset_datalist_component() {
    // 1)SELECT FIRST NEWS
    $("#news").val("0").trigger('change.select2');
    // 1)SELECT FIRST ISP
    $("#isp").val("0").trigger('change.select2');
    //REMOVE ALL THE LABEL ELEMENTS FEED BACK AFTER THE SELECT BOX
    $("#data-list .radio").remove();
}



function show_countries(){
	$("#country-flag").fadeOut();
	$("#country-flag").removeClass();
    var html= "<option value='0' disabled=''>Waiting for extracting Countries...</option>";
    $("#country").html(html);
    $.ajax({
        url: 'scripts.php?action=get_countries',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            }
            $("#country").html(html);
			$('#country option[value="230"]').attr('selected', 'selected');
			// $('#xdelay option[value="100000"]').attr('selected', 'selected');
			show_country_flag();
        }
    });
}

function show_countries_code(){
	$("#country-flag").fadeOut();
	$("#country-flag").removeClass();
    var html= "<option value='0' disabled=''>Waiting for extracting Countries...</option>";
    $("#country").html(html);
    $.ajax({
        url: 'scripts.php?action=get_countries_code',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].code+"</option>";
            }
            $("#country_code").html(html);
			$('#country_code option[value="230"]').attr('selected', 'selected');
			// $('#xdelay option[value="100000"]').attr('selected', 'selected');
			show_country_flag();
        }
    });
}

function show_country_flag(){
	$("#country-flag").fadeOut("slow");
	$("#country-flag").removeClass();
    $.ajax({
        url: 'scripts.php?action=get_country_flag',
        type: 'get',
		data: {
            country: document.getElementById("country").value
        },
        success: function(data) {
            var str=data.replace(/(\r\n|\n|\r)/gm,"");
            $("#country-flag").addClass(str);
			$("#country-flag").fadeIn("slow");
        }
    });
}

function show_isps(){
    var html= "<option value='0' disabled=''>Waiting for extracting ISPs...</option>";
    $("#isp").html(html);
    $.ajax({
        url: 'scripts.php?action=get_isps',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            }
            $("#isp").html(html); 
            $('#isp option[value="1"]').attr('selected', 'selected');			
        }
    });
}

function show_isps_monitor(){
    var html= "<option value='0' disabled=''>Waiting for extracting ISPs...</option>";
    $("#isp").html(html);
    $.ajax({
        url: 'scripts.php?action=get_isps',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            }
            $("#isp").html(html); 
            $('#isp option[value="0"]').attr('selected', 'selected');			
        }
    });
}



function select_isp(id_campaign,id_isp){
    var html= "<option value='0' disabled=''>Waiting for selecting ISP...</option>";
    $("#isp").html(html);
    $.ajax({
        url: 'scripts.php?action=get_isps',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            }
            $("#isp").html(html);   
            $('#isp option[value=' + id_isp + ']').attr('selected', 'selected');
			show_data_lists_edit(id_campaign);
        }
    });
}

function show_data_lists(){
    if((document.getElementById("news").value!=="0")&&(document.getElementById("isp").value!=="0")){
        var html= "<div class='progress progress-info progress-striped active span10'><div class='bar' style='width: 100%;'>Waiting for extracting Data Lists...</div></div>";
        $("#data-list").html(html);
        $.ajax({
            url: 'scripts.php?action=get_data_lists',
            type: 'get',
            data: {
                news: document.getElementById("news").value,
                isp: document.getElementById("isp").value
            },
            success: function(data) {
                var list = JSON.parse(data);
                var html = "";
                var cpt=0;
                if(list.length===0){
                    html= "<label class='radio'><span class='label label-important'>No Data Selected</span></label>";  
                }else{
                    for (var i = 0; i < list.length; i++) {
                        html += "<label class='checkbox'><input type='checkbox' name='data_lists[]'  value='"+list[i].id+"'><span class='label label-success'>"+list[i].name+"&nbsp;&nbsp;&nbsp;"+lisibilite_nombre(list[i].count_isp)+"</span></label>";
                        cpt+=parseInt(list[i].count_isp);
                    }
                }
                html+= "<label class='radio'><span class='label label'>Total&nbsp;&nbsp;&nbsp;"+lisibilite_nombre(cpt)+"</span></label>";
                $("#data-list").html(html);          
            }
        });
    }else{
        html= "<label class='radio'><span class='label label-important'>No Data Selected</span></label>";
        $("#data-list").html(html);
    }
    
}

function select_data_list(id,id_isp,id_news){
    if((id_news!=="0")&&(id_isp!=="0")){
        var html= "<div class='progress progress-info progress-striped active span10'><div class='bar' style='width: 100%;'>Waiting for selecting Data List...</div></div>";
        $("#data-list").html(html);
        $.ajax({
            url: 'scripts.php?action=get_data_lists',
            type: 'get',
            data: {
                news: id_news,
                isp: id_isp
            },
            success: function(data) {
                var list = JSON.parse(data);
                var html = "";
                var cpt=0;
                if(list.length===0){
                    html= "<label class='radio'><span class='label label-important'>No Data Selected</span></label>";  
                }else{
                    for (var i = 0; i < list.length; i++) {
                        html += "<label class='radio'><input type='radio' name='data_list' value='"+list[i].id+"'><span class='label label'>"+list[i].name+"&nbsp;&nbsp;&nbsp;"+lisibilite_nombre(list[i].count_isp)+"</span></label>";
                        cpt+=parseInt(list[i].count_isp);
                    }
                }
                html+= "<label class='radio'><span class='label label-success'>Total&nbsp;&nbsp;&nbsp;"+lisibilite_nombre(cpt)+"</span></label>";
                $("#data-list").html(html);
                $('input:radio[name=data_list][value='+id+']').attr('checked', true);
            }
        });
    }else{
        html= "<label class='radio'><span class='label label-important'>No Data Selected</span></label>";
        $("#data-list").html(html);
    }
    
}

function show_ips(){
    var html= "<option value='0' disabled=''>Waiting for extracting IP Addresses...</option>";
    $("#address_ip_vmta").html(html);
    $.ajax({
        url: 'scripts.php?action=get_ips',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "";
            for (var i = 0; i < list.length; i++) {
                 html += "<option value='"+list[i].address_ip+"'>"+list[i].address_ip+"</option>";
            }
            $("#address_ip_vmta").html(html);
			ip_select_count();
        }
    });
}

function select_server_show(id){
    var html= "<option value='0' disabled=''>Waiting for selecting Servers...</option>";
    $("#server").html(html);
    $.ajax({
        url: 'scripts.php?action=get_servers',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
						            var html = "<option value='all' >All</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            }
            $("#server").html(html);
            $('#server option[value="0"]').attr('selected', 'selected');
        }
    });
}

function select_mailer_show(id){
    var html= "<option value='0' disabled=''>Waiting for selecting Mailer...</option>";
    $("#mailer").html(html);
    $.ajax({
        url: 'scripts.php?action=get_mailers',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "<option value='0'>Select here...</option>";
			            var html = "<option value='all' >All</option>";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].username+"</option>";
            }
            $("#mailer").html(html); 
            $('#mailer option[value=' + id + ']').attr('selected', 'selected');
			                        get_campaigns_monitor_data();
									            get_campaigns_count_by_status();
        }
    });
}

function ip_select_count(){
    var nbips=$('#address_ip_vmta option:selected').length;
    var str='';
    if(nbips==0){
        str='No IP Address selected';
    }
    if(nbips==1){
        str=nbips+' IP Address selected';
    }
    if(nbips>1){
        str=nbips+' IP Addresses selected';
    }
    $("#ip_count").text(str);
}

function lisibilite_nombre(nbr){
    var nombre = ''+nbr;
    var retour = '';
    var count=0;
    for(var i=nombre.length-1 ; i>=0 ; i--){
            if(count!=0 && count % 3 == 0)
                    retour = nombre[i]+' '+retour ;
            else
                    retour = nombre[i]+retour ;
            count++;
    }
    return retour;
}

///////////////////////////////////// TEST GLOBAL ////////////////////////////////////
/*function show_servers(){
    var html= "<option value='0' disabled=''>Waiting for extracting Servers...</option>";
    $("#server").html(html);
    $.ajax({
        url: 'scripts.php?action=get_servers',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            }
            $("#server").html(html);
        }
    });
}*/

function select_server_vmta(id){
    var html= "<option value='0' disabled=''>Extracting...</option>";
    $("#server").html(html);
    $.ajax({
        url: 'scripts.php?action=get_servers',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+ "'  data-name='" + list[i].name + "' data-ip='" + list[i].main_ip + "' >"+list[i].name+"</option>";
            }
            $("#server").html(html);
            $('#server option[value=' + id + ']').attr('selected', 'selected');
			show_vmtas();

        }
    });
}




function myFunction1(){
var x = document.getElementById("server").selectedIndex;
var y = document.getElementById("server").options;

    $.ajax({
        url: 'scripts.php?action=get_ip_server',
        type: 'get',
	   data: {
            id: y[x].text
        },
        success: function(data) {
            var list = JSON.parse(data);
			            for (var i = 0; i < list.length; i++) {
window.open("http://"+list[i].main_ip+":8080/");
// window.open("http://"+list[i].main_ip+"/apps/mailer/pmta/manage.php");
						}
        }
    });
}

function myFunction1_pmta(){
var x = document.getElementById("server").selectedIndex;
var y = document.getElementById("server").options;

    $.ajax({
        url: 'scripts.php?action=get_ip_server',
        type: 'get',
	   data: {
            id: y[x].text
        },
        success: function(data) {
            var list = JSON.parse(data);
			for (var i = 0; i < list.length; i++) {
window.open("http://"+list[i].main_ip+":8080/");
						}
        }
    });
}


function myFunction1_rcm(){
var x = document.getElementById("server").selectedIndex;
var y = document.getElementById("server").options;

    $.ajax({
        url: 'scripts.php?action=get_ip_server',
        type: 'get',
	   data: {
            id: y[x].text
        },
        success: function(data) {
            var list = JSON.parse(data);
			            for (var i = 0; i < list.length; i++) {
window.open("http://"+list[i].main_ip+"/apps/mailer/pmta/manage.php");
						}
        }
    });
}



function show_vmtas(){
    //var html= "<option value='0' disabled=''>Waiting for extracting VMTAs...</option>";
	var html= "<option value='0' disabled=''>No Server selected</option>";
    $("#vmta").html(html);
    server_select_count();
	
	var x = document.getElementById("server").selectedIndex;
    var y = document.getElementById("server").options;
	 $("#server_nm").html(y[x].text);
	 
	 
    //Get the list of the servers from the multiple select :
    var servers = [];
    $('#server :selected').each(function(i, selected){
      servers[i] = $(selected).val();
    });
    
    $.ajax
    ({
        url: 'scripts.php?action=get_vmtas2',
        type: 'get',
        data: {
            server: servers
        },
        success: function(data) {
            var list = JSON.parse(data);
            var html = "";
            for (var i = 0; i < list.length; i++) {
				// html += "<option value='"+list[i].main_ip+";"+list[i].name+";"+list[i].address_ip+";"+list[i].host_name+";"+list[i].id+";"+list[i].id_server+";"+list[i].name_server+";"+list[i].id_mailer+"'>"+list[i].name_server+" | "+list[i].address_ip+" | "+list[i].host_name+"</option>";
			       html += "<option value='"+list[i].main_ip+";"+list[i].name+";"+list[i].address_ip+";"+list[i].host_name+";"+list[i].id+";"+list[i].id_server+";"+list[i].name_server+";"+list[i].id_mailer+"'>"+list[i].name_server+" | "+list[i].name+" | "+list[i].address_ip+" | "+list[i].host_name+"</option>";
            }
            $("#vmta").html(html);
			vmta_select_count();
			search_vmta_type();
        }
    });
}

function show_servers_edit(id_campaign){
    var html= "<option value='0' disabled=''>Extracting...</option>";
    $("#server").html(html);
    $.ajax({
        url: 'scripts.php?action=get_servers',
        type: 'get',
        success: function(data) {
            var list = JSON.parse(data);
            var html = "";
            for (var i = 0; i < list.length; i++) {
                html += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
            }
            $("#server").html(html);
			select_servers_edit(id_campaign);
        }
    });
}

function select_servers_edit(id_campaign){
	$.ajax({
		url: 'scripts.php?action=get_servers_edit',
		type: 'get',
		data: {
			id_campaign: id_campaign
		},
		success: function(data) {
			var list = JSON.parse(data);
			for (var i = 0; i < list.length; i++) {
				$("#server option[value='"+ list[i].id_server +"']").prop('selected', true);
			}
			show_vmtas_edit(id_campaign);

		}
	});
}

function show_vmtas_edit(id_campaign){
    var html= "<option value='0' disabled=''>Waiting for extracting VMTAs...</option>";
    $("#vmta").html(html);
    
    //Get the list of the servers from the multiple select :
    var servers = [];
    $('#server :selected').each(function(i, selected){
      servers[i] = $(selected).val();
    });
    
    $.ajax
    ({
        url: 'scripts.php?action=get_vmtas2',
        type: 'get',
        data: {
            server: servers
        },
        success: function(data) {
            var list = JSON.parse(data);
            var html = "";
            for (var i = 0; i < list.length; i++) {
				html += "<option value='"+list[i].main_ip+";"+list[i].name+";"+list[i].address_ip+";"+list[i].host_name+";"+list[i].id+";"+list[i].id_server+";"+list[i].name_server+";"+list[i].id_mailer+"'>"+list[i].name_server+" | "+list[i].address_ip+" | "+list[i].host_name+"</option>";
            }
            $("#vmta").html(html);
			select_vmtas_edit(id_campaign);
        }
    });
}

function select_vmtas_edit(id_campaign){
	server_select_count();
	$.ajax({
		url: 'scripts.php?action=get_vmtas_edit',
		type: 'get',
		data: {
			id_campaign: id_campaign
		},
		success: function(data) {
			var list = JSON.parse(data);
			var str='';
			for (var i = 0; i < list.length; i++) {
				$("#vmta option").each(function(){
				   str=$(this).val().split(";");
				   if(list[i].id_vmta.match(str[4])){
						$("#vmta option[value='"+ $(this).val() +"']").prop('selected', true);
				   }
				});	
			}
			vmta_select_count();
			search_vmta_type();
		}
	});
}

function show_data_lists(){
    if((document.getElementById("news").value!=="0")&&(document.getElementById("isp").value!=="0")){
        var html= "<div class='progress progress-info progress-striped active span10'><div class='bar' style='width: 100%;'>Waiting for extracting Data Lists...</div></div>";
        $("#data-list").html(html);
        $.ajax({
            url: 'scripts.php?action=get_data_lists',
            type: 'get',
            data: {
                news: document.getElementById("news").value,
                isp: document.getElementById("isp").value
            },
            success: function(data) {
                var list = JSON.parse(data);
                var html = "";
                var cpt=0;
                if(list.length===0){
                    html= "<label class='radio'><span class='label label-important'>No Data Selected</span></label>";  
                }else{
                    for (var i = 0; i < list.length; i++) {
                        html += "<label class='checkbox'><input class='checkbox1' type='checkbox' name='data_lists[]' id='data_listso' value='"+list[i].id+"'><span class='label label-info'>"+list[i].name+"&nbsp;&nbsp;&nbsp;</span>&nbsp;<span class='label label-warning'>"+lisibilite_nombre(list[i].count_total)+"</span></label>";
                        cpt+=parseInt(list[i].count_total);
                    }
                }
                html+= "<label class='radio'><span class='label label'>Total&nbsp;&nbsp;&nbsp;"+lisibilite_nombre(cpt)+"</span></label>";
                $("#data-list").html(html);          
            }
        });
    }else{
        html= "<label class='radio'><span class='label label-important'>No Data Selected</span></label>";
        $("#data-list").html(html);
    }
    
}

function show_data_lists_edit(id_campaign){
    if((document.getElementById("news").value!=="0")&&(document.getElementById("isp").value!=="0")){
        var html= "<div class='progress progress-info progress-striped active span10'><div class='bar' style='width: 100%;'>Waiting for extracting Data Lists...</div></div>";
        $("#data-list").html(html);
        $.ajax({
            url: 'scripts.php?action=get_data_lists',
            type: 'get',
            data: {
                news: document.getElementById("news").value,
                isp: document.getElementById("isp").value
            },
            success: function(data) {
                var list = JSON.parse(data);
                var html = "";
                var cpt=0;
                if(list.length===0){
                    html= "<label class='radio'><span class='label label-important'>No Data Selected</span></label>";  
                }else{
                    for (var i = 0; i < list.length; i++) {
                        html += "<label class='checkbox'><input type='checkbox' name='data_lists[]' value='"+list[i].id+"'><span class='label label-info'>"+list[i].name+"&nbsp;&nbsp;&nbsp;</span>&nbsp;<span class='label label-warning'>"+lisibilite_nombre(list[i].count_total)+"</span></label>";
                        cpt+=parseInt(list[i].count_total);
                    }
                }
                html+= "<label class='radio'><span class='label label'>Total&nbsp;&nbsp;&nbsp;"+lisibilite_nombre(cpt)+"</span></label>";
                $("#data-list").html(html);   
				select_data_lists_edit(id_campaign);
				
            }
        });
    }else{
        html= "<label class='radio'><span class='label label-important'>No Data Selected</span></label>";
        $("#data-list").html(html);
    }
    
}

function select_data_lists_edit(id_campaign){
    $.ajax({
		url: 'scripts.php?action=get_data_lists_edit',
		type: 'get',
		data: {
			id_campaign: id_campaign
		},
		success: function(data) {
			var list = JSON.parse(data);
			for (var i = 0; i < list.length; i++) {
				$("input:checkbox[value="+list[i].id_data_list+"]").attr("checked", true);
			}
		}
	});
}

function search_server_instant(){
	var str=document.getElementById("search_server").value;
	var cptshow=0;
	var cpthide=0;
	$("#server option").each(function(){
		if($(this).text().toLowerCase().indexOf(str.toLowerCase()) >= 0){
			$(this).show();
			cptshow++;
		}else{
			$(this).hide();
			cpthide++;
		}
	});
	if(cptshow==0)$("#server").append('<option value=-1 disabled>No results</option>');
	else $("#server option[value='-1']").remove();
}

function search_vmta_instant(){
	var str=document.getElementById("search_vmta").value;
	var cptshow=0;
	var cpthide=0;
	$("#vmta option").each(function(){
		if($(this).text().toLowerCase().indexOf(str.toLowerCase()) >= 0){
			$(this).show();
			cptshow++;
		}else{
			$(this).hide();
			cpthide++;
		}
	});
	if(cptshow==0)$("#vmta").append('<option value=-1 disabled>No results</option>');
	else $("#vmta option[value='-1']").remove();
}

function search_vmta_type(){
	var cpt=0;
	$("#vmta option").each(function(){
		var str=$(this).val().split(";");
		var vmta_idmailer=str[7];
		if($("#search_vmta_type_all").is(':checked')){
			$(this).show();
			cpt++;
		}
		if($("#search_vmta_type_valid").is(':checked')){
			if(vmta_idmailer=='0'){
				$(this).show();
				cpt++;
			}
			else $(this).hide();
		}
		if($("#search_vmta_type_fake").is(':checked')){
			if(vmta_idmailer!=0 && vmta_idmailer!=-1){
				$(this).show();
				cpt++;
			}
			else $(this).hide();
		}
	});
	if(cpt==0)$("#vmta").append('<option value=-1 disabled>No results</option>');
	else $("#vmta option[value='-1']").remove();
}

//$("#server option[value='"+ $(this).val() +"']").prop('selected', true);
	//$('#domain_body option[value=' + domain + ']').attr('selected', 'selected');
	//document.getElementById("domain_body").value = domain;
	//$("#domain_body option[value='"+ domain +"']").prop('selected', true);
	//document.getElementById("orange").selected = "true";
	/*$("#server option").each(function(){
		if(list[i].id_server.match($(this).val())){
		   $("#server option[value='"+ list[i].id_server +"']").prop('selected', true);
		}
	});*/
function confirm_stop_process(pid){
    $("#pid").html(pid);
}

function stop_process(pid){
	$.ajax({
		url: 'scripts.php?action=stop_process',
		type: 'post',
		data: {
			pid: pid
		},
		success: function(data) {
			var str=data.replace(/(\r\n|\n|\r)/gm,"");
			if(str=='0'){
				$("#message-success").slideDown("slow");
				setTimeout(function(){close_message_success();},3000);
			}else{
				$("#message-warning").slideDown("slow");
				setTimeout(function(){close_message_warning();},3000);
			}
		},
		error: function() {
			$("#message-error").slideDown("slow");
			setTimeout(function(){close_message_error();},3000);
		}
	});
}


   function getencode(){
	   
	   var str=$("#text-encoder-output").val();
	   document.getElementById("from_name").value=str;
	   
   }
   
   
   
      function getencode1(){
	   
	   var str=$("#text-encoder-output1").val();
	   document.getElementById("subject").value=str;
	   
   }

function text_encode(){
	$.ajax({
		url: 'scripts.php?action=text_encode',
		type: 'get',
		data: {
			inputtext:$("#text-encoder-input").val()
		},
		success: function(data) {
			var str=data.replace(/(\r\n|\n|\r)/gm,"");
			str=str.replace("	","");
			$("#text-encoder-output").text(str);
		},
	});
}


function text_encode1(){
	$.ajax({
		url: 'scripts.php?action=text_encode',
		type: 'get',
		data: {
			inputtext:$("#text-encoder-input1").val()
		},
		success: function(data) {
			var str=data.replace(/(\r\n|\n|\r)/gm,"");
						str=str.replace("	","");
			$("#text-encoder-output1").text(str);
		},
	});
}


function get_text_encode(){
var fn=document.getElementById("from_name").value;

$("#text-encoder-input").text(fn);
}


function get_text_encode1(){
var fn=document.getElementById("subject").value;

$("#text-encoder-input1").text(fn);
}

//CHARTS
function get_campaigns_monitor_data() {
    var id_mailer = document.getElementById('mailer').value;
    $.ajax({
        url: 'scripts.php?action=get_campaigns_monitor_data',
        type: 'get',
        data: {
			date_from: document.getElementById('from_yy').value+'-'+document.getElementById('from_mm').value+'-'+document.getElementById('from_dd').value+' 00:00:00 ',
            date_to: document.getElementById('to_yy').value+'-'+document.getElementById('to_mm').value+'-'+document.getElementById('to_dd').value+' 23:59:59 ',
            id_mailer: id_mailer
        },
        success: function (data) {
            var list = JSON.parse(data);
            var rawData = [];
            var ticks = [];
            var hover_labels = [];
            var total_campaigns = 0;
            //PREPAERE DATA COMING FROM DB TO 3 ARRAYS
            list.forEach(function (value, i) {
                var campaigns_count = parseInt(value.data);
                rawData.push(
                    [i, campaigns_count]
                );

                ticks.push(
                    [i, id_mailer != 'all' ? value.hour : "ID: " + value.id_mailer ]
                );
                
                hover_labels.push(
                    value.label
                );

                total_campaigns += campaigns_count;
				
				
            });           
            //DISPLAY TOTAL
			// alert(total_campaigns);
            $("#total_campaigns_monitor").html(total_campaigns);
 
            var dataSet = [
                { label: id_mailer != 'all' ? "Campaigns Sent By Hour" : "Campaigns Sent By Mailer", data: rawData, color: "#e83200", data_hover: hover_labels }
            ];

            var options = {
                series: {
                    bars: {
                        show: true
                    }
                },
                bars: {
                    align: "center",
                    barWidth: 0.5
                },
                xaxis: {
                    axisLabel: "Mailers",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Verdana, Arial',
                    axisLabelPadding: 10,
                    ticks: ticks
                },
                yaxis: {
                    tickDecimals: 0,
                    axisLabel: "Campaigns",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Verdana, Arial',
                    axisLabelPadding: 3,
                    tickFormatter: function (v, axis) {
                        return v;
                    }
                },
                legend: {
                    noColumns: 0,
                    labelBoxBorderColor: "#e83200",
                    position: "ne"
                },
                grid: {
                    hoverable: true,
                    borderWidth: 2,        
                    backgroundColor: { colors: ["#ffffff", "#EDF5FF"] }
                }
            };

            //HOVER INTERACTIVITY CODE
            var previousPoint = null, previousLabel = null;

            $.fn.UseTooltip = function () {
                $(this).bind("plothover", function (event, pos, item) {
                    if (item) {
                        if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                            previousPoint = item.dataIndex;
                            previousLabel = item.series.label;
                            $("#tooltip").remove();
        
                            var x = item.datapoint[0];
                            var y = item.datapoint[1];
        
                            var color = item.series.color;
        
                            // console.log(item.series.data_hover[x]);        
                            
                            showTooltip(item.pageX,
                                    item.pageY,
                                    color,
                                    "<strong>" + item.series.data_hover[x] + "<strong>");                
                        }
                    } else {
                        $("#tooltip").remove();
                        previousPoint = null;
                    }
                });
            };
        
            function showTooltip(x, y, color, contents) {
                $('<div id="tooltip">' + contents + '</div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 40,
                    left: x - 90,
                    border: '2px solid ' + color,
                    padding: '3px',
                    'font-size': '9px',
                    'border-radius': '5px',
                    'background-color': '#fff',
                    'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
                    opacity: 0.9
                }).appendTo("body").fadeIn(200);
            }

            $.plot($("#bar_campaigns_monitor"), dataSet, options);
            $("#bar_campaigns_monitor").UseTooltip();       
        },
        error: function () {

        }
    });
}

function get_campaigns_count_by_status() {
    $.ajax({
        url: 'scripts.php?action=get_campaigns_count_by_status',
        type: 'get',
        data: {
			date_from: document.getElementById('from_yy').value+'-'+document.getElementById('from_mm').value+'-'+document.getElementById('from_dd').value+' 00:00:00 ',
            date_to: document.getElementById('to_yy').value+'-'+document.getElementById('to_mm').value+'-'+document.getElementById('to_dd').value+' 23:59:59 ',
            id_mailer: document.getElementById('mailer').value
        },
        success: function (data) {
            var list = JSON.parse(data);
            var total_campaigns = 0;
            //CALULATE TOTAL
            list.forEach(element => {
                total_campaigns += element.data;
            });
            //DISPLAY TOTAL
            $("#total_campaigns_status").html(total_campaigns);
            
            var options = {
                series: {
                    pie: {
                        show: true,
                        innerRadius: 0.5
                    }
                },
                grid: {
                    hoverable: true,
                    clickable: true
                }
            };

            $.fn.showMemo = function () {
                $(this).bind("plothover", function (event, pos, item) {
                    if (!item) { return; }
                    // console.log(item.series.data)
                    var html = [];
                    
                    var percent = parseFloat(item.series.percent).toFixed(2);
                    if(isNaN(percent))
                        percent = 0;
            
                    html.push("<div style=\"border:1px solid grey;background-color:",
                         item.series.color,
                         ";margin-top: 15px\">",
                         "<span style=\"color:white\">",
                         "<strong style=\"color:white\">" + item.series.label + "</strong>",
                         " (", percent, "%)",
                         "</span>", 
                         "</div>");
                    $("#hover_campaigns_status").html(html.join(''));
                });
            }

            var plot = $.plot($("#pie_campaigns_status"), list, options);
            $("#pie_campaigns_status").showMemo();

            //SELECT FIRST ELEMENT BY DEFAULT
            var col = 1;
            var series = plot.getData()[0]; // first series
            var dataIndex = col - 1;
            ps = series.datapoints.pointsize;
            var item = {
            datapoint: series.datapoints.points.slice(dataIndex * ps, (dataIndex + 1) * ps),
            dataIndex: dataIndex,
            series: series,
            seriesIndex: 0
            };         

            //TRIGGER HOVER EVENT FOR FIRST ELEMENT BY DEFAULT
            $('#pie_campaigns_status').trigger('plothover',  [ null, item ]);
        },
        error: function () {

        }
    });
}