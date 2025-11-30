<?php
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';


$mensaje = '';
$tipo_mensaje = '';





if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $comentario_texto = trim($_POST['comentario'] ?? '');

    if (empty($nombre) || empty($correo) || empty($comentario_texto)) {
        $mensaje = 'Por favor, completa todos los campos.';
        $tipo_mensaje = 'warning';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = 'Por favor, ingresa un correo válido.';
        $tipo_mensaje = 'warning';
    } else {
        try {
            $insert = $pdo->prepare("INSERT INTO contacto (nombre, correo, comentario) VALUES (:nombre, :correo, :comentario)");
            $insert->execute([
                ':nombre' => $nombre,
                ':correo' => $correo,
                ':comentario' => $comentario_texto
            ]);

            $mensaje = '✅ Tu mensaje ha sido enviado correctamente. ¡Gracias!';
            $tipo_mensaje = 'success';

            $_POST = [];
        } catch (PDOException $e) {
            $mensaje = 'Error al guardar el mensaje: ' . $e->getMessage();
            $tipo_mensaje = 'danger';
        }
    }
}


try {
    $query = $pdo->prepare("
           SELECT id, nombre, correo, comentario, fecha 
        FROM contacto 
        ORDER BY fecha DESC 
        LIMIT 10
    ");
    $query->execute();
    $comentarios = $query->fetchAll();
} catch (PDOException $e) {
    echo "Error al obtener comentarios: " . $e->getMessage();
    $comentarios = [];
}
?>

<div class="container">
    <div class="hero-section">
        <h1>📞 Contacto</h1>
        <p>¿Tienes alguna consulta? Cuéntanos</p>
    </div>


    <div class="contact-form">
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h3 class="mb-4">Enviar Consulta</h3>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" 
                       placeholder="Tu nombre completo" required 
                       value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" 
                       placeholder="tu.email@ejemplo.com" required
                       value="<?php echo htmlspecialchars($_POST['correo'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="comentario" class="form-label">Mensaje</label>
                <textarea class="form-control" id="comentario" name="comentario" 
                          rows="5" placeholder="Cuéntanos tu consulta..." required><?php echo htmlspecialchars($_POST['comentario'] ?? ''); ?></textarea>
            </div>

            <button type="submit" class="btn btn-submit w-100">Enviar Mensaje</button>
        </form>
    </div>

    
    <?php if (!empty($comentarios)): ?>
        <div class="comentarios-container">
            <h3 class="mb-4">Comentarios Recientes</h3>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <?php foreach ($comentarios as $comentario): ?>
                        <div class="comentario-item">
                            <div class="comentario-autor">
                                <?php echo htmlspecialchars($comentario['nombre']); ?>
                            </div>
                            <div class="comentario-email">
                                📧 <?php echo htmlspecialchars($comentario['correo']); ?>
                            </div>
                            <div class="comentario-fecha">
                                🕐 <?php echo date('d/m/Y H:i', strtotime($comentario['fecha'])); ?>
                            </div>
                            <div class="comentario-texto">
                                <?php echo htmlspecialchars($comentario['comentario']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center mt-5" role="alert">
            <p>Sé el primero en dejar un comentario.</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
