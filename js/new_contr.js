$("#accept").on("click", function(){
    var contr = $("#new_contr").val().trim();
    var start = $("#start").val().trim();
    var end = $("#end_").val().trim();   
    var liveToast = document.getElementById('liveToast')  
    
    console.log(contr);
    if (contr == '0')  {
        var result = $.trim('Выбирите контрагента!');
        $("#errorMess").text(result);
        var toast = new bootstrap.Toast(liveToast)
        toast.show()
        $("#accept").prop("disabled", false);
                
        return false;
    }
    

    $.ajax({
        url: "includes/new_contr.inc.php",
        type: "POST",
        cache: false,
        data: {'contr': contr, 'start': start, 'end': end} ,
        dataType: 'html',
        beforeSend: function(){
            $("#accept").prop("disabled", true);
        },
        success: function(data) {
                var result = $.trim(data);
                $("#errorMess").text(result);
                var toast = new bootstrap.Toast(liveToast)
                toast.show()
                $("#accept").prop("disabled", false);
                if (result == 'Успешно!')
                    location.reload();
                return false;
            }
            
        
    })

});