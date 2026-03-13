boton = document.getElementById('btn-add-sucursal');
formulario = document.getElementById('modal-sucursal');
contenido = document.querySelector('.modal-content')
cerrar = document.querySelector('.close');


boton.addEventListener('click', () => {
    formulario.style.display = 'block';
    formulario.style.overflowY = 'scroll';
    formulario.style.overflowX = 'hidden';
    contenido.style.display = 'block';

    document.getElementById('main-wrapper').style.filter = 'blur(5px) grayscale(50%)';
});

cerrar.addEventListener('click', () => {
    formulario.style.display = 'none';
    contenido.style.display = 'none';
    document.getElementById('main-wrapper').style.filter = 'none';
});

// window.addEventListener('click', (e) => {
//     if (e.target == formulario) {
//         formulario.style.display = 'none';
//         contenido.style.display = 'none';
//         document.getElementById('main-wrapper').style.filter = 'none';
//     }
// });

