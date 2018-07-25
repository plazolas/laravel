@extends('layouts.app')

@section('content')
<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<div class="container-fluid">
    <div class="row">
        <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        <div>
            <?php if (0) {
                echo (isset($data['debug'])) ? $data['debug'] : 'no debug';
            } ?>
        </div>
        <form action="{{ url('properties') }}" method="POST">
            {{ csrf_field() }}
            <div class="col col-lg-3 col-md-4">
                <div class="wrap search priceRange">
                    <div class="col-md-12"><h4>Price Range</h4></div>
                    <div class="col-md-12">
                        From: <p id="amount"></p>
                    </div>
                    <div class="wrap-tool col-md-12">
                        <div id="my-slider-range"></div>
                        <input type="hidden" id="amount1" name="amount1" value="{{ $data['my_min_price']}}">
                        <input type="hidden" id="amount2" name="amount2" value="{{ $data['my_max_price']}}">
                    </div>
                </div>
            </div>
            <div class="col col-lg-3 col-md-4">
                <div class="wrap search property-type">
                    <h4>Property Types</h4>
                    <select id="prop-type" name="type" class="select">
                         <option class="select" value="0" <?php if (request()->input('type') == '0') {
                echo "selected='selected'";
            } ?>>All</option>
                        <option class="select" value="Residential" <?php if (request()->input('type') == 'Residential') {
                echo "selected='selected'";
            } ?>>Residential</option>
                        <option class="select" value="Industrial" <?php if (request()->input('type') == 'Industrial') {
                echo "selected='selected'";
            } ?>>Industrial</option>
                        <option class="select" value="Office" <?php if (request()->input('type') == 'Office') {
                echo "selected='selected'";
            } ?>>Office</option>
                        <option class="select" value="Hospitality" <?php if (request()->input('type') == 'Hospitality') {
                echo "selected='selected'";
            } ?>>Hospitality/Hotel/Motel</option>
                        <option class="select" value="Special Use" <?php if (request()->input('type') == 'Special Use') {
                echo "selected='selected'";
            } ?>>Special Use</option>
                        <option class="select" value="MultiFamily" <?php if (request()->input('type') == 'MultiFamily') {
                echo "selected='selected'";
            } ?>>MultiFamily</option>
                        <option class="select" value="Industrial Land" <?php if (request()->input('type') == 'Industrial Land') {
                echo "selected='selected'";
            } ?>>Industrial Land</option>
                        <option class="select" value="Restaurant - Bar" <?php if (request()->input('type') == 'Restaurant - Bar') {
                echo "selected='selected'";
            } ?>>Restaurant - Bar</option>
                    </select>
                </div>
                <div class="wrap search neighborhood">
                    <h4>Neighborhood</h4>
                    <input type="text" name="subdivision" label="Neighborhood" value="{{ request()->input('subdivision') }}"/>
                </div>
            </div>
            <div class="col col-lg-3 col-md-4">
                <div class="wrap search neighborhood">
                    <h4>County</h4>
                    <select id="county" name="county" class="select">
                        <option class="select" value="0">All</option>
                        @foreach ($data['counties'] as $county)
                        <option class="select" value="{{ $county }}" <?php if (request()->input('county') == $county) {
                echo "selected='selected'";
            } ?>>{{ $county }}</option>
                        @endforeach 
                    </select>
                </div>
                <div class="wrap search neighborhood">
                    <h4>City</h4>
                    <select id="city" name="city" class="select">
                        <option class="select" value="0">All</option>
                        @foreach ($data['cities'] as $city)
                        <option class="select" value="{{ $city }}" <?php if (request()->input('city') == $city) {
                echo "selected='selected'";
            } ?>>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col col-lg-3 col-md-12">
                <div class="wrap search submit">
                    <div class="wrap-tool">
                        <button type="submit" class="btn btn-red btn-full" name="search">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            SEE ALL <?php echo (request()->has('type') && request()->type != '0') ? strtoupper(request()->type) : '' ?> <span id="number">{{ $data['paginated']->total() }}</span> PROPERTIES
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <!-- Properties Listing -->
        @if (count($data['listings']) > 0)
        <div class="panel panel-default">

            <div class="panel-body">
                <div class="container">
                    <div class="panel-heading text-center">
                        <h1>Property Listings</h1>
                        <div class="sort">
                            <button data-toggle="collapse" data-target="#sort" aria-expanded="false" aria-controls="sort" class="">
                                Sort By &nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i>
                            </button>
                            <div class="collapse" id="sort">
                                <ul>
                                    <li>
                                        <a href="{{ url('properties/') }}?sortby=priceASC&<?php echo http_build_query(request()->except(['sortby'])); ?>"    
                                        <?php echo (request()->input('sortby') == 'priceASC') ? ' class="active"' : ''; ?>>
                                            <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
                                            Price: Lowest to Highest
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('properties/') }}?sortby=priceDESC&<?php echo http_build_query(request()->except(['sortby', 'page'])); ?>"    
                                        <?php echo (request()->input('sortby') == 'priceDESC') ? ' class="active"' : ''; ?>>
                                            <i class="fa fa-long-arrow-down" aria-hidden="true"></i>
                                            Price: Highest to Lowest
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('properties/') }}?sortby=sqftASC&<?php echo http_build_query(request()->except(['sortby', 'page'])); ?>"   
                                        <?php echo (request()->input('sortby') == 'sqftASC') ? ' class="active"' : ''; ?>>
                                            <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
                                            SqFt: Lowest to Highest
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('properties/') }}?sortby=sqftDESC&<?php echo http_build_query(request()->except(['sortby', 'page'])); ?>"   
                                    <?php echo (request()->input('sortby') == 'sqftDESC') ? ' class="active"' : ''; ?>>
                                            <i class="fa fa-long-arrow-down" aria-hidden="true"></i>
                                            SqFt: Highest to Lowest
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('properties/') }}?sortby=cityASC&<?php echo http_build_query(request()->except(['sortby', 'page'])); ?>"  
                                    <?php echo (request()->input('sortby') == 'cityASC') ? ' class="active"' : ''; ?>>
                                            <i class="fa fa-map" aria-hidden="true"></i>
                                            City: A to Z
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('properties/') }}?sortby=cityDESC&<?php echo http_build_query(request()->except(['sortby', 'page'])); ?>"   
                                    <?php echo (request()->input('sortby') == 'cityDESC') ? ' class="active"' : ''; ?>>
                                            <i class="fa fa-map" aria-hidden="true"></i>
                                            City: Z to A
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="text-right">Showing {{ $data['paginated']->firstItem() }} - {{ $data['paginated']->lastItem() }} of <span id="current-max-properties"> 
                            {{ $data['paginated']->total() }}</span>
                    </div>
                    <div class="row">{{ $data['paginated']->appends(request()->all())->links() }}</div>
                    <br>

                    @foreach ($data['listings'] as $property)
                    @if ($property->header)
                    <div class="row"><div class="item">
                            @endif
                            <div class="col-lg-4 col-sm-6">
                                <article class="getProperty">
                                    <div class="wrap">
                                        <div>
                                            <a id="property-image-link-{{ $property->id }}" href="properties/id/{{ $property->id }}" class="wrap-img"><img src="{{ $property->photo }}" class="crop responsive" style="width:100%;height:200px;overflow:hidden;max-height: 200px"></a>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="text-align: center">
                                                <a id="property-link-{{ $property->id }}" href="properties/id/{{ $property->id }}" >
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
                                            <div class="col-md-12" style="text-align: center"><b>{{ $property->LIST_9 }}</b></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="text-align: left;">
                                                {{ $property->LIST_78 }}
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div> 
                            @if ($property->footer)
                        </div></div>
                    @endif
                    @endforeach
                    {{ $data['paginated']->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<script>
        $(function () {
        $("#my-slider-range").slider({
        range: true,
                min: 0,
                max: {{ $data['max_price'] }},
                values: [{{ $data['my_min_price'] }}, {{ $data['my_max_price'] }}],
                step: 100000,
                slide: function (event, ui) {
                $("#amount").html("$" + useLetters($("#amount1").val()) + " - $" + useLetters($("#amount2").val()));
                        $("#amount1").val(ui.values[ 0 ]);
                        $("#amount2").val(ui.values[ 1 ]);
                }
        });
                $("#amount").html("$" + $("#my-slider-range").slider("values", 0) + " - $" + $("#my-slider-range").slider("values", 1));
        });
        $(function () {
        $("#amount").html("$" + useLetters($("#amount1").val()) + " - $" + useLetters($("#amount2").val()));
                });
        function addCommas(nStr){
        nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
                }
function useLetters(amount){
if (amount == 0){
return 0;
}
if ((amount / 1000000) >= 1) {
return (amount / 1000000) + "M";
} else if (amount / 1000 > 1) {
return (amount / 1000) + "K";
} else {
return amount;
}
}
$(document).ready(function(){
var current_city = $('#city').find(':selected').val();
        var current_county = $('#county').find(':selected').val();
        $('#county').change(function(){
let county = $(this).find(':selected').val();
        console.log(county);
        loadCities(county)
})
        if (current_city != "0" && current_county == "0"){
selectCounty(current_city);
}
});
        function loadCities(county){
        $.ajax({
        type: "POST",
                url: "/laravel/public/ajax/get_cities_by_county",
                data: "county=" + county
        }).done(function(result) {
        $("#city").empty().append($('<option>', {value: "0", text: "All"}));
                $.each(JSON.parse(result), function(index, city){
                $("#city").append($('<option>', {
                value: city,
                        text:  city,
                }));
                })
        });
                }
function selectCounty(city){
$.ajax({
type: "POST",
        url: "/ajax/get_county",
        data: "city=" + city
}).done(function(result) {
$('#county').val(result);
});
        }
</script>
@endsection
