//evento ajax para nuevo usuario
$(document).on('click', 'button.new-ajax', function(){
    that = $(this);
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

            var iconDelete = "<a href='#' class='delete-user' title='eliminar' style='color: #e03535;' ><i class='fa fa-times' ></i></a>";
            var iconEdit = "<a class='edit-user' title='editar' href='#user_new_modal' data-toggle='modal' style='color: #dead18;'><i class='fa fa-edit' ></i></a>";
            var acciones =  iconEdit+" "+ iconDelete;

            var table = $('#table-usuarios').DataTable();
            
            table.row.add([ 
                result.nombre,
                result.email,
                result.username,
                acciones]).node().id = result.id ;
            table.draw( false );

            $('#usuario_guardar').attr("disabled", false);
            $("#form-new")[0].reset();
            $( "#msg-server" ).append("<div id='msg' class='alert alert-info' role='alert'>¡Bien hecho! Usuario ha sido ingresado satisfactoriamente.</div>");
            
            window.setTimeout(function() {
                $("#msg").fadeTo(400, 0).slideUp(400, function(){
                    $(this).remove(); 
                });
              }, 4000);


        }
    });

    return false;            
                 
});



//evento  ajax para poblar datos de edicion usuario
$(document).on('click', 'a.edit-user', function(){
    that = $(this);

    $("#text-header-modal").html('<i class="fa fa-edit"></i> Editar Usuario');
    
    $("#usuario_guardar").removeClass("new-ajax");
    $("#usuario_guardar").addClass("update-ajax");

    var id=that.parent().parent().attr("id");
    var usuario = {
        id:id,
        nombre: that.parents("tr").find("td")[0].innerHTML,
        email: that.parents("tr").find("td")[1].innerHTML,
        username: that.parents("tr").find("td")[2].innerHTML
     }

    $("#usuario_nombre").val(usuario.nombre);
    $("#usuario_email").val(usuario.email);
    $("#usuario_username").val(usuario.username);
    $("#usuario_password").prop('disabled', true);


    return false;            
                 
});


//evento para actualizar usuario
$(document).on('click', 'button.update-ajax', function(){

    $('#usuario_guardar').attr("disabled", true);

    var id=that.parent().parent().attr("id");
    var usuarioUpdate = {
        id:id,
        nombre: $("#usuario_nombre").val(),
        email: $("#usuario_email").val(),
        username: $("#usuario_username").val(),
    }


    $.ajax({
        url:'/usuario/edit/ajax',
        type: "POST",
        dataType: "json",
        data: {
            "usuario": usuarioUpdate
        },
        async: true,
        success: function (data)
        {

            console.log("update");

            //$("#form-new")[0].reset();

            $( "#msg-server" ).append("<div id='msg' class='alert alert-info' role='alert'>¡Bien hecho! Usuario ha sido actualizado satisfactoriamente.</div>");
        
            window.setTimeout(function() {
                $("#msg").fadeTo(400, 0).slideUp(400, function(){
                    $(this).remove(); 
                    $('#usuario_guardar').attr("disabled", false);
                    
                });
            }, 4000);

            that.parents("tr").find("td:eq(0)").html(usuarioUpdate.nombre);
            that.parents("tr").find("td:eq(1)").html(usuarioUpdate.email);
            that.parents("tr").find("td:eq(2)").html(usuarioUpdate.username);

        }
    });



    return false;      

             
});


//evento para eliminar usuario
$(document).on('click', 'a.delete-user', function(){
    that = $(this);
    var id=that.parent().parent().attr("id");

    eliminar=confirm("¿Realmente deseas eliminar el usuario " + that.parents("tr").find("td")[0].innerHTML+"?");
    if (eliminar){
        $.ajax({
            url:'/usuario/delete/ajax',
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
                var table = $('#table-usuarios').DataTable();
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



//evento  para limpiar form
$(document).on('click', '#new-modal', function(){
    that = $(this);
    $("#form-new")[0].reset();
    $("#usuario_guardar").removeClass("update-ajax");
    $("#usuario_guardar").addClass("new-ajax");
    $("#text-header-modal").html('<i class="fa fa-edit"></i> Agregar nuevo usuario');
    $("#usuario_password").prop('disabled', false);
    return false;

});