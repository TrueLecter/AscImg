<?php
	$currPath = true;
	$selected = 0;
	if (isset($_GET["id"]) && intval($_GET["id"]) > 0) {
		include "./includes/getArtById.php";
		die("");
	}
	if (isset($_GET["gallery"])) {
		$selected = 1;
	}
	?>
<html>
	<head>
		<title>Img to colored HTML art</title>
		<meta charset="utf-8">
		<link href="css/fui/css/vendor/bootstrap.min.css" rel="stylesheet">
		<link href="css/fui/css/flat-ui.css" rel="stylesheet">
		<link href="css/spinner.css" rel="stylesheet">
		<link href="css/table.css" rel="stylesheet">
		<script src="js/jquery.min.js"></script>
		<script src="js/formHandler.js"></script>
		<script src="js/pageUtils.js"></script>
		<script src="js/flat-ui.min.js"></script>
		<script src="js/application.js"></script>
		<script src="js/colpick.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/colpick.css" type="text/css"/>
		<style type="text/css">
			.fileUpload {
			position: relative;
			overflow: hidden;
			margin: 10px;
			}
			.fileUpload input.upload {
			position: absolute;
			top: 0;
			right: 0;
			margin: 0;
			padding: 0;
			font-size: 20px;
			cursor: pointer;
			opacity: 0;
			filter: alpha(opacity=0);
			}
			#picker {
			border-right:20px solid green;
			}
		</style>
		<script type="text/javascript">
			function toggleOptions(){
				toggleVisible("options", 200);
			}
			$(document).ready(function(){
				document.getElementById("checkbox2").checked = false;
				document.getElementById("checkbox1").checked = false;
				document.getElementById("checkbox3").checked = false;
				document.getElementById("checkbox4").checked = false;
				sendRequest();
				<? if ($selected == 1){
					echo "gallery();";} ?>	
				$('#picker').colpick({
	layout:'hex',
	submit:0,
	colorScheme:'dark',
	onChange:function(hsb,hex,rgb,el,bySetColor) {
		$(el).css('border-color','#'+hex);
		if(!bySetColor) $(el).val(hex);
	}
}).keyup(function(){
	$(this).colpickSetColor(this.value);
});
			})
		</script>
	</head>
	<body style="background-color : #E3E4E8;">
		<?php include "includes/header.php"; ?>
		<div id="publish">
			<center>
				<h3 id="result">Submit your image</h3>
			</center>
			<form action="includes/upload_file.php" id="form" method="post" enctype="multipart/form-data" style="width:auto;" onsubmit="uploadFiles(event);">
				<div class="form-group" style="position: relative; left: 50%; margin-left: -188px;">
					<input id="uploadFile" placeholder="Choose File" readonly="readonly" style="width: 300px;">
					<div class="fileUpload btn btn-primary" style="width: 75px;">
						<span>Upload</span>
						<input type="file" name="file" class="upload" id="uploadBtn">
					</div>
				</div>
				<div style="width: 500px; position: relative; left: 50%; margin-left: -188px; margin-bottom: 30px;">
					<label class="checkbox" for="checkbox2" style="width: 150px; margin-right: 9.3%;">
						<input type="checkbox" value="" id="checkbox2" data-toggle="checkbox" name="additionalOptions" onchange="toggleOptions();">
						Additional options
					</label>
					<div id="options" style="display: none; ">
						<label class="checkbox" for="checkbox3" style="width: 80px; margin-left: 5%; position: relative; left:0;">
							<input type="checkbox" value="" id="checkbox3" data-toggle="checkbox" name="private">
							Private
						</label>
						<label class="checkbox" for="checkbox1"  style="max-width: 110px; margin-left: 5%; position: relative; left:0;">
							<input type="checkbox" value="" id="checkbox1" data-toggle="checkbox" name="customSize" onchange="toggleCustomSize();">
							Custom size
						</label>
						<div id="customSize" style="display: none; margin-left: 10%;">
							<input id="width" type="text" placeholder="Width" pattern="\d+" style="margin-bottom: 5px;">
							</br>
							<input id="height" type="text" placeholder="Height" pattern="\d+" >
							</br>
						</div>
						<label class="checkbox" for="checkbox4"  style="margin-left: 5%; position: relative; left:0;">
							<input type="checkbox" value="" id="checkbox4" data-toggle="checkbox" name="customSize" onchange="toggleCustomColor();">
							Custom background color
						</label>
						<div id="customColor" style="display: none; margin-left: 10%;">
							<input type="text" id="picker" ></input>
						</div>
					</div>
				</div>
				<center>
					<input type="submit" name="submit" id="submit" class="btn btn-block btn-lg btn-primary" style='max-width: 200px;' value="Submit">
				</center>
			</form>
			<center>
				<div id="status">
					<div id="statusCaption"></div>
					<div id="spinner" style = "padding-top: 0.5%;">
						<div class="windows8">
							<div class="wBall" id="wBall_1">
								<div class="wInnerBall">
								</div>
							</div>
							<div class="wBall" id="wBall_2">
								<div class="wInnerBall">
								</div>
							</div>
							<div class="wBall" id="wBall_3">
								<div class="wInnerBall">
								</div>
							</div>
							<div class="wBall" id="wBall_4">
								<div class="wInnerBall">
								</div>
							</div>
							<div class="wBall" id="wBall_5">
								<div class="wInnerBall">
								</div>
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					document.getElementById("uploadBtn").onchange = function() {
					    document.getElementById("uploadFile").value = document.getElementById("uploadBtn").value;
					    prepareUpload(document.getElementById("uploadBtn"));
					};
					$("#spinner").hide();
					$("#statusCaption").hide();
					$('#uploadBtn').value = "";
					$('#uploadFile').value = "";
				</script>
			</center>
		</div>
		<div id="gallery">
			<div id="spinnerGallery" style = "padding-top: 0.5%; position: relative; left: 50%; margin-left: -25px; width: 100px;">
						<div class="windows8">
							<div class="wBall" id="wBall_1">
								<div class="wInnerBall">
								</div>
							</div>
							<div class="wBall" id="wBall_2">
								<div class="wInnerBall">
								</div>
							</div>
							<div class="wBall" id="wBall_3">
								<div class="wInnerBall">
								</div>
							</div>
							<div class="wBall" id="wBall_4">
								<div class="wInnerBall">
								</div>
							</div>
							<div class="wBall" id="wBall_5">
								<div class="wInnerBall">
								</div>
							</div>
						</div>
					</div>
			<div id="table"></div>
		</div>
		<?php include "includes/footer.php"; ?>
	</body>
</html>
