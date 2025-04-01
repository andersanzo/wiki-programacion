<!-- Botón modo oscuro -->
<button id="theme-toggle" class="theme-toggle">🌙</button>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("theme-toggle");
    const theme = localStorage.getItem("theme");

    // Aplicar tema guardado
    if (theme === "dark") {
        document.body.classList.add("dark-mode");
        document.body.classList.remove("light-mode");
        toggleBtn.textContent = "☀️";
    } else {
        document.body.classList.add("light-mode");
        document.body.classList.remove("dark-mode");
        toggleBtn.textContent = "🌙";
    }

    // Cambiar tema al hacer clic
    toggleBtn.addEventListener("click", () => {
        if (document.body.classList.contains("dark-mode")) {
            document.body.classList.remove("dark-mode");
            document.body.classList.add("light-mode");
            localStorage.setItem("theme", "light");
            toggleBtn.textContent = "🌙";
        } else {
            document.body.classList.remove("light-mode");
            document.body.classList.add("dark-mode");
            localStorage.setItem("theme", "dark");
            toggleBtn.textContent = "☀️";
        }
    });
});
</script>

<style>
/* ========== GENERAL ========== */
body {
    font-family: 'Arial', sans-serif;
    transition: background-color 0.3s, color 0.3s;
    margin: 0;
}

/* Fondos según tema */
body.light-mode {
    background: url('/wiki-programacion/assets/images/a.gif') no-repeat center center fixed;
    background-size: calc(100vw - 260px) 100vh;
    background-position: 260px center;
    background-color: #f8f9fa !important;
    color: #212529;
}

body.dark-mode {
    background: url('/wiki-programacion/assets/images/dark.png') no-repeat center center fixed;
    background-size: calc(100vw - 260px) 100vh;
    background-position: 260px center;
    background-color: #1a1a1a !important;
    color: #ffffff !important;
}

/* ========== SIDEBAR ========== */
.sidebar {
    width: 260px;
    position: fixed;
    height: 100vh;
    background-color: #212529;
    padding: 20px;
    overflow-y: auto;
    transition: background-color 0.3s;
}

.sidebar a {
    display: block;
    color: #ffffff;
    padding: 10px;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.3s ease;
}

.sidebar a:hover {
    background: rgba(255, 255, 255, 0.1);
}

/* Modo oscuro en el sidebar */
.dark-mode .sidebar {
    background-color: #181818 !important;
}

/* ========== CONTENIDO PRINCIPAL ========== */
.content {
    margin-left: 270px;
    padding: 20px;
    width: calc(100% - 270px);
    transition: background-color 0.3s ease;
}

/* Estilo mejorado para la tarjeta de bienvenida */
.welcome-box {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
}

.dark-mode .welcome-box {
    background-color: #2b2b2b !important;
    color: white;
    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.1);
}

/* ========== BOTÓN MODO OSCURO ========== */
.theme-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 10000;
    border-radius: 50%;
    padding: 12px;
    font-size: 20px;
    border: none;
    background: rgba(0, 0, 0, 0.7);
    color: #fff;
    transition: 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.theme-toggle:hover {
    background: rgba(255, 255, 255, 0.3);
}

.dark-mode .theme-toggle {
    background-color: #555 !important;
}
</style>
