<!DOCTYPE html>
<html class="gr__bootswatch_com" lang="en"><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>PhotoShare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="{{ asset('https://fathomless-beach-12687.herokuapp.com/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('https://fathomless-beach-12687.herokuapp.com/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('https://fathomless-beach-12687.herokuapp.com/css/custom.css') }}">

    <script src="{{ asset('https://fathomless-beach-12687.herokuapp.com/jquery-1.js') }}"></script>

</head>
<body data-gr-c-s-loaded="true">
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="https://bootswatch.com/" class="navbar-brand">PhotoShare</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="search">Search</a></li>
                {{--<li>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</li>--}}
                <li><a href="login.html" target="">Login</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="col-md-3">
    </div>
    <div class="col-md-6" style="top: 50px;">
        <div class="row">
            <div class="well">
                <form class="form-horizontal" method="POST" action="postPhoto" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <fieldset>
                        <legend>Upload</legend>
                        <div class="form-group">
                            <label for="image" class="col-lg-2 control-label">Image</label>
                            <div class="col-lg-10">
                                <input class="btn btn-default" type="file" onchange="readURL(this);" id="image" name="image" required>
                                <img id="blah" src="#" alt=" " class="col-md-12"/>
                            </div>
                        </div>



                        <script type="text/javascript">
                            //preview upload
                            function readURL(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function (e) {
                                        $('#blah').attr('src', e.target.result);
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                        </script>

                        <div class="form-group">
                            <label for="autocomplete" class="col-lg-2 control-label">Location</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="autocomplete" placeholder="Location"
                                       onFocus="geolocate()" type="text" name="location">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-lg-2 control-label">Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="description" placeholder="Description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>


    <div class="col-md-3">
    </div>
</div>

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
<script>/* <![CDATA[ */(function(d,s,a,i,j,r,l,m,t){try{l=d.getElementsByTagName('a');t=d.createElement('textarea');for(i=0;l.length-i;i++){try{a=l[i].href;s=a.indexOf('/cdn-cgi/l/email-protection');m=a.length;if(a&&s>-1&&m>28){j=28+s;s='';if(j<m){r='0x'+a.substr(j,2)|0;for(j+=2;j<m&&a.charAt(j)!='X';j+=2)s+='%'+('0'+('0x'+a.substr(j,2)^r).toString(16)).slice(-2);j++;s=decodeURIComponent(s)+a.substr(j,m-j)}t.innerHTML=s.replace(/</g,'&lt;').replace(/\>/g,'&gt;');l[i].href='mailto:'+t.value}}catch(e){}}}catch(e){}})(document);/* ]]> */</script>

</body></html>