<?php
/**
 * Address template
 */

?>
<div class="tsmlx-address lh-sm mb-3">
    <div>
        <span>
            <div><strong><?php echo $data->loc ?></strong></div>
            <div>
                <?php echo $data->line1 ?>
                <?php echo property_exists($data, 'line2') ? $data->line2 : '' ?>
            </div>
        </span>
    </div>
    <div class="mb-2">
        <span><?php echo $data->city ?></span>,
        <span><?php echo $data->state ?></span>
        <span><?php echo $data->zip ?></span>
    </div>
    <small><?php echo $data->location_notes ?></small>
</div>

