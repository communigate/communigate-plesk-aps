// This script sends the id of the subscribe buttons, in the mailing
// list controller, index view to the hidden field in the subscribe form
document.addEventListener("DOMContentLoaded", function(event) {
	var subscribeBtn = $('a[data-target="#subscribeModal"]');
	subscribeBtn.click(function() {
		$('#SubscribeForm_listName').val(this.id);
	});
	var unsubscribeBtn = $('a[data-target="#unsubscribeModal"]');
	unsubscribeBtn.click(function() {
		$('#unsubscribeListName').val($(this).attr("data-listname"));
	});

});
