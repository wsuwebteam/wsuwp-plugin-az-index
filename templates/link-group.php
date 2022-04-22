<div class="wsu-az-index__link-list-group">
	<<?php echo esc_attr( $attrs['headingLevel'] ); ?> class="wsu-az-index__link-list-heading"><?php echo esc_attr( $label ); ?></<?php echo esc_attr( $attrs['headingLevel'] ); ?>>
	<?php
	if ( ! empty( $links ) ) {
		?>
		<ol class="wsu-az-index__link-list">
		<?php foreach ( $links as $l ) { ?>
			<li class="wsu-az-index__link-list-item">
				<a href="<?php echo esc_attr( $l['url'] ); ?>" class="wsu-az-index__link-list-link"><?php echo esc_attr( $l['title'] ); ?></a>
			</li>
		<?php } ?>
		</ol>
		<?php
	} else {
		echo '<p>No results found.</p>';
	}
	?>
</div>
