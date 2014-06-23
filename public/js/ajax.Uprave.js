jQuery(function() {
    if (typeof _insertZupanija === 'undefined') {
        _insertZupanija = null;
    }
    if (_insertZupanija) {
        _addBtn = "#dodajBtn";
        _frm = "#formUprave";
        _crudInsert = "crud/zupanije/insert";
        _crudDelete = "crud/zupanije/delete";
        _crudUpdate = "crud/zupanije/update";
        _table = "#tableUprave";
        _naziv = "zupaniju";
    }
    else {
        _addBtn = "#dodajBtn";
        _frm = "#formUprave";
        _crudInsert = "crud/uprave/insert";
        _crudDelete = "crud/uprave/delete";
        _crudUpdate = "crud/uprave/update";
        _table = "#tableUprave";
        _naziv = "upravu";

    }
    console.log(_crudInsert);
    jQuery(_addBtn).click(function() {
        jQuery(_frm).css("display", "block");
        jQuery(_addBtn).css("display", "none");
    }); /* DODAVANJE */
    function insertInTableZupanije(celijaNaziv, id) {

        brisi = URL + _crudDelete + "/" + id;
        textIcon = "<i class='glyphicon glyphicon-remove'></i>";
        textIcon2 = "<i class='glyphicon glyphicon-wrench'></i>";
        klasa = "glyphicon-remove-me JQdelete";
        klasa2 = "glyphicon-edit-me JQchange";
        /*
         * RADI NUMERIRANJA KOD STRANIČENJA
         */$(_table).find('tbody').children("tr").each(function(){
             $(this).children("td:first").remove();
        }) 
        
        $(_table).find('tbody') /* dodaj u tablicu*/
                .append($('<tr>').append($('<td>').append(celijaNaziv))
                        .append($('<td>').append($("<a>")
                                .attr('href', brisi)
                                .addClass(klasa)
                                .attr('val', id)
                                .html(textIcon)))
                        .append($('<td>').append($("<a>")
                                .attr('href', brisi)
                                .addClass(klasa2)
                                .attr('val', id)
                                .html(textIcon2)))
                        );
          setUPTableType2(_table);
    }
    function insertInTableUprave(celijaNaziv, celijaZupanije, id) {
        console.log("AA" + celijaNaziv);
        brisi = URL + _crudDelete + "/" + id;
        textIcon = "<i class='glyphicon glyphicon-remove'></i>";
        textIcon2 = "<i class='glyphicon glyphicon-wrench'></i>";
        klasa = "glyphicon-remove-me JQdelete";
        klasa2 = "glyphicon-edit-me JQchange";
        /*
         * RADI NUMERIRANJA KOD STRANIČENJA
         */$(_table).find('tbody').children("tr").each(function(){
             $(this).children("td:first").remove();
        }) 
        
        
      
        $(_table).find('tbody') /* dodaj u tablicu*/
                .append($('<tr>').append($('<td>').append(celijaNaziv))
                        .append($('<td>').append(celijaZupanije))
                        .append($('<td>').append($("<a>")
                                .attr('href', brisi)
                                .addClass(klasa)
                                .attr('val', id)
                                .html(textIcon)))
                        .append($('<td>').append($("<a>")
                                .attr('href', brisi)
                                .addClass(klasa2)
                                .attr('val', id)
                                .html(textIcon2)))
                        );
         /* DA STRANIČENJE OSVJEŽI */         
        setUPTableType2(_table);
    }
    jQuery(_frm).submit(function(event) {
        event.preventDefault();
        console.log("BLA");
        $.ajax({
            type: "POST",
            url: URL + _crudInsert,
            data: $(_frm).serialize(),
            success: function(data) {
                console.log(data);
                var podaci = $.parseJSON(data);
                var id = null;
                var celijaNaziv = null;
                var celijaZupanija = null;

                if (podaci.id_policijske_uprave) {
                    id = podaci.id_policijske_uprave;
                    celijaZupanija = podaci.zupanija;
                    celijaNaziv = podaci.uprava;
                }

                else if (podaci.id_zupanije) {
                    id = podaci.id_zupanije;
                    celijaNaziv = podaci.naziv;
                }

                if (data !== null) {
                    $(_frm).fadeOut();
                    $(_addBtn).fadeIn();
                    /* vise verzija ZA UPRAVE I ŽUPANIJE*/
                    if (podaci.id_zupanije) {
                        insertInTableZupanije(celijaNaziv, id);
                    }
                    else
                        insertInTableUprave(celijaNaziv, celijaZupanija, id);
                }
            }
        });
    });
    /* REMOVE */
    jQuery(document).on("click", "a.JQdelete", function(event) {
        event.preventDefault();
        celija = $(this).parent();
        red = celija.parent();

        naziv = red.children("td:first").next().text();
        console.log(naziv);
        id = red.children("td:last").children().attr("val");
        /* MESSAGE BOX: ARE YOU SURE?*/
        $.confirm({
            text: "Jeste li sigurni da želite izbrisati " + _naziv + " " + naziv,
            confirm: function(button) {
                /* SEND  AJAX REQUEST */
                $.ajax({
                    type: "POST",
                    url: URL + _crudDelete + "/" + id,
                    success: function(data) {
                        if (data)
                            red.remove();

                    }
                });
            },
            cancel: function(button) {
            }
        });

    })
    /* CHANGE ŽUPANIJE*/
    jQuery(document).on("click", "a.JQchange", function(event) {
        event.preventDefault();
        celija = $(this).parent();
        red = celija.parent();
        celija1 = red.children("td:first").next(); /* PROMJENA NA NEXT*/
        id = red.children("td:last").children().attr("val");
        naziv = celija1.text();
        $("#updateNaziv").val(naziv);

        if (!_insertZupanija) {
            zupanija = celija1.next().text();

            $("#updateZupanija option").each(function() {
                if ($(this).text() == zupanija)
                    $(this).attr("selected", "selected");
            })
        }
        $("#JQUpdate").fadeIn();
        $("html, body").animate({scrollTop: $('header').offset().top}, 1000);
        jQuery(document).on("click", "#updateBtn", function(event2) {
            event2.preventDefault();
            $.ajax({
                type: "POST",
                url: URL + _crudUpdate + "/" + id,
                data: $("#JQUpdate").serialize(),
                success: function(data) {
                    console.log(data);
                    var podaci = $.parseJSON(data);

                    if (podaci.id_policijske_uprave) {
                        celija1.next().text(podaci.zupanija);
                        celija1.text(podaci.uprava);
                    }

                    else if (podaci.id_zupanije) {
                        celija1.text(podaci.naziv);
                    }
                    $("#JQUpdate").fadeOut();
                }
            });
        })
        jQuery(document).on("click", "#cancelBtn", function(event3) {
            event3.preventDefault();
            $("#JQUpdate").fadeOut();
        })

    })

    /*if ($(".JQedit")[0]) 
     return;
     else {
     naziv = celija1.text();
     id = red.children("td:last").children().attr("val");
     klasa = "glyphicon-edit2-me JQedit";
     textIcon = "  <i class='glyphicon glyphicon-floppy-disk'></i>";
     
     celija1.text("");
     celija1.append($("<form>").attr("id","JQForm")
     .append($("<input/>").val(naziv))
     .append($("<a>").attr('href', "#").addClass(klasa).html(textIcon)))
     
     jQuery(document).on("click", ".JQedit", function(event2) {
     event2.preventDefault();
     console.log("AA");
     celija1 = $(this).parent().parent();
     noviNaziv = $(celija1).children("form").children("input").val();
     celija1.empty();
     
     $.ajax({
     type: "POST",
     url: URL + _crudUpdate + "/" + id,
     data: $("#JQForm").serialize(),
     success: function(data) {
     if (data)
     celija1.text(noviNaziv)
     
     }
     });
     })
     jQuery(document).on("click", ".JQedit", function(event2) {
     event2.preventDefault();
     console.log("AA");
     celija1 = $(this).parent().parent();
     noviNaziv = $(celija1).children("form").children("input").val();
     celija1.empty();
     
     $.ajax({
     type: "POST",
     url: URL + _crudUpdate + "/" + id,
     data: $("#JQForm").serialize(),
     success: function(data) {
     if (data)
     celija1.text(noviNaziv)
     
     }
     });
     })
     if(!celija1.text())celija1.text(naziv);
     }*/


});