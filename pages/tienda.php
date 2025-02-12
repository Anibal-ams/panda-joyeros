<?php
require_once '../includes/db_connection.php';
require_once '../includes/helpers.php';

// Fetch all products with their main image
$products_query = "SELECT p.*, pi.imagen_url 
                  FROM Productos p
                  LEFT JOIN ProductoImagenes pi ON p.id_producto = pi.id_producto AND pi.orden = 1";
$products_result = $conn->query($products_query);

// Fetch categories
$categories_query = "SELECT * FROM Categorias";
$categories_result = $conn->query($categories_query);

// Fetch materials
$materials_query = "SELECT * FROM Materiales";
$materials_result = $conn->query($materials_query);

// Close the connection
$conn->close();

// Function to get the correct image path
function get_image_path($image_url) {
   if (empty($image_url)) {
       return '../img/placeholder.jpg';
   }
   // Check if the image_url starts with 'http' or 'https'
   if (strpos($image_url, 'http') === 0) {
       return $image_url;
   }
   // If it's a relative path, prepend the correct directory
   return '../' . ltrim($image_url, '/');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tienda - Panda Joyeros</title>
   
   <link rel="icon" href="https://scontent.fclo8-1.fna.fbcdn.net/v/t1.6435-9/51272927_388836028592340_5069720473542066176_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFH0pLOXQi70Ej6pbSwQ1IDXZpjvWkc0kFdmmO9aRzSQdjb1mnpqEOlpICRpre2SnSIQ3gVdSR8Wf03e0w5ZX3D&_nc_ohc=n1SMTuspGckQ7kNvgEos2J1&_nc_oc=AdhDqxi_xaSd-SE5DqLpRXC4Pz7QldgW_C7Lk8RRjRdfmvL2yASC5cqDy09RdiTkM_k&_nc_zt=23&_nc_ht=scontent.fclo8-1.fna&_nc_gid=AkthrGTijLTJBM8dShHudrp&oh=00_AYCdHBv4OfonBGvWPSEjac7jNziKnuFN_En4S62BtGWcWw&oe=67CCF0A5" type="image/png">
   <link rel="stylesheet" href="../css/styles.css">
</head>
<style>
    .view-details {
        display: inline-block;
        background-color: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .view-details:hover {
        background-color: var(--accent-color);
    }
</style>
<body>
   <header>
       <div class="container">
           <a href="../index.php" class="logo">
               
           <img src="https://scontent.fclo8-1.fna.fbcdn.net/v/t1.6435-9/51272927_388836028592340_5069720473542066176_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFH0pLOXQi70Ej6pbSwQ1IDXZpjvWkc0kFdmmO9aRzSQdjb1mnpqEOlpICRpre2SnSIQ3gVdSR8Wf03e0w5ZX3D&_nc_ohc=n1SMTuspGckQ7kNvgHIjfiw&_nc_oc=AdhLq4haH9Wx8HyNq-nRopYW_l-bien1G1kqam_RWJ8OSDFYSE2TYOpbXsW7MhUhBNQ&_nc_zt=23&_nc_ht=scontent.fclo8-1.fna&_nc_gid=A9MC3JRY02YXJaPT21BEtV3&oh=00_AYA6OArn_m1UADcNhw-rBQsBtMGYpjDyoc_lImmcbRrRDQ&oe=67CF2325" alt="" width="80px">
           </a>
           <nav>
               <ul>
                   <li><a href="../index.php">Inicio</a></li>
                   <li><a href="tienda.php" class="active">Tienda</a></li>
                   <li><a href="quienes-somos.html">Sobre Nosotros</a></li>
                   <li><a href="contacto.html">Contacto</a></li>
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

   <main class="shop-page">
       <section class="shop-hero">
           <div class="container">
               <h1>Nuestra Colección</h1>
               <p>Descubre la elegancia atemporal en cada pieza</p>
           </div>
       </section>

       <section class="shop-content">
           <div class="container">
               <div class="shop-grid">
                   <aside class="shop-sidebar">
                       <div class="filter-section">
                           <h2>Filtrar por</h2>
                           <div class="filter-group">
                               <h3>Categoría</h3>
                               <ul>
                                   <?php while ($category = $categories_result->fetch_assoc()): ?>
                                       <li>
                                           <label>
                                               <input type="checkbox" name="category" value="<?php echo $category['id_categoria']; ?>">
                                               <?php echo safe_output($category['nombre']); ?>
                                           </label>
                                       </li>
                                   <?php endwhile; ?>
                               </ul>
                           </div>
                           <div class="filter-group">
                               <h3>Material</h3>
                               <ul>
                                   <?php while ($material = $materials_result->fetch_assoc()): ?>
                                       <li>
                                           <label>
                                               <input type="checkbox" name="material" value="<?php echo $material['id_material']; ?>">
                                               <?php echo safe_output($material['nombre']); ?>
                                           </label>
                                       </li>
                                   <?php endwhile; ?>
                               </ul>
                           </div>
                           <div class="filter-group">
                               <h3>Precio</h3>
                               <div class="price-range">
                                   <input type="range" id="price-range" min="0" max="5000" step="100" value="2500">
                                   <output for="price-range">€2500</output>
                               </div>
                           </div>
                       </div>
                   </aside>
                   <div class="product-grid">
                       <?php
                       if ($products_result && $products_result->num_rows > 0) {
                           while($product = $products_result->fetch_assoc()) {
                               $image_path = get_image_path($product['imagen_url']);
                       ?>
                       <div class="product-card">
                           <img src="<?php echo safe_output($image_path); ?>" alt="<?php echo safe_output($product['nombre'], 'Producto'); ?>">
                           <h3><?php echo safe_output($product['nombre'], 'Producto sin nombre'); ?></h3>
                           <p class="price"><?php echo safe_price($product['precio']); ?></p>
                           <a href="descripcion.php?id=<?php echo $product['id_producto']; ?>" class="view-details">Ver detalles</a>
                       </div>
                       <?php
                           }
                       } else {
                           echo "<p>No hay productos disponibles.</p>";
                       }
                       ?>
                   </div>
               </div>
               <div class="pagination">
                   <button class="prev" disabled>Anterior</button>
                   <span class="current-page">Página 1 de 3</span>
                   <button class="next">Siguiente</button>
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
                       <li><a href="quienes-somos.php">Historia</a></li>
                       <li><a href="quienes-somos.php#our-team">Artesanos</a></li>
                       <li><a href="quienes-somos.php#our-values">Sostenibilidad</a></li>
                   </ul>
               </div>
               <div class="footer-section">
                   <h3>Atención al Cliente</h3>
                   <ul>
                       <li><a href="contacto.php">Contacto</a></li>
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
                   <h3>Busqueda de</h3>
                   <p>Suscríbete para recibir las últimas novedades y ofertas exclusivas.</p>
                   <form class="newsletter-form">
                       <input type="email" placeholder="Tu email" required>
                       <button type="submit">Suscribir</button>
                   </form>
               </div>
           </div>
           <div class="footer-bottom">
               <p>&copy; 2024 Luxury Jewels. Todos los derechos reservados.</p>
           </div>
       </div>
   </footer>

   <script src="../js/main.js"></script>
   <script src="../js/shop.js"></script>
</body>
</html>
