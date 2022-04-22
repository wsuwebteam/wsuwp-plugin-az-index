<div class="wrap">
	<h2>Import A-Z Index Links</h2>
	<p>Upload a CSV with the following columns:</p>
	<p><b>linkTitle, linkURL, keywords, creatorName, creatorUsername, creatorEmail, altContactName, altContactEmail, dateCreated, dateModified</b></p>

	<form action="tools.php?page=import-az-index-links" method="post" enctype="multipart/form-data">
		<?php wp_nonce_field( 'az_importer_nonce' ); ?>
		<input type="hidden" value="true" name="az_import_form" />
		<input type="file" name="csvFile">
		<div>
			<input id="wsu-az-importer-csv-has-headers" type="checkbox" value="true" name="has_headers" />
			<label for="wsu-az-importer-csv-has-headers">File contains column headers</label>
		</div>
		<?php submit_button( 'Import' ); ?>
	</form>

	<?php
	if ( ! empty( $links_to_import ) ) {
		$columns = array_keys( $links_to_import[0] );
		?>
		<h3>Imported Links</h3>
		<table class="widefat striped fixed">
			<thead>
				<tr>
				<?php
				foreach ( $columns as $column ) {
					echo '<th>' . esc_attr( $column ) . '</th>';
				}
				?>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ( $links_to_import as $az_link ) {
				if ( ! $az_link ) {
					continue;
				}
				?>
					<tr>
						<?php
						foreach ( $columns as $column ) {
							echo '<td>' . esc_attr( $az_link[ $column ] ) . '</td>';
						}
						?>
					</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php
	}
	?>
</div>
