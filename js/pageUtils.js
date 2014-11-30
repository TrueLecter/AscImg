var selected = 0;
var limit = 0;
var debug = "";

function publish() {
	if (selected != 0) {
		$("#gallery").hide();
		$("#publish").fadeIn(200);
		selected = 0;
		$("#aLink").addClass("active");
		$("#bLink").removeClass("active");
	}
}

function gallery() {
	if (selected != 1) {
		$("#aLink").removeClass("active");
		$("#bLink").addClass("active");
		$("#publish").hide();
		$("#gallery").fadeIn(200);
		selected = 1;
	}
}

function changePage(pageV) {
	limit = pageV;
	sendRequest();
}

function sendRequest() {
	$("#spinnerGallery").fadeIn(200);
	$('#table').hide();
	$.ajax({
		type: "POST",
		url: "includes/gallery.php",
		data: "&limit=" + limit,
		dataType: 'json',
		success: function(data) {
			processResponce(data);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			retry();
		}
	});
}

function retry() {
	$.ajax({
		type: "POST",
		url: "includes/gallery.php",
		data: "&limit=" + limit,
		dataType: 'json',
		success: function(data) {
			processResponce(data);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			$("#spinnerGallery").hide();
			$("#table").fadeIn(200);
			$("#table").html("<center><h4>Request error!</h4>" + xhr.responseText + "</center>");
		}
	});
}

function processResponce(result) {
	debug = result;
	$("#spinnerGallery").hide();
	$('#table').html(processsTable(result.table) + processsPaging(result.pagination));
	$('#table').fadeIn(200);
	$("img").hover(function() {
		Pixastic.process($(this).get(0), "glow", {
			amount: 0.5,
			radius: 1.0
		});
	}, function() {
		Pixastic.revert($(this).get(0));
	});
}

function processsPaging(menu) {
	if (menu.empty) {
		return "";
	}
	var inHtml = "<center><div class=\"pagination pagination-info\">\n<ul>";
	if (menu['start'] != 1) {
		inHtml = inHtml + "<li><a href=\"#\" onclick=\"changePage(0)\"><i class=\"fui-arrow-left\"></i><i class=\"fui-arrow-left\"></i></a></li>\n";
	}
	for (var key in menu) {
		if (key == "total") {
			continue;
		}
		if (menu[key]["active"] == "true") {
			inHtml = inHtml + "<li class=\"active\"><a  href=\"#\">" + menu[key]["caption"] + "</a></li>";
		} else {
			inHtml = inHtml + "<li><a  href=\"#\" onclick=\"changePage(" + menu[key]["page"] + ")\">" + menu[key]["caption"] + "</a></li>";
		}
	}
	if (menu['start'] != 1) {
		inHtml = inHtml + "<li><a href=\"#\" onclick=\"changePage(" + menu["total"] + ")\"><i class=\"fui-arrow-right\"></i><i class=\"fui-arrow-right\"></i></a></li>";
	}
	return inHtml + "</ul></div><center>";
}

function processsTable(menu) {
	if (menu.empty) {
		return "<center><h4>Empty!</h4></center>";
	}
	var inHtml = "<div class=\"wrapper\"><div class=\"table\">\n<div class=\"row\">";
	var i = 0;
	for (var key in menu) {
		if (i > 0 && i % 4 == 0) {
			inHtml = inHtml + "</div><div class=\"row\">"
		}
		inHtml = inHtml + "<div class=\"cell\"><a onclick=\"openArt(" + menu[key]["id"] + ")\" href=\"javascript:void(0)\"><img class=\"glow\" src=\"" + menu[key]["image"] + "\"></img></a></div>";
		i++;
	}
	return inHtml + "</div></div>";
}