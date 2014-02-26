function refresh_panel() {
    $('#menu_repeat').load("script/processing/load_panel.php", {random: Math.random()});
	$('#mycart_container').load("script/processing/load_cart.php", {random: Math.random()});
	$('#banner_bottom_repeat').load("script/processing/search_area.php", {random: Math.random()});
	load_content('page_catalogue.php');
}

function clear_screen() {
	$('body').find(".tipsy").remove();
	$('body').find(".formError").remove(); // Clears All Form Validation Error Messages
}

function load_content(file_name) {
	clear_screen();
	$('#content_repeat').load("script/modules/" + file_name, {random: Math.random()});
}

function process_request(file, parameters, fn) {
	parameters.random = Math.random();
	$.ajax({  
	  type: 'POST',
	  url: 'script/processing/' + file + '.php',
	  data: parameters,
	  success: fn
	});
}

function submit_response(result) {
	var json = $.evalJSON(result);
	$('#info_message').animate({"height": "show"}, { duration: 1000 });
	$('#info_message').html(json.message);
}

function delete_response(result) {
	var json = $.evalJSON(result);
	if (json.success) {
		$.growlUI('Record Removed', json.message);
	}
}

function login_response(result) {
	var json = $.evalJSON(result);
	if (json.success) {
		refresh_panel();
		$.growlUI(json.title, json.message);
	}
}

function mycart_response(result) {
	var json = $.evalJSON(result);
	if (json.success) {
		$('#mycart_container').load("script/processing/load_cart.php", {random: Math.random()});
		$.growlUI('MyCart', json.message);
	}
}
								
function show_record(id, file_name) {
	clear_screen();
	$('#content_repeat').load("script/modules/" + file_name, {id : id, random: Math.random()});
}

$(function() {
	$('#delete_dialog').dialog({
		autoOpen: false,
		resizable: false,
		height: 210,
		modal: true,
		overlay: {
			opacity: 0.5
		},
		buttons: {
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
});

function delete_record(record_id, class_name, fn) {
	$('#delete_dialog').dialog('option', 'buttons', {
		'Delete Record': function() {
			process_request('delete_record', {record_id: record_id, class_name: class_name}, delete_response); 
			$(this).dialog("close"); 
			fn();
		},
		Cancel: function() {
			$(this).dialog('close');
		}
	});
	$('#delete_dialog').dialog('open');
}

refresh_panel();
$('#show_catalogue').click(function () {
	load_content('page_catalogue.php');
});