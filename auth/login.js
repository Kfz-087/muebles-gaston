const nombre = document.getElementById('nombre-usuario');
const contrasena = document.getElementById('contrasena-usuario');
const submit = document.getElementById('submit');
const rolInput = document.getElementById('rol');

submit.addEventListener('click', function (e) {
    e.preventDefault();

    if (nombre.value === '' || contrasena.value === '') {
        alert('Hay un Campo incompleto');
    } else {
        const data = {
            usuario: nombre.value,
            contrasena: contrasena.value,
            rol: rolInput ? rolInput.value : ''
        };
        fetch('../auth/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // DEBUG: Alert the data received
                    alert('Debug: ' + JSON.stringify(data));


                    // Ensure role is a string and trimmed
                    // let userRol = String(data.usuario.rol).trim();
                    // console.log('Rol detectado:', userRol);

                    if (data.usuario.rol === '1') {
                        console.log('Redirigiendo a admin');
                        window.location.href = '../admin/index.php';
                    } else if (data.usuario.rol === '0') {
                        console.log('Redirigiendo a public');
                        window.location.href = '../public/index.php';
                    }
                } else {
                    alert(data.message);
                    console.log(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al conectar con el servidor');
            });
    }
});