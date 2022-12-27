$("#upd_man").on("click", function(){
    var man_id = $("#man_id").val();
    var name = $("#name").val().trim();
    var procent = $("#procent").val().trim();
    var dealer = $("#dealers").val().trim();
    var comments = $("#upcomments").val().trim();


    
    var toastLiveExample = document.getElementById('liveToast')  
    
    var patt_name = new RegExp(/^([А-Я]{1}[а-яё]{1,32} [А-Я]{1}[а-яё]{1,32})$/gm);
    var name_check = patt_name.test(name);
    
    var patt_num = new RegExp(/^[1-9][0-9]?$/);
    var proc_check = patt_num.test(procent);

    if (name == "" || name_check == false) {
        $("#errorMess").text("Имя не подходит. Введите иное. Например: Иванов Иван");
        var toast = new bootstrap.Toast(toastLiveExample)
        toast.show()
        return false;
    } else if (proc_check == false || procent > 20) {
        $("#errorMess").text("Введите допустимый процент (1 -20%)");
        var toast = new bootstrap.Toast(toastLiveExample)
        toast.show()
        return false;
    } else if (String(comments).length > 150) {
        $("#errorMess").text("Комментарий слишком длинный");
        var toast = new bootstrap.Toast(toastLiveExample)
        toast.show()
        return false;
    }


    $.ajax({
        url: "includes/upd_man.inc.php",
        type: "POST",
        cache: false,
        data: {'man_id': man_id, 'name': name, 'procent': procent, 'dealer': dealer, 'comments': comments},
        dataType: 'html',
        beforeSend: function(){
            $("#upd_man").prop("disabled", true);
        },
        success: function(data) {
            //alert(data);
            location.reload();
            $("#upd_man").prop("disabled", false);
        }
    })    
});
