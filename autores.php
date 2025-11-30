<?php
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';


try {
    $query = $pdo->prepare("SELECT id_autor, nombre, apellido, ciudad FROM autores ORDER BY apellido ASC, nombre ASC");
    $query->execute();
    $autores = $query->fetchAll();
} catch (PDOException $e) {
    echo "Error al obtener autores: " . $e->getMessage();
    $autores = [];
}
?>

<div class="container">
    <div class="hero-section">
        <h1>✍️ Autores</h1>
        <p>Conoce a los autores de nuestra librería</p>
    </div>

    <?php if (!empty($autores)): ?>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <?php foreach ($autores as $autor): ?>
                    <div class="autor-card">
                        <div class="autor-nombre">
                            📖 <?php echo htmlspecialchars($autor['nombre'] . ' ' . $autor['apellido']); ?>
                        </div>
                        <p class="text-muted mb-0">
                            Ciudad: <?php echo htmlspecialchars($autor['ciudad']); ?> | ID: #<?php echo htmlspecialchars($autor['id_autor']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            <h4 class="alert-heading">No hay autores</h4>
            <p>No se encontraron autores en la base de datos.</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
