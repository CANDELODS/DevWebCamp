(function(){
    //Selecciono el UL Que Contiene las Horas
    const horas = document.querySelector('#horas');
    //Si Seleccionó Una Hora Entonces
    if(horas){
        let busqueda = {
            //La Categoría Vendrá Del Select De Categorias Con El name="categoria_id"
            categoria_id: '',
            //Los Días Vendrán De Los Radio Buttons Con El name="dia"
            dia: ''
        };
        //Selecciono La Categoria
        const categoria = document.querySelector('[name="categoria_id"]');
        //Le Asignamos El Evento Change Con La Función terminoBusqueda
        categoria.addEventListener('change', terminoBusqueda);
        //Selecciono Los Días
        const dias = document.querySelectorAll('[name="dia"]');
        //Selecciono Los Inputs De Tipo Hidden Que Contendrán Los Id A Enviar A La BD
        const inputHiddenDia = document.querySelector('[name="dia_id"]');
        const inputHiddenHora = document.querySelector('[name="hora_id"]');
        //Iteramos Los Días Y Les Asignamos El Evento Change Con La Función terminoBusqueda
        dias.forEach( dia=> dia.addEventListener('change', terminoBusqueda));

        //Se Ejecuta Cada El Usuario Cambia La Categoría Y El Día
        function terminoBusqueda(e){
            //Llenamos El Objeto Busqueda En Su Parte De Name, Con Los Names De Las Categorias Y Los Días
            busqueda[e.target.name] = e.target.value;
            //Reiniciar Campos Ocultos Y El Selector De Horas
            inputHiddenHora.value = '';
            inputHiddenDia.value = '';
            //Deshabilitar Hora Previa, Cuando Se Cambia La Categoría O El Día
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if(horaPrevia){
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }
            //Limitamos El LLamado A La API Solo Para Cuando Nuestro Objeto busqueda Esté Lleno
            if(Object.values(busqueda).includes('')){ //Si Almenos 1 De Los Campos Está Vacio Entonces:
                return;
            }
            buscarEventos();
        }
        
        //Consulta La API
        async function buscarEventos(){
            const {dia, categoria_id} = busqueda;
            const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`;
            const resultado = await fetch(url); //Hace La Consulta Hacia La URL Para Ver Si Puede Conectarse
            const eventos = await resultado.json();
            obtenerHorasDisponibles(eventos);
            
        }

        function obtenerHorasDisponibles(eventos){
            //Reiniciar Las Horas
            const listadoHoras = document.querySelectorAll('#horas li'); //Seleccionamos Todas Las Horas
            //Deshabilitamos Todas Las Horas Cada Vez Que Busquemos Un Nuevo Evento
            listadoHoras.forEach(li => li.classList.add('horas__hora--deshabilitada'));
            
            //Comprobar Eventos Ya Tomados Y Quitar La Variable De Deshabilitado
            const horasTomadas = eventos.map(evento => evento.hora_id); //Creamos Un Arreglo Con El Id De La Hora

            const listadoHorasArray = Array.from(listadoHoras); //Convertimos Las Horas A Arreglo Para Poder Usar Filter
           
            //Obtenemos Todas Las Horas Que No Han Sido Seleccionadas
            const resultado = listadoHorasArray.filter( li => !horasTomadas.includes(li.dataset.horaId));
            
            //Quitamos La Clase Para Que Las Horas Que No Estaban Seleccionadas Estén Disponibles
            resultado.forEach( li => li.classList.remove('horas__hora--deshabilitada'));

            //Trae Todas Las Horas Menos La Que Tiene La Clase De horas__hora--deshabilitada
            //Con Esto No Se Guardará El Name De Una Hora Que Ya Está Utilizada
            const horasDisponibles = document.querySelectorAll('#horas li:not(.horas__hora--deshabilitada)');
            horasDisponibles.forEach( hora => hora.addEventListener('click', seleccionarHora));
        }

        function seleccionarHora(e){
            //Deshabilitar Hora Previa, Si Hay Un Nuevo Click
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if(horaPrevia){
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }
            //Agregar Clase De Seleccionado
            e.target.classList.add('horas__hora--seleccionada');
            //Pasamos El Valor Del Id De Hora Al Input Hidden 
            inputHiddenHora.value = e.target.dataset.horaId //dataset Para Leer Atributos Personalizados De HTML
            //Llenar Campo Oculto De Dia
            inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value;
            // console.log(); 
        }
    }
})();