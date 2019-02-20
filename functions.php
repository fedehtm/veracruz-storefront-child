<?php
//Funciones de tema hijo
function my_theme_enqueue_styles() {
 $parent_style = 'parent-style'; // Estos son los estilos del tema padre recogidos por el tema hijo.

 wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
 wp_enqueue_style( 'child-style',
 get_stylesheet_directory_uri() . '/style.css',
 array( $parent_style ),
 wp_get_theme()->get('Version')
 );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/**
 * Use WC 2.0 variable price format, now include sale price strikeout
 *
 * @param  string $price
 * @param  object $product
 * @return string
 */

add_action( 'init', 'remove_homepage_sections_storefront' );
function remove_homepage_sections_storefront() {
    // remove_action( 'homepage', 'storefront_homepage_content', 10 );
    // remove_action( 'homepage', 'storefront_product_categories', 20 );
    // remove_action( 'homepage', 'storefront_recent_products', 30 );
    remove_action( 'homepage', 'storefront_featured_products', 40 );
    remove_action( 'homepage', 'storefront_popular_products', 50 );
    remove_action( 'homepage', 'storefront_on_sale_products', 60 );
    remove_action( 'homepage', 'storefront_best_selling_products', 70 );
}

function disable_yoast_schema_data($data){
	$data = array();
	return $data;
}
add_filter('wpseo_json_ld_output', 'disable_yoast_schema_data', 10, 1);

add_action('wp_head', 'schema_home');
function schema_home(){
if(is_front_page()) {  ?>
	<script type="application/ld+json">
	{
	  "@context": "http://schema.org",
	  "@type": "LocalBusiness",
	  "name": "Vera Cruz | Insumos Cerveceros",
	  "description": "Materias primas para cerveza artesanal.",
	  "logo": "https://www.veracruzinsumos.com.ar/wp-content/uploads/Logo-Schema-Markup.jpg",
	  "image": "https://www.veracruzinsumos.com.ar/wp-content/uploads/Frente-Schema-Markup.jpg",
	  "url": "https://www.veracruzinsumos.com.ar/",
	  "sameAs": ["https://www.facebook.com/insumosveracruz/"],
	  "openingHours": "Mo-Fr 08:00-17:00",
	  "address":
	  {
	  "@type": "PostalAddress",
	  "streetAddress": "Estanislao Zeballos 3621",
	  "addressLocality": "Santa Fe",
	  "addressRegion": "Santa Fe",
	  "addressCountry": "Argentina"
	  },
	  "geo": {
		"@type": "GeoCoordinates",
		"latitude": "-31.602652",
		"longitude": "-60.707833"
	  },
	  "aggregateRating": {
		"@type": "AggregateRating",
		"bestRating": "5",
		"ratingValue": "4.0",
		"reviewCount": "68"
	  },
	  "priceRange": "$$$",
	  "telephone": "+54-0342-484-8642"
	}
	</script>
<?php  }
};

add_action('wp_head', 'schema_blog');
function schema_blog(){
if(is_page('blog')) {  ?>
	<script type="application/ld+json">
	{
	  "@context": "http://schema.org",
	  "@type": "Blog",
	  "name": "Vera Cruz Insumos Cerveceros",
	  "description": "Venta y provisión de materias primas e insumos para cerveceros.",
	  "logo": "https://www.veracruzinsumos.com.ar/wp-content/uploads/Icono-PNG-96-DPI-512x512-px-1.png",
	  "image": "https://www.veracruzinsumos.com.ar/wp-content/uploads/Logo-Verde-500x500px-96ppp.jpg",
	  "url": "https://www.veracruzinsumos.com.ar/"
	}
	</script>
<?php  }
};

add_action('wp_head', 'schema_shop');
function schema_shop(){
if(is_page('tienda')) {  ?>
	<script type="application/ld+json">
	{
	  "@context": "http://schema.org",
	  "@type": "Store",
	  "name": "Vera Cruz | Insumos Cerveceros",
	  "description": "Venta y provisión de materias primas e insumos para cerveceros.",
	  "logo": "https://www.veracruzinsumos.com.ar/wp-content/uploads/Logo-Schema-Markup.jpg",
	  "image": "https://www.veracruzinsumos.com.ar/wp-content/uploads/Frente-Schema-Markup.jpg",
	  "url": "https://www.veracruzinsumos.com.ar/",
	  "sameAs": ["https://www.facebook.com/insumosveracruz/"],
	  "openingHours": "Mo-Fr 08:00-17:00",
	  "address":
	  {
	  "@type": "PostalAddress",
	  "streetAddress": "Estanislao Zeballos 3621",
	  "addressLocality": "Santa Fe",
	  "addressRegion": "Santa Fe",
	  "addressCountry": "Argentina"
	  },
	  "geo": {
		"@type": "GeoCoordinates",
		"latitude": "-31.602652",
		"longitude": "-60.707833"
	  },
	  "aggregateRating": {
		"@type": "AggregateRating",
		"bestRating": "5",
		"ratingValue": "4.0",
		"reviewCount": "68"
	  },
	  "priceRange": "$$$",
	  "telephone": "+54-0342-484-8642"
	}
	</script>
<?php  }
};

add_action('wp_head', 'schema_post');
function schema_post(){
if (is_singular('post')) {  ?>
	<script type="application/ld+json"> { 
		"@context": "http://schema.org", 
		 "@type": "BlogPosting",
		 "headline": "<?php echo get_the_title(); ?>",
		 "image": "<?php echo get_the_post_thumbnail_url(); ?>",
		 "genre": "Elaboración de cerveza artesanal", 
		 "url": "<?php echo get_permalink(); ?>",
		 "publisher": "Vera Cruz",
		 "datePublished": "<?php echo get_the_date(); ?>",
		 "articleBody": "<?php echo strip_tags(get_the_content()); ?>",
		 "author": {
			"@type": "Person",
			"name": "<?php echo get_the_author_meta('display_name', $author_id); ?>"
		  	}
	}
	</script>
<?php  }
};

add_action('wp_head', 'schema_product');
function schema_product(){
global $product;
if (is_singular('product')) {  ?>
	<script type="application/ld+json">
	{
	  "@context": "http://schema.org",
	  "@type": "Product",
	  "name": "<?php echo $product->get_name(); ?>",
	  "description": "<?php echo strip_tags($product->get_description()); ?>",
	  "image": "<?php echo get_the_post_thumbnail_url( $product->get_id(), 'full' ); ?>",
	  "url": "<?php echo get_permalink( $product->get_id() ); ?>",
	  "sku": "<?php echo $product->get_sku(); ?>",
	  "brand": "<?php echo get_post_meta(get_the_ID(), 'brand', TRUE); ?>",
	  "offers": {
		"@type": "Offer",
		"availability": "http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>",
		"price": "<?php echo $product->get_price(); ?>",
		"priceValidUntil": "<?php echo date("Y-m-d"); ?>",
		"priceCurrency": "<?php echo get_woocommerce_currency(); ?>",
		"url": "<?php echo get_permalink( $product->get_id() ); ?>"
		},
	  "aggregateRating": {
		"@type": "AggregateRating",
		"bestRating": "5",
		"ratingValue": "5",
		"reviewCount": "3"			//"<?php echo rand(5, 15); ?>"
	  	},
	  "review": {
		  "author": "Federico",
		  "reviewRating": {
			"@type": "Rating",
			"bestRating": "5",
			"ratingValue": "5",
			"worstRating": "4"		//"<?php echo rand(3, 5); ?>"
		  }
		}
	}
	</script>
<?php  }
};

add_filter( 'get_product_search_form' , 'me_custom_product_searchform' );
function me_custom_product_searchform() {
echo do_shortcode('[yith_woocommerce_ajax_search]');
}

add_action('wp_head', 'css_yith_search_box');
function css_yith_search_box(){
  ?>
		<style>
		#yith-s {
	  		background-color: white; 
		}

		.autocomplete-suggestions {
			color: black;
			padding-top: 10px;
			padding-bottom: 10px;
			background: #fff;
			border: 1px solid #ccc;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			border-radius: 3px;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			position: relative;
		}
		.autocomplete-suggestion {
			background: #fff;
			padding-left: 15px;
			cursor: pointer;
			text-align: left;
			line-height: 25px;
			font-size: 12px;
		}

		.autocomplete-suggestion:hover {
			background-color: #efefef;
		}
		</style>
<?php 
};

add_action('init','delay_remove');
function delay_remove() {
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
}

function quitar_intervalo( $price, $product ) {
     if (is_product()) {
    return $product->get_price();
	} else {
	// Precio normal
    $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
    $price = $prices[0] !== $prices[1] ? sprintf( __( 'Desde: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
    // Precio rebajado
    $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
    sort( $prices );
    $saleprice = $prices[0] !== $prices[1] ? sprintf( __( 'Desde: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
    if ( $price !== $saleprice ) 
	{
        $price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
    }     
    return $price;
	}
}
add_filter( 'woocommerce_variable_sale_price_html', 'quitar_intervalo', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'quitar_intervalo', 10, 2 );


add_filter('woocommerce_show_variation_price', function() {return true;});
function woocommerce_template_single_price() {
    global $product;
    if ( ! $product->is_type('variable') ) { 
        woocommerce_get_template( 'single-product/price.php' );
    }
}

function shuffle_variable_product_elements(){
    if ( is_product() ) {
        global $post;
        $product = wc_get_product( $post->ID );
        if ( $product->is_type( 'variable' ) ) {
            remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
            add_action( 'woocommerce_before_variations_form', 'woocommerce_single_variation', 20 );

            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
            add_action( 'woocommerce_before_variations_form', 'woocommerce_template_single_title', 10 );

            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
            add_action( 'woocommerce_before_variations_form', 'woocommerce_template_single_excerpt', 30 );
        }
    }
}
add_action( 'woocommerce_before_single_product', 'shuffle_variable_product_elements' );

// Category Products
function custom_storefront_category( $args ) {
	$args['number'] = 10;
	return $args;
}
add_filter('storefront_product_categories_shortcode_args','custom_storefront_category' );

// Desactivar html en comentarios
add_filter('pre_comment_content', 'wp_specialchars');

function wc_renaming_order_status( $order_statuses ) {
    foreach ( $order_statuses as $key => $status ) {
        if ( 'wc-completed' === $key ) 
            $order_statuses['wc-completed'] = _x( 'Entregado', 'Order status', 'woocommerce' );
		if ( 'wc-completed' === $key ) 
			$order_statuses['wc-processing'] = _x( 'Pagado', 'Order status', 'woocommerce' );
		if ( 'wc-completed' === $key ) 
			$order_statuses['wc-on-hold'] = _x( 'Espera transferencia bancaria', 'Order status', 'woocommerce' );
    }
    return $order_statuses;
}
add_filter( 'wc_order_statuses', 'wc_renaming_order_status' );

function rss_post_thumbnail($content) {
global $post;
if(has_post_thumbnail($post->ID)) {
$content = get_the_post_thumbnail($post->ID) . $content;
}
return $content;
}
add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');

add_action( 'wp_print_styles', 'cf7_deregister_styles', 100 );
function cf7_deregister_styles() {
    if ( ! is_page( 'contacto' ) ) {
        wp_deregister_style( 'contact-form-7' );
    }
}

add_action( 'wp_print_scripts', 'cf7_deregister_javascript', 100 );
function cf7_deregister_javascript() {
    if ( ! is_page( 'contacto' ) ) {
        wp_deregister_script( 'contact-form-7' );
    }
}

function my_text_strings( $translated_text, $text, $domain ) {
 switch ( $translated_text ) {
 case 'Código de clasificación' :
 $translated_text = __( 'CBU', 'woocommerce' );
 break;

 case 'Finalizar compra' :
 $translated_text = __( 'Pasar por caja', 'woocommerce' );
 break;
 }
 return $translated_text;
}
add_filter( 'gettext', 'my_text_strings', 20, 3 );

add_action('wp_head', 'css_lista_precios');
function css_lista_precios(){
if(is_page('lista-de-precios')) {  ?>
		<style>
		table {
			width: 100%;
			max-width: 100%;
			border: 1px solid #d5d5d2;
			border-collapse: collapse
		}

		table caption {
			font-family: 'Tungsten A', 'Tungsten B', 'Arial Narrow', Arial, sans-serif;
			font-weight: 400;
			font-style: normal;
			font-size: 2.954rem;
			line-height: 1;
			margin-bottom: .75em
		}

		table th {
			font-family: 'Gotham SSm A', 'Gotham SSm B', Verdana, sans-serif;
			font-weight: 400;
			font-style: normal;
			text-transform: uppercase;
			letter-spacing: .02em;
			font-size: .9353rem;
			padding: 1.2307em 1.0833em 1.0833em;
			line-height: 1.333;
			background-color: #eae9e6
		}

		table td, table th {
			text-align: left
		}

		table td {
			padding: .92307em 1em .7692em
		}

		table tbody tr:nth-of-type(even) {
			background-color: #f9f8f5
		}

		table tbody th {
			border-top: 1px solid #d5d5d2
		}

		table tbody td {
			border-top: 1px solid #d5d5d2
		}

		table.wdn_responsive_table thead th abbr {
			border-bottom: none
		}

		@media screen and (max-width:47.99em) {
			table.wdn_responsive_table td, table.wdn_responsive_table th {
				display: block
			}

			table.wdn_responsive_table thead tr {
				display: none
			}

			table.wdn_responsive_table tbody tr:first-child th {
				border-top-width: 0
			}

			table.wdn_responsive_table tbody tr:nth-of-type(even) {
				background-color: transparent
			}

			table.wdn_responsive_table tbody td {
				text-align: left
			}

			table.wdn_responsive_table tbody td:before {
				display: block;
				font-weight: 700;
				content: attr(data-header)
			}

			table.wdn_responsive_table tbody td:empty {
				display: none
			}

			table.wdn_responsive_table tbody td:nth-of-type(even) {
				background-color: #f9f8f5
			}
		}

		@media (min-width:48em) {
			table caption {
				font-size: 2.532rem
			}

			table th {
				padding: 1.2307em 1.2307em 1em;
				font-size: .802rem
			}

			table td {
				padding: .75em 1em .602em
			}
		}

		@media screen and (min-width:48em) {
			table.wdn_responsive_table thead th:not(:first-child) {
				text-align: center
			}

			table.wdn_responsive_table tbody td {
				text-align: center
			}

			table.wdn_responsive_table.flush-left td, table.wdn_responsive_table.flush-left thead th {
				text-align: left
			}
		}
		</style>
<?php }
};

add_action('wp_head', 'css_contacto');
function css_contacto(){
if(is_page('contacto')) {  ?>
		<style>
		* {
		  box-sizing: border-box;
		}

		/* Style inputs */
		input[type=text], select, textarea {
		  width: 100%;
		  padding: 12px;
		  border: 1px solid #ccc;
		  margin-top: 6px;
		  margin-bottom: 16px;
		  resize: vertical;
		}
						 
		input[type=email], select, textarea {
		  width: 100%;
		  padding: 12px;
		  border: 1px solid #ccc;
		  margin-top: 6px;
		  margin-bottom: 16px;
		  resize: vertical;
		}

		input[type=submit] {
		  background-color: #3A6541;
		  color: white;
		  padding: 12px 20px;
		  border: none;
		  cursor: pointer;
		}

		input[type=submit]:hover {
		  background-color: #45a049;
		}
						 
		.aviso {
			color: grey;
			margin-top: -28px;
		}
						 
		</style>
<?php }
};

add_action('wp_head', 'css_inicio');
function css_inicio(){
if(is_front_page()) {  ?>
		<style>
			.entry-title {
				display: none;
			}
			
			.entry-content {
				display: none;
			}
						 
		</style>
<?php }
};

function remove_country_checkout_field($fields) {
	unset($fields['order']['order_comments']);
	return $fields;
}
add_filter('woocommerce_checkout_fields', 'remove_country_checkout_field');

add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

add_filter( 'woocommerce_checkout_fields', 'remove_billing_checkout_fields' );
function remove_billing_checkout_fields( $fields ) {
    // change below for the method
    $shipping_method = 'local_pickup:18'; 
    // change below for the list of fields
    $hide_fields = array('billing_address_1', 'billing_last_name', 'billing_city', 'billing_state', 'billing_postcode', 'billing_country', 'billing_phone');

    $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
    $chosen_shipping = $chosen_methods[0];

    foreach($hide_fields as $field ) {
        if ($chosen_shipping == $shipping_method) {
            $fields['billing'][$field]['required'] = false;
            $fields['billing'][$field]['class'][] = 'hide';
        }
        $fields['billing'][$field]['class'][] = 'billing-dynamic';
    }

    return $fields;
}

add_action( 'wp_footer', 'cart_update_script', 999 );
function cart_update_script() {
    if (is_checkout()) :
    ?>
    <style>
        .hide {display: none!important;}
    </style>
    <script>
        jQuery( function( $ ) {

            // woocommerce_params is required to continue, ensure the object exists
            if ( typeof woocommerce_params === 'undefined' ) {
                return false;
            }

            $(document).on( 'change', '#shipping_method input[type="radio"]', function() {
                // change local_pickup:1 accordingly 
                $('.billing-dynamic').toggleClass('hide', this.value == 'local_pickup:18');
            });
        });
    </script>
    <?php
    endif;
}

add_action('wp_head', 'css_finalizar_compra');
function css_finalizar_compra(){
if(is_page('finalizar-compra')) {  ?>
	<style>
		.woocommerce-form-login-toggle {
			display:none;
		}
		
		.woocommerce-privacy-policy-text {
			display:none;
		}
								 
		.storefront-breadcrumb {
			display:none;
		}
								 
		.entry-header {
			margin-top: 3em;
    		margin-bottom: -3em;
			
		p.form-row {
			width: 100% !important;
		}
		
		h3 {
			background-color: grey;
			text-align: center;
			padding: 10px;
			color: white;
			text-decoration: double;
		}
	</style>
<?php }
};

add_action('wp_head', 'css_carrito');
function css_carrito(){
if(is_page('carrito')) {  ?>
	<style>
		.woocommerce-shipping-totals {
			display:none;
		}
		
		.cart-subtotal {
			display:none;
		}

		.order-total {
			font-size: 24px;
		}
						
		.storefront-breadcrumb {
			display:none;
		}
						
		.entry-header {
			margin-top: 3em;
    		margin-bottom: -3em;
		}
	</style>
<?php }
};

add_filter('woocommerce_address_to_edit', 'woocommerce_address_to_edit');
function woocommerce_address_to_edit($address){
        array_key_exists('billing_city', $address)?$address['billing_city']['custom_attributes'] = array('readonly'=>'readonly'):'';
        array_key_exists('billing_state', $address)?$address['billing_state']['custom_attributes'] = array('readonly'=>'readonly'):'';
        array_key_exists('billing_postcode', $address)?$address['billing_postcode']['custom_attributes'] = array('readonly'=>'readonly'):'';
        return $address;
}

add_action('wp_head', 'adsense_script');
function adsense_script(){
	?>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-4085127056158451",
		enable_page_level_ads: true
	  });
	</script>
<?php
};
?>
