/**
 * This function replaces the template variables with the correct data
 * @param  {string} string The template
 * @param  {object} data   The template variables and values
 * @param {boolean} propagate If the childs should be templated too
 * @return {string}
 */
function template (string,data, propagate) {
	for(var variable in data) {
		var replacement = data[variable];
		if (variable.indexOf("{") !== -1 && variable.indexOf("}") !== -1 && propagate !== false) {
			variable = template(variable,data,false);
		}
		if (replacement.indexOf("{") !== -1 && replacement.indexOf("}") !== -1 && propagate !== false) {
			replacement = template(replacement,data,false);
		}

	    string = string.replace("{"+variable+"}",replacement);
	}
	return string;
}

function findByProperty ( array, property, value) {
	for (var i = 0; i < array.length; i++) {
		if ( array[i][property] == value ) {
			return array[i];
		}
	}
}

/**
 * This function is a wrapper for the bootstrap alert system
 * @param  {object} data          Data for the Mustache template
 * @param  {string} template      An optional Mustcahe template for the content, if no data is supplied then this would be the text
 * @param  {string} templateId    The id without the # of the alert template to use
 * @param  {object} container     The container to insert the alert into
 * @param  {string} mode          The insert mode "prepend" or "append"
 * @param  {function} closeCallback A function to called when the alert is closed
 * @param  {integer} timeout       An optional time in ms the alert should be shown
 */
function alert ( data, template, templateId, container, mode, closeCallback, timeout ) {
	container = container || $("body");
	timeout = timeout || null;
	$("#" + templateId + "Clone").remove();
	var alert = $("#" + templateId).clone();
	var html = alert.html();
	if (data == null) {
		var content = template;
	} else {
		var content = Mustache.render(template,data);
	}

	alert.html(html.replace("{{message}}",content));
	alert.attr("id",templateId+"Clone");

	if ( mode == "append" )  {
		$(container).append(alert);
	} else {
		$(container).prepend(alert);
	}

	if ( timeout != null ) {
		setTimeout(function () {
			$("#" + templateId + "Clone").alert("close");

			if ( typeof closeCallback == "function" ) {
				closeCallback();
			}
		},timeout);
	}
}

function makeid( length )
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < length; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}