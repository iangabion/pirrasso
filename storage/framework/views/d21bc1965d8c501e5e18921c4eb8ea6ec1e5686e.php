<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title>Buy and Sell</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
        <link rel="icon" type="image/png"  href="<?php echo e(asset('images/qonvex_buy_sell.png')); ?>">

    </head>
    <body>
        <div id="app">
            <App/>
        </div>

        <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    </body>
</html>
<?php /**PATH /var/www/html/resources/views/welcome.blade.php ENDPATH**/ ?>