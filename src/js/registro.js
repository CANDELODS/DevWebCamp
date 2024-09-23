import Swal from 'sweetalert2';
(function () {
    let eventos = [];
    const resumen = document.querySelector('#registro-resumen');
    if (resumen) {
        const eventosBoton = document.querySelectorAll('.evento__agregar');
        eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento));

        const formularioRegistro = document.querySelector('#registro');
        formularioRegistro.addEventListener('submit', submitFormulario);

        mostrarEventos();

        //Nos Permitirá Seleccionar El Evento
        function seleccionarEvento(e) {
            if (eventos.length < 5) {
                //Deshabilitar El Evento
                e.target.disabled = true;
                eventos = [...eventos, {
                    id: e.target.dataset.id,
                    //Vamos Al Elemento Padre Del Button (div class="evento__informacion" Y Seleccionamos El H4 Con La Clase
                    //.evento__nombre)
                    titulo: e.target.parentElement.querySelector('.evento__nombre').textContent.trim()
                }]

                mostrarEventos();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Máximo 5 Eventos Por Registro',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }

        }

        //Por Medio Del Scripting Mostrar Los Eventos Que Se Agregan Al Registro
        function mostrarEventos() {
            //LIMPIAR HTML
            limpiarEventos();
            if (eventos.length > 0) {
                eventos.forEach(evento => {
                    const eventoDOM = document.createElement('DIV');
                    eventoDOM.classList.add('registro__evento');

                    const titulo = document.createElement('H3');
                    titulo.classList.add('registro__nombre');
                    titulo.textContent = evento.titulo;

                    const botonEliminar = document.createElement('BUTTON');
                    botonEliminar.classList.add('registro__eliminar');
                    botonEliminar.innerHTML = `<i class="fa-solid fa-trash"></i>Eliminar`
                    botonEliminar.onclick = function () {
                        eliminarEvento(evento.id);
                    }

                    //Renderizar En El HTML
                    eventoDOM.appendChild(titulo);
                    eventoDOM.appendChild(botonEliminar);
                    resumen.appendChild(eventoDOM);
                })
            }else{
                const noRegistro = document.createElement('P');
                noRegistro.textContent = 'No Hay Eventos, Añade Hasta 5 Desde El Lado Izquierdo';
                noRegistro.classList.add('registro__texto');
                resumen.appendChild(noRegistro);
            }
        }

        //Nos Permitirá Eliminar Un Evento
        function eliminarEvento(id) {
            //Recordemos Que Filter Nos Retorna Un Nuevo Arreglo
            //Obtenemos Todos Los Eventos Que Tengan Un Id Diferente Al Que Le Estamos Pasando
            eventos = eventos.filter(evento => evento.id !== id);
            //Habilitamos El Evento Nuevamente
            const botonAgregar = document.querySelector(`[data-id="${id}"]`);
            botonAgregar.disabled = false;
            //Renderizamos Y Mostramos HTML
            mostrarEventos();
        }

        //Evitamos Que Los Eventos Se Muestren Repetidos
        function limpiarEventos() {
            while (resumen.firstChild) {
                resumen.removeChild(resumen.firstChild);
            }
        }

        //Controlará El Envío Del Formulario
       async function submitFormulario(e){
        //Prevenimos La Acción Por Default Que Es Leer El Valor Del Action y El Method, Dado Que
        //Vamos A Usar Fetch API
            e.preventDefault();

            //Obtener El Regalo
            const regaloId = document.querySelector('#regalo').value;
            //Obtenemos El Id De Los Eventos
            //Recordemos Que El Map Nos Permite Iterar Un Arreglo Y Nos Devolverá Los Valores
            //Que Consideremos Importantes
            const eventosId = eventos.map(evento => evento.id);

            //Si El Arreglo Está Vacío (No Han Seleccionado Nada) Entonces
            if(eventosId.length === 0 || regaloId === ''){
                Swal.fire({
                    title: 'Error',
                    text: 'Elige Al Menos Un Evento Y Un Regalo',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
                return;
            }
            //Form Data Para Enviar La Informacion
            const datos = new FormData();
            datos.append('eventos', eventosId);
            datos.append('regalo_id', regaloId);
            const url = '/finalizar-registro/conferencias';
            const respuesta = await fetch(url,{
               method: 'POST',
               body: datos
            });
            const resultado = await respuesta.json();

            if(resultado.resultado){
                Swal.fire(
                    'Registro Exitoso',
                    'Tus Conferencias Se Han Almacenado Y Tu Registro Fue Exitoso, Te Esperamos En DevWebCamp',
                    'success'
                ).then( () => location.href = `/boleto?id=${resultado.token}`);
            }else{
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo Un Error, Vuelve A Revisar La Disponibilidad De Los Eventos',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then( () => location.reload() );
            }
        }
    }

})();