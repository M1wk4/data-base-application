$("#log").on("click", function(){
    var login = $("#loginInput").val().trim();
    var password = $("#floatingPassword").val().trim();
    //alert(login);

    if (login == "" || password == "") {
        alert("Введите данные!"); 
        return false;
    }
    $.ajax({
        url: "includes/index.inc.php",
        type: "post",
        cache: false,
        data: {'login': login, 'password': password},
        dataType: 'html',
        beforeSend: function(){
            $("#log").prop("disabled", true);
        },
        success: function(data) {
            //alert(data);
            var result = $.trim(data);
            if (result === '1') {
                 alert("Неверный логин или пароль!");
            }
            else {
                document.location.href = "http://localhost/APP_DB/account.php";
            }
           $("#log").prop("disabled", false);
        }
    })    
});

