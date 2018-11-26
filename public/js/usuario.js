//evento ajax para nuevo cliente
$(document).on('click', 'button.new-ajax', function(){
    that = $(this);
    console.log("new");
    $('#usuario_guardar').attr("disabled", true);

    var usuario = {
        nombre: $("#usuario_nombre").val(),
        email: $("#usuario_email").val(),
        username: $("#usuario_username").val(),
        password: $("#usuario_password").val()
       
    }

    if(usuario.username == "" || usuario.password == "" ){
        alert("Complete los campos requeridos username o password");
        $('#usuario_guardar').attr("disabled", false);
        return false;  
    }

    $.ajax({
        url:'/usuario/new/ajax',
        type: "POST",
        dataType: "json",
        data: {
            "usuario": usuario
        },
        async: true,
        success: function (data)
        {
            var result = JSON.parse(data);
            console.log(result);

            
        }
    });

    return false;            
                 
});