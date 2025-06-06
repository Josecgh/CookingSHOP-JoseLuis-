<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('terminos');
        const botonPagar = document.getElementById('btnPagar');

        function actualizarEstadoBoton() {
            botonPagar.disabled = !checkbox.checked;
        }

        // Escuchar cambios en el checkbox
        checkbox.addEventListener('change', actualizarEstadoBoton);

        // Establecer el estado inicial al cargar la página
        actualizarEstadoBoton();
    });
</script>

<form action="index.php?modulo=factura" method="post" id="payment-form" style="margin-top: 11px;">
    <table class="table table-striped table-inverse" id="tablaPasarela">
        <thead class="thead-inverse">
            <tr style="background-color:rgba(161, 161, 161, 0.72);">
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
 
    <div class="form-row">
        <h4 class="mt-3">Datos de su tarjeta</h4>
        <div id="card-element">
            <!-- A Stripe Element will be inserted here. -->
        </div>
 
        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
    </div>
    <div class="mt-3">
        <h4>Terminos y condiciones</h4>
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Minima, soluta non quibusdam, assumenda mollitia expedita nihil quisquam sapiente optio rem reiciendis voluptatum laborum eos consectetur obcaecati sint incidunt doloribus placeat!
        Lorem, ipsum dolor sit amet consectetur (le entrego mi alrma a programamdor novato y acepto dar like) adipisicing elit. Minima, soluta non quibusdam, assumenda mollitia expedita nihil quisquam sapiente optio rem reiciendis voluptatum laborum eos consectetur obcaecati sint incidunt doloribus placeat!
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Minima, soluta non quibusdam, assumenda mollitia expedita nihil quisquam sapiente optio rem reiciendis voluptatum laborum eos consectetur obcaecati sint incidunt doloribus placeat!
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="terminos" id="terminos" value="checkedValue" checked>
                Acepto los términos y condiciones
            </label>
        </div>
    </div>
    <div class="mt-3">
        <a class="btn btn-warning" href="index.php?modulo=registroEnvio" role="button">Ir a envio</a>
        <button class="btn btn-primary float-end" id="btnPagar">Pagar</button>
    </div>
</form>