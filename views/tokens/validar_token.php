<?php
require_once __DIR__ . '/../../config/config.php';
require_once view_path('views/templates/header.php');
require_once view_path('views/templates/navbar.php');
?>

<main class="d-flex justify-content-center align-items-center" 
      style="min-height: 85vh; background: linear-gradient(135deg, #007bff, #6610f2);">
  <div class="card shadow-lg p-4 text-center bg-white" style="width: 420px; border-radius: 1rem;">
    <h4 class="mb-3 text-primary fw-bold">🔐 Validar Acceso con Token</h4>
    <p class="text-muted">Ingresa un token válido para acceder al panel de administración</p>

    <input type="text" id="token" class="form-control mb-3 text-center" placeholder="Ingrese su token">
    <button onclick="validarToken()" class="btn btn-primary w-100 rounded-pill shadow-sm">
      Verificar Token
    </button>

    <div id="resultado" class="mt-3 fw-bold"></div>
  </div>
</main>

<script>
function validarToken() {
  const token = document.getElementById("token").value.trim(); //verifica el token
  const resultado = document.getElementById("resultado");
  resultado.className = "mt-3 fw-bold";

  if (token === "") {
    resultado.innerHTML = "⚠️ Debes ingresar un token."; //verificacion inicial
    resultado.classList.add('text-danger');
    return;
  }

fetch('../../api/tokens.php?action=validate', {
  method: 'POST',
  headers: {'Content-Type': 'application/json'}, //validacion de token
  body: JSON.stringify({ token })
})


  .then(res => {
    if (!res.ok) throw new Error('Error al conectar con la API');
    return res.json();
  })
  .then(data => {                
    if (data.status === 'success') {
      resultado.innerHTML = "✅ Token válido. Redirigiendo...";
      resultado.classList.remove('text-danger');
      resultado.classList.add('text-success');
      setTimeout(() => window.location.href = '../admin/dashboard.php', 1500);//Si el token es válido → muestra un mensaje y redirige al dashboard
    } else {
      resultado.innerHTML = "❌ Token inválido o expirado.";//  Si es inválido → muestra un error.
      resultado.classList.add('text-danger');
    }
  })
  .catch(err => {
    resultado.innerHTML = "⚠️ Error: " + err.message; //Capturalos errores de las API y lo muestra en la interfaz
    resultado.classList.add('text-danger');
  });
}
</script>

<?php require_once __DIR__ . '/../admin/templates/footer.php'; ?>
