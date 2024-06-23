function buscarActividades() {
    const input = document.getElementById('busqueda').value;
    const sugerencias = document.getElementById('sugerencias');

    if (input.length < 3) {
        sugerencias.innerHTML = '';
        return;
    }

    fetch(`buscar_actividades.php?q=${input}`)
        .then(response => response.json())
        .then(data => {
            sugerencias.innerHTML = '';
            data.forEach(actividad => {
                const li = document.createElement('li');
                li.textContent = actividad.nombre;
                li.onclick = () => {
                    window.location.href = `../actividad.php?ac=${actividad.id}`;
                };
                sugerencias.appendChild(li);
            });
        })
        .catch(error => console.error('Error:', error));
}
