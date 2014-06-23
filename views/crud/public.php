<article>
    <h2><?php
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?></h2>
    <h1> Popis djelatnika i policijskih uprava</h1>


    <br>
    <div class="panel panel-primary">
        <div class="panel-heading">
                <div class="row">    
                    <h4 class="col-md-2 col-md-offset-0" for = "zupanijaSelect">Odabir županije</h4>
                <div class="col-md-10">
                    <select class="form-control" name="zupanijaSelect" id="zupanijaSelect">
                        <?php
                        foreach ($this->zupanije as $value) {
                            echo "<option value={$value['id_zupanije']}>{$value['naziv']}</option>";
                        }
                        ?>
                    </select>
                </div>
                </div>
        </div>
        
        
        <div class="panel-body">
            
            <table class = "table table-responsive table-select table-buttons-1" id="tableUprave">
                <thead>
                    <tr><th>Naziv</th>
                    </tr>
                <thead>
                <tbody>
                    <tr><th colspan="2">Nema uprava za traženu županiju</th></tr>
                </tbody>
            </table>
            
            <div class="panel panel-danger">
            <table class = "table table-responsive table-striped table-buttons-1" id="tablePolicajci">
                <thead>
                    <tr><th>Ime</th>
                        <th>Prezime</th>
                        <th>Kontakt</th>
                    </tr>
                <thead>
                <tbody>
                    <tr><th colspan="3">Nema policajaca za traženu upravu</th></tr>
                </tbody>
            </table>
            </div>
        </div>
        
    </div>
    
</article>
<script type="text/javascript">
    var URL = '<?php echo URL ?>';
</script>

<script type="text/javascript">
    $("#zupanijaSelect").change(function() {

        $("#tableUprave").children("tbody").empty();
        $("#tablePolicajci").children("tbody").empty();
        $("#tablePolicajci").children("tbody").append('<tr><th colspan="3">Nema policajaca za traženu upravu</th></tr>')
        var URL = '<?php echo URL ?>';
        zupanija = "Splitsko-dalmatinska";
        zupanija = $("#zupanijaSelect option:selected").text();
        $.ajax({
            type: "POST",
            url: URL + "login/djelatnici/zupanija/" + zupanija,
            success: function(data) {
                console.log(data);
                if (data)
                    uprave = $.parseJSON(data)
                $(uprave).each(function() {
                    $("#tableUprave").children("tbody").append($("<tr/>")
                            .append($("<td/>").text(this.naziv))
                            .attr("val", this.id_policijske_uprave));
                });
                setUPTable($("#tableUprave"));
            }
        });
    })

    $("#tableUprave").delegate('tr', 'click', function() {
        $("#tablePolicajci").children("tbody").empty();
        console.log($(this).attr("val"))
        upravaid = $(this).attr("val")
        $.ajax({
            type: "POST",
            url: URL + "login/djelatnici/uprava/" + upravaid,
            success: function(data) {
                uprave = $.parseJSON(data)
                if (uprave) {

                    $(uprave).each(function() {
                        $("#tablePolicajci").children("tbody").append($("<tr/>")
                                .append($("<td/>").text(this.ime))
                                .append($("<td/>").text(this.prezime))
                                .append($("<td/>").text(this.email))
                                .attr("val", this.id_policijske_uprave));
                    });
                }
                else
                    $("#tablePolicajci").children("tbody").append('<tr><th colspan="3">Nema policajaca za traženu upravu</th></tr>')
                $("#tablePolicajci").children("tfoot").empty();
                setUPTable($("#tablePolicajci"));
            }
        });
    });
</script>