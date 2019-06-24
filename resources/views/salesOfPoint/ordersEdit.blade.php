<!-- Modal add register-->
<div class="modal fullscreen-modal fade" id="modal_add_register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                <h3> Punto de Venta </h3>
            </div>
            <div class="modal-body">

                <section class="content">
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-sm-12">
                            <form class="form-horizontal">

                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#details" data-toggle="tab" aria-expanded="false">@{{ boxName }}</a></li>
                                    </ul>
                                    <div class="tab-content">

                                        <div class="tab-pane active" id="details">

                                            <div class="container">
                                                <div class="col-xs-12">
                                                    <div class="carousel slide" id="myCarousel">
                                                        <div class="carousel-inner">

                                                            <div class="item active">
                                                                <ul class="thumbnails">
                                                                    <li class="col-sm-3" ng-repeat="product in products">
                                                                        <div class="casing">
                                                                            <div class="thumbnail">
                                                                                <a href="#"><img src="http://placehold.it/360x240" alt=""></a>
                                                                            </div>
                                                                            <div class="caption">
                                                                                <h4>Item Title</h4>
                                                                                <p>Hello world, something nice to develop</p>
                                                                                <a class="btn btn-mini" href="#">» Read More</a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div><!-- /Slide1 -->

                                                            <div class="item">
                                                                <ul class="thumbnails">
                                                                    <li class="col-sm-3" ng-repeat="product in products" ng-if="index > 4 && index%4 == 0">
                                                                        <div class="casing">
                                                                            <div class="thumbnail">
                                                                                <a href="#"><img src="http://placehold.it/360x240" alt=""></a>
                                                                            </div>
                                                                            <div class="caption">
                                                                                <h4>Item Title</h4>
                                                                                <p>Hello world, something nice to develop</p>
                                                                                <a class="btn btn-mini" href="#">» Read More</a>
                                                                            </div>
                                                                        </div>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                            <!-- /Slide2 -->

                                                        </div>

                                                        <nav>
                                                            <ul class="control-box pager">
                                                                <li class="left"><a data-slide="prev" href="#myCarousel" class="arrowStil"><i class="glyphicon glyphicon-chevron-left"></i></a></li>
                                                                <li class="right"><a data-slide="next" href="#myCarousel" class="arrowStil"><i class="glyphicon glyphicon-chevron-right"></i></li>
                                                            </ul>
                                                        </nav>
                                                        <!-- /.control-box -->

                                                    </div><!-- /#myCarousel -->

                                                </div><!-- /.col-xs-12 -->

                                            </div>
                                            <!-- /.container -->


                                            {{--<div class="container">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="Carousel" class="carousel slide">

                                                            <ol class="carousel-indicators">
                                                                <li data-target="#Carousel" data-slide-to="0" class="active"></li>
                                                                <li data-target="#Carousel" data-slide-to="1"></li>
                                                                <li data-target="#Carousel" data-slide-to="2"></li>
                                                            </ol>

                                                            <!-- Carousel items -->
                                                            <div class="carousel-inner">

                                                                <div class="item active">
                                                                    <div class="row">
                                                                        <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
                                                                        <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
                                                                        <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
                                                                        <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
                                                                    </div><!--.row-->
                                                                </div><!--.item-->

                                                            </div><!--.carousel-inner-->
                                                            <a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
                                                            <a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
                                                        </div><!--.Carousel-->

                                                    </div>
                                                </div>
                                            </div>--}}<!--.container-->


                                            {{--<div class="container">
                                                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                    <!-- Wrapper for slides -->
                                                    <div class="carousel-inner">

                                                        <div class="item active" ng-repeat="product in products" ng-if="$first">
                                                                <div class="col-sm-4">
                                                                    <a href="#">
                                                                        <image-load image="product.logo"></image-load>
                                                                    </a>
                                                                    <h5 class="text-center" ng-bind="product.nombre"></h5>
                                                                    <p class="text-center">
                                                                        Precio <span class="label label-success" ng-bind="'$ '+product.total"></span>
                                                                    </p>

                                                                    <div class="row">
                                                                        <div class="col-sm-12 text-center">
                                                                            <button type="button" class="btn btn-primary btn-sm">
                                                                                <span class="glyphicon glyphicon-shopping-cart"></span> AGREGAR
                                                                            </button>
                                                                            --}}{{--<button class="btn btn-default btn-sm" id="btn2" name="btn2" value="2" type="submit"> <span class="glyphicon glyphicon-info-sign"></span> INFO</button>--}}{{--
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>

                                                        <div class="item " ng-repeat="product in products" ng-if="!$first">
                                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                                    <a href="#">
                                                                        <image-load image="product.logo"></image-load>
                                                                    </a>
                                                                    <h5 class="text-center" ng-bind="product.nombre"></h5>
                                                                    <p class="text-center">
                                                                        Precio <span class="label label-success" ng-bind="'$ '+product.total"></span>
                                                                    </p>

                                                                    <div class="row">
                                                                        <div class="col-sm-12 text-center">
                                                                            <button type="button" class="btn btn-primary btn-sm">
                                                                                <span class="glyphicon glyphicon-shopping-cart"></span> AGREGAR
                                                                            </button>
                                                                            --}}{{--<button class="btn btn-default btn-sm" id="btn2" name="btn2" value="2" type="submit"> <span class="glyphicon glyphicon-info-sign"></span> INFO</button>--}}{{--
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    </div>
                                                    <!-- Left and right controls -->
                                                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                </div>

                                            </div>--}}


                                        </div>
                                        <!-- /.tab-pane -->

                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- /.nav-tabs-custom -->

                            </form>

                        </div>
                        <!-- /.col -->
                    </div>
                </section>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    {{--<button-register method="insertRegister()" permission="permisos" spinning="spinning"></button-register>--}}
                </div>
            </div>
        </div>
    </div>
</div>