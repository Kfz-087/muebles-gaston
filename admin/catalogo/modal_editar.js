document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal_editar");
    // Ensure we have the content container
    let modalContent = modal.querySelector(".modal-content");
    if (!modalContent) {
        modalContent = document.createElement("div");
        modalContent.className = "modal-content";
        modal.appendChild(modalContent);
    }

    // Close modal function
    const closeModal = () => {
        modal.classList.remove("is-active");
    };

    // Close modal when clicking outside
    window.addEventListener("click", function (event) {
        if (event.target == modal) {
            closeModal();
        }
    });

    document.body.addEventListener("click", e => {
        const btn = e.target.closest(".btn-modificar");
        if (btn) {
            const id_producto = btn.dataset.id;

            // Show loading state and open modal
            modal.classList.add("is-active");
            modalContent.innerHTML = '<p style="text-align:center; padding: 20px;">Cargando datos...</p>';

            fetch("cargar_datos.php?id_producto=" + id_producto)
                .then(response => response.json())
                .then(data => {
                    console.log("Producto:", data);

                    // Build Category Options
                    let categoriesOptions = '<option value="">Seleccionar Categoria</option>';
                    if (typeof categoriesData !== 'undefined') {
                        categoriesData.forEach(cat => {
                            const selected = (data.id_categoria == cat.id_categoria) ? 'selected' : '';
                            categoriesOptions += `<option value="${cat.id_categoria}" ${selected}>${cat.nombre}</option>`;
                        });
                    }

                    let HTML = `
                        <span class="cerrar">&times;</span>
                        <h3 class="modal-title">Editar Producto</h3>
                        
                        <form action="actualizar_producto.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_producto" value="${data.id_producto}">
                            
                            <div class="form-wrapper">
                                <div class="form-group">
                                    <label for="nombre_producto">Nombre del Producto</label>
                                    <input type="text" name="nombre" id="nombre_producto" value="${data.nombre}" placeholder="Ej: Mesa de Roble">
                                </div>
                                

                                <div class="form-group">
                                    <label for="descripcion_producto">Descripción</label>
                                    <input type="text" name="descripcion" id="descripcion_producto" value="${data.descripcion}">
                                </div>

                                

                                <div class="form-group">
                                    <label for="categoria_producto">Categoría</label>
                                    <select name="categoria" id="categoria_producto">
                                        ${categoriesOptions}
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="imagen_producto">Imagen del Producto</label>
                                    <input type="file" name="imagen" id="imagen_producto">
                                </div>
                                
                                ${data.ruta ? `
                                <div class="img-preview-container">
                                    <img src="${data.ruta}" alt="Vista previa">
                                </div>` : ''}
                            </div>

                            <button type="submit" class="btn-save-producto">
                                Actualizar Producto
                            </button>
                        </form>
                    `;

                    modalContent.innerHTML = HTML;

                    // Close button handler
                    const closeBtn = modalContent.querySelector(".cerrar");
                    if (closeBtn) {
                        closeBtn.onclick = closeModal;
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    modalContent.innerHTML = `
                        <span class="cerrar">&times;</span>
                        <p style="color:red; text-align:center; padding: 20px;">Error al cargar los datos</p>
                    `;
                    const closeBtn = modalContent.querySelector(".cerrar");
                    if (closeBtn) closeBtn.onclick = closeModal;
                });
        }
    });
});
