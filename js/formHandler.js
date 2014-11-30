var files = undefined;

function prepareUpload(target) {
	files = target.files;
}

function uploadFiles(event) {
	event.stopPropagation();
	event.preventDefault();
	if (files == undefined) {
		$("#result").html("Select your image!");
		$("#result").animate({
			color: '#E34F4F'
		}, 500);
	} else {
		$("#result").html("Working...");
		$("#result").animate({
			color: '#34495E'
		}, 500);
		var data = new FormData();
		disableForm();
		enableSoinner();
		$.each(files, function(key, value) {
			data.append(key, value);
		});
		$.ajax({
			url: 'includes/upload_file.php?files',
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function(data, textStatus, jqXHR) {
				if (data.error == 0) {
					console.log('fileName: ' + data.name);
					console.log('id: ' + data.id);
					$("#statusCaption").html("Image uploaded. Generating art...");
					returnArt(data.id);
				} else {
					console.log('ERRORS: ' + data.error);
					$("#statusCaption").html("Error uploading image!</br>" + data.errorDesc);
					$("#result").html("Error!");
					disableSpinner();
					enableForm();
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$("#statusCaption").html("Error uploading image!");
				$("#statusCaption").animate({
					color: 'red'
				}, 500);
				console.log('ERRORS: ' + textStatus);
				console.log('ERRORS: ' + errorThrown);
				console.log('ERRORS: ' + jqXHR.responseText);
				disableSpinner();
				enableForm();
			}
		});
		return;
	}
}

function getValue(elem) {
	return document.getElementById(elem).value;
}

function isChecked(elem) {
	return document.getElementById(elem).checked;
}

function returnArt(id) {
	var additional = "";
	if (isChecked("checkbox2")) {
		additional = additional + "&additionalOptions=1";
		if (isChecked("checkbox3")) {
			additional = additional + "&private=1";
		}
		if (isChecked("checkbox1")) {
			additional = additional + "&customSize=1";
			if (getValue("width") > 0) {
				additional = additional + "&width=" + getValue("width");
			}
			if (getValue("height") > 0) {
				additional = additional + "&height=" + getValue("height");
			}
		}
		if (isChecked("checkbox4")) {
			additional = additional + "&customBackgroud=" + getValue("picker");
		}
	}
	$.ajax({
		url: 'includes/art.php',
		type: 'GET',
		data: 'id=' + id + additional,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		success: function(data, textStatus, jqXHR) {
			if (data.error == 0) {
				disableSpinner();
				$("#statusCaption").html("Art generated!");
				$("#result").html("Select your image!");
				$("#statusCaption").animate({
					color: 'green'
				}, 500);
				openArt(data.id);
				enableForm();
				disableSpinner();
				sendRequest();
			} else {
				console.log('ERRORS: ' + data.error);
				$("#statusCaption").html("Error generating art image!</br>" + data.errorDesc);
				$("#statusCaption").animate({
					color: 'red'
				}, 500);
				disableSpinner();
				enableForm();
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			$("#statusCaption").html("Error generating art!");
			$("#statusCaption").animate({
				color: 'red'
			}, 500);
			console.log('ERRORS: ' + textStatus);
			console.log('ERRORS: ' + errorThrown);
			console.log('ERRORS: ' + JSON.stringify(jqXHR));
			disableSpinner();
			enableForm();
		}
	});
}

function openArt(art){
	window.open("index.php?id="+art, 'mywindow', 'resizable=no, toolbar=no, scrollbars=yes location=no, directories=no, menubar = no');
}

function toggleEnabled(elem) {
	document.getElementById(elem).disabled = !document.getElementById(elem).disabled;
}

function toggleVisible(elem, duration) {
	$("#" + elem).toggle(duration);
}

function toggleCustomSize() {
	//toggleEnabled("width");
	//toggleEnabled("height");
	toggleVisible("customSize", 200);
}

function toggleCustomColor() {
	toggleVisible("customColor", 200);
}

function disableForm() {
	document.getElementById("submit").disabled = true;
}

function enableForm() {
	document.getElementById("submit").disabled = false;
}

function disableSpinner() {
	$("#spinner").fadeOut(200);
}

function removeCaption() {
	$("#statusCaption").fadeOut(200);
}

function enableSoinner() {
	$("#spinner").show(200);
	$("#statusCaption").show(200);
	$("#statusCaption").animate({
		color: 'black'
	});
	$("#statusCaption").html("Uploading image...");
}