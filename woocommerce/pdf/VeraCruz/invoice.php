<?php do_action( 'wpo_wcpdf_before_document', $this->type, $this->order ); ?>
<?php $order = new WC_Order($order_id); ?>

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

<h1>
	Pedido N° 
	<?php $this->order_number(); ?>
	(<?php echo ucwords(strtolower(wc_get_order_status_name($order->get_status()))); ?>) 
</h1>

<?php do_action( 'wpo_wcpdf_after_document_label', $this->type, $this->order ); ?>

<table class="factura-order-data-addresses">
	<tr>
		<td class="address billing-address">
			<h3><?php _e( 'Billing Address:', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3>
			<?php do_action( 'wpo_wcpdf_before_billing_address', $this->type, $this->order ); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ucwords($order->billing_first_name); ?>
			<?php echo ucwords($order->billing_last_name); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $order->billing_company; ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ucwords($order->billing_address_1); ?>
			<?php echo $order->billing_address_2; ?>
			, 
			<?php echo ucwords($order->billing_city); ?>
			(<?php echo $order->billing_postcode; ?>)
			, 
			<?php 
			$country = $order->get_billing_country();
			$state = $order->get_billing_state();
			echo WC()->countries->get_states($country)[$state];
			?>
		</td>
	</tr>
</table>

<?php do_action( 'wpo_wcpdf_before_order_details', $this->type, $this->order ); ?>

<h1>
	Detalle
</h1>
<table class="order-details">
	<thead>
		<tr>
			<th class="product"><?php _e('Product', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="quantity"><?php _e('Quantity', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="price"><?php _e('Price', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
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
			<td class="price"><?php echo $item['order_price']; ?></td>
		</tr>
		<?php endforeach; endif; ?>
	</tbody>
	<tfoot>
		<tr class="no-borders">
			<td class="no-borders" colspan="2">
				<table class="totals">
					<tfoot>
						<?php foreach( $this->get_woocommerce_totals() as $key => $total ) : ?>
						<tr class="<?php echo $key; ?>">
							<td class="no-borders"></td>
							<th class="description"><?php echo $total['label']; ?></th>
							<td class="price"><span class="totals-price"><?php echo $total['value']; ?></span></td>
						</tr>
						<?php endforeach; ?>
					</tfoot>
				</table>
			</td>
		</tr>
	</tfoot>
</table>

<?php do_action( 'wpo_wcpdf_after_order_details', $this->type, $this->order ); ?>

<?php if ( $this->get_footer() ): ?>
<div id="footer">
	<?php $this->footer(); ?>
</div><!-- #letter-footer -->
<?php endif; ?>
<?php do_action( 'wpo_wcpdf_after_document', $this->type, $this->order ); ?>
