var button_container = d3.select("#clock-action-button");

var clock_action = button_container.select("#timer-action");
var clock_time = button_container.select("#time");

//calculate circle radious relative to div size (suport of multiple screen resolutions) 
var circle_radius=$("#clock-action-button").height()*0.3;
var animating = false;

button_container.select("circle")
	.attr("r",circle_radius)
	.attr("transform","translate("+($("#stopwatch").width()/2)+","+$("#stopwatch").height()/2+")")
	.on("mouseover",function(){
		if(check_inputs()){
			d3.select(this).attr("stroke-width","5");
		}
	})
	.on("mouseout",function(){
		d3.select(this).attr("stroke-width","3");
	})
	.on("click",function(){
		if(check_inputs()){
			if(clock_action.text()=="Start"){
				start();
				logPresentWork("start");
			}else{
				end();
				logPresentWork("end");
			}
		}
});

clock_action.attr("transform","translate("+($("#stopwatch").width()/2-$("#timer-action").width()/2)+","+($("#stopwatch").height()/2+$("#time").height()/2)+")")
	.attr("font-size",(circle_radius/10));
clock_time.attr("transform","translate("+($("#stopwatch").width()/2-($("#time").width()/2))+","+$("#stopwatch").height()/2+")")
	.attr("font-size",(circle_radius/4));

function format_digits(number){
	return number>9 ? number: "0"+number;
}

function check_past_inputs(){
	var project = document.getElementById('projectvalue').value;
	var activity = document.getElementById('activityvalue').value;
	var fromdate = document.getElementById('fromdate').value;
	var todate = document.getElementById('todate').value;
	if(project != "select a project" && activity != "select an Activity" && fromdate !== "" && todate !== ""){
		$('#logsubmit').prop('disabled', false);
	}
}

function check_inputs(){
	check_past_inputs();
	var estimatedtime = document.getElementById('estimatedtime').value;
	var present_time = document.getElementById('optradio').checked;
	var project = document.getElementById('projectvalue').value;
	var activity = document.getElementById('activityvalue').value;
	if(!present_time || estimatedtime=="Estimated Time" || project == "select a project" || activity == "select an Activity") {
		button_container.select("circle").attr("stroke","grey");
		button_container.selectAll("text").attr("fill","grey");
		return false;
	}else{
		button_container.select("circle").attr("stroke","steelblue");
		button_container.selectAll("text").attr("fill","#e58757");
		if(!animating){
			animating = true;
			animate_stopwatch = setInterval(function() {
				if(button_container.select("circle").attr("r") == circle_radius){
					button_container.select("circle").transition().attr("r",circle_radius*1.1).duration(400);
				}else if(button_container.select("circle").attr("r") == circle_radius*1.1){
					button_container.select("circle").transition().attr("r",circle_radius).duration(400);
				}
			},400);
			endanimation = setTimeout(function() {
				clearInterval(animate_stopwatch);
				button_container.select("circle").transition().attr("r",circle_radius).duration(400);
			}, 1600);
		}
		return true;
	}
}

function start(){
	start_date = Date.now();
	document.getElementById("fromdate").value = start_date;
	//format(date);
	button_container.classed("active",true);
	clock_action.text("End");
	refreshIntervalId = setInterval(function() {
		var current_date = Date.now();
		var milliseconds = (current_date-start_date);
		var hours = Math.floor(milliseconds / 36e5),
			mins = Math.floor((milliseconds % 36e5) / 6e4),
			secs = Math.floor((milliseconds % 6e4) / 1000);
			clock_time.text(format_digits(hours) + ":" + format_digits(mins) + ":" + format_digits(secs));
	}, 1000);
	var estimatedTime = parseInt(document.getElementById('estimatedtime').value,10);
	estimatedTimeReached = setTimeout(function() {
		d3.select("#estimated-alert").transition().style("opacity","1").duration(2000);
	}, Number(estimatedTime*60*1000));
}

function end(){
	clearInterval(refreshIntervalId);
	var end_date = Date.now();
	document.getElementById("todate").value = end_date;
	console.log(document.getElementById("todate").value,document.getElementById("fromdate").value);
	clock_action.text("Start");
	d3.select("#submitted-alert").transition().style("opacity","1").duration(2000);
	setTimeout(function(){
		d3.select("#submitted-alert").transition().style("opacity","0").duration(2000);
	},4000);
}
