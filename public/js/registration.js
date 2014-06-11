jQuery(function() {
    
    isEntered={}
    isEntered.oib=false;
    isEntered.korime=false;
    isEntered.email=false;
    isEntered.pass=false;
    
    jQuery("#register_form").submit(function(event) {
        event.preventDefault();
        if(!isEntered.oib){
            $("#oib").focus();
            return;
        }
        else if(!isEntered.korime){
            $("#korime").focus();
            return;
        }
        else if(!isEntered.email){
            $("#email").focus();
            return;
        }
        else if(!isEntered.pass){
            $("#pass").focus();
            return;
        }
        //console.log(URL+"register/run");
        //1. first ajax request 
        $.ajax({
          type: "POST",
          url: URL+"register/runJson",
          //url: "http://posttestserver.com/post.php",
          data: $('#register_form').serialize(),
          success:function(result){
            korime=$("#korime").val();
            //2. when data will arrive this method is executed with data in result argument.
            console.log(result);
            data = jQuery.parseJSON(result);
            if(result==true) console.log("TRUE");
            else console.log("FALSE");
            //do what ever with data.
            jQuery("#register_form").fadeOut();
            jQuery("#register_form2").fadeIn();
            $("html, body").animate({ scrollTop: $('header').offset().top }, 1000);
            
            jQuery("#register_form2").submit(function(event2) {
              //3. make other ajax request.
              event2.preventDefault();
              $.ajax({
                  type: "POST",
                  url: URL+"register/updateJson",
                  data: $('#register_form2').serialize()+"&korime="+korime,
                  success:function(result2){
                       console.log(result2)
                       window.location.replace(URL+"register/success");
                        }
                    });

             })
          }
        });
    })

    glyphicon={};
    glyphicon.ok="<span class='glyphicon glyphicon-ok form-control-feedback'></span>";
    glyphicon.remove="<span class='glyphicon glyphicon-remove form-control-feedback'></span>";

    messages={}
    messages.oib={}
    messages.oib.ok="OIB je slobodan";
    messages.oib.error="OIB je zauzet";
    messages.email={}
    messages.email.ok="Email je slobodan";
    messages.email.error="Email je zauzet";
    messages.email.error2="Email je neispravno unesen";
    messages.korime={}
    messages.korime.ok="Korisničko ime je slobodno";
    messages.korime.error="Korisničko ime je zauzeto";
    messages.korime.error2="Korisničko ime je prekratko";
    messages.pass={}
    messages.pass.ok="Lozinka je ispravna";
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
        whatToInsert=element.get(0).id; //get ID of attribute for focus
        if(glyph=="ok"){
            element.after( glyphicon.ok );
            isEntered[whatToInsert]=true;
        }
        else{
            element.after( glyphicon.remove );
            isEntered[whatToInsert]=false;
        }
        if(msg){
             text=elementParent.find( ".help-block" );
             text.html(msg);
             if(text.css('display')=="none")
                 text.fadeIn();
       }
    }
    /* OIB */
    jQuery("#oib").focusout(function(event){
        element=$("#oib");
        parentEl=element.parent();
        if(!element.val()) return;
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
    /* email */
    jQuery("#email").focusout(function(event){
        element=$("#email");
        parentEl=element.parent();
        if(!element.val()) return;
        var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
        if( !pattern.test(element.val()) ){
            addItems(element,"has-error", "remove", messages.email.error2);
            return;
        }
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
    
     /* korime */
    jQuery("#korime").focusout(function(event){
        element=$("#korime");
        parentEl=element.parent();
        if(!element.val()) return;
        var pattern = new RegExp(/^[+a-zA-Z0-9._-]{3,20}$/i);
        if(!pattern.test(element.val())){
            addItems(element,"has-error", "remove", messages.korime.error2);
            return;
        }
        $.ajax({
                  type: "GET",
                  url: URL+"register/check/korime/"+element.val(),
                  success:function(result2){
                       console.log(result2);
                       console.log(element.val());
                       if(result2=="FALSE"){
                           addItems(element,"has-success", "ok", messages.korime.ok);
                       }
                       else
                          addItems(element,"has-error", "remove", messages.korime.error);
                  }
        });
    })
    /* pass */
    jQuery("#pass").focusout(function(event){
        pass=$("#pass");
        parentEl=pass.parent();
        var pattern = new RegExp(/^[+a-zA-Z0-9._-]{3,20}$/i);
        pass2=$("#pass2");
        
        if(!pattern.test(pass.val())){
            addItems(pass2,"has-error", "remove", messages.pass.error);
            addItems(pass,"has-error", "remove");
        }
        else if(pass.val()!==pass2.val() && pass2.val()){
            addItems(pass2,"has-error", "remove", messages.pass.error2);
            addItems(pass,"has-error", "remove");
        }
        else if(pass2.val()){
            addItems(pass2,"has-success", "ok", messages.pass.ok);
            addItems(pass,"has-success", "ok");
        }
            
    })
    /* pass2 */
    jQuery("#pass2").focusout(function(event){
        pass2=$("#pass2");
        parentEl=pass2.parent();
        pass=$("#pass");
        removeClass(pass.parent());
        if(!pass2.val()){
            addItems(pass2,"has-error", "remove", messages.pass.error);
            addItems(pass,"has-error", "remove");
        }
        else if(pass2.val()!==pass.val())
            addItems(pass2,"has-error", "remove", messages.pass.error2);
        else{
            addItems(pass2,"has-success", "ok", messages.pass.ok);
            addItems(pass,"has-success", "ok");
        }

    })
})

