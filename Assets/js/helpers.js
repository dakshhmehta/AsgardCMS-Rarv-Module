$(document).ready(() => {
    $(".ajax-link").click(function (e) {
        e.preventDefault();
    
        var href = $(this).data('url');
        var method = $(this).data('method') || 'GET';
        var isClickable = $(e.target).is(":disabled");

        console.log(isClickable);

        if(isClickable == false){
            $.ajax({
                method: method,
                url: href,
                success: function (res) {
                    $(e.target).prop('disabled', false);
                    if (res.error == true) {
                        app.$notify.error({title: 'Error!', message: res.message});
                        return false;
                    }
        
                    app.$notify.success({message: res.message});
        
                    if(res.changeText != undefined){
                        $(e.target).html(res.changeText);
                    }

                    if(res.disableBtn != undefined){
                        $(e.target).data('clickable', res.disableBtn);

                        if(res.disableBtn == 1){
                            $(e.target).prop('disabled', true);
                            $(e.target).attr("disabled", "disabled");
                        }
                    }
                }
            });
        }
    });
})