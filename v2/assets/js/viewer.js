window.autoRefresh = false;
window.refreshRate = 60000;

function refresh ( url ) {

	if ( ! localStorage.getItem("twa_token") === false ) {
		$.ajax({
			type : "GET",
			dataType: 'json',
			contentType : "application/json",
			url : base_url + url + "?token=" + localStorage.getItem("twa_token"),
		}).success( function ( data ) {

			/*var datasets = [];

			var response = data

			$(response.tweets).each( function ( index, element ) {
				var color = hexToRgb(element.color);
				datasets.push({
					fillColor : "rgba(" + color.r + ", " + color.g + " , " + color.b + " ,0.5)",
					strokeColor : "rgba(" + color.r + ", " + color.g + " , " + color.b + " ,1)",
					data : [element.tweet_count]
				});
			} );

			var ctx = document.getElementById("stats").getContext("2d");
			console.log(datasets);

			var chartData = {
				labels : [""],
				datasets : datasets
			};

			window.chart = new Chart(ctx).Bar(chartData, {
				scaleLineWidth : 10,
				barDatasetSpacing : 5
			});*/

			$("#chart").highcharts({
				chart : {
					type : "bar"
				}
			});
		} ).error( function ( xhr, status, data ) {
			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );

		if ( window.autoRefresh === true ) {
			setTimeout( function () {
				refresh(url);
			}, window.refreshRate );
		}
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
}

$(document).ready( function () {
	refresh("get/tweets/1/400000");
} );

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}