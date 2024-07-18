(function () { //Función IIFE
    const tagsInput = document.querySelector('#tags_input');
    if (tagsInput) {
        const tagsDiv = document.querySelector('#tags');
        const tagsInputHidden = document.querySelector('[name="tags"]');
        let tags = [];
        //Recuperar Del Input Oculto
        if(tagsInputHidden.value !== ''){
            tags = tagsInputHidden.value.split(',');
            mostrarTags();
        }

        //Escuchar Los Cambios En El Input
        tagsInput.addEventListener('keypress', guardarTag);

        function guardarTag(e) {
            //El keyCode Nos Permite Saber El Código De La Tecla Presionada, En Este Caso 44 = coma(,)
            if (e.keyCode === 44) {
                //Para Que No Se Ponga La Coma En Automático Cuando Se Borra El Input Quitamos La Acción Por Defecto Del Form
                e.preventDefault();
                //Prevenir Espacios En Blanco
                if (e.target.value.trim() === '' || e.target.value < 1) {
                    return;
                }
                //Tomamos Una Copia Del Arreglo Tags, Y Reemplazamos El Contenido Con Lo Que Hay En El Input
                tags = [...tags, e.target.value.trim()];
                //Vaciamos El Input Cada Vez Que Se Pone Una Coma(,)
                tagsInput.value = '';
                mostrarTags();
            }
        }

        function mostrarTags(){
            tagsDiv.textContent = '';
            //Iteramos El Arreglo Que Tiene Los Tags, Creo La Variable Momentanea Tag Y Hago Escripting Para
            //Mostrar Los Tags En El Lugar Deseado
            tags.forEach(tag => {
                const etiqueta = document.createElement('LI');
                etiqueta.classList.add('formulario__tag');
                etiqueta.textContent = tag;
                //Pasamos Función A Cada Uno De Los Tags Conforme Son Creados
                etiqueta.ondblclick = eliminarTag; //No Ponemos eliminarTag() Por Que Llamaría La Función Inmediatamente
                tagsDiv.appendChild(etiqueta);
            })

            actualizarInputHidden();
        }

        //Como Su Nombre lo Dice, Nos Permitirá Eliminar Los Tags, Se Pasa El Evento (e) Para Identificar El Tag
        function eliminarTag(e){
            //Quitamos El Tag Del DOM
            e.target.remove();
            //Quitamos El Tag Del Arreglo
            //Traenos Todos Los Tags Que No Sean Al Que Yo Le Dí Click 
            tags = tags.filter(tag => tag !== e.target.textContent);
            //Refrescamos Y Sincronizamos El Input Oculto Con Los Nuevos Valores
            actualizarInputHidden();
        }

        //Esta Función Nos Permitirá Agregar Y Quitar Los Tags O Etiquetas, Seleccionando El Input Hidden
        //Con El Name Tags El Cual Usaremos Para Comunicarnos Con La BD
        function actualizarInputHidden(){
            //Convertimos El Arreglo En Un String
            tagsInputHidden.value = tags.toString();
        }
    }

})() //Este Parentecis Manda A Llamar A La Función
