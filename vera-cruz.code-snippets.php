<?php
/**
 * Lista de Precios CSS snippet
 *
 * Hoja de estilos CSS para la página Lista de Precios
 */
add_action( 'wp_head', function () { ?>
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
<?php } );


/**
 * Quitar barra admin
 *
 * Quitar barra administrador en usuarios no-admin no-autor
 */
if (!current_user_can('edit_posts')) {
	add_filter('show_admin_bar', '__return_false');
}

/**
 * Quitar barra ordenar por popularidad
 *
 * Quitar el desplegable de ordenar por en Storefront
 */
add_action('init','delay_remove');
function delay_remove() {
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
}

/**
 * Cambio de textos en WooCommerce/WordPress
 *
 * Mas información en http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
 */
function my_text_strings( $translated_text, $text, $domain ) {
 switch ( $translated_text ) {
 case 'Código de clasificación' :
 $translated_text = __( 'CBU', 'woocommerce' );
 break;
 
 case 'Rebajados' :
 $translated_text = __( 'Promociones', 'woocommerce' );
 break;
 
 case 'Favoritos de los fans' :
 $translated_text = __( 'Favoritos', 'woocommerce' );
 break;
 
 case 'Productos relacionados' :
 $translated_text = __( 'Quizás te interesen estos productos', 'woocommerce' );
 break;
 }
 return $translated_text;
}
add_filter( 'gettext', 'my_text_strings', 20, 3 );

/**
 * Quitar intervalo de precios
 *
 * Quitar intervalo de precios en productos variables de WooCommerce
 */
function quitar_intervalo( $price, $product ) {
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
add_filter( 'woocommerce_variable_sale_price_html', 'quitar_intervalo', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'quitar_intervalo', 10, 2 );

/**
 * Buscador YITH Ajax Filter
 *
 * Cambiar buscador de productos de Storefront por YITH Ajax Filter
 */
add_filter( 'get_product_search_form' , 'me_custom_product_searchform' );
function me_custom_product_searchform() {
echo do_shortcode('[yith_woocommerce_ajax_search]');
}

/**
 * Desactivar HTML en comentarios
 *
 * Desactivar html en comentarios
 */
add_filter('pre_comment_content', 'wp_specialchars');

/**
 * Desactivar Schema MU de Yoast
 *
 * Desactivar agregados de Schema Markup de parte de Yoast SEO
 */
function disable_yoast_schema_data($data){
	$data = array();
	return $data;
}
add_filter('wpseo_json_ld_output', 'disable_yoast_schema_data', 10, 1);

/**
 * Cambiar los "Order Status"
 *
 * Cambiar nombres de "Order Status" en WooCommerce
 */

add_filter( 'wc_order_statuses', 'wc_renaming_order_status' );
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

/**
 * Schema Markup Principal
 *
 * Agregar datos estructurados a la página principal
 */
add_action('wp_head', 'schema_home');
function schema_home(){
if(is_front_page()) {  ?>
	<script type="application/ld+json">
	{
	  "@context": "http://schema.org",
	  "@type": "Store",
	  "name": "Vera Cruz Insumos Cerveceros",
	  "description": "Venta y provisión de materias primas e insumos para cerveceros.",
	  "logo": "https://www.veracruzinsumos.com.ar/wp-content/uploads/Icono-PNG-96-DPI-512x512-px-1.png",
	  "image": "https://www.veracruzinsumos.com.ar/wp-content/uploads/Logo-Verde-500x500px-96ppp.jpg",
	  "url": "https://www.veracruzinsumos.com.ar/",
	  "openingHours": "Mo-Fr 09:00-21:00",
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
		"ratingValue": "4.2",
		"reviewCount": "187"
	  },
	  "priceRange": "$$$",
	  "telephone": "+54-0342-484-8642"
	}
	</script>
<?php  }
};

/**
 * Schema Markup Blog
 *
 * Agregar datos estructurados al blog
 */
add_action('wp_head', 'schema_blog');
function schema_blog(){
if(is_single(12)) {  ?>
	<script type="application/ld+json">
	{
	  "@context": "http://schema.org",
	  "@type": "Store",
	  "name": "Vera Cruz Insumos Cerveceros",
	  "description": "Venta y provisión de materias primas e insumos para cerveceros.",
	  "logo": "https://www.veracruzinsumos.com.ar/wp-content/uploads/Icono-PNG-96-DPI-512x512-px-1.png",
	  "image": "https://www.veracruzinsumos.com.ar/wp-content/uploads/Logo-Verde-500x500px-96ppp.jpg",
	  "url": "https://www.veracruzinsumos.com.ar/",
	  "openingHours": "Mo-Fr 09:00-21:00",
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
		"ratingValue": "4.2",
		"reviewCount": "187"
	  },
	  "priceRange": "$$$",
	  "telephone": "+54-0342-484-8642"
	}
	</script>
<?php  }
};

/**
 * Schema Markup Tienda
 *
 * Agregar datos estructurados a la tienda
 */
add_action('wp_head', 'schema_shop');
function schema_shop(){
if(is_single(4)) {  ?>
	<script type="application/ld+json">
	{
	  "@context": "http://schema.org",
	  "@type": "Store",
	  "name": "Vera Cruz Insumos Cerveceros",
	  "description": "Venta y provisión de materias primas e insumos para cerveceros.",
	  "logo": "https://www.veracruzinsumos.com.ar/wp-content/uploads/Icono-PNG-96-DPI-512x512-px-1.png",
	  "image": "https://www.veracruzinsumos.com.ar/wp-content/uploads/Logo-Verde-500x500px-96ppp.jpg",
	  "url": "https://www.veracruzinsumos.com.ar/",
	  "openingHours": "Mo-Fr 09:00-21:00",
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
		"ratingValue": "4.2",
		"reviewCount": "187"
	  },
	  "priceRange": "$$$",
	  "telephone": "+54-0342-484-8642"
	}
	</script>
<?php  }
};

/**
 * Google Tag Manager 1
 *
 * Etiqueta de seguimiento de Google Tag Manager HEAD
 */
add_action( 'wp_head', function () { ?>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-MDCHDJ8');</script>
<?php } );

/**
 * Google Tag Manager 2
 *
 * Etiqueta de seguimiento de Google Tag Manager BODY
 */
add_action( 'wp_head', function () { ?>
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MDCHDJ8"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php } );
