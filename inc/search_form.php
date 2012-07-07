<?php
if(!defined('GRAND_ACCESS') || GRAND_ACCESS != 1) {
    exit('__Restricted Area__');
}

// Form data.
$form_data = array();
if(isset($_GET)) {
    $form_data = $_GET;
}
?>
<div class="container_12">
    <div class="grid_12">
        <div class="box">
            <h1>Youtube Search via Zend Data</h1>
            <form action="" method="get" class="search_form">
                <?php $value = (isset($form_data['keywords'])) ? $form_data['keywords'] : null; ?>
                <input type="text" name="keywords" id="keywords" class="long tb" value="<?php echo $value; ?>" />
                <input type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>
