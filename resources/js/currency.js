$(document).ready(function getMessage() {

    $.ajax({
        type:'GET',
        url:'/currencies',
        success:function(data) {
            $("#currency").html(data);
        }});

});
