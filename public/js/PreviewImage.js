function PreviewImage(header) {
        index = 0
        $("#putImage").empty();
        heading=false;
        do {
            var oFReader = new FileReader();

            oFReader.readAsDataURL(document.getElementById("picture").files[index]);

            oFReader.onload = function(oFREvent) {
                if(!heading && header){
                    $("#putImage").append("<h2>Slike za prijenos</h2>");
                    heading=true;
                }
                $("#putImage").append('<img src=' + oFREvent.target.result + ' style="width: 100px; height: 100px;" />')
            };
            index = index + 1;
        } while (document.getElementById("picture").files[index]);

    };