$("#upd_man").on("click", function(){
    var end = $("#end").val().trim();
    var contr = $("#contrid").val().trim();  
    var man_id = $("#mann").val().trim(); 
    alert(end);
    $.ajax({
        url: "includes/upd_ins.inc.php",
        type: "POST",
        cache: false,
        data: {'contr': contr, 'end': end, 'man_id': man_id} ,
        dataType: 'html',
        beforeSend: function(){
            $("#upd_man").prop("disabled", true);
        },
        success: function(data) {
                location.reload();
                $("#upd_man").prop("disabled", false);
                return false;
            }
            
        
    })

});