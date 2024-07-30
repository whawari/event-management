<?php
require_once __DIR__ . "/../config/root-directory.php";

$githubIcon = file_get_contents(__DIR__ . "/../public/images/icons/github.svg");
$linkedinIcon = file_get_contents(__DIR__ . "/../public/images/icons/linkedin.svg");
?>

<link rel="stylesheet" href="<?php echo $rootDirectory . 'public/css/footer.css' ?>">

<footer class="footer">
    <div class="container">
        <div class="footer__content">
            <div class="footer__dev">
                <h5 class="text--light">Developed by</h5>

                <p class="text--light">Walid Hawari</p>
            </div>

            <div class="footer__contact">
                <h5 class="text--light">Contact</h5>

                <a href="mailto:walidhawari95@gmail.com" class="link link--accent">
                    Walidhawari95@gmail.com
                </a>
            </div>

            <div class="footer__social">
                <h5 class="text--light">Follow me on</h5>

                <div class="footer__social__box">
                    <a href='https://github.com/whawari' target="_blank" rel="no-referrer" type='button' class='icon-button icon-button--light icon-button--ml-minus8' title='Github'>
                        <i class='icon-button__icon'><?php echo $githubIcon; ?></i>
                    </a>

                    <a href='https://www.linkedin.com/in/walid-hawari/' target="_blank" rel="no-referrer" type='button' class='icon-button icon-button--light' title='LinkedIn'>
                        <i class='icon-button__icon'><?php echo $linkedinIcon; ?></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>