var files;

function prepareUpload(target) {
	files = target.files;
}

function uploadFiles(event) {
	event.stopPropagation();
	event.preventDefault();
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
}

function returnArt(id) {
	$.ajax({
		url: 'includes/art.php',
		type: 'GET',
		data: 'id=' + id,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		success: function(data, textStatus, jqXHR) {
			if (data.error == 0) {
				disableSpinner();
				$("#statusCaption").html("Art generated! Opening..");
				$("#statusCaption").animate({
					color: 'green'
				}, 500);
				window.open(data.art, 'mywindow', 'resizable=no, toolbar=no, scrollbars=yes location=no, directories=no, menubar = no');
				enableForm();
				disableSpinner();
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

function toggleCustomSize(){
	document.getElementById("width").disabled = !document.getElementById("width").disabled;
	document.getElementById("height").disabled = !document.getElementById("height").disabled;
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

function removeCaption(){
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