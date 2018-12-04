//evento ajax para nuevo producto
$(document).on('click', 'button.new-ajax', function(){
    that = $(this);

    if($("#producto_barcode").val() == "" || $("#producto_nombre").val() == "" ){
        alert("Complete los campos requeridos codigo / nombre");
        return false;  
    }
    
    $('#producto_guardar').attr("disabled", true);

    var f = new Date();
    var fechaActual = f.getFullYear() + "-"+(f.getMonth()+1)+"-"+f.getDate();

    var producto = {
        barcode: $("#producto_barcode").val(),
        nombre: $("#producto_nombre").val(),
        isIva:  $('#producto_isIva').is(":checked"),
        fchIngreso:fechaActual,
        cantPack:parseInt($("#producto_cantPack").val()),
        cantUnit: parseInt($("#producto_cantUnit").val()),
        cantTotal: 0,
        precioPack: parseFloat($("#producto_precioPack").val()).toFixed(2),
        precioUnit: parseFloat($("#producto_precioUnit").val()).toFixed(2),
    }


    validarForm(producto);

    console.log(producto);
   
    $.ajax({
        url:'/producto/new/ajax',
        type: "POST",
        dataType: "json",
        data: {
            "producto": producto
        },
        async: true,
        success: function (data)
        {
            var result = JSON.parse(data);
            console.log(result);

            var iconDelete = "<a href='#' class='delete-prod' title='eliminar' style='color: #e03535;' ><i class='fa fa-times' ></i></a>";
            var iconEdit = "<a class='edit-prod' title='editar' href='#product_new_modal' data-toggle='modal' style='color: #dead18;'><i class='fa fa-edit' ></i></a>";
            var acciones =  iconEdit+" "+ iconDelete;

            var table = $('#table-productos').DataTable();

            table.row.add([ 
                result.barcode,
                result.nombre, 
                result.precioPack,
                result.precioUnit,
                result.cantPack,
                result.cantUnit,
                result.cantTotal,
                result.isIva,
                acciones]).node().id = result.id ;

            table.draw( false );

            $("#form-new")[0].reset();
            $('#producto_guardar').attr("disabled", false);
            $( "#msg-server" ).append("<div id='msg' class='alert alert-info' role='alert'>¡Bien hecho! Producto ha sido ingresado satisfactoriamente.</div>");
          
            window.setTimeout(function() {
                $("#msg").fadeTo(400, 0).slideUp(400, function(){
                    $(this).remove(); 
                });
              }, 4000);

        }
    });




    return false;            
                 
});



function validarForm(producto){

    var cantTotal;

    if (isNaN(producto.cantPack) ||  producto.cantPack < 0 ) {
        producto.cantPack=0;
    }
    if (isNaN(producto.cantUnit) ||  producto.cantUnit < 0) {
        producto.cantUnit=0;
    }

    if(producto.cantPack == 0){
        cantTotal = 1 * producto.cantUnit;
        console.log(cantTotal);
    }

    if(producto.cantUnit == 0){
        cantTotal = 1 * producto.cantPack;
        console.log(cantTotal);
    }

    if(producto.cantUnit > 0 && producto.cantPack > 0 ){
        cantTotal = producto.cantPack * producto.cantUnit;
        console.log(cantTotal);
    }


    producto.cantTotal = cantTotal;


    if (isNaN(producto.precioPack) ||  producto.precioPack < 0 ) {
        producto.precioPack=0;
    }
    if (isNaN(producto.precioUnit) ||  producto.precioUnit < 0) {
        producto.precioUnit=0;
    }
    

    if(producto.isIva == true){
        producto.isIva = 1;
    }else{
        producto.isIva = 0;
    }

  
};




