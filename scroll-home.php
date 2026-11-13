<div class="section-scroll">
    <img class="image center" src="images/scroll/3.png">
    <img class="image left" src="images/scroll/1.png">
    <img class="image right" src="images/scroll/2.png" <?php if ($_SESSION['lang'] == 'en') { ?>style="transform: translateX(100%);"<?php } ?>>

</div>

<script>
    window.addEventListener('scroll', function() {
      var scrollPos = window.pageYOffset || document.documentElement.scrollTop;
      var leftImage = document.querySelector('.image.left');
      var rightImage = document.querySelector('.image.right');
      
      leftImage.style.top = -300 + (scrollPos / 8) + 'px';
      rightImage.style.top = 750 - (scrollPos / 8) + 'px';
    });
  </script>