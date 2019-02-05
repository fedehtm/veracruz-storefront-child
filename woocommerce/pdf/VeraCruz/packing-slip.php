<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php do_action( 'wpo_wcpdf_before_document', $this->type, $this->order ); ?>

<table class="head container">
	<tr>
		<td class="header">
		<?php
		if( $this->has_header_logo() ) {
			$this->header_logo();
		} else {
			echo $this->get_title();
		}
		?>
		</td>
		<td class="shop-info">
			<div class="shop-name"><h3><?php $this->shop_name(); ?></h3></div>
			<div class="shop-address"><?php $this->shop_address(); ?></div>
		</td>
	</tr>
</table>

<h1 class="document-type-label">
Remito - Pedido <?php $this->order_number(); ?>
</h1>

<?php do_action( 'wpo_wcpdf_after_document_label', $this->type, $this->order ); ?>

<h2>Destinatario</h2>
<table class="remito-order-data-addresses">
	<?php do_action( 'wpo_wcpdf_before_shipping_address', $this->type, $this->order ); ?>
	<tr>	
		<td>Nombre</td>
		<td>
			<?php echo $order->get_shipping_first_name(); ?>
			<?php echo $order->get_shipping_last_name(); ?>
		</td>
	</tr>
	<tr>	
		<td>CUIT/DNI</td>
		<td>
			<?php echo $order->get_shipping_company(); ?>
		</td>
	</tr>
	<tr>
		<td>Dirección</td>
		<td>
			<?php echo $order->get_shipping_address_1(); ?>
			<?php echo $order->get_shipping_address_2(); ?>
			, 
			<?php echo $order->get_shipping_city(); ?>
			(<?php echo $order->get_shipping_postcode(); ?>)
		</td>
	</tr>
	<tr>	
		<td>Teléfono</td>
		<td>
			<?php echo $order->get_billing_phone(); ?>
		</td>
	</tr>
</table>

<h2>Remitente</h2>
<table class="remito-order-data-addresses">
	<tr>	
		<td>Nombre</td>
		<td>Federico Berrone</td>
	</tr>
	<tr>
		<td>CUIT</td>
		<td>20-34176214-7</td>
	</tr>
</table>

<?php do_action( 'wpo_wcpdf_before_order_details', $this->type, $this->order ); ?>

<h2>Detalle del envío</h2>
<table class="order-details">
	<thead>
		<tr>
			<th class="product"><?php _e('Product', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="quantity"><?php _e('Quantity', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $items = $this->get_order_items(); if( sizeof( $items ) > 0 ) : foreach( $items as $item_id => $item ) : ?>
		<tr class="<?php echo apply_filters( 'wpo_wcpdf_item_row_class', $item_id, $this->type, $this->order, $item_id ); ?>">
			<td class="product">
				<?php $description_label = __( 'Description', 'woocommerce-pdf-invoices-packing-slips' ); // registering alternate label translation ?>
				<span class="item-name"><?php echo $item['name']; ?></span>
				<?php do_action( 'wpo_wcpdf_before_item_meta', $this->type, $item, $this->order  ); ?>
				<span class="item-meta"><?php echo $item['meta']; ?></span>

				<?php do_action( 'wpo_wcpdf_after_item_meta', $this->type, $item, $this->order  ); ?>
			</td>
			<td class="quantity"><?php echo $item['quantity']; ?></td>
		</tr>
		<?php endforeach; endif; ?>
	</tbody>
</table>

<?php do_action( 'wpo_wcpdf_after_order_details', $this->type, $this->order ); ?>

<h4>Peso total: 
<?php
foreach( $order->get_items() as $item_id => $product_item ){
        $quantity = $product_item->get_quantity(); // get quantity
        $product = $product_item->get_product(); // get the WC_Product object
        $product_weight = $product->get_weight(); // get the product weight
        // Add the line item weight to the total weight calculation
        $total_weight += floatval( $product_weight * $quantity );
    }
	
    // Output
    echo round($total_weight);
?>
 kg.</h4>
 
<h4>Valor declarado: $
<?php
foreach( $order->get_items() as $item_id => $product_item ){
        $quantity = $product_item->get_quantity(); // get quantity
        $product = $product_item->get_product(); // get the WC_Product object
        $product_price = $product->get_price(); // get the product price
        // Add the line item price to the total price calculation
        $total_price += floatval( $product_price * $quantity );
    }
	
    // Output
    echo round($total_price);
?>
 </h4>

&nbsp;
 
<h3>Abona en destino / Pago en origen</h3>

<?php do_action( 'wpo_wcpdf_before_customer_notes', $this->type, $this->order ); ?>
<div class="customer-notes">
	<?php if ( $this->get_shipping_notes() ) : ?>
		<h3><?php _e( 'Customer Notes', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3>
		<?php $this->shipping_notes(); ?>
	<?php endif; ?>
</div>

<?php do_action( 'wpo_wcpdf_after_customer_notes', $this->type, $this->order ); ?>

<?php if ( $this->get_footer() ): ?>

<div id="footer">			
	<?php $this->footer(); ?>
</div><!-- #letter-footer -->
<?php endif; ?>

<?php do_action( 'wpo_wcpdf_after_document', $this->type, $this->order ); ?>