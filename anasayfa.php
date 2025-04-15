<?php
    $sliders = $database->select("* FROM sliders ORDER BY created_at DESC");
?>
<main class="container row" style="margin-left: auto; margin-right: auto;">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <div id="slider-div" style="max-width: 1440px; margin-left: auto; margin-right: auto;">
        <swiper-container
        style="width: 100%;"
        class="container">
            <?php
            foreach ($sliders as $slider) {
                echo '<swiper-slide>';
                echo '    <div class="slider-image">';
                echo '        <img src="' . $slider['resim_yolu'] . '">';
                echo '    </div>';
                echo '    <div class="slider-text">';
                echo '        <h2>' . $slider['baslik'] . '</h2>';
                echo '        <p>' . $slider['aciklama'] . '</p>';
                echo '    </div>';
                echo '</swiper-slide>';
            }
            ?>
        </swiper-container>
    </div>
</main>
<script>
    function showSwiperPagination() {
        if (window.matchMedia("(min-width: 1200px)").matches) {
            return true;
        } else {
            return false;
        }
    };
    
    const swiper = document.querySelector("swiper-container");
    
    $(document).ready(function () {
        swiper.setAttribute("navigation", showSwiperPagination());
    });
    
    $(window).resize(function () {
        swiper.setAttribute("navigation", showSwiperPagination());
    });
</script>