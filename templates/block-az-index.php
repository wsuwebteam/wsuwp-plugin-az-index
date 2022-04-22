<div class="wsu-az-index <?php echo esc_attr( $attrs['className'] ); ?>">
	<?php
	if ( false === $attrs['showAllLinks'] ) {
		?>
		<div class="wsu-az-index__controls">
			<nav class="wsu-az-index__nav" role="navigation" aria-label="A-Z Index Navigation">
				<ol class="wsu-az-index__nav-list">
					<?php

					foreach ( $link_groups as $group ) {
						$label          = self::get_group_label( $group );
						$selected_class = $selected_letter === $label ? ' is-selected' : '';
						$has_links      = isset( $grouped_links[ $group ] );
						echo '<li class="wsu-az-index__nav-item">';
						if ( $has_links ) {
							echo '<a href="?c=' . esc_attr( $group ) . '" class="wsu-az-index__nav-link wsu-button' . esc_attr( $selected_class ) . '">' . esc_attr( $label ) . '</a>';
						} else {
							echo '<a class="wsu-az-index__nav-link wsu-button is-disabled" role="link" aria-disabled="true">' . esc_attr( $label ) . '</a>';
						}
						echo '</li>';
					}
					?>
				</ol>
			</nav>
			<form action="" method="GET" class="wsu-az-index__search-form">
				<input type="text" class="wsu-az-index__search-input" name="search" placeholder="Search" value="<?php echo esc_attr( $_GET['search'] ); ?>">
			</form>
		</div>
		<?php
	}
	?>

	<?php
	if ( true === $attrs['showAllLinks'] ) {
		foreach ( $link_groups as $group ) {
			$label = self::get_group_label( $group );
			$links = isset( $grouped_links[ $group ] ) ? $grouped_links[ $group ] : array();
			self::render_link_group( $attrs, $label, $links );
		}
	} else {
		$group = self::get_group_to_display( $link_groups, $grouped_links );
		$label = $group['label'];
		$links = $group['links'];
		self::render_link_group( $attrs, $label, $links );
	}
	?>
</div>
