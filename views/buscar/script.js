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

            if (data.status === "error") {
                Swal.fire({ icon: "error", title: "Error", text: data.message });
            } else if (data.status === "warning" || data.status === "info") {
                Swal.fire({ icon: "info", title: "Aviso", text: data.message });
            } else if (data.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Búsqueda exitosa",
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                mostrarResultados(data.data);
            }
        } catch (err) {
            console.error(err);
            Swal.fire({ icon: "error", title: "Error", text: "No se pudo conectar con la API." });
        }
    });

    function mostrarResultados(resultados) {
        resultadosDiv.innerHTML = "";
        resultados.forEach(item => {
            const card = document.createElement("div");
            card.classList.add("card", "shadow-sm", "mb-3");

            card.innerHTML = `
                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold">${item.lugar}</h5>
                    <p class="card-text mb-1"><strong>Tipo:</strong> ${item.tipo || "Sin tipo"}</p>
                    <p class="card-text"><strong>Descripción:</strong> ${item.descripcion || "Sin descripción"}</p>
                    <p class="card-text"><strong>Ubicación:</strong> ${item.departamento}, ${item.provincia}, ${item.distrito}</p>
                </div>
            `;
            resultadosDiv.appendChild(card);
        });
    }
});
