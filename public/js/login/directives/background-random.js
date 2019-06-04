
app.directive("backgroundRandom", function() {
    return {
        restrict: "A",
        scope: "=",
        link: function() {
            var images = ['images_1.jpg', 'images_2.jpg', 'images_3.jpg', 'images_4.jpg',  'images_5.jpg',
                'images_6.jpg', 'images_7.jpg', 'images_8.jpg', 'images_9.jpg',  'images_10.jpg'];

            $("html").css({
                'background': ' #FFF url(img/banner-images/' + images[Math.floor(Math.random() * images.length)] + ') top center'
            });

        }
    }
});