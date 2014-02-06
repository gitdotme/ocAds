<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $titleLayout; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charsetLayout; ?>">
        <meta name="description" content="<?php echo $descLayout; ?>">
        <meta name="keywords" content="<?php echo makeKeywords($descLayout); ?>">
        <meta name="robots" content="<?php echo $robotsLayout; ?>">
        <base href="<?php echo baseURL(); ?>">
        <?php echo $cssLayout; ?>
        
        <?php echo $jsLayout; ?>
    </head>
    <body>
        <!-- wrap layer begin //-->
        <div id="wrap">
            <?php echo $contentLayout; ?>
            
            <!-- footer layer start //-->
            <footer id="footer">
                <p><a href="<?php echo baseURL('about_us'); ?>">About Us</a> | <a href="<?php echo baseURL('privacy_policy'); ?>">Privacy Policy</a> | <a href="<?php echo baseURL('terms_of_use'); ?>">Term of Use</a> | <a href="<?php echo baseURL('contact'); ?>">Contact</a></p>
                <p>&copy; <?php echo Config::get('siteName', 'seo'); ?> <?php echo date('Y'); ?> &middot; Powered by <a href="http://www.ocads.org" title="Free Classifieds Script">ocAds</a></p>
            </footer>
            <!-- footer layer end //-->
        </div>
        <!-- wrap layer end //-->
    </body>
</html>