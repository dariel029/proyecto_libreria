<?php
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';
?>

<div class="container">
    
    <div class="hero-section">
        <h1> Bienvenido a Nuestra Librería Online</h1>
        <p>Explora nuestro amplio catálogo de libros de todos los géneros</p>
    </div>

    
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Descripción General</h2>
                    <p class="lead text-center">
                        Somos una librería digital con una amplia selección de títulos de calidad. 
                        Contamos con autores nacionales e internacionales en diversos géneros.
                    </p>
                    
                    <div class="row text-center mt-5">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h3 class="text-primary">📖</h3>
                                <h4>Libros Disponibles</h4>
                                <p>Catálogo completo actualizado</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h3 class="text-primary">✍️</h3>
                                <h4>Autores</h4>
                                <p>Descubre nuestros autores</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h3 class="text-primary">📞</h3>
                                <h4>Contacto</h4>
                                <p>Envíanos tus consultas</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-5">
                        <a href="libros.php" class="btn btn-primary btn-lg me-md-2">Ver Libros</a>
                        <a href="contacto.php" class="btn btn-outline-primary btn-lg">Contactar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
