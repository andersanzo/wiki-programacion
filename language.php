<?php
require_once 'config.php';
include 'includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$language_id = intval($_GET['id']);

$stmt = $mysqli->prepare("SELECT * FROM languages WHERE id = ?");
$stmt->bind_param("i", $language_id);
$stmt->execute();
$result = $stmt->get_result();
$language = $result->fetch_assoc();

if (!$language) {
    echo "Lenguaje no encontrado.";
    exit;
}

$stmt2 = $mysqli->prepare("SELECT * FROM categories WHERE language_id = ?");
$stmt2->bind_param("i", $language_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$categories = $result2->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>


  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($language['name']); ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
.card {
    --bs-card-spacer-y: 1rem;
    --bs-card-spacer-x: 1rem;
    --bs-card-title-spacer-y: 0.5rem;
    --bs-card-title-color: ;
    --bs-card-subtitle-color: ;
    --bs-card-border-width: var(--bs-border-width);
    --bs-card-border-color: var(--bs-border-color-translucent);
    --bs-card-border-radius: var(--bs-border-radius);
    --bs-card-box-shadow: ;
    --bs-card-inner-border-radius: calc(var(--bs-border-radius) -(var(--bs-border-width)));
    --bs-card-cap-padding-y: 0.5rem;
    --bs-card-cap-padding-x: 1rem;
    --bs-card-cap-bg: rgba(var(--bs-body-color-rgb), 0.03);
    --bs-card-cap-color: ;
    --bs-card-height: ;
    --bs-card-color: ;
    --bs-card-bg: #c7c7c7b5;
    --bs-card-img-overlay-padding: 1rem;
    --bs-card-group-margin: 0.75rem;
    position: relative;
    display: flex
;
    flex-direction: column;
    min-width: 0;
    height: var(--bs-card-height);
    color: var(--bs-body-color);
    word-wrap: break-word;
    background-color: var(--bs-card-bg);
    background-clip: border-box;
    border: var(--bs-card-border-width) solid var(--bs-card-border-color);
    border-radius: var(--bs-card-border-radius);
}
  </style>
</head>
<body>
<?php include 'includes/sidebar.php'; ?>
  <div class="container mt-4">
    <h1 class="text-center text-primary"><?php echo htmlspecialchars($language['name']); ?></h1>
    <p class="text-center"><?php echo htmlspecialchars($language['description']); ?></p>
    
    <div class="row">
      <?php foreach ($categories as $cat): ?>
        <div class="col-md-4">
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($cat['name']); ?></h5>
              <p class="card-text"><?php echo htmlspecialchars($cat['description']); ?></p>
              <a href="category.php?lang=<?php echo $language_id; ?>&cat=<?php echo $cat['id']; ?>" class="btn btn-primary">Ver Snippets</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    
    <a href="index.php" class="btn btn-secondary">Volver a Inicio</a>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
