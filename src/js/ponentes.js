(function(){
    const ponentesInput = document.querySelector('#ponentes');
    if(ponentesInput){
        let ponentes = [];
        let ponentesFiltrados = [];
        const listadoPonentes = document.querySelector('#listado-ponentes');
        const ponenteInputHidden = document.querySelector('[name="ponente_id"]');

        obtenerPonentes();
        ponentesInput.addEventListener('input', buscarPonentes);

        async function obtenerPonentes() {
            const url = `/api/ponentes`;
            const respuesta = await fetch(url); //Hace La Consulta Hacia La URL Para Ver Si Puede Conectarse
            const resultado = await respuesta.json();

            formatearPonentes(resultado);   
        }
        //Esta Función Le Da Un Formato Diferente A Los Ponentes, Obteniendo Solo La Información Necesaria
        function formatearPonentes(arrayPonentes = []){
            //Recordemos Que Map Crea Un Arreglo Nuevo
            ponentes = arrayPonentes.map( ponente => {
                return{
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: ponente.id
                }
            })
        }
        //Como Su Nombre Lo Dice, Buscará Los Diferentes Ponentes Que Hay En La BD
        function buscarPonentes(e){
            const busqueda = e.target.value;
            if(busqueda.length > 3){
                //Creamos Expresión Regular Para Que Al Escribir Un Nombre No Importen Mayusculas O Minúsculas Y
                //Otra Para Obviar Los Acentos
                //Una Expresión Regular Busca Un Valor En Un Patrón
                //"i" Significa Que No Importa Si Algo Está Escrito En Mayuscula O Minúscula
                // const expresion = new RegExp(busqueda, "i")//Si Solo Queremos Que No Importen Mayusculas O Minúsculas
                const expresion = new RegExp(busqueda.normalize('NFD').replace(/[\u0300-\u036f]/g, ""), "i");

                ponentesFiltrados = ponentes.filter(ponente => {
                    //Recordemos Que "ponente" Es La Variable Temporal De La Función formatearPonentes
                    //No Importará Si Está Escrito En Mayuscula O Minúscula O Si Tiene O Nó Acento
                    if(ponente.nombre.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase().search(expresion) != -1){
                        return ponente; //Retornamos El Ponente En Forma De Arreglo Gracias A Filter()
                    }
                })
            }else{
                //Cuando Se Borre Lo Que Estaba Escrito No Mostrará Ningun Ponente La Función mostrarPonentes()
                ponentesFiltrados = [];
            }

            mostrarPonentes();
        }
        //Mostrará Los Ponentes Encontrados En Pantalla
        function mostrarPonentes(){
            //Limpiamos Cada Vez Que Se Encuentra Un Ponente
            //Este While Tiene Más Performance Que listadoPonentes.innerHTML = '';
            while(listadoPonentes.firstChild){
                listadoPonentes.removeChild(listadoPonentes.firstChild);
            }

            if(ponentesFiltrados.length > 0){
                ponentesFiltrados.forEach(ponente => {
                    const ponenteHTML = document.createElement('LI');
                    ponenteHTML.classList.add('listado-ponentes__ponente');
                    ponenteHTML.textContent = ponente.nombre;
                    ponenteHTML.dataset.ponenteId = ponente.id;
                    //Recordemos Que Unas De Las Ventajas De Usar createElement Es Que Podemos Asociar Eventos
                    ponenteHTML.onclick = seleccionarPonente;
                    //Añadir Al DOM
                    listadoPonentes.appendChild(ponenteHTML);
                })
            }else{
                //No Se Encontraron Resultados Entonces:
                if(ponentesInput.value.length >=3 ) {
                    const noResultados = document.createElement('P');
                    noResultados.classList.add('listado-ponentes__no-resultado');
                    noResultados.textContent = 'No Hay Resultados Para Tu Busqueda';
                    //Añadir Al DOM
                    listadoPonentes.appendChild(noResultados);
                }

            }
        }

        function seleccionarPonente(e){
            //Remover La Clase Previa
            const ponentePrevio = document.querySelector('.listado-ponentes__ponente--seleccionado');
            if(ponentePrevio){
                ponentePrevio.classList.remove('listado-ponentes__ponente--seleccionado');
            }
            const ponente = e.target //Con Esto El Ponente Será El Que Seleccionemos
            ponente.classList.add('listado-ponentes__ponente--seleccionado');

            //Asignamos El Id De La Selección A La Variable ponenteInputHidden
            ponenteInputHidden.value = ponente.dataset.ponenteId;
        }
    }
})();