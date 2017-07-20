<!DOCTYPE html>
<html class="gr__bootswatch_com" lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>PhotoShare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="{{ asset('https://fathomless-beach-12687.herokuapp.com/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('https://fathomless-beach-12687.herokuapp.com/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('https://fathomless-beach-12687.herokuapp.com/css/custom.css') }}">

    <script src="{{ asset('https://fathomless-beach-12687.herokuapp.com/jquery-1.js') }}"></script>
     </head>
  <body data-gr-c-s-loaded="true">
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="search" class="navbar-brand">PhotoShare</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav navbar-right">
            {{--<li><a>{{Auth::user()->name or "Guest"}}</a></li>--}}
            <li><a>@if(!empty(Auth::user()->name)){{Auth::user()->name}} @else Guest @endif </a></li>
            <li> @if(!empty(Auth::user()->id))<a href="upload"> Upload </a> @else <a href="register"> Register </a> @endif </li>
            <li> @if(!empty(Auth::user()->id))<a href="upload"></a> @else <a href="register"> Login </a> @endif </li>

          </ul>
        </div>
      </div>
    </div>
    <div class="container">
<style>
    #autocomplete{ width:80%;}
    .btn{width:15%;}
</style>
<div class="col-md-12" style="top: 60px;">
    <div class="well ">
    <h4>Search For a location</h4>
    <form class="form-inline" action="search" method="post">
        {{csrf_field()}}
        <div class="col-md-1">
        </div>
        <div class="form-group col-md-9">
            <label for="autocomplete">Search:</label>
            <input class="form-control" id="autocomplete" placeholder="Enter your address" name="search" onFocus="geolocate()" type="text">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
        <div class="col-md-1">
        </div>
    </form>
    </div>
</div>
 </div>

    @if(!empty($result))
    <div class="container" style="margin-top: 30px;">
        @foreach($result as $results)
            <div class="well">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{$results-> photo}}" style="max-width: 350px !important; min-height: 200px;">
                    </div>
                    <div class="col-md-6">
                        <h2><i class="fa fa-map-marker" aria-hidden="true"></i> {{$results-> location}}</h2>
                        <h6>Taken on: {{$results-> created_at}}</h6>
                        <h4>{{$results-> description}}</h4>
                    </div>
                    <div class="col-md-2">
                        <a style="height: 43px; width: 85px;" href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal{{$results-> id}}"><i class="fa fa-eye fa-2x"></i></a>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div id="myModal{{$results-> id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{$results-> location}}</h4>
                        </div>
                        <div class="modal-body">
                            <center><img src="{{$results-> photo}}" style="max-width: 6000px; max-height: 400px;"></center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
    @endif


    <script>
        // This example displays an address form, using the autocomplete feature
        // of the Google Places API to help users fill in the information.

        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

        var placeSearch, autocomplete;
        var componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'short_name',
            country: 'long_name',
            postal_code: 'short_name'
        };

        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                {types: ['geocode']});

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();

            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

            // Get each component of the address from the place details
            // and fill the corresponding field on the form.
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
        }

        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }
    </script>

    <script src="{{ asset('https://fathomless-beach-12687.herokuapp.com/bootstrap.js') }}"></script>
    <script src="{{ asset('https://fathomless-beach-12687.herokuapp.com/custom.js') }}"></script>
    <script src="<?php echo asset('https://maps.googleapis.com/maps/api/js?key=AIzaSyBC_xXN_75YcrCvqzBuY3eYHL0DOdI53zQ &libraries=places&callback=initAutocomplete') ?>"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBC_xXN_75YcrCvqzBuY3eYHL0DOdI53zQ &libraries=places&callback=initAutocomplete"
            async defer></script>


</body></html>