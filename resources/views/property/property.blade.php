@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <main id="property" class="property">
                    <section class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-10 col-md-7">                                   
                                    <div class="title">
                                        <h1>{{ $title }}</h1>
                                        <h2 class="mega">$<?php echo number_format($property->LIST_22, 0, ".", ",") ?></h2>
                                        <h5>
                                            {{ $property->LIST_31 }} {{ $property->LIST_34 }} {{ $property->LIST_37 }} {{ $property->LIST_33 }}, {{ $property->LIST_39 }} {{ $property->LIST_40 }} {{ $property->LIST_43 }}
                                        </h5>
                                        <h5>
                                            <span>TYPE</span>&nbsp;<span><b>{{ $property->LIST_9 }}</b></span>
                                            <span>SqFt</span>&nbsp;<span><b><?php echo number_format($property->LIST_48, 0, ".", ",") ?></b></span>
                                            <span>MLS#</span>&nbsp;<span><b>{{ $property->LIST_3 }}</b></span>
                                        </h5>
                                    </div>
                                    <div class="gallery">
                                        <div id="carousel" class="carousel slide" data-ride="carousel">
                                            <div class="wrap">
                                                <div class="carousel-inner" role="listbox">
                                                    <?php echo $carousel; ?>
                                                </div>
                                                <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                                                    <div>
                                                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                                                        <span class="sr-only">Previous</span>
                                                    </div>
                                                </a>
                                                <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                                                    <div>
                                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                        <span class="sr-only">Next</span>
                                                    </div>
                                                </a>
                                                <a href="#modal" class="expand" data-toggle="modal" data-target="#modal">
                                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                                </a>
                                            </div>

                                            <ol class="carousel-indicators thumb">
                                                <?php echo $indicators ?>
                                            </ol>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modal">
                                        <div class="modal-dialog" role="document">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </button>
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div id="gallery" class="carousel slide" data-ride="carousel">
                                                        <div class="wrap">
                                                            <div class="carousel-inner" role="listbox">
                                                                <div class="carousel-item">
                                                                    <img src="http://placehold.it/760x460" data-src="http://placehold.it/760x460" alt="" class="img-responsive" >

                                                                </div>
                                                                <div class="carousel-item">
                                                                    <img src="http://placehold.it/760x460" data-src="http://placehold.it/760x460" alt="" class="img-responsive" >

                                                                </div>
                                                            </div>
                                                            <a class="left carousel-control" href="#gallery" role="button" data-slide="prev">
                                                                <div>
                                                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                                                    <span class="sr-only">Previous</span>
                                                                </div>
                                                            </a>
                                                            <a class="right carousel-control" href="#gallery" role="button" data-slide="next">
                                                                <div>
                                                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                                    <span class="sr-only">Next</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <ol class="carousel-indicators">

                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="description"><h2>Property Details</h2>
                                        <table class="table">
                                            <tbody>
                                                <tr><td>Status</td><td><b>{{ $property->LIST_15 }}</b></td><td> | On the market since: </td><td><b>{{ $property->LIST_16 }}</b></td></tr>
                                            </tbody>
                                        </table>
                                        {{ $property->LIST_78 }} <br>
                                        {{ $property->GF20121210032127871857000000 }} <br>
                                        {{ $property->GF20121210032143719113000000 }}

                                    </div>
                                    <div class="highlights">
                                        <h2>Property Highlights</h2>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Price</td>
                                                    <td><b>$<?php echo number_format($property->LIST_22, 0, ".", ",") ?><br></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Type</td>
                                                    <td><b>{{ $property->LIST_9 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Subdivision</td>
                                                    <td><b>{{ $property->LIST_77 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Building Size</td>
                                                    <td><b><?php echo number_format($property->LIST_48, 0, ".", ",") ?> Sqft</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Price/SF</td>
                                                    <td><b>${{ $property->LIST_125 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Land/Lot SqFt</td>
                                                    <td><b>{{ $property->LIST_56 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Waterefront</td>
                                                    <td><b>{{ $property->GF20121206202937679400000000 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>County</td>
                                                    <td><b>{{ $property->LIST_41 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Taxes</td>
                                                    <td><b>${{ $property->LIST_74 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Tax Year</td>
                                                    <td><b>{{ $property->LIST_76 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Miles to the Expressway</td>
                                                    <td><b>{{ $property->FEAT20121228141956418528000000 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Miles to the Beach</td>
                                                    <td><b>{{ $property->FEAT20121228141945056231000000 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Commision Description</td>
                                                    <td><b>{{ $property->GF20121210032303651504000000 }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="highlights">
                                        <h2>Building Information</h2>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Building Description</td>
                                                    <td><b>{{ $property->GF20121210031859306151000000 }} </b></td>
                                                </tr>
                                                <tr>
                                                    <td>Zoning</td>
                                                    <td><b>{{ $property->LIST_74 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of Stories</td>
                                                    <td><b>{{ $property->LIST_64 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of Units</td>
                                                    <td><b>{{ $property->LIST_65 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Available for Lease</td>
                                                    <td><b>{{ $property->LIST_112 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Building Size Source</td>
                                                    <td><b>{{ $property->LIST_97 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Year Built</td>
                                                    <td><b>{{ $property->LIST_53 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of Offices</td>
                                                    <td><b>{{ $property->FEAT20121228141330591036000000 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Interior Ceiling Height</td>
                                                    <td><b>{{ $property->FEAT20121228141522363023000000 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Building Capacity</td>
                                                    <td><b>{{ $property->FEAT20121228141538045232000000 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of Current Tenants</td>
                                                    <td><b>{{ $property->FEAT20130102140646336002000000 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of Available Bays</td>
                                                    <td><b>{{ $property->FEAT20121228141707970724000000 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Bay Door Height</td>
                                                    <td><b>{{ $property->FEAT20121228141728638669000000 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of Loading Docks</td>
                                                    <td><b>{{ $property->FEAT20121228141754532717000000 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Available Documents</td>
                                                    <td><b>{{ $property->GF20121210032110757551000000 }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Available Information</td>
                                                    <td><b>{{ $property->GF20121210032048203667000000 }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="highlights">
                                        <h2>Building Features</h2>
                                        <table class="table">
                                            <tbody>
                                            <td>Location</td>
                                            <td><b>{{ $property->GF20121210032004030746000000 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Construction</td>
                                                <td><b>{{ $property->GF20121206202935157741000000 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Cooling</td>
                                                <td><b>{{ $property->GF20121206202935069920000000 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>% Air Conditioned</td>
                                                <td><b>{{ $property->LIST_51 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Heating</td>
                                                <td><b>{{ $property->GF20121206202935801841000000 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Roof</td>
                                                <td><b>{{ $property->GF20121206202936671897000000 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Ceiling</td>
                                                <td><b>{{ $property->GF20121210032303651504000000 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Flooring</td>
                                                <td><b>{{ $property->GF20121206202935671233000000 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Fire Protect</td>
                                                <td><b>{{ $property->GF20121210032202398521000000 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Security</td>
                                                <td><b>{{ $property->GF20121206202936970585000000 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Sales Include</td>
                                                <td><b>{{ $property->GF20121210032031601627000000 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Utilities</td>
                                                <td><b>{{ $property->GF20121206202937541928000000 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Maintenance Fee Includes</td>
                                                <td><b>{{ $property->GF20121206202936296956000000 }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Special Information</td>
                                                <td><b>{{ $property->GF20121210032127871857000000 }}, {{ $property->GF20121210032143719113000000 }}</b></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-7">
                                    <!--aside-->
                                    <div class="widget">
                                        <div class="col-lg-3">
                                            <a href="#" download title="Print Property Listing from Waltz Realty">
                                                Print
                                                <i class="fa fa-print" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="col-lg-3">
                                            <a href="#" title="Share Property Listing For Waltz Realty">
                                                Share
                                                <i class="fa fa-share-alt" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="col-lg-6">
                                            Back Button HERE
                                        </div>
                                    </div>
                                    <div class="brochure">
                                        <a href="{{ $property->UNBRANDEDIDXVIRTUALTOUR }}" class="btn btn-blue-inv btn-full" target="_blank" download>
                                            Vitural Tour
                                        </a>
                                    </div>

                                    <div id="map"></div>

                                    <center><p>This property is in the neighborhood of <br>
                                            {{ $property->LIST_77 }} in {{ $property->LIST_39 }}</p></center>
                                    <!--/aside-->
                                </div>
                            </div>
                        </div>
                        <hr/>
                    </section>
                    <?php //echo '<pre>';print_r($similar);echo '</pre>' ?>
                    @if(count($similar['listings']) > 0)
                    <section class="getProperties">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1>Similar Properties</h1>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                   
                                    @foreach ($similar['listings'] as $property)
                                        <div class="item">
                                            <div class="col-lg-4 col-sm-6">
                                                <article class="getProperty">
                                                    <div class="wrap">
                                                        <div>
                                                            <a href="properties/id/{{ $property->id }}" class="wrap-img"><img src="{{ $property->photo }}" class="crop responsive" style="width:100%;height:auto;overflow:hidden;max-height: 200px"></a>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12" style="text-align: center">
                                                                <a href="properties/id/{{ $property->id }}" >
                                                                    <h5>{{ $property->LIST_31 }} {{ $property->LIST_34 }} {{ $property->LIST_37 }} {{ $property->LIST_33 }}, <br> 
                                                                        {{ $property->LIST_39 }} {{ $property->LIST_40 }} {{ $property->LIST_43 }}</h5>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4" style="text-align: center">{{ $property->LIST_48 }} SqFt</div>
                                                            <div class="col-md-4" style="text-align: center"></div>
                                                            <div class="col-md-4" style="text-align: left"><b>$ {{ $property->LIST_22 }}</b></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12" style="text-align: center">{{ $property->LIST_9 }}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12" style="text-align: left;">
                                                                {{ $property->LIST_78 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div> 
                                        </div>
                                    @endforeach
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    @endif
                </main>
            </div>
        </div>
    </div>
</div>


<script>
    function initMap() {
    var myLatLng = {lat: {{ $property-> LIST_46 }}, lng: {{ $property-> LIST_47 }} };
            var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
                    center: myLatLng
            });
            var marker = new google.maps.Marker({
            position: myLatLng,
                    map: map,
                    title: '{{ $property->LIST_31 }} {{ $property->LIST_34 }}, {{ $property->LIST_39 }}'
            });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzrxDrQpY4EEBfI4bmy7LK62KlWoxwgm8&callback=initMap"
async defer></script>
<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 400px;
        width: 650px;
    }

</style>
@endsection
