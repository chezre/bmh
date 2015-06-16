var currentPage = 1;
function buildChart() {
	$.get("get.chart.data.php").done(function(data){
		var dataSource = [];
		var json = $.parseJSON(data);
		for (var i=0;i<json.length;i++) {
			dataSource.push({month: json[i].month,incomplete: parseInt(json[i].incomplete),complete: parseInt(json[i].complete)});
			var chartOptions = {
			    dataSource: dataSource,
			    commonSeriesSettings: {
			        type: "stackedBar",
			        argumentField: "month",
			        font: { color: "#FFF" }
			    },
			    commonAxisSettings: {
			        color: 'white',
			        grid: {
			            visible: true,
			            color: 'white'
			        },
			        label: {
			            font: { color: 'white' }
			        }
			    },
			    series: [
			        { valueField: "complete", name: "Complete", color: "#254B7C" },
			        { valueField: "incomplete", name: "Incomplete", color: "#CD3333" }
			    ],
			    tooltip:{
			        enabled: true
			    },
			    legend: {
			        verticalAlignment: "top",
			        horizontalAlignment: "right",
					font: { color: 'white' }
			    },
			    title: "Complete & Incomplete Registrations (last 6 months)"
			};
			$("#chartDiv").dxChart(chartOptions);
		}
	});
}

$(document).ready(function() {
	$(".metricDiv").click(function(){
		$("#detailsHeadingDiv").empty().append($(this).find('.desc').attr('title'));
		var id = $(this).attr('val');
		$("#currentId").val(id);
		currentPage = 1;
		submitFrm();
	});
	$("#mainMetric").click(function(){
		$("#detailsHeadingDiv").empty().append("Completed Registrations");
		currentPage = 1;
		getCompleteRegistrations();
	});
	$("#rfid,#email").keyup(function() {
		$("#detailsHeadingDiv").empty().append("Search Results");
		currentPage = 1;
		getSearchedChips();
	});
	
	buildChart();
});

function submitFrm() {
	var id = $("#currentId").val();
	$.post("get.detail.php",{i: id,pg: currentPage}).done(function(data){
		$("#tblReportDetails").empty().append(data);
	});
}

function getCompleteRegistrations() {
	$.post("get.completed.registrations.php",{pg: currentPage}).done(function(data){
		$("#tblReportDetails").empty().append(data);
	});
}
function getSearchedChips() {
	var r = $("#rfid").val();
	var e = $("#email").val();
	$.post("get.searched.rfids.php",{pg: currentPage,rfid: r,email: e}).done(function(data){
		$("#tblReportDetails").empty().append(data);
	});
}