<?php

require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';
?>

<div class="container">

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-4">Pruebas del Sistema</h2>

                    <?php
                    $checks = [];
                    $all_passed = true;

                    $checks[] = [
                        'name' => 'PHP Version',
                        'value' => phpversion(),
                        'status' => version_compare(phpversion(), '7.4', '>=') ? 'success' : 'error'
                    ];

                    $checks[] = [
                        'name' => 'PDO Extension',
                        'value' => extension_loaded('pdo') ? 'Instalada ✅' : 'No encontrada ❌',
                        'status' => extension_loaded('pdo') ? 'success' : 'error'
                    ];

                    $checks[] = [
                        'name' => 'PDO MySQL',
                        'value' => extension_loaded('pdo_mysql') ? 'Instalada ✅' : 'No encontrada ❌',
                        'status' => extension_loaded('pdo_mysql') ? 'success' : 'error'
                    ];

                    $folders = ['includes', 'css', 'js'];
                    foreach ($folders as $folder) {
                        $path = __DIR__ . '/' . $folder;
                        $exists = is_dir($path);
                        $checks[] = [
                            'name' => "Carpeta /$folder/",
                            'value' => $exists ? 'Existe ✅' : 'No existe ❌',
                            'status' => $exists ? 'success' : 'error'
                        ];
                        if (!$exists) $all_passed = false;
                    }

                    $files = ['index.php', 'libros.php', 'autores.php', 'contacto.php', 'debug.php'];
                    foreach ($files as $file) {
                        $path = __DIR__ . '/' . $file;
                        $exists = file_exists($path);
                        $checks[] = [
                            'name' => "Archivo $file",
                            'value' => $exists ? 'Existe ✅' : 'No existe ❌',
                            'status' => $exists ? 'success' : 'error'
                        ];
                        if (!$exists) $all_passed = false;
                    }

                    $includes_files = ['db.php', 'header.php', 'footer.php'];
                    foreach ($includes_files as $file) {
                        $path = __DIR__ . '/includes/' . $file;
                        $exists = file_exists($path);
                        $checks[] = [
                            'name' => "Include $file",
                            'value' => $exists ? 'Existe ✅' : 'No existe ❌',
                            'status' => $exists ? 'success' : 'error'
                        ];
                        if (!$exists) $all_passed = false;
                    }

                    $css_path = __DIR__ . '/css/style.css';
                    $css_exists = file_exists($css_path);
                    $checks[] = [
                        'name' => 'Archivo style.css',
                        'value' => $css_exists ? 'Existe ✅' : 'No existe ❌',
                        'status' => $css_exists ? 'success' : 'error'
                    ];
                    if (!$css_exists) $all_passed = false;

                    $js_path = __DIR__ . '/js/main.js';
                    $js_exists = file_exists($js_path);
                    $checks[] = [
                        'name' => 'Archivo main.js',
                        'value' => $js_exists ? 'Existe ✅' : 'No existe ❌',
                        'status' => $js_exists ? 'success' : 'error'
                    ];
                    if (!$js_exists) $all_passed = false;

                    $db_status = 'error';
                    $db_message = 'No conectado';
                    try {
                        $dsn = "mysql:host=localhost;dbname=dblibreria;charset=utf8mb4";
                        $pdo = new PDO($dsn, 'root', '', [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_TIMEOUT => 3
                        ]);
                        $db_status = 'success';
                        $db_message = 'Conectado a dblibreria ✅';
                    } catch (PDOException $e) {
                        $db_message = 'Error: ' . $e->getMessage();
                    }

                    $checks[] = [
                        'name' => 'Conexión MySQL',
                        'value' => $db_message,
                        'status' => $db_status
                    ];

                    if ($db_status !== 'success') $all_passed = false;

                    if ($db_status === 'success') {
                        try {
                            $tables = $pdo->query("SHOW TABLES")->fetchAll();
                            $table_names = array_map(function($t) { return $t[0]; }, $tables);
                            
                            foreach (['títulos', 'autores'] as $required_table) {
                                $exists = in_array($required_table, $table_names);
                                $checks[] = [
                                    'name' => "Tabla $required_table",
                                    'value' => $exists ? 'Existe ✅' : 'No existe ❌',
                                    'status' => $exists ? 'success' : 'warning'
                                ];
                            }

                           
                            try {
                                $count_titulos = $pdo->query("SELECT COUNT(*) FROM títulos")->fetchColumn();
                                $checks[] = [
                                    'name' => 'Libros en BD',
                                    'value' => $count_titulos . ' registros',
                                    'status' => $count_titulos > 0 ? 'success' : 'warning'
                                ];
                            } catch (Exception $e) {
                            }

                            try {
                                $count_autores = $pdo->query("SELECT COUNT(*) FROM autores")->fetchColumn();
                                $checks[] = [
                                    'name' => 'Autores en BD',
                                    'value' => $count_autores . ' registros',
                                    'status' => $count_autores > 0 ? 'success' : 'warning'
                                ];
                            } catch (Exception $e) {
                            }

                        } catch (Exception $e) {
                        }
                    }

                    foreach ($checks as $check) {
                        $class = 'check-' . $check['status'];
                        echo '<div class="check-item ' . $class . '">';
                        echo '<strong>' . $check['name'] . ':</strong> ' . $check['value'];
                        echo '</div>';
                    }
                    ?>

                    <hr class="my-4">

                    <div class="alert <?php echo $all_passed && $db_status === 'success' ? 'alert-success' : 'alert-warning'; ?>">
                        <h4 class="alert-heading">
                            <?php echo $all_passed && $db_status === 'success' ? '✅ ¡TODO CORRECTO!' : '⚠️ Requiere Atención'; ?>
                        </h4>
                        <p>
                            <?php 
                            if ($all_passed && $db_status === 'success') {
                                echo 'El proyecto está completamente instalado y funcional. Puedes acceder a las siguientes páginas:';
                                echo '<ul style="margin-top: 1rem;">';
                                echo '<li><a href="index.php">📄 Página de Inicio</a></li>';
                                echo '<li><a href="libros.php">📚 Libros Disponibles</a></li>';
                                echo '<li><a href="autores.php">✍️ Autores</a></li>';
                                echo '<li><a href="contacto.php">📞 Contacto</a></li>';
                                echo '</ul>';
                            } else {
                                echo 'Verifica los ítems marcados en rojo o amarillo.';
                                echo '<br><strong>Problemas comunes:</strong>';
                                echo '<ul style="margin-top: 1rem;">';
                                echo '<li>MySQL no está ejecutándose (inicia en XAMPP Control Panel)</li>';
                                echo '<li>Base de datos dblibreria no existe (créala en phpMyAdmin)</li>';
                                echo '<li>Las tablas títulos y autores no existen (importa tu BD)</li>';
                                echo '</ul>';
                            }
                            ?>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
