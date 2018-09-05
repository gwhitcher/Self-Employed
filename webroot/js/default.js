/* Confirm */
$(document).ready(function(){
    $(".confirm").on("click", null, function(){
        return confirm("Are you sure?");
    });
});

//Flash message disappear
jQuery(document).ready(function($){
    if('.fadeout-message'){
        setTimeout(function() {
            $('.alert').slideUp(1200);
        }, 5000);
    }
});