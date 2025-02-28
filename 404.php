<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<section class="section-hero section-shaped my-0">
    <div class="shape shape-style-1 shape-background">
        <!-- The following spans create the background shape -->
        <span class="span-150"></span>
        <span class="span-50"></span>
        <span class="span-50"></span>
        <span class="span-75"></span>
        <span class="span-100"></span>
        <span class="span-75"></span>
        <span class="span-50"></span>
        <span class="span-100"></span>
        <span class="span-50"></span>
        <span class="span-100"></span>
    </div>
    <div class="container shape-container d-flex align-items-center">
        <div class="col px-0">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 text-center pt-lg">
                    <!-- Large error number -->
                    <h1 class="display-1 text-white shake-slow shake-constant" style="font-size: 12rem;">404</h1>
                    <!-- Explanation text -->
                    <p class="lead mt-4 mb-5 text-black"><b>Context Not Found</b></p>
                    <div class="btn-wrapper">
                        <!-- Buttons or links can be added here -->
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-around stars-and-coded">
                <div class="col-sm-4"></div>
                <div class="col-sm-4 mt-4 mt-sm-0 text-right">
                    <!-- Additional content can be placed here -->
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->need('footer.php'); ?>
