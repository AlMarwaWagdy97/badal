<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="text-center py-5 mb-0 undermenu  bg-success text-light h3 bg-battern">
    <h3 class="py-4 mt-4"> شكراً لك </h3>
</div>
<div class="bg-light">
    <div class="container text-right py-5">
        <div class="row justify-content-md-center">
            <div class="col-lg-6 py-5 text-center">
                <img src="<?php echo MEDIAURL ?>/logo.png" alt="logo" class="img-fluid p-5">
                <?php flash('msg'); ?>
                <?php if (isset($data['order']->total) && $data['order']->total > 0) { ?>
                    <p> شكراً لكم لتبرعكم بقيمة <span class="amount"> <?= $data['order']->total ?> </span> <img src="<?php echo MEDIAURL . '/rayal.png'; ?>" width="20px">+</p>
                <?php } ?>
                <?= $data['settings']['site']->thankyou; ?>
                <a class="mt-5 btn px-5 btn-primary" href="<?php echo URLROOT; ?>"><i class=" icofont-home"></i> العودة الي الرئيسية</a>

                <h3 class="d-none" id="total"><?= $data['total'] ?></h3>
            </div>
        </div>
    </div>
</div>

<?php

// $itemLayers = [];
// $total = 0;
// if ($data['donations']) {
//     foreach ($data['donations'] as $don) {
//         $itemLayers[] =  [
//             'item_id' =>  $don->project_id,
//             'item_name' =>  $don->donation_type,
//             'currency' =>  'SAR',
//             'price' =>  $don->amount,
//             'quantity' =>  $don->quantity,
//         ];
//         $total += ($don->amount * $don->quantity);
//     }
// }

// $dataLayer = [
//     'event' => 'purchase',
//     'ecommerce' => [
//         'currency' => 'SAR',
//         'paymentMethod' => $data['paymentMethod'],
//         'value' => $total,
//         'items' => $itemLayers,
//     ],
// ];

// $dataLayerValue = $total;
?>


<script>
    <?php if (isset($data['order']) && is_object($data['order']) && isset($data['order']->total) && $data['order']->total > 0 && isset($data['order']->order_id)) : ?>
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
            event: "purchase",
            transaction_id: "<?php echo htmlspecialchars($data['order']->order_id, ENT_QUOTES, 'UTF-8'); ?>",
            value: <?php echo floatval($data['order']->total); ?>,
            currency: "SAR"
        });
        console.log('DataLayer Purchase Event Pushed:', dataLayer);
    <?php endif; ?>
</script>

<script>
    <?php if (isset($data['order']) && is_object($data['order']) && isset($data['order']->total) && $data['order']->total > 0 && isset($data['order']->order_id)) : ?>
        ttq.track('Purchase', {
            value: <?php echo floatval($data['order']->total); ?>,
            currency: "SAR",
            contents: [{
                content_id: "<?php echo htmlspecialchars($data['order']->order_id, ENT_QUOTES, 'UTF-8'); ?>",
                quantity: <?php echo floatval($data['order']->quantity); ?>
            }],
            content_type: 'product'
        });
    <?php endif; ?>
</script>

<script>
    <?php if (isset($data['order']) && is_object($data['order']) && isset($data['order']->total) && $data['order']->total > 0 && isset($data['order']->order_id)) : ?>
        snaptr('track', 'PURCHASE', {
            'price': <?php echo floatval($data['order']->total); ?>,
            'currency': "SAR",
            'transaction_id': "<?php echo htmlspecialchars($data['order']->order_id, ENT_QUOTES, 'UTF-8'); ?>",
        })
    <?php endif; ?>
</script>

<?php require APPROOT . '/app/views/inc/footer.php'; ?>