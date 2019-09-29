// Select 2
var Select2=function(){
	if($( ".select2" ).length>0) {
	$(".select2").select2({ 
		});
	}
};

// Order
var Order=function(){
	if(location.href == 'http://127.0.0.1:8000/report/order')
	{
		$('form button[id="http://127.0.0.1:8000/report/order?status_id=1"]').addClass('active-bg');
	}
	$('form button[id="' + location.href + '"]').addClass('active-bg');
};

$(function(){
	Select2();
	Order();
});
