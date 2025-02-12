<?php
require_once 'includes/db_connection.php';
require_once 'includes/helpers.php';

// Fetch featured products with their images
$featured_query = "SELECT p.*, GROUP_CONCAT(pi.imagen_url ORDER BY pi.orden ASC SEPARATOR '|') AS imagenes
                 FROM Productos p
                 LEFT JOIN ProductoImagenes pi ON p.id_producto = pi.id_producto
                 WHERE p.destacado = 1
                 GROUP BY p.id_producto
                 LIMIT 3";
$featured_result = $conn->query($featured_query);

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panda Joyeros - Joyería Elegante</title>
    <link rel="icon" href="https://scontent.fclo8-1.fna.fbcdn.net/v/t1.6435-9/51272927_388836028592340_5069720473542066176_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFH0pLOXQi70Ej6pbSwQ1IDXZpjvWkc0kFdmmO9aRzSQdjb1mnpqEOlpICRpre2SnSIQ3gVdSR8Wf03e0w5ZX3D&_nc_ohc=n1SMTuspGckQ7kNvgEos2J1&_nc_oc=AdhDqxi_xaSd-SE5DqLpRXC4Pz7QldgW_C7Lk8RRjRdfmvL2yASC5cqDy09RdiTkM_k&_nc_zt=23&_nc_ht=scontent.fclo8-1.fna&_nc_gid=AkthrGTijLTJBM8dShHudrp&oh=00_AYCdHBv4OfonBGvWPSEjac7jNziKnuFN_En4S62BtGWcWw&oe=67CCF0A5" type="image/png">
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/main.js" defer></script>
</head>
<body>
    <header>
        <div class="container">
            <a href="index.php" class="logo">
            <img src="https://scontent.fclo8-1.fna.fbcdn.net/v/t1.6435-9/51272927_388836028592340_5069720473542066176_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFH0pLOXQi70Ej6pbSwQ1IDXZpjvWkc0kFdmmO9aRzSQdjb1mnpqEOlpICRpre2SnSIQ3gVdSR8Wf03e0w5ZX3D&_nc_ohc=n1SMTuspGckQ7kNvgHIjfiw&_nc_oc=AdhLq4haH9Wx8HyNq-nRopYW_l-bien1G1kqam_RWJ8OSDFYSE2TYOpbXsW7MhUhBNQ&_nc_zt=23&_nc_ht=scontent.fclo8-1.fna&_nc_gid=A9MC3JRY02YXJaPT21BEtV3&oh=00_AYA6OArn_m1UADcNhw-rBQsBtMGYpjDyoc_lImmcbRrRDQ&oe=67CF2325" alt="" width="80px">
          
        </a>
            <nav>
                <ul>
                    <li><a href="index.php" class="active">Inicio</a></li>
                    <li><a href="pages/tienda.php">Tienda</a></li>
                    <li><a href="pages/quienes-somos.html">Quienes somos</a></li>
                    <li><a href="pages/contacto.html">Contacto</a></li>
                    <li><a href="admin/login.php">Admintracion</a></li>
                </ul>
            </nav>
            <div class="user-actions">
                <button aria-label="Favoritos">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </button>
                <button aria-label="Carrito">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <h1>Elengacia y calidad </h1>
                <p>Descubre nuestra exclusiva colección de joyas que combina artesanía tradicional con diseños contemporáneos</p>
                <a href="pages/tienda.php" class="cta-button">Explorar Tienda</a>
            </div>
        </section>

        <section class="featured-products">
            <div class="container">
                <h2>Productos Destacados</h2>
                <div class="product-grid">
                    <?php
                    if ($featured_result && $featured_result->num_rows > 0) {
                        while($row = $featured_result->fetch_assoc()) {
                            $imagenes = !empty($row['imagenes']) ? explode('|', $row['imagenes']) : [];
                    ?>
                    <article class="product-card">
                        <div class="product-images">
                            <?php if (!empty($imagenes)): ?>
                                <?php foreach ($imagenes as $index => $imagen): ?>
                                    <img src="<?php echo safe_output($imagen, 'https://via.placeholder.com/300x200.png?text=No+Image'); ?>" 
                                         alt="<?php echo safe_output($row['nombre'], 'Producto sin nombre'); ?>"
                                         class="<?php echo $index === 0 ? 'active' : ''; ?>">
                                <?php endforeach; ?>
                            <?php else: ?>
                                <img src="https://via.placeholder.com/300x200.png?text=No+Image" alt="Imagen no disponible" class="active">
                            <?php endif; ?>
                        </div>
                        <h3><?php echo safe_output($row['nombre'], 'Producto sin nombre'); ?></h3>
                        <p class="product-description"><?php echo safe_output($row['descripcion'], 'Sin descripción'); ?></p>
                        <div class="product-footer">
                            <span class="price"><?php echo safe_price($row['precio']); ?></span>
                            <a href="pages/descripcion.php?id=<?php echo $row['id_producto']; ?>" class="buy-button">Ver Detalles</a>
                        </div>
                    </article>
                    <?php
                        }
                    } else {
                        echo "<p>No hay productos destacados disponibles.</p>";
                    }
                    ?>
                </div>
            </div>
        </section>

        <section class="about-us">
            <div class="container">
                <div class="about-content">
                    <h2>Especialista en elaboracion y Diseño de joyas</h2>
                    <p>Con más de 10 años de experiencia en la creación de joyas excepcionales, combinamos técnicas tradicionales con innovación moderna para crear piezas únicas que perduran en el tiempo.</p>
                    <p>Cada joya es cuidadosamente elaborada por nuestros maestros artesanos, utilizando solo los materiales más finos y piedras preciosas de la más alta calidad.</p>
                    <a href="pages/quienes-somos.html" class="cta-button secondary">Conoce Nuestra Historia</a>
                </div>
                <div class="about-image">
                    <img src="https://scontent.fclo8-1.fna.fbcdn.net/v/t1.6435-9/119986139_812238352918770_6603148847958086400_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=833d8c&_nc_eui2=AeFdzkaetTslofQc6dGuCBUEN6Kp5Kb3qNc3oqnkpveo1w0q2hXnWltFC_LKrI1vjulH_yNy3waZe3DeqkiWuJgH&_nc_ohc=ADkwOPyjelsQ7kNvgFG2eWv&_nc_zt=23&_nc_ht=scontent.fclo8-1.fna&_nc_gid=AXbV4dtKAwTOZIyRH7xYsdj&oh=00_AYBVnggk7XTOgcdV4qHDgh0yS534-foLMlMBK4fsm6CuEg&oe=67CA0363" alt="Artesano trabajando en una joya">
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Sobre Nosotros</h3>
                    <ul>
                        <li><a href="pages/quienes-somos.php">Historia</a></li>
                        <li><a href="pages/quienes-somos.php#our-team">Artesanos</a></li>
                        <li><a href="pages/quienes-somos.php#our-values">Sostenibilidad</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Atención al Cliente</h3>
                    <ul>
                        <li><a href="pages/contacto.php">Contacto</a></li>
                        <li><a href="#">Envíos</a></li>
                        <li><a href="#">Devoluciones</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Legal</h3>
                    <ul>
                        <li><a href="#">Privacidad</a></li>
                        <li><a href="#">Términos</a></li>
                        <li><a href="#">Cookies</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Busqueda de informacion</h3>
                    <p>Suscríbete para recibir las últimas novedades y ofertas exclusivas.</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Tu email" required>
                        <button type="submit">Suscribir</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <a href="admin/login.php" class="admin-link">Admin</a>
                <p>&copy; 2025  Panda joyeros. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>

