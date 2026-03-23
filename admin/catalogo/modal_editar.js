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
                                    <label for="color_tono">Tono de Color</label>
                                    <select name="color_tono" id="color_tono">
                                        <option value="">Seleccionar Tono</option>
                                        <option value="Blanco" ${data.color_tono == 'Blanco' ? 'selected' : ''}>Blanco</option>
                                        <option value="Gris" ${data.color_tono == 'Gris' ? 'selected' : ''}>Gris</option>
                                        <option value="Negro" ${data.color_tono == 'Negro' ? 'selected' : ''}>Negro</option>
                                        <option value="Madera Clara" ${data.color_tono == 'Madera Clara' ? 'selected' : ''}>Madera Clara</option>
                                        <option value="Madera Media" ${data.color_tono == 'Madera Media' ? 'selected' : ''}>Madera Media</option>
                                        <option value="Madera Oscura" ${data.color_tono == 'Madera Oscura' ? 'selected' : ''}>Madera Oscura</option>
                                        <option value="Cálido" ${data.color_tono == 'Cálido' ? 'selected' : ''}>Cálido</option>
                                        <option value="Frío" ${data.color_tono == 'Frío' ? 'selected' : ''}>Frío</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tipo_diseno">Tipo de Diseño</label>
                                    <select name="tipo_diseno" id="tipo_diseno">
                                        <option value="">Seleccionar Diseño</option>
                                        <option value="Unicolor" ${data.tipo_diseno == 'Unicolor' ? 'selected' : ''}>Unicolor</option>
                                        <option value="Madera" ${data.tipo_diseno == 'Madera' ? 'selected' : ''}>Madera</option>
                                        <option value="Material" ${data.tipo_diseno == 'Material' ? 'selected' : ''}>Material (Piedra, Textil, Metal)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="superficie_acabado">Superficie/Acabado</label>
                                    <select name="superficie_acabado" id="superficie_acabado">
                                        <option value="">Seleccionar Acabado</option>
                                        <option value="Mate" ${data.superficie_acabado == 'Mate' ? 'selected' : ''}>Mate</option>
                                        <option value="Brillante" ${data.superficie_acabado == 'Brillante' ? 'selected' : ''}>Brillante</option>
                                        <option value="Texturado" ${data.superficie_acabado == 'Texturado' ? 'selected' : ''}>Texturado</option>
                                        <option value="Poroso" ${data.superficie_acabado == 'Poroso' ? 'selected' : ''}>Poroso</option>
                                    </select>
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
