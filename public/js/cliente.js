
//evento ajax para nuevo cliente
$(document).on('click', 'button.new-ajax', function(){
    that = $(this);
    console.log("new");
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


//evento  ajax para poblar datos de edicion cliente
$(document).on('click', 'a.edit-cli', function(){
    that = $(this);

    $("#text-header-modal").html('<i class="fa fa-edit"></i> Editar cliente');
    
    $("#cliente_guardar").removeClass("new-ajax");
    $("#cliente_guardar").addClass("update-ajax");

    var id=that.parent().parent().attr("id");
    var cliente = {
        id:id,
        nombre: that.parents("tr").find("td")[0].innerHTML,
        email: that.parents("tr").find("td")[1].innerHTML,
        direccion: that.parents("tr").find("td")[2].innerHTML,
        cedula: that.parents("tr").find("td")[3].innerHTML,
        fecha: that.parents("tr").find("td")[4].innerHTML
     }

    $("#cliente_nombre").val(cliente.nombre);
    $("#cliente_cedula").val(cliente.cedula);
    $("#cliente_email").val(cliente.email);
    $("#cliente_direccion").val(cliente.direccion);


    return false;            
                 
});


//evento para actualizar cliente
$(document).on('click', 'button.update-ajax', function(){

    $('#cliente_guardar').attr("disabled", true);

    var id=that.parent().parent().attr("id");
    var clienteUpdate = {
        id:id,
        nombre: $("#cliente_nombre").val(),
        cedula: $("#cliente_cedula").val(),
        email: $("#cliente_email").val(),
        direccion: $("#cliente_direccion").val(),
    }


    $.ajax({
        url:'/cliente/edit/ajax',
        type: "POST",
        dataType: "json",
        data: {
            "cliente": clienteUpdate
        },
        async: true,
        success: function (data)
        {

            console.log("update");

            //$("#form-new")[0].reset();

            $( "#msg-server" ).append("<div id='msg' class='alert alert-info' role='alert'>¡Bien hecho! Cliente ha sido actualizado satisfactoriamente.</div>");
        
            window.setTimeout(function() {
                $("#msg").fadeTo(400, 0).slideUp(400, function(){
                    $(this).remove(); 
                    $('#cliente_guardar').attr("disabled", false);
                    
                });
            }, 4000);

            that.parents("tr").find("td:eq(0)").html(clienteUpdate.nombre);
            that.parents("tr").find("td:eq(1)").html(clienteUpdate.email);
            that.parents("tr").find("td:eq(2)").html(clienteUpdate.direccion);
            that.parents("tr").find("td:eq(3)").html(clienteUpdate.cedula);

        }
    });



    return false;      

             
});


//evento para eliminar cliente
$(document).on('click', 'a.delete-cli', function(){
    that = $(this);
    var id=that.parent().parent().attr("id");

    eliminar=confirm("¿Realmente deseas eliminar el cliente " + that.parents("tr").find("td")[0].innerHTML+"?");
    if (eliminar){
        $.ajax({
            url:'/cliente/delete/ajax',
            type: "POST",
            dataType: "json",
            data: {
                "id": id
            },
            async: true,
            success: function (data)
            {
                console.log("exit delete");
                console.log(data);
                var table = $('#table-clientes').DataTable();
                table.row( that.parents("tr") ).remove().draw();

                $( "#msg-delete" ).append("<div id='msg' class='alert alert-info' role='alert'>Aviso! Datos eliminados exitosamente.</div>");
        
                window.setTimeout(function() {
                    $("#msg").fadeTo(400, 0).slideUp(400, function(){
                        $(this).remove();                         
                    });
                }, 4000);


            }
        });
    }

       
    
    return false;    

});


//evento   para limpiar form
$(document).on('click', '#new-modal', function(){
    that = $(this);
    $("#form-new")[0].reset();
    $("#cliente_guardar").removeClass("update-ajax");
    $("#cliente_guardar").addClass("new-ajax");
    $("#text-header-modal").html('<i class="fa fa-edit"></i> Agregar nuevo cliente');
    return false;

});