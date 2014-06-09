jQuery(function() {
    jQuery("#register_form").submit(function(event) {
        console.log("PROLAZI SUBMIT");
        event.preventDefault();
        console.log(URL+"register/run");
        //1. first ajax request 
        $.ajax({
          type: "POST",
          url: URL+"register/runJson",
          //url: "http://posttestserver.com/post.php",
          data: $('#register_form').serialize(),
          success:function(result){
           //2. when data will arrive this method is executed with data in result argument.
           console.log(result);
           data = jQuery.parseJSON(result);
            if(result==true) console.log("TRUE");
            else console.log("FALSE");
           //do what ever with data.
           jQuery("#register_form").fadeOut();
           jQuery("#register_form2").fadeIn();
           $("html, body").animate({ scrollTop: $('header').offset().top }, 1000);
           //3. make other ajax request.
              $.ajax({
                  type: "GET",
                  url: URL+"register/runJson",
                  data: $('#register_form2').serialize(),
                  success:function(result2){

                       //4. final response.. will arrive here in result2
                        }
                    });

          }
        });
    })
    glyphicon={};
    glyphicon.ok="<span class='glyphicon glyphicon-ok form-control-feedback'></span>";
    /*glyphicon.ok="<span class='glyphicon glyphicon-ok form-control-feedback'></span>";
    glyphicon.ok="<span class='glyphicon glyphicon-ok form-control-feedback'></span>";*/
    
    jQuery("#oib").focusout(function(event){
        oib=$("#oib");
        parentEl=oib.parent();
        parentEl.parent().removeClass( "has-success" );
        parentEl.find( "span" ).remove();
        $.ajax({
                  type: "GET",
                  url: URL+"register/check/oib/"+oib.val(),
                  success:function(result2){
                       console.log(result2);
                       console.log(oib.val());
                       //4. final response.. will arrive here in result2
                  }
        });
        parentEl.parent().addClass( "has-success" );
        $("#oib").after( glyphicon.ok );
    
    })

})

