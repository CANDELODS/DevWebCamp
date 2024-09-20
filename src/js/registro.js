(function () {
    let eventos = [];
    const resumen = document.querySelector('#registro-resumen');
    const eventosBoton = document.querySelectorAll('.evento__agregar');
    eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento));

    //Nos Permitirá Seleccionar El Evento
    function seleccionarEvento(e) {
        
        //Deshabilitar El Evento
        e.target.disabled = true;
        eventos = [...eventos, {
            id: e.target.dataset.id,
            //Vamos Al Elemento Padre Del Button (div class="evento__informacion" Y Seleccionamos El H4 Con La Clase
            //.evento__nombre)
            titulo: e.target.parentElement.querySelector('.evento__nombre').textContent.trim()
        }]

        mostrarEventos();
    }

    //Por Medio Del Scripting Mostrar Los Eventos Que Se Agregan Al Registro
    function mostrarEventos(){
        //LIMPIAR HTML
        limpiarEventos();
        if(eventos.length > 0){
            eventos.forEach(evento =>{
                const eventoDOM = document.createElement('DIV');
                eventoDOM.classList.add('registro__evento');

                const titulo = document.createElement('H3');
                titulo.classList.add('registro__nombre');
                titulo.textContent = evento.titulo;

                const botonEliminar = document.createElement('BUTTON');
                botonEliminar.classList.add('registro__eliminar');
                botonEliminar.innerHTML = `<i class="fa-solid fa-trash"></i>Eliminar`
                botonEliminar.onclick = function() {
                    eliminarEvento(evento.id);
                }

                //Renderizar En El HTML
                eventoDOM.appendChild(titulo);
                eventoDOM.appendChild(botonEliminar);
                resumen.appendChild(eventoDOM);
            })
        }
    }

    //Nos Permitirá Eliminar Un Evento
    function eliminarEvento(id){
        console.log(id);
    }

    //Evitamos Que Los Eventos Se Muestren Repetidos
    function limpiarEventos(){
        while(resumen.firstChild){
            resumen.removeChild(resumen.firstChild);
        }
    }
})();