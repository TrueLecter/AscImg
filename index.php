<html>

<head>
    <title>Img to colored ASCII art</title>
    <meta charset="utf-8">
    <link href="css/fui/css/vendor/bootstrap.min.css" rel="stylesheet">
    <link href="css/fui/css/flat-ui.css" rel="stylesheet">
   	<link href="css/spinner.css" rel="stylesheet">
   	<script src="js/jquery.min.js"></script>
    <script src="js/flat-ui.min.js"></script>
    <script src="js/application.js"></script>
    <script src="js/formHandler.js"></script>
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
    </style>
</head>

<body>
	<center><h3 id="result"></h3>
    <form action="includes/upload_file.php" id="form" method="post" enctype="multipart/form-data" style="width:auto;" onsubmit="uploadFiles(event);">
        <div class="form-group">
            <input id="uploadFile" placeholder="Choose File" disabled="disabled">
            <div class="fileUpload btn btn-primary">
                <span>Upload</span>
                <input type="file" name="file" class="upload" id="uploadBtn">
            </div>
            <!--</br>
            Custom size: <input type="checkbox" id="customSize" onchange="toggleCustomSize();" checked="true"></br>
            <input id="width" type="text" placeholder="Width" pattern="\d+"></br>
            <input id="height" type="text" placeholder="Height" pattern="\d+"></br>
            </br><b>Note: </b> if image size will be more then 500x500, image will be automaticaly resized!-->
        </div>
        <input type="submit" name="submit" id="submit" class="btn btn-block btn-lg btn-primary" style='max-width: 200px;' value="Submit">
    </form>
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
    </script></center>
</body>

</html>
