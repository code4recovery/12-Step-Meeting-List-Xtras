<?php
/**
 * Meeting table template for a single group
 * Available variables:
 * - $data: Object containing all data for this template
 */
// Get the week number for use in url's
$weeknum = (integer) date("W") + 1;
?>

<div id="tsmlx">
    <section id="meetings" class="post-list">
		<?php if ($data->show_header === "1") { ?>
            <div class="clearfix">
                <h3 class="mb-2 mb-md-4 tsmlx-primary">Meeting Schedule</h3>
				<?php echo $data->notes_above; ?>
            </div>
		<?php } ?>
        
        <!-- Desktop Table -->
        <table class="table-meetings-group table d-none d-md-table">
            <thead>
            <tr>
				<?php foreach ( $data->tsml_columns as $key => $column ) { ?>
                    <th class="<?php echo $key; ?>"><?php echo __( $column, '12-step-meeting-list' ); ?></th>
				<?php } ?>
            </tr>
            </thead>
            <tbody>
			<?php
			// Loop through and output
			foreach ( $data->meetings as $daynum => $meetinggroup ) { ?>
				<?php
				foreach ( $meetinggroup as $meetingkey => $meeting ) {
					$meeting['region'] = ( ! empty( $meeting['sub_region'] ) ) ? htmlentities( $meeting['sub_region'], ENT_QUOTES ) : htmlentities( @$meeting['region'], ENT_QUOTES ); ?>
                    <tr class="meetingrow border-bottom">
						<?php foreach ( $data->tsml_columns as $key => $column ) { ?>
							<?php switch ( $key ) {
								case 'type': ?>
                                    <td class="<?php echo $key ?> w-80">
                                        <div class="d-block mb-2">
                                            <h5 class="meeting-time mt-0 mb-2 me-md-1 d-block<?php echo $data->secondary_dark === 'on' ? ' text-white' : '' ?>">
                                                <a class="tsmlx-primary" href="<?php echo $meeting['url'] ?>?wk=<?php echo $weeknum ?>">
                                                <?php
                                                echo tsml_format_day_and_time( $meeting['day'], $meeting['time'] );
                                                if ( ! empty( $meeting['end_time'] ) ) {
                                                    /* translators: until */
                                                    echo __( ' to ', '12-step-meeting-list' ), tsml_format_time( $meeting['end_time'] );
                                                } ?>
                                                </a>
                                            </h5>
	                                        <?php tsmlxtras_get_typesbadges( $meeting['types_expanded'] ) ?>
                                        </div>
	                                    <?php if ( $meeting['attendance_option'] != 'in_person' ) { ?>
                                        <a class="tsmlx-primary text-decoration-none collapsed" data-bs-toggle="collapse" href="#collapse<?php echo $daynum ?><?php echo $meetingkey ?>" role="button" aria-expanded="false" aria-controls="collapse<?php echo $daynum ?><?php echo $meetingkey ?>">
                                            Virtual Meeting Info
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="ionicon right"
                                                 viewBox="0 0 512 512">
                                                <title>Caret Forward</title>
                                                <path d="M190.06 414l163.12-139.78a24 24 0 000-36.44L190.06 98c-15.57-13.34-39.62-2.28-39.62 18.22v279.6c0 20.5 24.05 31.56 39.62 18.18z"/>
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="ionicon down"
                                                 viewBox="0 0 512 512">
                                                <title>Caret Down</title>
                                                <path d="M98 190.06l139.78 163.12a24 24 0 0036.44 0L414 190.06c13.34-15.57 2.28-39.62-18.22-39.62h-279.6c-20.5 0-31.56 24.05-18.18 39.62z"/>
                                            </svg>
                                        </a>
                                        <div id="collapse<?php echo $daynum ?><?php echo $meetingkey ?>" class="collapse mt-2 shadow-sm">
                                            <div class="card card-body">
                                                <?php
                                                if ( ! empty( $meeting['conference_url'] ) && $provider = tsml_conference_provider( $meeting['conference_url'] ) ) { ?>
                                                    <a class="tsmlx-primary fw-bolder" href="<?php echo $meeting['conference_url'] ?>" target="_blank">
                                                        <svg xmlns="http://www.w3.org/2000/svg" color="currentColor" class="ionicon me-1" viewBox="0 0 512 512">
                                                            <title>Videocam</title>
                                                            <path d="M374.79 308.78L457.5 367a16 16 0 0022.5-14.62V159.62A16 16 0 00457.5 145l-82.71 58.22A16 16 0 00368 216.3v79.4a16 16 0 006.79 13.08z"
                                                                  fill="none"
                                                                  stroke="currentColor"
                                                                  stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  stroke-width="32"/>
                                                            <path d="M268 384H84a52.15 52.15 0 01-52-52V180a52.15 52.15 0 0152-52h184.48A51.68 51.68 0 01320 179.52V332a52.15 52.15 0 01-52 52z"
                                                                  fill="none"
                                                                  stroke="currentColor"
                                                                  stroke-miterlimit="10"
                                                                  stroke-width="32"/>
                                                        </svg><?php echo $provider === TRUE ? $meeting['conference_url'] : sprintf( __( 'Join with %s', '12-step-meeting-list' ), $provider ) ?>
                                                    </a>
                                                    <?php if ( $meeting['conference_url_notes'] ) { ?>
                                                        <small class="d-block my-3 alert border-light tsmlx-secondary-bg bg-opacity-10 shadow-sm">
                                                            <?php echo nl2br( $meeting['conference_url_notes'] ) ?>
                                                        </small>
                                                    <?php } ?>
                                                <?php }
                                                if ( ! empty( $meeting['conference_phone'] ) ) { ?>
                                                    <a class="tsmlx-primary fw-bolder" href="tel:<?php echo $meeting['conference_phone'] ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon me-1" viewBox="0 0 512 512">
                                                            <title>Phone Portrait</title>
                                                            <path d="M382 0H130a18 18 0 00-18 18v476a18 18 0 0018 18h252a18 18 0 0018-18V18a18 18 0 00-18-18zM148 448V64h216v384z"
                                                                  fill="currentColor"/>
                                                        </svg><?php _e( 'Join by Phone', '12-step-meeting-list' ) ?>
                                                    </a>
                                                    <?php if ( $meeting['conference_phone_notes'] ) { ?>
                                                        <small class="d-inline-block my-3 alert border-light bg-opacity-75 shadow-sm"><?php echo nl2br( $meeting['conference_phone_notes'] ) ?></small>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </td>
									<?php
									break;
								
								case 'time_formatted': ?>
                                <?php
                                    switch ( $meeting['attendance_option'] ) {
										case 'online':
											$att_class = 'tsmlx-primary';
											break;
										case 'in_person':
											$att_class = 'tsmlx-secondary';
											break;
										case 'hybrid':
											$att_class = 'tsmlx-tertiary';
											break;
									}
									?>
                                    <td class="<?php echo $key ?> text-uppercase">
                                        <span class="d-inline-block text-center">
                                            <a class="text-decoration-none text-black" href="<?php echo $meeting['url'] ?>?wk=<?php echo $weeknum ?>">
                                                <?php echo tsmlxtras_get_calendardisplay($data->tsml_days[ $daynum ], $meeting[ $key ]) ?>
                                            </a>
                                            <small class="fw-bold text-uppercase <?php echo $att_class ?>">
                                                <?php echo $data->tsml_meeting_attendance_options[ $meeting['attendance_option'] ]; ?>
                                            </small>
                                        </span>
                                    </td>
									<?php
									break;
								
								default: ?>
                                    <td class="<?php echo $key ?>"><?php echo $meeting[ $key ] ?></td>
								<?php
							}
						} ?>
                    </tr>
                    <tr class="datarow" style="display: none;">
                        <td colspan="<?php echo count( $data->tsml_columns ); ?>" class="p-0">
                            <div class="mb-3 px-2-bg p-2">
                            </div>
                            <div class="row row-cols-1 row-cols-md-3 g-3 mb-3 mx-1">
								<?php if ( $meeting['attendance_option'] != 'in_person' ) { ?>
                                    <div class="col online-info">
                                        <div class="card h-100 online-info">
                                            <div class="card-header tsmlx-secondary-bg bg-opacity-10">
                                                <span class="opacity-75">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>People</title><path d="M402 168c-2.93 40.67-33.1 72-66 72s-63.12-31.32-66-72c-3-42.31 26.37-72 66-72s69 30.46 66 72z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path d="M336 304c-65.17 0-127.84 32.37-143.54 95.41-2.08 8.34 3.15 16.59 11.72 16.59h263.65c8.57 0 13.77-8.25 11.72-16.59C463.85 335.36 401.18 304 336 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/><path d="M200 185.94c-2.34 32.48-26.72 58.06-53 58.06s-50.7-25.57-53-58.06C91.61 152.15 115.34 128 147 128s55.39 24.77 53 57.94z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path d="M206 306c-18.05-8.27-37.93-11.45-59-11.45-52 0-102.1 25.85-114.65 76.2-1.65 6.66 2.53 13.25 9.37 13.25H154" fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32"/></svg>
                                                </span>
                                                <h6 class="mb-0 fw-bolder d-inline-block">Virtual Meeting Info</h6>
                                            </div>
                                            <div class="card-body">
												<?php
												if ( ! empty( $meeting['conference_url'] ) && $provider = tsml_conference_provider( $meeting['conference_url'] ) ) { ?>
                                                    <a class="tsmlx-primary fw-bolder" href="<?php echo $meeting['conference_url'] ?>" target="_blank">
                                                        <svg xmlns="http://www.w3.org/2000/svg" color="currentColor" class="ionicon me-1" viewBox="0 0 512 512">
                                                            <title>Videocam</title>
                                                            <path d="M374.79 308.78L457.5 367a16 16 0 0022.5-14.62V159.62A16 16 0 00457.5 145l-82.71 58.22A16 16 0 00368 216.3v79.4a16 16 0 006.79 13.08z"
                                                                  fill="none"
                                                                  stroke="currentColor"
                                                                  stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  stroke-width="32"/>
                                                            <path d="M268 384H84a52.15 52.15 0 01-52-52V180a52.15 52.15 0 0152-52h184.48A51.68 51.68 0 01320 179.52V332a52.15 52.15 0 01-52 52z"
                                                                  fill="none"
                                                                  stroke="currentColor"
                                                                  stroke-miterlimit="10"
                                                                  stroke-width="32"/>
                                                        </svg><?php echo $provider === TRUE ? $meeting['conference_url'] : sprintf( __( 'Join with %s', '12-step-meeting-list' ), $provider ) ?>
                                                    </a>
													
												<?php }
												if ( ! empty( $meeting['conference_phone'] ) ) { ?>
                                                    <a class="tsmlx-primary fw-bolder" href="tel:<?php echo $meeting['conference_phone'] ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon me-1" viewBox="0 0 512 512">
                                                            <title>Phone Portrait</title>
                                                            <path d="M382 0H130a18 18 0 00-18 18v476a18 18 0 0018 18h252a18 18 0 0018-18V18a18 18 0 00-18-18zM148 448V64h216v384z"
                                                                  fill="currentColor"/>
                                                        </svg><?php _e( 'Join by Phone', '12-step-meeting-list' ) ?>
                                                    </a>
													
												<?php } ?>
                                            </div>
                                        </div>
                                    </div>
								<?php } ?>
                            </div>
                        </td>
                    </tr>
				<?php } ?>
			<?php } ?>
            </tbody>
        </table>
        <!-- Mobile Table -->
        <table class="table-meetings-group table d-table d-md-none mobile-table">
            <thead>
            <tr>
                <th>Day/Time</th>
                <th>Info</th>
            </tr>
            </thead>
            <tbody>
			<?php
			// Loop through and output
			foreach ( $data->meetings as $daynum => $meetinggroup ) { ?>
				<?php
				foreach ( $meetinggroup as $meeting ) { ?>
                    <tr class="meetingrow border-bottom">
						<?php $meeting_types = tsml_format_types( $meeting['types'] ); ?>
                        <td class="tsmlx-compound text-center">
							<?php
							switch ( $meeting['attendance_option'] ) {
								case 'online':
									$att_class = 'tsmlx-primary';
									break;
								case 'in_person':
									$att_class = 'tsmlx-secondary';
									break;
								case 'hybrid':
									$att_class = 'tsmlx-tertiary';
									break;
							} ?>
                            <a class="text-black text-decoration-none" title="Click to see meeting" href="<?php echo $meeting['url'] ?>?wk=<?php echo $weeknum ?>">
	                            <?php echo tsmlxtras_get_calendardisplay($data->tsml_days[ $daynum ], $meeting[ 'time_formatted' ]) ?>
                            </a>
                            <small class="fw-bold text-uppercase <?php echo $att_class ?>">
		                        <?php echo $data->tsml_meeting_attendance_options[ $meeting['attendance_option'] ]; ?>
                            </small>
                        </td>
						<?php foreach ( $data->tsml_columns as $key => $column ) { ?>
							<?php if ( $key == 'type' ) { ?>
                                <td class="tsmlx-compound">
                                    <div class="d-block mb-2">
										<?php tsmlxtras_get_typesbadges( $meeting['types_expanded'] ) ?>
                                    </div>
									<?php if ( $meeting['attendance_option'] != 'in_person' ) { ?>
                                    <a class="tsmlx-primary text-decoration-none fw-bolder collapsed"
                                       data-bs-toggle="collapse"
                                       href="#collapse<?php echo $daynum ?><?php echo $meetingkey ?>"
                                       role="button" aria-expanded="false"
                                       aria-controls="collapse<?php echo $daynum ?><?php echo $meetingkey ?>">
                                        Virtual Meeting Info
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="ionicon right"
                                             viewBox="0 0 512 512">
                                            <title>Caret Forward</title>
                                            <path d="M190.06 414l163.12-139.78a24 24 0 000-36.44L190.06 98c-15.57-13.34-39.62-2.28-39.62 18.22v279.6c0 20.5 24.05 31.56 39.62 18.18z"/>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="ionicon down"
                                             viewBox="0 0 512 512">
                                            <title>Caret Down</title>
                                            <path d="M98 190.06l139.78 163.12a24 24 0 0036.44 0L414 190.06c13.34-15.57 2.28-39.62-18.22-39.62h-279.6c-20.5 0-31.56 24.05-18.18 39.62z"/>
                                        </svg>
                                    </a>
                                    <div id="collapse<?php echo $daynum ?><?php echo $meetingkey ?>"
                                         class="collapse mt-2 shadow-sm">
                                        <div class="card card-body">
											<?php
											if ( ! empty( $meeting['conference_url'] ) && $provider = tsml_conference_provider( $meeting['conference_url'] ) ) { ?>
                                                <a class="tsmlx-primary fw-bolder"
                                                   href="<?php echo $meeting['conference_url'] ?>"
                                                   target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         color="currentColor"
                                                         class="ionicon me-1"
                                                         viewBox="0 0 512 512">
                                                        <title>Videocam</title>
                                                        <path d="M374.79 308.78L457.5 367a16 16 0 0022.5-14.62V159.62A16 16 0 00457.5 145l-82.71 58.22A16 16 0 00368 216.3v79.4a16 16 0 006.79 13.08z"
                                                              fill="none"
                                                              stroke="currentColor"
                                                              stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              stroke-width="32"/>
                                                        <path d="M268 384H84a52.15 52.15 0 01-52-52V180a52.15 52.15 0 0152-52h184.48A51.68 51.68 0 01320 179.52V332a52.15 52.15 0 01-52 52z"
                                                              fill="none"
                                                              stroke="currentColor"
                                                              stroke-miterlimit="10"
                                                              stroke-width="32"/>
                                                    </svg><?php echo $provider === TRUE ? $meeting['conference_url'] : sprintf( __( 'Join with %s', '12-step-meeting-list' ), $provider ) ?>
                                                </a>
												<?php if ( $meeting['conference_url_notes'] ) { ?>
                                                    <small class="d-block my-3 alert border-light tsmlx-secondary-bg bg-opacity-10 shadow-sm">
														<?php echo nl2br( $meeting['conference_url_notes'] ) ?>
                                                    </small>
												<?php } ?>
											<?php }
											if ( ! empty( $meeting['conference_phone'] ) ) { ?>
                                                <a class="tsmlx-primary fw-bolder"
                                                   href="tel:<?php echo $meeting['conference_phone'] ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="ionicon me-1"
                                                         viewBox="0 0 512 512">
                                                        <title>Phone
                                                            Portrait</title>
                                                        <path d="M382 0H130a18 18 0 00-18 18v476a18 18 0 0018 18h252a18 18 0 0018-18V18a18 18 0 00-18-18zM148 448V64h216v384z"
                                                              fill="currentColor"/>
                                                    </svg><?php _e( 'Join by Phone', '12-step-meeting-list' ) ?>
                                                </a>
												<?php if ( $meeting['conference_phone_notes'] ) { ?>
                                                    <small class="d-inline-block my-3 alert border-light bg-opacity-75 shadow-sm"><?php echo nl2br( $meeting['conference_phone_notes'] ) ?></small>
												<?php } ?>
											<?php } ?>
                                        </div>
										<?php } ?>
                                </td>
								<?php }
						} ?>
                    </tr>
				<?php } ?>
			<?php } ?>
            </tbody>
        </table>
		<?php if ($data->show_footer === 1) { ?>
            <div class="clearfix container">
				<?php echo $data->notes_below; ?>
            </div>
		<?php } ?>
    </section>  <!-- /.end of section -->
</div>
