document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formBusqueda");
    const resultadosDiv = document.getElementById("resultados");
    const imagenPrueba = "https://i.pinimg.com/1200x/7f/c3/68/7fc368451428d898438268d36383d154.jpg"; // imagen de prueba

    // Verificar que el formulario y la división de resultados existen
    if (!form || !resultadosDiv) return;

    // Evento del formulario al hacer submit
    form.addEventListener("submit", async (e) => {
        e.preventDefault(); // Prevenir el envío normal del formulario

        // Tomar los valores del token y dato del formulario
        const token = document.getElementById("token")?.value.trim();
        const dato = document.getElementById("dato")?.value.trim();

        if (!token || !dato) {
            Swal.fire({
                icon: "warning",
                title: "Campos vacíos",
                text: "Por favor completa todos los campos.",
                confirmButtonColor: "#3085d6"
            });
            return;
        }

        try {
            // Hacer la solicitud a la API con los datos del formulario
            const response = await fetch(`${baseUrl}/api/buscar_api.php`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ token, dato }) // Enviar los datos como JSON
            });

            const data = await response.json(); // Parsear la respuesta como JSON

            // Limpiar el contenedor de resultados
            resultadosDiv.innerHTML = "";

            // Verificar errores en la respuesta
            if (data.status === "error" && data.message) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message,
                    confirmButtonColor: "#d33"
                });
                return;
            }

            // Mostrar los resultados si son exitosos
            if (data.status !== "success" || !data.data || data.data.length === 0) {
                resultadosDiv.innerHTML = `<div class="alert alert-warning text-center mt-4">
                    ⚠️ No se encontraron resultados para <b>${dato}</b>.
                </div>`;
                return;
            }

            // Crear las tarjetas con los resultados
            const cardsContainer = document.createElement("div");
            cardsContainer.style.display = "flex";
            cardsContainer.style.flexWrap = "wrap";
            cardsContainer.style.gap = "20px";
            cardsContainer.style.justifyContent = "center";

            data.data.forEach(item => {
                const cardWrapper = document.createElement("div");
                cardWrapper.className = "card-wrapper";
                cardWrapper.innerHTML = `
                    <div class="card shadow-sm h-100">
                        <img src="${imagenPrueba}" class="card-img-top" alt="${item.nombre}">
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold">${item.nombre}</h5>
                            <p class="card-text"><strong>Tipo:</strong> ${item.tipo || "Sin tipo"}</p>
                            <p class="card-text"><strong>Distrito:</strong> ${item.distrito || "—"}</p>
                            <p class="card-text"><strong>Provincia:</strong> ${item.provincia || "—"}</p>
                            <p class="card-text"><strong>Departamento:</strong> ${item.departamento || "—"}</p>
                        </div>
                    </div>
                `;
                cardsContainer.appendChild(cardWrapper);
            });

            resultadosDiv.appendChild(cardsContainer); // Agregar las tarjetas al contenedor

        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "No se pudo conectar con la API.",
                confirmButtonColor: "#d33"
            });
        }
    });
});
