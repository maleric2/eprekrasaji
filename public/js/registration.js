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
    glyphicon.remove="<span class='glyphicon glyphicon-remove form-control-feedback'></span>";
    /*glyphicon.ok="<span class='glyphicon glyphicon-ok form-control-feedback'></span>";*/
    messages={}
    messages.oib={}
    messages.oib.ok="OIB je slobodan";
    messages.oib.error="OIB je zauzet";
    messages.email={}
    messages.email.ok="Email je slobodan";
    messages.email.error="Email je zauzet";
    messages.korime={}
    messages.korime.ok="Korisničko ime je slobodno";
    messages.korime.error="Korisničko ime je zauzeto";
    messages.pass={}
    messages.pass.ok="Lozinka je snažna";
    messages.pass.error="Unesite bolju lozinku";
    messages.pass.error2="Lozinke se ne poklapaju";
    
    /* Za Bootstrap formu, zahtjeva parenta*/
    function removeClass(elementParent){
        elementParent.parent().removeClass( "has-success" );
        elementParent.parent().removeClass( "has-error" );
        elementParent.find( "span" ).remove();
    }
    /* Za Bootstrap formu, zahtjeva element, klasu koja se doda(string), glyph(string), msg(string)*/
    function addItems(element, classToAdd, glyph, msg) {
        elementParent=element.parent();
        removeClass(elementParent);
        elementParent.parent().addClass( classToAdd );
        if(glyph=="ok")
            element.after( glyphicon.ok );
        else
            element.after( glyphicon.remove );
        if(msg){
            elementParent.find( ".help-block" ).html(msg);
        }
    }
    /* OIB */
    jQuery("#oib").focusout(function(event){
        element=$("#oib");
        parentEl=element.parent();
        $.ajax({
                  type: "GET",
                  url: URL+"register/check/oib/"+element.val(),
                  success:function(result2){
                       console.log(result2);
                       console.log(element.val());
                       /*parentEl.parent().addClass( "has-success" );
                       $("#oib").after( glyphicon.ok );*/
                       if(result2=="FALSE")
                           addItems(element,"has-success", "ok", messages.oib.ok);
                           
                       else
                          addItems(element,"has-error", "remove", messages.oib.error);
                  }
        });
    })
    /* OIB */
    jQuery("#email").focusout(function(event){
        element=$("#email");
        parentEl=element.parent();
        $.ajax({
                  type: "GET",
                  url: URL+"register/check/email/"+element.val(),
                  success:function(result2){
                       console.log(result2);
                       console.log(element.val());
                       if(result2=="FALSE")
                           addItems(element,"has-success", "ok", messages.email.ok);
                           
                       else
                          addItems(element,"has-error", "remove", messages.email.error);
                  }
        });
    })
})

