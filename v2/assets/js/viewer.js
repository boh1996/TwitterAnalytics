window.autoRefresh = true;
window.refreshRate = 60000;

/**
 * Bootstrap theme for Highcharts JS
 * @author Martin Aarhof
 */

Highcharts.theme = {
	colors: ['#0044cc', '#2f96b4', '#51a351', '#f89406', '#bd362f', '#222222'],
	chart: {
		backgroundColor: 'transparent',
		plotBackgroundColor: 'transparent',
		plotShadow: false,
		plotBorderWidth: 0
	},
	title: {
		style: {
			color: '#333',
			font: 'bold 20px "Helvetica Neue", Helvetica, Arial, sans-serif'
		}
	},
	subtitle: {
		style: {
			color: '#666666',
			font: 'bold 12px "Helvetica Neue", Helvetica, Arial, sans-serif'
		}
	},
	xAxis: {
		gridLineWidth: 1,
		lineColor: '#333',
		tickColor: '#333',
		labels: {
			style: {
				color: '#333',
				font: '11px "Helvetica Neue", Helvetica, Arial, sans-serif'
			}
		},
		title: {
			style: {
				color: '#333',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: '"Helvetica Neue", Helvetica, Arial, sans-serif'

			}
		}
	},
	yAxis: {
		minorTickInterval: 'auto',
		lineColor: '#333',
		lineWidth: 1,
		tickWidth: 1,
		tickColor: '#333',
		labels: {
			style: {
				color: '#000',
				font: '11px "Helvetica Neue", Helvetica, Arial, sans-serif'
			}
		},
		title: {
			style: {
				color: '#333',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: '"Helvetica Neue", Helvetica, Arial, sans-serif'
			}
		}
	},
	legend: {
		itemStyle: {
			font: '9pt "Helvetica Neue", Helvetica, Arial, sans-serif',
			color: '#333'

		},
		itemHoverStyle: {
			color: '#039'
		},
		itemHiddenStyle: {
			color: 'gray'
		}
	},
	labels: {
		style: {
			color: '#99b'
		}
	},

	navigation: {
		buttonOptions: {
			theme: {
				stroke: '#CCCCCC'
			}
		}
	}
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);


function refresh ( url ) {
	url = url || window.url;
	window.url = url;

	if ( ! localStorage.getItem("twa_token") === false ) {
		$.ajax({
			type : "GET",
			dataType: 'json',
			contentType : "application/json",
			url : base_url + url + "?token=" + localStorage.getItem("twa_token"),
		}).success( function ( data ) {

			$("#avg").html( data.avg );

			var dataValues = [];
			var colors = [];
			var lab = [];

			var response = data

			$(response.tweets).each( function ( index, element ) {
				var label = element.change_next || "";
				lab.push(label);
				dataValues.push({
					y: parseInt(element.tweet_count),
					color: element.color,
					categories : element.categories
				});
			} );

			$("#chart").highcharts({
				chart : {
					type : "column"
				},
				title : {
					text : pageObject.name
				},
				credits : {
					enabled : false
				},
				yAxis : {
					min : 0,
					title : {
						text : translations.user_tweets_per_interval
					}
				},
				xAxis : {
					tickPositions : [ 0.5, 1.5, 2.5, 3.5, 4.5, 5.5, 6.5, 7.5, 8.5, 9.5],
					labels: {
						formatter : function () {
							var x = this.value - 0.5;
							if ( lab[x] != "" ) {
								return lab[x] + "%";
							} else {
								return "";
							}
						}
					},
					tickmarkPlacement : "between",
					title : {
						text : translations.user_intervals_right_to_left
					}
				},
				series : [{
					type : "column",
					data: dataValues,
					name : pageObject.name,
					showInLegend: false,
				}],
				tooltip: {
					useHTML : true,
				     formatter: function () {
				     	var string = "";

				     	$(this.point.categories).each( function (index, element) {
				     		string =  string + translations.user_category + ":" + element.name + " - " + translations.user_count + ":"  + element.count + "<br>";
				     	} );
				     	if ( string != "" ) {
				     		string = string + translations.user_count + ":"  + this.y + "<br>";
				        	return string;
				    	} else {
				    		return translations.user_count + ":"  + this.y;
				    	}
				     }
				}
			});
		} ).error( function ( xhr, status, test ) {
			var data = xhr.responseJSON;
			if ( data.login_redirect == true ) {
				window.location = base_url + "sign_in"
			}

			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );

		if ( window.autoRefresh === true ) {
			setTimeout( function () {
				refresh();
			}, window.refreshRate );
		}
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
}

$(document).ready( function () {
	refresh("get/tweets/" + page + "/" + $('.selectpicker').find('option:eq(0)').attr("data-key"));
	$('.selectpicker').selectpicker();

	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
	    $('.selectpicker').selectpicker('mobile');
	}
} );

$(document).on("click", "#refresh", function () {
	var value = $("#intervals").val();
	refresh("get/tweets/" + page + "/" + $('#intervals').find('option[value="' + value + '"]').attr("data-key"));
} );

$(document).on("change", "#intervals", function () {
	var value = $("#intervals").val();
	refresh("get/tweets/" + page + "/" + $('#intervals').find('option[value="' + value + '"]').attr("data-key"));
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