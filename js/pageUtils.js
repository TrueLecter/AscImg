var selected = 0;

function publish(){
	if (selected != 0){
		$("#gallery").hide();
		$("#publish").fadeIn(200);
		selected = 0;
		$("#aLink").addClass("active");
		$("#bLink").removeClass("active");
	}
}

function gallery(){
	if (selected != 1){
		$("#aLink").removeClass("active");
		$("#bLink").addClass("active");
		$("#publish").hide();
		$("#gallery").fadeIn(200);
		selected = 1;
	}
}