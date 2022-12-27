$("#del_man").on("click", function(){

    

    var id = $("#man_id").val().trim();
    
    
    console.log(id);
    var toastLive = document.getElementById('liveToast')  
    
    
    $.ajax({
        url: "includes/del_man.inc.php",
        type: "POST",
        cache: false,
        data: {'id' : id} ,
        dataType: 'html',
        beforeSend: function(){
            $("#del_man").prop("disabled", true);
        },
        success: function(data) {
            var result = $.trim(data);
            $("#errorMess").text(result);
            var toast = new bootstrap.Toast(toastLive)
            toast.show()
            $("#del_man").prop("disabled", false);
            if (result == 'Успешно!')
                location.reload();
            return false;
            
        }
    })    
});