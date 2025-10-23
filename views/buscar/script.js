document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formBusqueda");
    const resultadosDiv = document.getElementById("resultados");
    const imagenPrueba = "https://i.pinimg.com/1200x/7f/c3/68/7fc368451428d898438268d36383d154.jpg";

    if (!form || !resultadosDiv) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const token = document.getElementById("token")?.value.trim();
        const urlApi = document.getElementById("url_api")?.value.trim();
        const dato = document.getElementById("dato")?.value.trim();

        if (!token || !urlApi || !dato) {
            Swal.fire({
                icon: "warning",
                title: "Campos vacíos",
                text: "Por favor completa todos los campos.",
                confirmButtonColor: "#3085d6"
            });
            return;
        }

        // Cambiar la URL sin recargar
        const newUrl = `${window.location.pathname}?token=${encodeURIComponent(token)}&dato=${encodeURIComponent(dato)}`;
        window.history.pushState({ path: newUrl }, "", newUrl);

        try {
            const response = await fetch(urlApi, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ token, dato })
            });

            const data = await response.json();
            resultadosDiv.innerHTML = "";

            // 🔴 Detectar token inválido o inactivo (maneja acentos y emojis)
            if (data.status === "error" && data.message) {
                const cleanMessage = data.message
                    .normalize("NFD") // elimina acentos
                    .replace(/[\u0300-\u036f]/g, "") // quita marcas
                    .replace(/[^\w\s]/gi, "") // elimina emojis o signos
                    .toLowerCase();

                if (cleanMessage.includes("token invalido") || cleanMessage.includes("token inactivo")) {
                    Swal.fire({
                        icon: "error",
                        title: "Token inactivo o inválido",
                        text: "Tu token está inactivo o no es válido. Por favor verifica o solicita uno nuevo.",
                        confirmButtonColor: "#d33"
                    });
                    return;
                }
            }

            if (data.status !== "success" || !data.data || data.data.length === 0) {
                resultadosDiv.innerHTML = `<div class="alert alert-warning text-center mt-4">
                    ⚠️ No se encontraron resultados para <b>${dato}</b>.
                </div>`;
                return;
            }

            // Contenedor de tarjetas
            const cardsContainer = document.createElement("div");
            cardsContainer.style.display = "flex";
            cardsContainer.style.flexWrap = "wrap";
            cardsContainer.style.gap = "20px";
            cardsContainer.style.justifyContent = data.data.length <= 2 ? "center" : "flex-start";

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

            resultadosDiv.appendChild(cardsContainer);

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
