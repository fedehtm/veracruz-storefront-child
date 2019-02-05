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
		<td class="order-data">
			<table>
			<h5>
				<?php do_action( 'wpo_wcpdf_before_order_data', $this->type, $this->order ); ?>
				<div class="order-number">
					<?php echo 'OP n°: '; ?>
					<?php $this->order_number(); ?>
				</div>
				<div class="order-date">
					<?php echo 'Fecha: '; ?>
					<?php $this->order_date(); ?>
				</div>
				<div class="shipping-method">
					<?php echo 'Envío: '; ?>
					<?php $this->shipping_method(); ?>
				</div>
				<?php do_action( 'wpo_wcpdf_after_order_data', $this->type, $this->order ); ?>
			</h5>
			</table>			
		</td>
	</tr>
</table>

<h1 class="document-type-label">
<?php echo 'REMITO'; ?>
</h1>

<h2 class="document-type-label">
<?php echo ''; ?>
<?php echo 'Destinatario'; ?>
</h2>

<?php do_action( 'wpo_wcpdf_before_shipping_address', $this->type, $this->order ); ?>
<div><?php $this->shipping_first_name(); ?></div>
<div><?php $this->shipping_last_name(); ?></div>
<div><?php $this->shipping_company(); ?></div>
<div><?php $this->shipping_address_1(); ?></div>
<div><?php $this->>shipping_address_2(); ?></div>
<div><?php $this->shipping_city(); ?></div>
<div><?php $this->shipping_postcode(); ?></div>
<div><?php $this->shipping_state(); ?></div>
<?php do_action( 'wpo_wcpdf_after_shipping_address', $this->type, $this->order ); ?>

			<?php if ( isset($this->settings['display_email']) ) { ?>
			<div class="billing-email"><?php $this->billing_email(); ?></div>
			<?php } ?>
			<?php if ( isset($this->settings['display_phone']) ) { ?>
			<div class="billing-phone">
				<?php echo 'Teléfono: '; ?>
				<?php $this->billing_phone(); ?>
			</div>
			<?php } ?>
			<?php if ( isset($this->settings['display_billing_address']) && $this->ships_to_different_address()) { ?>
			<?php _e( 'Billing Address:', 'woocommerce-pdf-invoices-packing-slips' ); ?>
			<?php do_action( 'wpo_wcpdf_before_billing_address', $this->type, $this->order ); ?>
			<?php $this->billing_address(); ?>
			<?php do_action( 'wpo_wcpdf_after_billing_address', $this->type, $this->order ); ?>
			<?php } ?>

<h2 class="document-type-label">
<?php echo ''; ?>
<?php echo 'Remitente'; ?>
</h2>

<div class="shop-name"><?php $this->shop_name(); ?></div>
<div class="shop-address"><?php $this->shop_address(); ?></div>
			
<?php do_action( 'wpo_wcpdf_after_document_label', $this->type, $this->order ); ?>

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