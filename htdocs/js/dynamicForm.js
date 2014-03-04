var i = 1;
var l = 1;
function cloneFormElements (formID, attributes, wrapperDivID, i) {
	var	newWrapperDivId = wrapperDivID + '_' + i;
	var copy = $('#' + wrapperDivID).clone(true, true).html();
	var className = $('#' + wrapperDivID).attr('class');
	if (i == 1 ) {
		$('<div id='+ newWrapperDivId  +' class=' + className +'></div>').insertAfter('#' + wrapperDivID);
	} else{
		$('<div id='+ newWrapperDivId  +' class=' + className +'></div>').insertAfter('#' + wrapperDivID + '_' + (i - 1));
	};
	
	for (var j = 0; j < attributes.length; j++) {

		regEx = new RegExp(formID + '_' + attributes[j], 'g');
		var	toReplace = formID + '_'+ i +'_' + attributes[j];
		var copy = copy.replace(regEx, toReplace);

		regEx = new RegExp(formID + '\\[' + attributes[j] + '\\]', 'g');
		toReplace = formID + '['+ i +']' +'['+ attributes[j] +']';
		copy = copy.replace(regEx, toReplace);
	};
	copy = copy.replace(/btnRemove/g, 'btnRemove_' + i );
	copy = copy.replace(/btnActionRemove/g, 'btnRemove_' + i );
	copy = copy.replace('Rules', '');
	copy = copy.replace('Action', '');
	$('#' + newWrapperDivId).append($(copy));
}

if (typeof filterValues != 'undefined') {
	$('#CreateFilterForm_name').val(filterValues[1]);
	$('#CreateFilterForm_priority').val(filterValues[0]);
	$('#CreateFilterForm_data').val(filterValues[2][0][0]);
	$('#CreateFilterForm_operation').val(filterValues[2][0][1]);
	$('#CreateFilterForm_dataParam').val(filterValues[2][0][2]);
	var attributes = ['data', 'operation', 'dataParam'];

	for (var j = 0; j < filterValues[2].length - 1; j++) {
		cloneFormElements('CreateFilterForm', attributes, "rules", i);
		$('#CreateFilterForm_'+i+'_data').val(filterValues[2][i][0]);
		$('#CreateFilterForm_'+i+'_operation').val(filterValues[2][i][1]);
		$('#CreateFilterForm_'+i+'_dataParam').val(filterValues[2][i][2]);
				i++;
	};
	var attributes = ['action', 'actionParam'];
	$('#CreateFilterForm_action').val(filterValues[3][0][0]);
	$('#CreateFilterForm_actionParam').val(filterValues[3][0][1])
	for (var j = 0; j < filterValues[3].length - 1; j++) {
		cloneFormElements('CreateFilterForm', attributes, "actions", l);
		console.log(filterValues[3][l][0]);
		$('#CreateFilterForm_'+l+'_action').val(filterValues[3][l][0]);
		$('#CreateFilterForm_'+l+'_actionParam').val(filterValues[3][l][1])
		l++;
	};
};

$('.duplicate').live('click', duplicateRules);

$('.remove').live('click', function(event) {
	event.preventDefault();
	var p =	this.id.substr(this.id.length - 1);
	$('#rules_' + p ).remove();
	if (i != 1) {i--;};
});

$('.duplicateAction').live('click', function(event) {
	event.preventDefault();
	var attributes = ['action', 'actionParam'];
	cloneFormElements('CreateFilterForm', attributes, "actions", l);
	l++;
});

$('.removeAction').live('click', function(event) {
	event.preventDefault();
	var p =	this.id.substr(this.id.length - 1);
	$('#actions_' + p ).remove();
	if (l != 1) {l--;};
});

function duplicateRules (event) {
	event.preventDefault();
	var attributes = ['data', 'operation', 'dataParam'];
	cloneFormElements('CreateFilterForm', attributes, "rules", i);
	i++;
}
