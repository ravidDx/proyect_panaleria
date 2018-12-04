//evento ajax para nuevo cliente
$(document).on('click', 'button.addProd', function(){
    that = $(this);



     var detalleFactura = {
        id: that.parent().parent().attr("id"),
        producto: that.parents("tr").find("td")[1].innerHTML,
        cantidad: that.parents("tr").find('#cantidad').val(),
        precio: that.parents("tr").find('.producto_precio').val(),
        isUds:that.parents("tr").find('.producto_isUds').is(":checked")

     }


    console.log(detalleFactura);



    return false;            
                 
});


$('.producto_isUds').change(function() {
    that = $(this);
    var isUds = that.parents("tr").find('.producto_isUds').is(":checked");
    var precioPaq = that.parents("tr").find('.producto_precio').attr('value2');
    var precioUds=  that.parents("tr").find('.producto_precio').attr('value1');
  
    if(isUds == false){
        that.parents("tr").find('.producto_precio').val(precioPaq);
    }

    if(isUds == true){
        that.parents("tr").find('.producto_precio').val(precioUds);
    }
    
  
})