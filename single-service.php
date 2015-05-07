<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<?php wp_head(); ?>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<h1><?php echo get_the_title(); ?></h1>
			<?php echo wpautop( $post->post_content ); ?>
			<form method="POST">
				<input type="hidden" name="service_id" value="<?php echo get_the_ID() ?>" />
				<input type="hidden" name="action" value="submit_appointment" />
				<input type="hidden" id="appointment_total_cost" name="appointment_total_cost" value="0.00" />
				<?php if ( $notification = get_post_meta( get_the_ID(), '_service_notification', true ) ): ?>
					<div class="alert alert-success" role="alert"><?php echo wpautop( $notification ); ?></div>
				<?php endif; ?>
				<p>&nbsp;</p>
				<div id="user-information">
					<h3>Your Information</h3>
					<div class="form-group row">
						<div class="col-md-6">
							<label for="name">First Name</label>
							<input type="text" class="form-control" id="user_nicename" name="customer[meta][first_name]" placeholder="John">
						</div>
						<div class="col-md-6">
							<label for="name">Last Name</label>
							<input type="text" class="form-control" id="user_nicename" name="customer[meta][last_name]" placeholder="Doe">
						</div>
					</div>
					<div class="form-group">
						<label for="mobile">Mobile</label>
						<input type="text" class="form-control" id="user_mobile_nuber" name="customer[meta][mobile_number]" placeholder="(336) 555-5555">
					</div>
					<div class="form-group">
						<label for="email">Email (optional)</label>
						<input type="email" class="form-control" id="user_email" name="customer[user_email]" placeholder="info@battlebranding.com">
					</div>
				</div>
				<p>&nbsp;</p>
				<!-- Delivery Information -->
				<div id="appointment-times">
					<?php $is_delivery = get_post_meta( get_the_ID(), '_service_is_delivery', true ); ?>
					<h3><?php echo ( $is_delivery ) ? 'Delivery' : 'Appointment' ?> Details</h3>
					<?php if( $is_delivery ): ?>
						<div class="form-group">
							<label for="name">Delivery Location</label>
							<textarea class="form-control" id="delivery_location" name="delivery_location" placeholder="100 Your Place, Greensboro, NC"></textarea>
						</div>
					<?php endif; ?>
					<div class="form-group">
						<label>Select your desired <?php echo ( $is_delivery ) ? 'delivery' : 'appointment' ?> time</label>
						<?php foreach( $skhed->get_availability() as $availabity ): ?>
							<?php 
								$day_of_week = get_post_meta( $availabity->ID, '_availability_day_of_week', true ); 
								$availability_date = date('l M jS', strtotime( $day_of_week ) );

								$is_avaiable = $skhed->check_if_available( $availabity->ID );
								$available_class = ( $is_avaiable ) ? '' : 'disabled';
							?>
							<div class="radio <?php echo $available_class ?>">
								<label>
									<input type="radio" name="availability_id" value="<?php echo $availabity->ID ?>" <?php echo $available_class ?>/>
									<?php echo $availability_date; ?> @ <?php echo get_post_meta( $availabity->ID, '_availability_time_of_day', true ); ?>
									<?php if ( ! $is_avaiable ): ?>
										<strong> (Full)</strong>
									<?php endif; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<p>&nbsp;</p>
				<div id="addon-products">
					<h3>Checkout</h3>
					<?php if ( $products = get_post_meta( get_the_ID(), '_service_addon_products', true ) ): ?>
						<table class="table">
							<thead>
								<tr>
									<td>Item</td>
									<td width="25%">Quantity</td>
									<td>Price</td>
								</tr>
							</thead>
							<?php foreach( $products as $product ):  ?>
								<tr>
									<td><?php echo get_the_title( $product['product_id'] ) ?></td>
									<td><input type="text" class="addon-quantity form-control" name="quantities[<?php echo $product['product_id'] ?>]" value="<?php echo $product['default_quantity'] ?>" /></td>
									<td><span class="addon-price" data-price="<?php echo get_post_meta( $product['product_id'], '_product_price', true ); ?>">$0.00</span></td>
								</tr>
							<?php endforeach; ?>
							<tr>
								<td colspan="2"><strong>Total Due on Delivery</strong></td>
								<td><span id="total_price_display">$0.00</span></td>
							</tr>
						</table>
					<?php endif; ?>
				</div>	
				<p>&nbsp;</p>
				<div>
					<h3>Comments</h3>
					<div class="form-group">
						<textarea class="form-control" name="additional_comments"></textarea>
						<span id="helpBlock" class="help-block">Please leave any special notes or information here</span>
					</div>
				</div>
				
				<button class="btn btn-default" type="submit">Submit</button>
				<p>&nbsp;</p>
			</form> 
			<div class="row">
				<!-- <p class="text-center">Powered by Skhed.com</p> -->
			</div>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>