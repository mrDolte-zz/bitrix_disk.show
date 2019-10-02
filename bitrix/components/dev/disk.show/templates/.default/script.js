$(document).on("click", "[data-show-more]", function(){
        var btn = $(this);
        var bx_ajax_id = btn.attr("data-ajax-id");
        var folder_id= btn.attr("data-realobjectid");
        var block_id = "#comp_"+bx_ajax_id;
        var data = {
            bxajaxid:bx_ajax_id,
            folderid:folder_id,
        };
        $.ajax({
                type: "POST",
                url: window.location.href,
                data: data,
                timeout: 3000,
								beforeSend:function(data){
									console.log("sending...");
                  btn.addClass("loader");
								},
                success: function(data) {
                  btn.removeClass("loader");
                  btn.removeAttr("data-show-more");
		        			btn.parent().append(data);
                }
        });
    });
