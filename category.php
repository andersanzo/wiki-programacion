<?php
require_once 'config.php';
include 'includes/header.php';

if (!isset($_GET['lang']) || !isset($_GET['cat'])) {
    header("Location: index.php");
    exit;
}

$language_id = intval($_GET['lang']);
$category_id = intval($_GET['cat']);

// Obtener información del lenguaje y la categoría
$stmt = $mysqli->prepare("SELECT l.name AS language_name, c.name AS category_name 
                          FROM languages l 
                          JOIN categories c ON l.id = c.language_id 
                          WHERE l.id = ? AND c.id = ?");
$stmt->bind_param("ii", $language_id, $category_id);
$stmt->execute();
$result = $stmt->get_result();
$info = $result->fetch_assoc();

if (!$info) {
    echo "Información no encontrada.";
    exit;
}

// Obtener los snippets de esta categoría
$stmt2 = $mysqli->prepare("SELECT * FROM snippets WHERE language_id = ? AND category_id = ?");
$stmt2->bind_param("ii", $language_id, $category_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$snippets = $result2->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>


  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($info['category_name']); ?> - <?php echo htmlspecialchars($info['language_name']); ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.0/styles/github-dark.min.css">
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
    .container {
      max-width: 900px;
      margin-top: 30px;
    }
    .snippet-card {
      background: #1e1e1e;
      color: #ffffff;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.2s ease-in-out;
    }
    .snippet-card:hover {
      transform: scale(1.006);
    }
    .snippet-title {
      font-size: 1.5rem;
      font-weight: bold;
    }
    .snippet-description {
      font-size: 1rem;
      color: #d4d4d4;
      margin-bottom: 10px;
    }
    .snippet-meta {
      font-size: 0.9rem;
      color: #aaaaaa;
    }
    pre {
      background: #1e1e1e !important;
      padding: 15px;
      border-radius: 8px;
      font-size: 14px;
      overflow-x: auto;
      position: relative;
    }
    .copy-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background: #007bff;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
    }
    .copy-btn:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
<?php include 'includes/sidebar.php'; ?>

  <div class="container">
    <div class="text-center mb-4">
      <h1 class="text-primary"><?php echo htmlspecialchars($info['language_name']); ?></h1>
      <h3 class="text-secondary"><?php echo htmlspecialchars($info['category_name']); ?></h3>
    </div>

    <!-- Campo de búsqueda -->
    <div class="mb-3">
      <input type="text" id="search" class="form-control" placeholder="Buscar snippet...">
    </div>

    <div id="snippetsContainer">
      <?php if (count($snippets) > 0): ?>
        <?php foreach ($snippets as $snippet): ?>
          <div class="snippet-card">
            <h5 class="snippet-title"><?php echo htmlspecialchars($snippet['title']); ?></h5>
            <p class="snippet-description"><?php echo htmlspecialchars($snippet['description']); ?></p>
            <p class="snippet-meta">
                📅 Creado: <?php echo date('d/m/Y', strtotime($snippet['created_at'])); ?> |
                ✏️ Última Modificación: 
                <?php echo isset($snippet['updated_at']) ? date('d/m/Y', strtotime($snippet['updated_at'])) : 'No actualizado'; ?>
            </p>

            <pre>
              <button class="copy-btn" onclick="copyCode(this)">📋 Copiar</button>
              <code class="hljs"><?php echo htmlspecialchars($snippet['code']); ?></code>
            </pre>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="alert alert-warning text-center">No hay snippets en esta categoría.</div>
      <?php endif; ?>
    </div>

    <div class="text-center mt-3">
      <a href="language.php?id=<?php echo $language_id; ?>" class="btn btn-outline-secondary">Volver</a>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.0/highlight.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll("pre code").forEach((block) => {
            hljs.highlightElement(block);
        });
    });

    function copyCode(button) {
        let codeBlock = button.nextElementSibling;
        navigator.clipboard.writeText(codeBlock.innerText).then(() => {
            button.innerText = "✅ Copiado";
            setTimeout(() => { button.innerText = "📋 Copiar"; }, 2000);
        }).catch(err => console.error("Error al copiar: ", err));
    }

    // Función de búsqueda en tiempo real
    document.getElementById("search").addEventListener("input", function() {
        let query = this.value.toLowerCase();
        document.querySelectorAll(".snippet-card").forEach(card => {
            let title = card.querySelector(".snippet-title").textContent.toLowerCase();
            let description = card.querySelector(".snippet-description").textContent.toLowerCase();
            if (title.includes(query) || description.includes(query)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
  </script>


</body>
</html>
