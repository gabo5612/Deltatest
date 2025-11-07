<?php
/**
 * Template Name: Catálogo Dinámico de Productos
 */

?>

<style>
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1.5rem;
  padding: 2rem 1rem;
}

.product-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  overflow: hidden;
  text-align: center;
  transition: transform 0.3s ease;
}
.product-card:hover { transform: translateY(-5px); }

.product-card img {
  width: 100%;
  height: 200px;
  object-fit: contain;
  background: #f7f7f7;
}

.product-card .info {
  padding: 1rem;
}

.product-card h3 {
  font-size: 1.1rem;
  font-weight: 600;
  color: #111;
  margin: 0.5rem 0;
}

.product-card .price {
  font-size: 1.2rem;
  font-weight: bold;
  color: #111;
}

.product-card .buttons {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 1rem;
}

.product-card .btn {
  padding: 0.5rem 1.2rem;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  font-weight: 600;
  color: #fff;
  transition: all 0.3s ease;
}

.product-card .btn-buy {
  background: linear-gradient(90deg, #243949, #8e2de2);
}
.product-card .btn-buy:hover {
  opacity: 0.9;
}

.product-card .btn-info {
  background: #444;
}
</style>

<div class="container">
  <h2 style="text-align:center; margin-top: 40px;">Catálogo de Productos</h2>

  <div class="product-grid">
    <?php
    // Query WooCommerce products
    $args = array(
      'post_type' => 'product',
      'posts_per_page' => 8,
      'post_status' => 'publish',
    );

    $loop = new WP_Query($args);

    if ($loop->have_posts()) :
      while ($loop->have_posts()) : $loop->the_post();
        global $product;
        $price = $product->get_price_html();
        $img = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'medium');
    ?>
        <div class="product-card">
          <a href="<?php the_permalink(); ?>">
            <img src="<?php echo esc_url($img[0]); ?>" alt="<?php the_title(); ?>">
          </a>
          <div class="info">
            <h3><?php the_title(); ?></h3>
            <p class="price"><?php echo $price; ?></p>
            <div class="buttons">
              <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="btn btn-buy">Comprar</a>
              <a href="<?php the_permalink(); ?>" class="btn btn-info">Más info</a>
            </div>
          </div>
        </div>
    <?php
      endwhile;
    else :
      echo '<p style="text-align:center;">No hay productos disponibles.</p>';
    endif;

    wp_reset_postdata();
    ?>
  </div>
</div>

