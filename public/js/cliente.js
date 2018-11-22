$(document).on('click', 'button.new-ajax', function(){
     that = $(this);

     var cliente = {
        nombre: $("#cliente_nombre").val(),
        cedula: $("#cliente_cedula").val(),
        email: $("#cliente_email").val(),
        direccion: $("#cliente_direccion").val(),
     }

     console.log(cliente);

    $.ajax({
        url:'/cliente/new/ajax',
        type: "POST",
        dataType: "json",
        data: {
            "cliente": cliente
        },
        async: true,
        success: function (data)
        {
            console.log("save exit");
            console.log(data);  
        }
    });

    return false;            
                 
});