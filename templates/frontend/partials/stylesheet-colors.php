<style>
    :root {
        --tsmlx-headers: <?php echo $data->header_color['hex'] ?>;
        --tsmlx-primary: <?php echo $data->primary_color['hex'] ?>;
        --tsmlx-secondary: <?php echo $data->secondary_color['hex'] ?>;
        --tsmlx-tertiary: <?php echo $data->tertiary_color['hex'] ?>;
        --tsmlx-headers-rgb: <?php echo implode(' ',$data->header_color['rgb']) ?>;
        --tsmlx-primary-rgb: <?php echo implode(' ',$data->primary_color['rgb']) ?>;
        --tsmlx-secondary-rgb: <?php echo implode(' ',$data->secondary_color['rgb']) ?>;
        --tsmlx-tertiary-rgb: <?php echo implode(' ',$data->tertiary_color['rgb']) ?>;
        --tsmlx-headers-hsl: <?php echo implode(' ',$data->header_color['hsl']) ?>;
        --tsmlx-primary-hsl: <?php echo implode(' ',$data->primary_color['hsl']) ?>;
        --tsmlx-secondary-hsl: <?php echo implode(' ',$data->secondary_color['hsl']) ?>;
        --tsmlx-tertiary-hsl: <?php echo implode(' ',$data->tertiary_color['hsl']) ?>;
    }
</style>
