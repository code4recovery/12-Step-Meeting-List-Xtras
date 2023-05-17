<?php
/**
 * Meeting table accordion template
 * Available variables:
 * - $data: Object containing all data for this template
 */

// @todo Mobile version of table
// Instantiate a new template laoder for use here
$hidden_cols     = [
	'distance'
];
?>
<div class="tsmlx" id="tsmlx">
	<section id="meetinglist" class="post-list tw-relative tw-overflow-auto">
		<!-- Notes Above -->
		<?php if ( $data->show_header === "1" ) { ?>
			<div>
				<h3 class="tw-text-2xl tw-text-tsmlx-primary">Meeting Schedule</h3>
				<?php echo wp_kses_post( wpautop( $data->notes_above ) ); ?>
				<small class="tw-mb-2 tw-block tw-text-tsmlx-tertiary"><em>* Click a meeting to see more info.</em> (Current day is always listed first.)</small>
			</div>
		<?php } ?>

		<!-- Desktop Table -->
		<table class="table-meetings tw-border-spacing-0 tw-border-separate tw-whitespace-normal tw-table tw-table-auto tw-max-w-full tw-border-0">
			<?php // Loop through and output
			foreach ( $data->meetings as $daynum => $meetinggroup ) { ?>
				<thead>
				<tr class="tw-uppercase">
					<th class="day tw-p-2 tw-border-0 tw-bg-tsmlx-headers tw-border-b tw-border-solid tw-border-black" colspan="<?php echo count( $data->tsml_columns ) + 1; ?>">
						<h5 class="tw-my-0 tw-text-left <?php if (!empty($data->header_invert)) echo 'tw-text-white'; ?>"><?php echo $data->tsml_days[ $daynum ]; ?></h5>
					</th>
				</tr>
				</thead>
				<?php
				foreach ( $meetinggroup as $meeting ) {
					$group_url         = $meeting['url'];
					$meeting['region'] = ( ! empty( $meeting['sub_region'] ) ) ? htmlentities( $meeting['sub_region'], ENT_QUOTES ) : htmlentities( @$meeting['region'], ENT_QUOTES );
					$attendance_class = tsml_xtras_get_classes('badge') . ' tw-bg-tsmlx-primary/80 tw-text-white';
					switch ( $meeting['attendance_option'] ) {
						case 'in_person':
							$attendance_class .= ' tw-hidden';
							break;
					}
					?>
					<tbody>
					<tr class="expandable tw-cursor-pointer hover:tw-bg-tsmlx-secondary/5 meetingrow">
						<td class="tw-p-0 tw-py-2 tw-bg-transparent tw-border-0 tw-border-r tw-border-r-black/20 tw-bg-tsmlx-primary/5 tw-w-6">
							<div class="tw-flex tw-items-center tw-justify-center tw-text-tsmlx-headers">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="tw-w-5 tw-h-5 accordion-toggle">
									<path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
								</svg>
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="tw-w-5 tw-h-5 accordion-toggle tw-hidden">
									<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
								</svg>
							</div>
						</td>
						<?php foreach ( $data->tsml_columns as $key => $column ) { ?>
							<td class="tw-align-top tw-p-2 tw-bg-transparent tw-border-0 tw-border-t tw-border-t-black/20 <?php if (in_array($key, $hidden_cols)) echo ' tw-hidden '; ?><?php echo $key; ?>">
								<?php
								switch ( $key ) {
									case 'time': ?>
										<span class="tw-whitespace-nowrap tw-font-bold">
											<?php
											if ( ! empty( $meeting['time_formatted'] ) ) {
												echo $meeting['time_formatted'];
											} else {
												_e( 'Appointment', '12-step-meeting-list' );
											}
											?>
										</span>
										<?php
										break;

									case 'name':
										$meeting_types = tsml_format_types( $meeting['types'] ); ?>
									<span>
										<span class="tw-break-words"><?php echo htmlentities( @$meeting['name'], ENT_QUOTES ); ?></span>
										<?php if ( ! empty( $meeting_types ) ) { ?>
										<span class="tw-bg-tsmlx-tertiary/80 tw-text-white tw-text-primary <?php echo tsml_xtras_get_classes('badge'); ?>"><?php echo $meeting_types ?></span>
										</span>
										<?php }
										break;

									case 'types': ?>
										<span><?php tsmlxtras_get_typesbadges( $meeting['types_expanded'], $data->loader, 'tw-border tw-border-tsmlx-primary/50 tw-text-tsmlx-primary tw-bg-tsmlx-primary/5 tw-justify-self-start' ); ?></span>
										<?php
										break;

									case 'region': ?>
										<span><?php echo $meeting['region']; ?></span>
										<?php
										break;

									case 'location_group':
										$meeting_location = $meeting['location'];
										if ($meeting['attendance_option'] == 'online' || $meeting['attendance_option'] == 'inactive') {
											$meeting_location = '';
										} ?>
										<span class="location-name tw-break-words tw-mr-2 empty:tw-hidden"><?php echo $meeting_location; ?></span>
										<small class="<?php echo $attendance_class; ?> attendance-<?php echo $meeting['attendance_option']; ?>">
											<?php if ($meeting['attendance_option'] != 'in_person') echo $data->tsml_meeting_attendance_options[$meeting['attendance_option']]; ?>
										</small>
										<?php
										break;

									case 'address': ?>
										<span><?php echo tsml_format_address( $meeting['formatted_address'], $data->tsml_street_only ); ?></span>
										<?php
										break;

									case 'district': ?>
										<span><?php echo $meeting['district'] . ' &raquo; ' . $meeting['sub_district']; ?></span>
										<?php
										break;

									default: ?>
										<span><?php echo $meeting[$key]; ?></span>
									<?php } ?>
							</td>
						<?php } ?>
					</tr>
					<tr class="datarow tw-border-t">
						<td class="tw-p-0 tw-border-x-0" colspan="<?php echo count( $data->tsml_columns ) + 1; ?>">
							<div class="tsmlx-container tw-overflow-hidden tw-max-h-0 tw-duration-500 tw-transition-all">
								<div class="tw-p-2 tw-flex tw-items-between tw-border-t tw-border-t-black/20">
									<span class="tw-inline-block tw-mb-0">
										<a class="tw-font-bold tw-flex tw-flex-row tw-gap-0.5 hover:tw-gap-1 tw-items-center tw-text-tsmlx-secondary tw-no-underline tw-border-b tw-border-tsmlx-secondary" href="<?php echo $group_url ?>">
											Visit Meeting Page
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-4 tw-h-4">
												<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
											</svg>
										</a>
									</span>
								</div>
								<div class="tw-p-2 tw-mb-2 tw-gap-4 tw-grid tw-grid-flow-row md:tw-grid-flow-col md:tw-grid-cols-3">
									<!-- Meeting Info -->
									<div id="meeting-info" class="<?php echo tsml_xtras_get_classes( 'card' ) ?>">
										<div class="<?php echo tsml_xtras_get_classes( 'card_header' ) ?>">
										<span class="<?php echo tsml_xtras_get_classes( 'card_header_svg' ) ?> tw-text-tsmlx-primary">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-5 tw-h-5">
												<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
											</svg>
										</span>
											<h6 class="<?php echo tsml_xtras_get_classes( 'card_header_text' ) ?>">Meeting Info</h6>
										</div>
										<div class="tw-card-body tw-p-4">
											<?php if (!array_key_exists('types', $data->tsml_columns)): ?>
												<small class="tw-uppercase tw-text-tsmlx-secondary tw-block tw-mb-1">Type</small>
												<span class="meeting-types tw-mb-4 tw-flex tw-flex-wrap tw-gap-2">
											<?php tsmlxtras_get_typesbadges( $meeting['types_expanded'], $data->loader, 'tw-border tw-border-tsmlx-primary/20 tw-text-tsmlx-primary tw-bg-tsmlx-primary/5 tw-justify-self-start' ) ?>
										</span>
											<?php endif; ?>
											<small class="tw-uppercase tw-text-tsmlx-secondary tw-block tw-mb-1">District</small>
											<span class="meeting-district tw-mb-0 tw-leading-4">
											<?php echo $meeting['district'] . ' &raquo; ' . $meeting['sub_district']; ?>
										</span>
										</div>
									</div>
									<!-- Virtual Meeting Info -->
									<?php if ( $meeting['attendance_option'] != 'in_person' ) { ?>
										<div id="online-info" class="<?php echo tsml_xtras_get_classes( 'card' ) ?>">
											<div class="<?php echo tsml_xtras_get_classes( 'card_header' ) ?>">
											<span class="<?php echo tsml_xtras_get_classes( 'card_header_svg' ) ?> tw-text-tsmlx-primary">
												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-5 tw-h-5">
													<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
												</svg>
											</span>
												<h6 class="<?php echo tsml_xtras_get_classes( 'card_header_text' ) ?>">Virtual Meeting Info</h6>
											</div>
											<div class="tw-card-body tw-p-4">
												<?php
												if ( ! empty( $meeting['conference_url'] ) && $provider = tsml_conference_provider( $meeting['conference_url'] ) ) { ?>
													<a class="<?php echo tsml_xtras_get_classes( 'button' ); ?> <?php echo tsml_xtras_get_classes( 'button_secondary_outline' ); ?>" href="<?php echo $meeting['conference_url'] ?>" target="_blank">
														<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-4 tw-h-4">
															<path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/>
														</svg><?php echo $provider === TRUE ? $meeting['conference_url'] : sprintf( __( 'Join with %s', '12-step-meeting-list' ), $provider ) ?>
													</a>
													<?php if ( $meeting['conference_url_notes'] ) { ?>
														<div class="<?php echo tsml_xtras_get_classes('notes'); ?>">
															<div class="tw-flex tw-items-center tw-gap-2">
																<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-flex-shrink-0 tw-w-6 tw-h-6 tw-text-tsmlx-secondary tw-inline-block">
																	<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
																</svg>
																<div class="tw-whitespace-normal tw-break-words">
																	<?php echo nl2br( $meeting['conference_url_notes'] ) ?>
																</div>
															</div>
														</div>
													<?php } ?>
												<?php }
												if ( ! empty( $meeting['conference_phone'] ) ) { ?>
													<a class="<?php echo tsml_xtras_get_classes( 'button' ); ?> <?php echo tsml_xtras_get_classes( 'button_secondary_outline' ); ?>" href="tel:<?php echo $meeting['conference_phone'] ?>">
														<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-4 tw-h-4">
															<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
														</svg><?php _e( 'Join by Phone', '12-step-meeting-list' ) ?>
													</a>
													<?php if ( !empty($meeting['conference_phone_notes'] )) { ?>
														<div class="<?php echo tsml_xtras_get_classes('notes'); ?>">
															<div class="tw-flex tw-items-center tw-gap-2">
																<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-flex-shrink-0 tw-w-6 tw-h-6 tw-text-tsmlx-secondary tw-inline-block">
																	<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
																</svg>
																<div class="tw-whitespace-normal tw-break-words">
																	<?php echo nl2br( $meeting['conference_phone_notes'] ) ?>
																</div>
															</div>
														</div>
													<?php } ?>
												<?php } ?>
											</div>
										</div>
									<?php } ?>
									<!-- Address -->
									<?php if ( !empty($meeting['attendance_option'] !== 'online' )) { ?>
										<div id="meeting-address" class="<?php echo tsml_xtras_get_classes( 'card' ) ?>">
											<div class="<?php echo tsml_xtras_get_classes( 'card_header' ) ?>">
												<span class="<?php echo tsml_xtras_get_classes( 'card_header_svg' ) ?> tw-text-tsmlx-primary">
													<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-4 tw-h-4">
														<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
														<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
													</svg>
												</span>
												<h6 class="<?php echo tsml_xtras_get_classes( 'card_header_text' ) ?>">Address</h6>
											</div>
											<div class="tw-card-body tw-p-4">
												<?php //d($meeting); ?>
												<?php echo tsml_format_address($meeting['formatted_address']); ?>
												<?php if ( !empty($meeting['location_notes'] )) { ?>
													<div class="<?php echo tsml_xtras_get_classes('notes'); ?>">
														<div class="tw-flex tw-items-center tw-gap-2">
															<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-flex-shrink-0 tw-w-6 tw-h-6 tw-text-tsmlx-secondary tw-inline-block">
																<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
															</svg>
															<div class="tw-whitespace-normal tw-break-words">
																<?php echo nl2br( $meeting['location_notes'] ) ?>
															</div>
														</div>
													</div>
												<?php } ?>
												<small class="tw-mt-2 tw-block">
													<a href="#" class="<?php echo tsml_xtras_get_classes( 'button' ); ?> <?php echo tsml_xtras_get_classes( 'button_secondary_outline' ); ?>" data-latitude="<?php echo $meeting['latitude'] ?>" data-longitude="<?php echo $meeting['longitude'] ?>" data-location="<?php echo $meeting['location'] ?>">
														<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-4 tw-h-4">
															<path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5"/>
														</svg>
														Directions
													</a>
												</small>
											</div>
										</div>
									<?php } ?>
									<!-- 7th Tradition -->
									<?php
									$active_services = array_filter( array_keys( $data->services ), function ( $service ) use ( $meeting ) {
										return ! empty( $meeting[ $service ] );
									} );
									if ( count( $active_services ) ) { ?>
										<div id="donations" class="<?php echo tsml_xtras_get_classes( 'card' ) ?>">
											<div class="<?php echo tsml_xtras_get_classes( 'card_header' ) ?>">
												<span class="<?php echo tsml_xtras_get_classes( 'card_header_svg' ) ?> tw-text-tsmlx-primary">
														<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-4 tw-h-4">
															<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
														</svg>
													</span>
												<h6 class="<?php echo tsml_xtras_get_classes( 'card_header_text' ) ?>">7th Tradition</h6>
											</div>
											<div class="tw-card-body tw-p-4">
												<?php
												foreach ( $active_services as $field ) {
													$service  = $data->services[ $field ];
													$username = substr( $meeting[ $field ], $service['substr'] );
													if ( ! empty( $meeting[ $field ] ) ) {
														tsmlxtras_get_basketbutton( $field, $service, $username, $data->loader );
													}
												} ?>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			<?php } ?>
		</table>
		<!-- Notes Below -->
		<?php if ( $data->show_footer === "1" ) { ?>
			<div>
				<?php echo wp_kses_post( wpautop( $data->notes_below ) ); ?>
			</div>
		<?php } ?>
	</section>  <!-- /.end of section -->
</div>