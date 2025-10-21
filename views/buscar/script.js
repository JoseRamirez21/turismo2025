document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formBusqueda");
    const resultadosDiv = document.getElementById("resultados");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const token = document.getElementById("token").value.trim();
        const urlApi = document.getElementById("url_api").value.trim();
        const dato = document.getElementById("dato").value.trim();

        if (!token || !urlApi || !dato) {
            Swal.fire({
                icon: "warning",
                title: "Campos vacíos",
                text: "Por favor completa todos los campos.",
                confirmButtonColor: "#3085d6"
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

            if (data.status !== "success" || !data.data || data.data.length === 0) {
                resultadosDiv.innerHTML = `<div class="alert alert-warning text-center mt-4">
                    ⚠️ No se encontraron resultados para <b>${dato}</b>.
                </div>`;
                return;
            }

            // Mostrar solo id, nombre, tipo y distrito
            let html = `<div class="table-responsive mt-4">
                <table class="table table-striped table-hover text-center align-middle shadow-sm">
                    <thead class="table-primary text-dark">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Distrito</th>
                        </tr>
                    </thead>
                    <tbody>`;

            data.data.forEach((item, i) => {
                html += `<tr>
                    <td>${i + 1}</td>
                    <td>${item.id_lugar}</td>
                    <td>${item.nombre}</td>
                    <td>${item.tipo || "Sin tipo"}</td>
                    <td>${item.distrito || "—"}</td>
                </tr>`;
            });

            html += `</tbody></table></div>`;
            resultadosDiv.innerHTML = html;

        } catch (err) {
            console.error(err);
            Swal.fire({ icon: "error", title: "Error", text: "No se pudo conectar con la API." });
        }
    });
});
