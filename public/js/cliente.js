$(document).on('click', 'button.new-ajax', function(){
     that = $(this);
     $('#cliente_guardar').attr("disabled", true);

     var cliente = {
        nombre: $("#cliente_nombre").val(),
        cedula: $("#cliente_cedula").val(),
        email: $("#cliente_email").val(),
        direccion: $("#cliente_direccion").val(),
     }

     if(cliente.nombre == "" || cliente.cedula == "" ){
          alert("Complete los campos requeridos");
          return false;  
     }

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
            console.log("cliente save exit");
            console.log("id_cliente: "+data);
            $('#cliente_guardar').attr("disabled", false);
            $("#form-new")[0].reset();
            $( "#msg-server" ).append("<div id='msg' class='alert alert-info' role='alert'>¡Bien hecho! Cliente ha sido ingresado satisfactoriamente.</div>");

          	window.setTimeout(function() {
			    $("#msg").fadeTo(400, 0).slideUp(400, function(){
			        $(this).remove(); 
			    });
			}, 4000);
		

        }
    });

    return false;            
                 
});