<div class="blue-ribbon portfolio-ribbon category">
    <h1 class="clients-title">
        <?php if ( is_day() ) : ?>
            <?php printf( __( 'Currently viewing posts from: %s', '' ), '<span>' . get_the_date() . '</span>' ); ?>
        <?php elseif ( is_month() ) : ?>
            <?php printf( __( 'Currently viewing posts from: %s', '' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', '' ) ) . '</span>' ); ?>
        <?php elseif ( is_year() ) : ?>
            <?php printf( __( 'Currently viewing posts from: %s', '' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', '' ) ) . '</span>' ); ?>
        <?php else : ?>
            <?php _e( 'Archives', '' ); ?>
        <?php endif; ?>
    </h1>
</div>



<div class="mobile-title">
    <h1>
        <?php if ( is_day() ) : ?>
            <?php printf( __( 'Currently viewing posts from: %s', '' ), '<span>' . get_the_date() . '</span>' ); ?>
        <?php elseif ( is_month() ) : ?>
            <?php printf( __( 'Currently viewing posts from: %s', '' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', '' ) ) . '</span>' ); ?>
        <?php elseif ( is_year() ) : ?>
            <?php printf( __( 'Currently viewing posts from: %s', '' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', '' ) ) . '</span>' ); ?>
        <?php else : ?>
            <?php _e( 'Archives', '' ); ?>
        <?php endif; ?>
    </h1>
</div>