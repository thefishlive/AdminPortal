$(document).ready(function() {

	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

	var checkin = $('#time-from').datepicker({
		format: 'dd/mm/yyyy',
		onRender : function(date) {
			return date.valueOf() < now.valueOf() ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
		if (ev.date.valueOf() > checkout.date.valueOf()) {
			var newDate = new Date(ev.date)
			newDate.setDate(newDate.getDate() + 1);
			checkout.setValue(newDate);
		}
		checkin.hide();
		$('#time-to').focus();
	}).data('datepicker');
	var checkout = $('#time-to').datepicker({
		format: 'dd/mm/yyyy',
		onRender : function(date) {
			return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
		checkout.hide();
	}).data('datepicker');

	$("#search-chat").click(function() {

		$("#chatlog-wrapper").slideUp();
		$("#loading").show();

		console.log($("#time-from").val());		
		console.log($("#time-to").val());
		
		$.ajax({
			url : "./assets/php/get-chat-log.php",
			cache : false,
			type : "POST",
			data : {
				timeFrom : $("#time-from").val(),
				timeTo : $("#time-to").val()
			},

			success : function(html) {
				$("#loading").hide();
				$("#chatlog-output").html(html);
				$("#chatlog-wrapper").slideDown();
			},
			error : function() {
				displayAlert("Could not get chat logs");
				$("#loading").hide();
			}
		});
	});
});
