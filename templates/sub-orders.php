<?php
/**
 * Dokan Sub Order Templates
 *
 * @since 2.4
 *
 * @package dokan
 */
?>

<header>
    <h2><?php _e( 'Sub Orders', 'dokan-lite' ); ?></h2>
</header>

<div class="dokan-info">
    <strong><?php _e( 'Note:', 'dokan-lite' ); ?></strong>
    <?php _e( 'This order has products from multiple vendors. So we divided this order into multiple vendor orders.
    Each order will be handled by their respective vendor independently.', 'dokan-lite' ); ?>
</div>

<table class="shop_table my_account_orders table table-striped">

    <thead>
        <tr>
            <th class="order-number"><span class="nobr"><?php _e( 'Order', 'dokan-lite' ); ?></span></th>
            <th class="order-date"><span class="nobr"><?php _e( 'Date', 'dokan-lite' ); ?></span></th>
            <th class="order-status"><span class="nobr"><?php _e( 'Status', 'dokan-lite' ); ?></span></th>
            <th class="order-total"><span class="nobr"><?php _e( 'Total', 'dokan-lite' ); ?></span></th>
            <th class="order-actions">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($sub_orders as $order_post) {
        $order      = new WC_Order( $order_post->ID );
        $item_count = $order->get_item_count();
        ?>
            <tr class="order">
                <td class="order-number">
                    <a href="<?php echo $order->get_view_order_url(); ?>">
                        <?php echo $order->get_order_number(); ?>
                    </a>
                </td>
                <td class="order-date">
                    <time datetime="<?php echo date('Y-m-d', strtotime( dokan_cmp_get_date_created( $order ) ) ); ?>" title="<?php echo esc_attr( strtotime( dokan_cmp_get_date_created( $order ) ) ); ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( dokan_cmp_get_date_created( $order ) ) ); ?></time>
                </td>
                <td class="order-status" style="text-align:left; white-space:nowrap;">
                    <?php echo isset( $statuses[dokan_cmp_get_prop( $order, 'status' )] ) ? $statuses[dokan_cmp_get_prop( $order, 'status' )] : dokan_cmp_get_prop( $order, 'status' ); ?>
                </td>
                <td class="order-total">
                    <?php echo sprintf( _n( '%s for %s item', '%s for %s items', $item_count, 'dokan-lite' ), $order->get_formatted_order_total(), $item_count ); ?>
                </td>
                <td class="order-actions">
                    <?php
                        $actions = array();

                        $actions['view'] = array(
                            'url'  => $order->get_view_order_url(),
                            'name' => __( 'View', 'dokan-lite' )
                        );

                        $actions = apply_filters( 'dokan_my_account_my_sub_orders_actions', $actions, $order );

                        foreach( $actions as $key => $action ) {
                            echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
                        }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
