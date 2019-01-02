$("a[data-trigger=event]").click(function(e) {
	e.preventDefault();

    var href = $(this).attr('href');

    $.ajax({
        method: 'POST',
        url: '/api/rarv/events/trigger/'+href,
        success: function(res){
        	if(res.errors != false){
        		app.$notify.error({title: 'Error!', message: res.message});
        		return false;
        	}

        	app.$notify.success({message: res.message});
        }
    });
});