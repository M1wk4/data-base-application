$("#newman").on("click", function(){


    var name = $("#name_new").val().trim();
    var procent = $("#precent_new").val().trim();

    var dealer = $("#precent_new").val().trim();

    var login = $("#login_new").val().trim();
    var password = $("#pass").val().trim();
    var comment = $("#comments").val().trim();

    const nameel = document.getElementById("name_new") ;
    const procectel = document.getElementById("precent_new");
    const dealerel  = document.getElementById("precent_new");
    const loginel = document.getElementById("login_new");
    const passel = document.getElementById("pass");
    if (!nameel.checkValidity()){
        nameel.reportValidity();
        return false;
    }
    if (!procectel.checkValidity()){
        procectel.reportValidity();
        return false;
    }
    if (!dealerel.checkValidity()){
        dealerel.reportValidity();
        return false;
    }
    if (!loginel.checkValidity()){
        loginel.reportValidity();
        return false;
    }
    if (!passel.checkValidity()){
        passel.reportValidity();
        return false;
    }
    
    console.log(comment);
    var toastLive = document.getElementById('liveToast1')  
    
    
    
    $.ajax({
        url: "includes/new_man.inc.php",
        type: "POST",
        cache: false,
        data: {'name': name, 'procent': procent, 'dealer': dealer, 
                'login': login, 'password': password, 'comment': comment} ,
        dataType: 'html',
        beforeSend: function(){
            $("#newman").prop("disabled", true);
        },
        success: function(data) {
            //alert(data);
            var result = $.trim(data);
            $("#errorMess1").text(result);
            var toast = new bootstrap.Toast(toastLive)
            toast.show()
            $("#newman").prop("disabled", false);
            if (result == 'Успешно!')
                location.reload();
            return false;
            
        }
    })    
});
