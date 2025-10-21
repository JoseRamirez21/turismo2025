document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formBusqueda");
    const resultadosDiv = document.getElementById("resultados");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const token = document.getElementById("token").value.trim();
        const urlApi = document.getElementById("url_api").value.trim();
        const dato = document.getElementById("dato").value.trim();

        if (!token || !dato) {
            Swal.fire({
                icon: "warning",
                title: "Campos vacíos",
                text: "Por favor completa todos los campos.",
            });
            return;
        }

        try {
            const response = await fetch(urlApi, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ token, dato })
            });

            const data = await response.json();
            resultadosDiv.innerHTML = "";

            if (data.status === "error") {
                Swal.fire({ icon: "error", title: "Error", text: data.message });
                return;
            } 

            if (data.status === "warning" || data.status === "info" || !data.data || data.data.length === 0) {
                resultadosDiv.innerHTML = `<div class="alert alert-warning text-center mt-4">
                    ⚠️ No se encontraron resultados para <b>${dato}</b>.
                </div>`;
                return;
            }

            // Mostrar resultados en cards
            let html = '';
            data.data.forEach(item => {
                html += `
                    <div class="col-md-4">
                        <div class="card-lugar p-3">
                            <h5 class="fw-bold text-primary">${item.nombre}</h5>
                            <p class="mb-1"><strong>Tipo:</strong> ${item.tipo || "Sin tipo"}</p>
                            <p class="mb-0"><strong>Distrito:</strong> ${item.distrito || "—"}</p>
                        </div>
                    </div>
                `;
            });

            resultadosDiv.innerHTML = `<div class="row g-3">${html}</div>`;

        } catch (err) {
            console.error(err);
            Swal.fire({ icon: "error", title: "Error", text: "No se pudo conectar con la API." });
        }
    });
});
