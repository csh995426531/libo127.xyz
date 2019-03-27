<!-- //footer -->
<div class="footer">
    <div class="container">
        <div class="w3_footer_grids">
            <div class="col-md-3 w3_footer_grid">
                <h3>Contact</h3>
                <ul class="address">
                    <li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i><a href="mailto:info@example.com">info@example.com</a></li>
                </ul>
            </div>
            <div class="col-md-3 w3_footer_grid">
                <h3>Information</h3>
                <ul class="info">
                    <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="about.html">About Us</a></li>
                    <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="contact.html">Contact Us</a></li>
                </ul>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>

</div>
<div class="footer-botm">
    <div class="container">
        <div class="w3layouts-foot">
            <ul>
                <li><a href="#" class="w3_agile_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#" class="agile_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="#" class="w3_agile_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
                <li><a href="#" class="w3_agile_vimeo"><i class="fa fa-vimeo" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <div class="payment-w3ls">
            <img src="images/card.png" alt=" " class="img-responsive">
        </div>
        <div class="clearfix"> </div>
    </div>
</div>
<!-- //footer -->
<!-- Bootstrap Core JavaScript -->
<!--    <script src="js/bootstrap.min.js"></script>-->

<!-- top-header and slider -->
<!-- here stars scrolling icon -->

<!-- //here ends scrolling icon -->
<!-- main slider-banner -->
<!--    <script type="text/javascript">-->
<!--        jQuery(document).ready(function(){-->
<!--            jQuery('#demo1').skdslider({'delay':5000, 'animationSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoSlide':true,'animationType':'fading'});-->
<!---->
<!--            jQuery('#responsive').change(function(){-->
<!--                $('#responsive_wrapper').width(jQuery(this).val());-->
<!--            });-->
<!---->
<!--        });-->
<!--    </script>-->
<?php
$this->registerJs(
    "
            $('document').ready(function(){   
            
                    $().UItoTop({ easingType: 'easeOutQuart' });
            
                    $('#demo1').skdslider({'delay':5000, 'animationSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoSlide':true,'animationType':'fading'});
        
                    $('#responsive').change(function(){
                        $('#responsive_wrapper').width($(this).val());
                    });
            });
            
            paypal.minicart.render({
                action: '#'
            });
    
            if (~window.location.search.indexOf('reset=true')) {
                paypal.minicart.reset();
            }
        "
);
?>
<!-- //main slider-banner -->
</body>
</html>
</div>
