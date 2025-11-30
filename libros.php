<?php
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';


try {
    $query = $pdo->prepare("SELECT id_titulo, titulo, precio, tipo FROM titulos ORDER BY titulo ASC");
    $query->execute();
    $libros = $query->fetchAll();
} catch (PDOException $e) {
    echo "Error al obtener libros: " . $e->getMessage();
    $libros = [];
}
?>

<div class="container">
    <div class="hero-section">
        <h1>📚 Libros Disponibles</h1>
        <p>Consulta nuestro catálogo completo</p>
    </div>

    <?php if (!empty($libros)): ?>
        <div class="row">
            <?php foreach ($libros as $libro): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card libro-card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><?php echo htmlspecialchars($libro['titulo']); ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <strong>ID:</strong> <?php echo htmlspecialchars($libro['id_titulo']); ?><br>
                                <strong>Tipo:</strong> <?php echo htmlspecialchars($libro['tipo']); ?><br>
                            </p>
                        </div>
                        <div class="card-footer bg-white">
                            <p class="libro-price mb-0">$<?php echo $libro['precio'] ? number_format($libro['precio'], 2) : 'N/A'; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            <h4 class="alert-heading">No hay libros</h4>
            <p>No se encontraron libros en la base de datos.</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
