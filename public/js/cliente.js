$(document).on('click', 'button.new-ajax', function(){
     that = $(this);
     $('#cliente_guardar').attr("disabled", true);

     var f = new Date();
     var fechaActual = f.getFullYear() + "-"+(f.getMonth()+1)+"-"+f.getDate();

     var cliente = {
        nombre: $("#cliente_nombre").val(),
        cedula: $("#cliente_cedula").val(),
        email: $("#cliente_email").val(),
        direccion: $("#cliente_direccion").val(),
        fecha: fechaActual
     }

     if(cliente.nombre == "" || cliente.cedula == "" ){
          alert("Complete los campos requeridos");
           $('#cliente_guardar').attr("disabled", false);
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
            var result = JSON.parse(data);
            console.log(result);

            var iconDelete = "<a href='#' class='delete-cli' title='eliminar' style='color: #e03535;' ><i class='fa fa-times' ></i></a>";
            var iconEdit = "<a class='edit-cli' title='editar' href='#client_new_modal' data-toggle='modal' style='color: #dead18;'><i class='fa fa-edit' ></i></a>";
            var acciones =  iconEdit+" "+ iconDelete;

            var table = $('#table-clientes').DataTable();
            
            table.row.add([ 
                result.nombre, 
                result.email,
                result.direccion,
                result.cedula,
                cliente.fecha,
                acciones]).node().id = result.id ;

            table.draw( false );

            
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