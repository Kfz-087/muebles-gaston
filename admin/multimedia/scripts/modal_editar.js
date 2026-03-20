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
            const id_multimedia = btn.dataset.id;

            // Show loading state and open modal
            modal.classList.add("is-active");
            modalContent.innerHTML = '<p style="text-align:center; padding: 20px;">Cargando datos...</p>';

            fetch("backend/cargar_multimedia.php?id_multimedia=" + id_multimedia)
                .then(response => response.json())
                .then(data => {
                    console.log("Multimedia:", data);

                    // Build Formato Options
                    let formatosOptions = '<option value="">Seleccionar Formato</option>';
                    if (typeof formatosData !== 'undefined') {
                        formatosData.forEach(form => {
                            const selected = (data.id_formato == form.id_formato) ? 'selected' : '';
                            formatosOptions += `<option value="${form.id_formato}" ${selected}>${form.Nombre}</option>`;
                        });
                    }

                    let HTML = `
                        <span class="cerrar">&times;</span>
                        <h3 class="modal-title">Editar Archivo Multimedia</h3>
                        
                        <form action="backend/actualizar_multimedia.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_multimedia" value="${data.id_multimedia}">
                            
                            <div class="form-wrapper">
                                <div class="form-group">
                                    <label for="nombre_multimedia">Nombre / Título</label>
                                    <input type="text" name="nombre" id="nombre_multimedia" value="${data.nombre}" placeholder="Ej: Video Presentación">
                                </div>
                                
                                <div class="form-group">
                                    <label for="duracion_multimedia">Duración (seg)</label>
                                    <input type="number" name="duracion" id="duracion_multimedia" value="${data.duracion || ''}" placeholder="Dejar en blanco si es foto">
                                </div>

                                <div class="form-group">
                                    <label for="formato_multimedia">Formato</label>
                                    <select name="id_formato" id="formato_multimedia">
                                        ${formatosOptions}
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="archivo_multimedia">Reemplazar Archivo</label>
                                    <input type="file" name="ruta" id="archivo_multimedia" accept="image/*,video/*">
                                </div>
                                
                                ${data.ruta ? `
                                <div class="img-preview-container">
                                    ${data.tipo === 'video' ? 
                                        `<video src="${data.ruta}" controls style="max-width:100%"></video>` : 
                                        `<img src="${data.ruta}" alt="Vista previa">`
                                    }
                                </div>` : ''}
                            </div>

                            <button type="submit" class="btn-save-producto">
                                Actualizar Archivo
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
