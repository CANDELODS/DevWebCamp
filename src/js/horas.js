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

        function terminoBusqueda(e){
            //Llenamos El Objeto Busqueda En Su Parte De Name, Con Los Names De Las Categorias Y Los Días
            busqueda[e.target.name] = e.target.value;
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
            obtenerHorasDisponibles();
        }

        function obtenerHorasDisponibles(){
            const horasDisponibles = document.querySelectorAll('#horas li');
            horasDisponibles.forEach( hora => hora.addEventListener('click', seleccionarHora));
        }

        function seleccionarHora(e){
            //Pasamos El Valor Del Id De Hora Al Input Hidden 
            inputHiddenHora.value = e.target.dataset.horaId //dataset Para Leer Atributos Personalizados De HTML
            // console.log(); 
        }
    }
})();