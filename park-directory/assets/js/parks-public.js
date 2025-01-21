(function( $ ) {

    "use strict";
    
    $('#facilities_filter .fac_btn').click(function() {
        
        $("#curr_facility").val($(this).attr('id'));
        $('#parks-list-container').html('<p>Loading...</p>');
       // $('#load-more-parks').hide();
        loadParks(1);
     });

     $('#load-more-parks').click(function() {
        var page = $(this).data('page');
        loadParks(page + 1); 
    });

    function loadParks(page) {
        $.ajax({
            type: "POST",
            url: ajax_object.ajax_url,
            data: {
                action: "load_parks",
                page: page,
                facility: $("#curr_facility").val()
            },
            success: function(response) {
                console.log(response);
                if (page === 1) {
                    $('#parks-list-container').html(response);
                } else {
                    $('#parks-list-container').append(response);
                } 
                $('#load-more-parks').data('page', page);
                $('#load-more-parks').toggle(response.trim() !== "");
            }
        });
    }

})(jQuery);


// jQuery(document).ready(function($) {


//     

//    
// });