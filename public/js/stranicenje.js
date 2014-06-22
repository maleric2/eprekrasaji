$(document).ready(function() {
    /*function WhatTable(button){
        return button.
    }*/
    function PrepareTable(table) {
        $(table).children("thead").children("tr").prepend("<th>#</th>")
        brojRedova = 0
        $(table).children("tbody").children("tr").each(function() {
            $(this).prepend("<td>" + (brojRedova + 1) + "</td>")
            brojRedova++
        })
        return brojRedova;
    }
    function ShowTable(table, firstRow, lastRow) {
        brojRedova = 0
        $(table).children("tbody").children("tr").each(function() {
            brojRedova++
            //console.log(brojRedova + " > " + lastRow + " || " + brojRedova + " <= " + firstRow)
            if (brojRedova <= firstRow || brojRedova > lastRow )
                $(this).hide();
            else
                $(this).fadeIn(100);
        })
        return brojRedova;
    }
    
    _current={};
    _ukupno={};
    _brojTablica=0;
    $("table").each(function() {
        //console.log($(this))
        _brojTablica++;
        _current[_brojTablica] = 0;
        _ukupno[_brojTablica] = PrepareTable($(this));
        console.log(_ukupno[_brojTablica]);
        ShowTable($(this), 0, 10);
        
        
        $(this).attr("val",_brojTablica);
        /*if ($("#TablePrevious")[0]) {
            //$("#TablePrevious").after
        }*/
        if((_ukupno[_brojTablica]/10)>1){
            $(this).append($("<tfoot/>").append($("<td colspan='4' />")
                    .append("<button type='button' id='TablePageFirst' class='btn btn-success'><i class='glyphicon glyphicon-fast-backward'></i></button> "
                    + " <button type='button' id='TablePrevious' class='btn btn-primary'>Prethodni</button> "
                    + " <button type='button' id='TableNext' class='btn btn-primary'>Sljedeci</button> "
                    + " <button type='button' id='TablePageLast' class='btn btn-success'><i class='glyphicon glyphicon-fast-forward'></i></button> ")));
        }
    })
    
    $(document).on("click","#TableNext",function(){
        //table=$(this).parent().parent().parent();
        table=$(this).closest("table");
        tableNumber=table.attr("val");
        console.log(tableNumber);
        if ((_current[tableNumber] + 10) < _ukupno[tableNumber]) {
            _current[tableNumber] += 10
            ShowTable(table, _current[tableNumber], _current[tableNumber] + 10);
        }
    })
    $(document).on("click","#TablePrevious",function(){
        table=$(this).closest("table");
        //table=$(this).parent().parent().parent();
        console.log(table)
        tableNumber=table.attr("val");
        console.log(tableNumber);
        if (_current[tableNumber] > 0) {
            _current[tableNumber] -= 10;
            ShowTable(table, _current[tableNumber], _current[tableNumber] + 10);
        }
    })
    $(document).on("click","#TablePageLast",function(){
        table=$(this).closest("table");
        tableNumber=table.attr("val");
        if (_current[tableNumber] < _ukupno[tableNumber]) {
            _current[tableNumber] = _ukupno[tableNumber]-10;
            ShowTable(table, _current[tableNumber], _current[tableNumber] + 10);
        }
    })
    $(document).on("click","#TablePageFirst",function(){
        table=$(this).closest("table");
        tableNumber=table.attr("val");
        if (_current[tableNumber] > 0) {
            _current[tableNumber] = 0;
            ShowTable(table, _current[tableNumber], _current[tableNumber] + 10);
        }
    })
})
