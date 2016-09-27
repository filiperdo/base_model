$(document).ready(function() {
	
	$('.calendary').daterangepicker({
		singleDatePicker: true,
		calender_style: "picker_4",
		format: 'DD/MM/YYYY' 
		
	}, function(start, end, label) {
		console.log(start.toISOString(), end.toISOString(), label);
	});
	
	$(".delete").click(function(e) {
		var c = confirm("Deseja realmente deletar este registro?");
		if (c == false) return false;
	}); 

});