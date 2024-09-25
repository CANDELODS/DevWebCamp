<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo; ?></h2>
    <p class="registro__descripcion">Elige Tu Plan</p>

    <div class="paquetes__grid">
        <div class="paquete">
            <h3 class="paquete__nombre">Pase Gratis</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual A Devwebcamp</li>
            </ul>
            <p class="paquete__precio">0 COP</p>

            <form action="/finalizar-registro/gratis" method="post">
                <input type="submit" class="paquetes__submit" value="Inscripción Gratis">
            </form>
        </div>

        <div class="paquete">
            <h3 class="paquete__nombre">Pase Presencial</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Presencial A Devwebcamp</li>
                <li class="paquete__elemento">Pase Por 2 Dias</li>
                <li class="paquete__elemento">Acceso A Talleres Y Conferencias</li>
                <li class="paquete__elemento">Acceso A Grabaciones</li>
                <li class="paquete__elemento">Camisa Del Evento</li>
                <li class="paquete__elemento">Comida Y Bebida</li>
            </ul>
            <p class="paquete__precio">800.000 COP</p>
            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>

        <div class="paquete">
            <h3 class="paquete__nombre">Pase Virutal</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual A Devwebcamp</li>
                <li class="paquete__elemento">Pase Por 2 Dias</li>
                <li class="paquete__elemento">Acceso A Talleres Y Conferencias</li>
                <li class="paquete__elemento">Acceso A Grabaciones</li>
            </ul>
            <p class="paquete__precio">200.000 COP</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container-virtual"></div>
                </div>
            </div>
        </div>
</main>


<!-- Reemplazar CLIENT_ID por tu client id proporcionado al crear la app desde el developer dashboard) -->
<script src="https://www.paypal.com/sdk/js?client-id=AdmDeV5ElpFX21J-BayAPVSGTCZW7mfdX5E1etXIGm27VXQbKHyuT4p-VAdz0SJQaKJN_Qfuta9PKsAl" data-sdk-integration-source="button-factory"></script>
 
<script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
        },
 
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"1","amount":{"currency_code":"USD","value":199}}]
          });
        },
 
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
            const datos = new FormData();
            datos.append('paquete_id', orderData.purchase_units[0].description);
            datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);

            fetch('/finalizar-registro/pagar', {
              method: 'POST',
              body: datos
            })
            .then( respuesta => respuesta.json())
            .then( resultado =>{
              if(resultado.resultado){
                //Redireccionar
                actions.redirect('http://localhost:3000/finalizar-registro/conferencias'); //El Actions es de Paypal
              }
            })

            
          });
        },
 
        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');

      //Pase Virtual
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"2","amount":{"currency_code":"USD","value":49}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
            
            const datos = new FormData();
            datos.append('paquete_id', orderData.purchase_units[0].description);
            datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);

            fetch('/finalizar-registro/pagar', {
              method: 'POST',
              body: datos
            })
            .then( respuesta => respuesta.json())
            .then( resultado =>{
              if(resultado.resultado){
                //Redireccionar
                actions.redirect('http://localhost:3000/finalizar-registro/conferencias'); //El Actions es de Paypal
              }
            })
          });
        },

        onError: function(err) {
          console.log(err);
        }

      }).render('#paypal-button-container-virtual');      
    }
 
  initPayPalButton();
</script>