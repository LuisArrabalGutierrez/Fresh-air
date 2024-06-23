// Obtener referencias a los elementos del DOM
const botonMostrar = document.querySelector('.mostrar-comentarios');
const divComentarios = document.querySelector('.seccion-comentarios');
const comentarioFormulario = document.getElementById('commentForm');
const authorInput = document.getElementById('author');
const commentTextInput = document.getElementById('commentText');
const emailInput = document.getElementById('email');
const botonesMostrarModificar = document.querySelectorAll('.mostrar-modificar');
const divModificar = document.querySelectorAll('.div-modificar');
const campoBusqueda = document.getElementById('busqueda');

let palabrasProhibidas = [];

function cargarPalabrasProhibidas() {
    fetch('prohibidas.php')
        .then(response => response.json())
        .then(data => {
            palabrasProhibidas = data;
            console.log(palabrasProhibidas);
        })
        .catch(error => console.error('Error al cargar palabras prohibidas:', error));
}

cargarPalabrasProhibidas();

// Función para mostrar u ocultar la sección de comentarios
botonMostrar.addEventListener('click', () => {
    if (divComentarios.style.display === 'none' || divComentarios.style.display === '') {
        divComentarios.style.display = 'block';
        botonMostrar.textContent = 'Ocultar comentarios';
    } else {
        divComentarios.style.display = 'none';
        botonMostrar.textContent = 'Ver comentarios';
    }
});

// Iterar sobre todos los botones y agregar el evento click
botonesMostrarModificar.forEach((boton, index) => {
    boton.addEventListener('click', () => {
        if (divModificar[index].style.display === 'none' || divModificar[index].style.display === '') {
            divModificar[index].style.display = 'block';
            boton.textContent = 'Cerrar';
        } else {
            divModificar[index].style.display = 'none';
            boton.textContent = 'Abrir';
        }
    });
});

// Mostrar filtros y búsqueda de comentarios moderador
campoBusqueda.addEventListener('input', () => {
    const textoBusqueda = campoBusqueda.value.toLowerCase().trim();
    const comentarios = document.querySelectorAll('.comentario');

    comentarios.forEach(comentario => {
        const textoComentario = comentario.textContent.toLowerCase();
        comentario.style.display = textoComentario.includes(textoBusqueda) ? 'block' : 'none';
    });
});

// Escuchar el evento 'input' en el campo de texto del comentario
commentTextInput.addEventListener('input', () => {
    let comentario = commentTextInput.value;

    palabrasProhibidas.forEach(palabra => {
        const regex = new RegExp(`\\b${palabra}\\b`, 'gi');
        comentario = comentario.replace(regex, '*'.repeat(palabra.length));
    });

    commentTextInput.value = comentario;
});

// Validación del formulario de comentarios
comentarioFormulario.addEventListener('submit', (event) => {
    event.preventDefault();

    if (authorInput.value.trim() === '' || emailInput.value.trim() === '' || commentTextInput.value.trim() === '') {
        alert('Por favor, complete todos los campos del formulario.');
        return;
    }

    const emailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailFormat.test(emailInput.value.trim())) {
        alert('Por favor, introduzca un correo electrónico válido.');
        return;
    }

    const nuevoComentario = document.createElement('div');
    nuevoComentario.classList.add('comentario');
    nuevoComentario.innerHTML = `
        <p><strong>Autor:</strong> ${authorInput.value.trim()}</p>
        <p><strong>Fecha:</strong> ${new Date().toLocaleDateString()}</p>
        <p>${commentTextInput.value.trim()}</p>
        <div class="clasificacion">
            <span class="estrella">&#9733;</span>
            <span class="estrella">&#9733;</span>
            <span class="estrella">&#9733;</span>
            <span class="estrella">&#9733;</span>
            <span class="estrella">&#9733;</span>
        </div>
    `;

    divComentarios.insertBefore(nuevoComentario, comentarioFormulario);
    comentarioFormulario.reset();
});
