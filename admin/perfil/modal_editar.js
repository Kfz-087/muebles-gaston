document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal-perfil");
    // Ensure we have the content container
    let modalContent = modal.querySelector(".modal-content2");
    if (!modalContent) {
        modalContent = document.createElement("div");
        modalContent.className = "modal-content2";
        modal.appendChild(modalContent);
    }

    // Close modal when clicking outside
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    document.body.addEventListener("click", e => {
        // Use the correct selector for the edit button
        const btn = e.target.closest("#btn-editar");
        if (btn) {
            const id_cliente = btn.dataset.id;

            // Show loading state
            modal.style.display = "block";
            modalContent.innerHTML = '<p style="text-align:center;">Cargando datos...</p>';

            fetch("cargar_datos.php?id_cliente=" + id_cliente)
                .then(response => response.json())
                .then(data => {
                    console.log("Cliente:", data);

                    if (data.error) {
                        modalContent.innerHTML = `<p style="color:red; text-align:center;">${data.error}</p>`;
                        return;
                    }

                    let HTML = `
                    <div style="display: flex; justify-content: flex-end;">
                        <span class="close" style="color: #aaa; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
                    </div>
                    <h2 style="text-align:center; margin-bottom: 20px;">Editar Perfil</h2>
                    <form action="actualizar_cliente.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_cliente" value="${data.id_cliente}">
                        <input type="hidden" name="ruta" value="${data.ruta || ''}">
                        
                        <label for="nombre_cliente" class="modificar-label"> Nombre:
                            <input type="text" class='modificar' name="nombre" id="nombre_cliente" value="${data.nombre}" style="display:block; width:100%; margin-bottom:10px;">
                        </label>

                        <label for="apellido_cliente" class="modificar-label"> Apellido:
                            <input type="text" class='modificar' name="apellido" id="apellido_cliente" value="${data.apellido}" style="display:block; width:100%; margin-bottom:10px;">
                        </label>

                        <label for="usuario_cliente" class="modificar-label"> Usuario:
                            <input type="text" class='modificar' name="usuario" id="usuario_cliente" value="${data.usuario}" style="display:block; width:100%; margin-bottom:10px;">
                        </label>

                        <label for="email_cliente" class="modificar-label"> Email:
                            <input type="email" class='modificar' name="email" id="email_cliente" value="${data.correo}" style="display:block; width:100%; margin-bottom:10px;">
                        </label>

                        <label for="telefono_cliente" class="modificar-label"> Teléfono:
                            <input type="text" class='modificar' name="telefono" id="telefono_cliente" value="${data.telefono}" style="display:block; width:100%; margin-bottom:10px;">
                        </label>

                        <label for="direccion_cliente" class="modificar-label"> Dirección:
                            <input type="text" class='modificar' name="direccion" id="direccion_cliente" value="${data.direccion}" style="display:block; width:100%; margin-bottom:10px;">
                        </label>

                        <label for="localidad_cliente" class="modificar-label"> Localidad:
                            <input type="text" class='modificar' name="localidad" id="localidad_cliente" value="${data.localidad}" style="display:block; width:100%; margin-bottom:10px;">
                        </label>

                        <label for="cod_postal" class="modificar-label"> Código Postal:
                            <input type="number" class='modificar' name="postal" id="cod_postal" value="${data.postal || ''}" style="display:block; width:100%; margin-bottom:10px;">
                        </label>
                        
                         <label for="password_cliente" class="modificar-label"> Contraseña:
                            <input type="password" class='modificar' name="password" id="password_cliente" value="${data.contrasena}" style="display:block; width:100%; margin-bottom:10px;">
                        </label>

                        <label for="imagen_producto" class="modificar-label"> Imagen de Perfil:
                            <input type="file" class='modificar-imagen' name="imagen" id="imagen_producto" style="display:block; width:100%; margin-bottom:10px;">
                        </label>
                        
                        ${data.ruta ? `<div style="text-align: center; margin-bottom: 10px;"><img src="${data.ruta}" alt="Imagen actual" style="max-height: 100px; border-radius: 50%;"></div>` : ''}

                        <button type="submit" class="btn-add-cart-sm" style="width:100%; margin-top: 10px; cursor: pointer;">Actualizar Perfil</button>
                    </form>
                    `;

                    modalContent.innerHTML = HTML;

                    // Close button handler
                    const closeBtn = modalContent.querySelector(".close");
                    if (closeBtn) {
                        closeBtn.onclick = () => {
                            modal.style.display = "none";
                        };
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    modalContent.innerHTML = '<p style="color:red; text-align:center;">Error al cargar los datos</p>';
                });
        }
    })
})

