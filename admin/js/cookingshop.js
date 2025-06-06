$(document).ready(function () {
  $.ajax({
    type: "post",
    url: "ajax/leerCarrito.php",
    dataType: "json",
    success: function (response) {
      llenarCarrito(response);
    }
  });
  $.ajax({
    type: "post",
    url: "ajax/leerCarrito.php",
    dataType: "json",
    success: function (response) {
      llenarTablaCarrito(response);
    }
  });
  function llenarTablaCarrito(response){
    $("#tablaCarrito tbody").text("");
    var total=0;
    response.forEach(element => {
      var precio=parseFloat(element['precio']);
      var totalProd=element['cantidad']*precio;
      total=total+totalProd;
      $("#tablaCarrito tbody").append(
        `
        <tr style="border-bottom:rgba(161, 161, 161, 0.44) solid 2px;">
          <td><img src="${element['web_path']}" class="img-size-50"></td>
          <td>${element['nombre']}</td>
          <td>
            <button type="button" class="btn-xs btn-danger menos"
            ${element['cantidad'] <= 1 ? 'disabled' : ''}
            data-id="${element['id']}"
            data-tipo="menos">-</button>
            ${element['cantidad']}
            <button type="button" class="btn-xs btn-primary mas"
            data-id="${element['id']}"
            data-tipo="mas"
            >+</button>
          </td>
          <td>${precio.toFixed(2)}</td>
          <td>${totalProd.toFixed(2)}</td>
          <td><i class="fa fa-trash text-danger borrarProducto" data-id="${element['id']}"></i></td>
        </tr>
        `
      );
    });
    $("#tablaCarrito tbody").append(
      `
      <tr>
        <td colspan="4" class="text-right"><strong>Total:</strong></td>
        <td>${total.toFixed(2)}</td>
        <td></td>
      </tr>
      <tr>

      </tr>
      `
    );
  }
  $.ajax({
    type: "post",
    url: "ajax/leerCarrito.php",
    dataType: "json",
    success: function (response) {
      llenarTablaPasarela(response);
    }
  });
  function llenarTablaPasarela(response){
    $("#tablaPasarela tbody").text("");
    var total=0;
    response.forEach(element => {
      var precio=parseFloat(element['precio']);
      var totalProd=element['cantidad']*precio;
      total=total+totalProd;
      $("#tablaPasarela tbody").append(
        `
        <tr style="border-bottom:rgba(161, 161, 161, 0.44) solid 2px;">
          <td><img src="${element['web_path']}" class="img-size-50"></td>
          <td>${element['nombre']}</td>
          <td>
            ${element['cantidad']}
            <input type="hidden" name="id[]" value="${element['id']}">
            <input type="hidden" name="cantidad[]" value="${element['cantidad']}">
            <input type="hidden" name="precio[]" value="${precio.toFixed(2)}">
          </td>
          <td>${precio.toFixed(2)}</td>
          <td>${totalProd.toFixed(2)}</td>
        </tr>
        `
      );
    });
    $("#tablaPasarela tbody").append(
      `
      <tr>
        <td colspan="4" class="text-right"><strong>Total:</strong></td>
        <td>${total.toFixed(2)}
          <input type="hidden" name="total" value="${total.toFixed(2)*100}">
        </td>
      </tr>
      `
    );
  }
  $(document).on("click",".mas,.menos", function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var tipo = $(this).data('tipo');
    $.ajax({
      type: "post",
      url: "ajax/cambiarCantidadProducto.php",
      data: {"id":id,"tipo":tipo},
      dataType: "json",
      success: function (response) {
        llenarTablaCarrito(response);
        llenarCarrito(response);
      }
    });
  });
  $(document).on("click", ".borrarProducto",function(e){
    e.preventDefault();
    var id=$(this).data('id');
    $.ajax({
      type: "post",
      url: "ajax/borrarProducto.php",
      data: {"id":id},
      dataType: "json",
      success: function (response) {
        llenarTablaCarrito(response);
        llenarCarrito(response);
      }
    });
  });
  $("#agregarCarrito").click(function (e) { 
    e.preventDefault();
    var id=$(this).data('id');
    var nombre=$(this).data('nombre');
    var web_path=$(this).data('web_path');
    var cantidad=$("#cantidadProducto").val();
    var precio = $(this).data('precio');
    var existencias=$(this).data("existencias");
    $.ajax({
      type: "post",
      url: "ajax/agregarCarrito.php",
      data: {"id":id, "nombre":nombre, "web_path":web_path, "cantidad":cantidad, "precio":precio, "existencias":existencias},
      dataType: "json",
      success: function (response) {
        llenarCarrito(response);
        $("#badgeProducto").hide(500).show(500).hide(500).show(500).hide(500).show(500);
      }
    });
  });
  function llenarCarrito(response){
    var cantidad = Object.keys(response).length;
    if(cantidad>0){
      $("#badgeProducto").text(cantidad);
    } else {
      $("#badgeProducto").text("");
    }
    $("#listaCarrito").text("");
    response.forEach(element => {
      $("#listaCarrito").append(
        `
        <a href="index.php?modulo=descripcionProducto&id=${element['id']}" class="dropdown-item">
          <!-- Message Start -->
          <div class="media d-flex align-items-center">
            <img src="${element['web_path']}" class="img-size-50 mr-3 img-circle">
            <div class="media-body">
              <h3 class="dropdown-item-title">${element['nombre']}</h3>
              <p class="text-sm">Cantidad: ${element['cantidad']}</p>
            </div>
          </div>
          <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        `
      );
    });
    $("#listaCarrito").append(
      `
      <a href="index.php?modulo=verCarrito" class="dropdown-item dropdown-footer text-success" style="text-align: center;">
        Ver el carrito
        <i class="fas fa-eye"></i>
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item dropdown-footer text-danger" id="borrarCarrito" style="text-align: center;">
        Limpiar el carrito
        <i class="fa fa-trash"></i>
      </a>
      `
    );
  }
  $(document).on("click","#borrarCarrito",function(e){
    e.preventDefault();
    $.ajax({
      type: "post",
      url: "ajax/borrarCarrito.php",
      dataType: "json",
      success: function (response) {
        llenarCarrito(response);
      }
    });
  });
});