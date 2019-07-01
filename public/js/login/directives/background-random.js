
app.directive("backgroundRandom", function() {
    return {
        restrict: "A",
        scope: "=",
        link: function() {
            var images = ['images_1.jpg', 'images_2.jpg', 'images_3.jpg', 'images_4.jpg',  'images_5.jpg',
                'images_6.jpg', 'images_7.jpg', 'images_8.jpg', 'images_9.jpg',  'images_10.jpg','images_11.jpg',
                'images_12.jpg', 'images_13.jpg','images_14.jpg','images_15.jpg','images_16.jpg','images_17.jpg',
                'images_18.jpg','images_19.jpg','images_20.jpg'];

            setInterval(function () {
                $("html").css({
                    'background': ' #FFF url(img/banner-images/' + images[Math.floor(Math.random() * images.length)] + ') top center'
                });
            },10000);

        }
    }
});

app.directive("watchPassword", function() {
    return {
        restrict: "A",
        scope: "=",
        link: function(scope,element) {
            var eyeIcon = $("#eyeIcon");
            eyeIcon.show();
            eyeIcon.mouseover(function() {
                element.attr("type","text");
            });
            eyeIcon.mouseout(function() {
                element.attr("type","password");
            });
        }
    }
});