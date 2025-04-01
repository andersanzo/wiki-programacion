<?php
require_once 'config.php';
include 'includes/header.php';

// Obtener la lista de lenguajes
$query = "SELECT * FROM languages";
$result = $mysqli->query($query);
$languages = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Wiki de Programación</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
body {
  transition: background 0.3s ease;
}

body.light-mode {
  background: url('assets/images/a.gif') no-repeat left top fixed;
  background-size: calc(100vw - 260px) 100vh; /* 260px es el ancho del sidebar */
  background-position: 260px center; /* desplazamos el inicio del fondo */
  background-color: #f8f9fa;
}

body.dark-mode {
  background: url('assets/images/dark.png') no-repeat left top fixed;
  background-size: calc(100vw - 260px) 100vh;
  background-position: 260px center;
  background-color: #1a1a1a;
}

    .sidebar {
      height: 100vh;
      width: 260px;
      background-color: #212529;
      padding: 20px;
      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
      overflow-y: auto;
    }
    .sidebar h4 {
      color: white;
      text-align: center;
      margin-bottom: 20px;
    }
    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      padding: 10px;
      border-radius: 5px;
      transition: background 0.3s;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .content {
      margin-left: 270px;
      padding: 20px;
      width: calc(100% - 270px);
    }
    .welcome-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    #search-bar {
    width: 50%;
    max-width: 600px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: box-shadow 0.3s ease;
    display: block;
    margin: 0 auto;
}

/* Resultados de búsqueda */
#search-results {
    position: absolute;
    background: white;
    width: 50%;
    max-width: 600px;
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #ccc;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    left: 50%;
    transform: translateX(-50%);
    display: none;
    border-radius: 5px;
}

/* Elementos de la búsqueda */
.search-item {
    display: block;
    padding: 12px;
    text-decoration: none;
    color: black;
    font-size: 14px;
    transition: background 0.3s ease;
    border-bottom: 1px solid #eee;
}

.search-item:hover {
    background-color: #f8f9fa;
}

/* Modo oscuro */
.dark-mode #search-results {
    background: #2b2b2b;
    color: white;
    border-color: #444;
}

.dark-mode .search-item {
    color: white;
}

.dark-mode .search-item:hover {
    background-color: #444;
}
pre {
    background: #2d2d2d;
    color: #ffffff;
    padding: 15px;
    border-radius: 5px;
    font-size: 14px;
    overflow-x: auto;
}


  </style>
</head>
<body>
  <!-- Menú lateral -->
  <div class="sidebar">
  <h4>👻 Lenguajes 👻</h4>
  <a href="admin/login.php" class="btn btn-dark w-100 mb-2">🗝 Administración 🗝</a>
    <?php foreach ($languages as $lang): ?>
      <a href="language.php?id=<?php echo $lang['id']; ?>" class="btn btn-dark w-100 mb-2">
        <?php echo htmlspecialchars($lang['name']); ?>
      </a>
    <?php endforeach; ?>
  </div>
  <div class="container text-center mt-3">
    <input type="text" id="search-bar" class="form-control mx-auto" placeholder="🔍 Buscar en la Wiki...">
    <div id="search-results" class="search-dropdown"></div>
  </div>
  </div>

     
    <!--
  <div class="container mt-5">
    <h2>🛠️ Generador de Snippets con IA</h2>
    <p>Escribe una descripción y genera automáticamente un código.</p>

    <form id="snippet-form">
        <input type="text" id="prompt" class="form-control mb-3" placeholder="Ejemplo: Función en Python para ordenar una lista">
        <button type="submit" class="btn btn-primary">✨ Generar Código</button>
    </form>

    <div id="generated-snippet" class="mt-3"></div>
    -->
</div>



<script src="assets/js/bootstrap.bundle.min.js"></script>
<script>
/*
document.getElementById("snippet-form").addEventListener("submit", function (e) {
    e.preventDefault();

    const prompt = document.getElementById("prompt").value.trim();
    const resultDiv = document.getElementById("generated-snippet");

    if (!prompt) {
        resultDiv.innerHTML = "<p class='text-danger'>❌ Escribe una descripción antes de generar.</p>";
        return;
    }

    resultDiv.innerHTML = "<p class='text-info'>⏳ Generando código...</p>";

    fetch("generate_snippet.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "prompt=" + encodeURIComponent(prompt)
    })
    .then(response => response.json())
    .then(data => {
        if (data.code) {
            resultDiv.innerHTML = `<pre><code>${data.code}</code></pre>`;
        } else {
            resultDiv.innerHTML = `<p class='text-danger'>❌ ${data.error}</p>`;
        }
    })
    .catch(error => {
        console.error("Error:", error);
        resultDiv.innerHTML = "<p class='text-danger'>❌ Error en la generación.</p>";
    });
});

*/


document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-bar");
    const searchResults = document.getElementById("search-results");

    searchInput.addEventListener("input", function () {
        let query = this.value.trim();
        if (query.length < 2) {
            searchResults.style.display = "none";
            return;
        }

        fetch(`ajax_search.php?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                searchResults.innerHTML = "";
                if (data.length > 0) {
                    data.forEach(item => {
                        let resultItem = document.createElement("a");
                        resultItem.href = item.url;
                        resultItem.className = "search-item";
                        resultItem.innerHTML = `<strong>${item.name}</strong>`;
                        searchResults.appendChild(resultItem);
                    });
                    searchResults.style.display = "block";
                } else {
                    searchResults.innerHTML = "<p class='text-center text-muted'>No hay resultados.</p>";
                    searchResults.style.display = "block";
                }
            })
            .catch(error => console.error("Error en la búsqueda:", error));
    });

    // Ocultar resultados al hacer clic fuera
    document.addEventListener("click", function (event) {
        if (!searchResults.contains(event.target) && event.target !== searchInput) {
            searchResults.style.display = "none";
        }
    });
});


</script>


</body>
</html>
