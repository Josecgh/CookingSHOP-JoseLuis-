<!-- Hacer valoracion -->
<style>
  .volver-enlace img {
    transition: transform 0.3s ease;
  }

  .volver-enlace:hover img {
    transform: scale(1.1);
  }

  .valoracion {
    font-family: Arial, sans-serif;
    text-align: center;
    margin: 20px;
  }

  .estrellas {
    font-size: 40px;
    color: #ccc; /* Color por defecto de las estrellas */
  }

  .estrellas .estrella {
    cursor: pointer;
    transition: color 0.3s ease;
  }

  .estrellas .estrella:hover,
  .estrellas .estrella.hover {
    color: gold; /* Color de las estrellas cuando el mouse pasa por encima */
  }

  .estrellas .estrella.selected {
    color: gold; /* Color de las estrellas seleccionadas */
  }

  #valorSeleccionado {
    font-size: 18px;
    color: #333;
    margin-top: 10px;
  }

</style>
<?php
if(isset($_GET['id'])){
  $id = $_GET['id'];
} else {
  $id = $_POST['idProd'];
}
?>
<a href="index.php?modulo=descripcionProducto&id=<?php echo $id; ?>" class="volver-enlace" id="boton">
  <img src="admin/assets/imagenes/anterior.png" alt="Volver a la descripción del producto" id="imagen-boton" width="50px">
</a>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="app-content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h2>Formulario de valoración</h2>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <form class="container" action="index.php?modulo=subirValoracion&id=<?php echo $id?>" method="POST" style="margin-top: 20px;">
    <label class="center" for="comentario">Escribe tu opinión:</label><br>
    <textarea id="comentario" name="comentario" rows="4" cols="50"></textarea><br><br>
    
    <label for="puntuación">Valora con una puntuación</label><br>
    <div class="valoracion">
      <div class="estrellas" id="estrellas">
        <span class="estrella" data-value="1">&#9733;</span>
        <span class="estrella" data-value="2">&#9733;</span>
        <span class="estrella" data-value="3">&#9733;</span>
        <span class="estrella" data-value="4">&#9733;</span>
        <span class="estrella" data-value="5">&#9733;</span>
      </div>
      <p id="valorSeleccionado">Has seleccionado: 0 estrellas</p>
    </div>
    <button type="submit" class="btn btn-success">Enviar</button>
    <input type="hidden" name="idProd" value="<?php $id ?>">
    <input type="hidden" id="puntuacion" name="puntuacion">
  </form>
</div>
<script>
  // Obtener el botón de la imagen y la imagen
  var botonImagen = document.getElementById('boton');
  var imagenBoton = document.getElementById('imagen-boton');

  // Cambiar la imagen cuando el botón es presionado
  botonImagen.addEventListener('mousedown', function() {
    imagenBoton.src = 'admin/assets/imagenes/anterior_click.png'; // Cambia la imagen
  });

  // Restaurar la imagen cuando el botón es soltado
  botonImagen.addEventListener('mouseup', function() {
    imagenBoton.src = 'admin/assets/imagenes/anterior.png'; // Restaurar la imagen original
  });

  // También restaurar la imagen si el mouse sale del área del enlace sin soltar el botón
  botonImagen.addEventListener('mouseleave', function() {
    imagenBoton.src = 'admin/assets/imagenes/anterior.png'; // Restaurar la imagen original
  });
  document.addEventListener('DOMContentLoaded', function() {
    const estrellas = document.querySelectorAll('.estrella');
    const valorSeleccionado = document.getElementById('valorSeleccionado');
    let valor = 0;

    // Agregar evento de hover
    estrellas.forEach(estrella => {
      estrella.addEventListener('mouseenter', function() {
        // Cambiar color de las estrellas al pasar el ratón
        resetEstrellas();
        let valorHover = this.getAttribute('data-value');
        document.getElementById('puntuacion').value=valorHover;
        for (let i = 0; i < valorHover; i++) {
          estrellas[i].classList.add('hover');
        }
      });

      // Evento de salir del hover
      estrella.addEventListener('mouseleave', function() {
        resetEstrellas();
        for (let i = 0; i < valor; i++) {
          estrellas[i].classList.add('selected');
        }
      });

      // Evento de click para seleccionar el valor
      estrella.addEventListener('click', function() {
        valor = this.getAttribute('data-value');
        valorSeleccionado.textContent = `Has seleccionado: ${valor} estrella${valor > 1 ? 's' : ''}`;
        actualizarEstrellas();
      });
    });

    // Función para actualizar el estado de las estrellas
    function actualizarEstrellas() {
      resetEstrellas();
      for (let i = 0; i < valor; i++) {
        estrellas[i].classList.add('selected');
      }
    }

    // Función para resetear la animación de las estrellas
    function resetEstrellas() {
      estrellas.forEach(estrella => {
        estrella.classList.remove('hover', 'selected');
      });
    }
  });


</script>