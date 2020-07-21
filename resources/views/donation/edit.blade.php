@extends('layouts.master')

@section('title', 'Edit Donation')

@section('content')
    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
        <form class="form-horizontal" method="post" action="{{route('donation.update', $donation)}}">
            @method('PUT')
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                 @endif
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <fieldset>
                        <div class="card">
                            <div class="card-body">
                        <legend>Enter main details</legend>
                        <div class="form-group">
                            <label for="title" class="col-lg-2 control-label">Title</label>
                            <div class="col-lg-10">
                            <input type="text" class="form-control" id="name" name="title" value="{{old('title', $donation->title)}}">
                            </div>
                            <label for="details" class="col-lg-2 control-label">Details</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="details" name="details" value="{{old('details', $donation->details)}}">
                            </div>
                            <label for="availableDate" class="col-lg-2 control-label">Availablility </label>
                            <div class="col-lg-10">
                                <input type="Datetime-local" class="form-control" id="availableDate" name="availableDate" value="{{old('availableDate', $date)}}">
                            </div>
                        <input type="hidden" id='lat'name="lat" value="{{old('lat', $donation->location->latitude)}}" >
                        <input type="hidden" id='lng'name="lng" value="{{old('lng', $donation->location->longitude)}}">
                        <label for="address" class="col-lg-2 control-label">Address</label>
                        <div class="col-lg-10">
                        <input type="text" class="form-control" id='address'name="address" value="{{old('address', $donation->location->address)}}" readonly>
                         </div>
                    </div>
                        <div class="form-group">
                        <div class="col-lg-10" id="map"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                            <a href="{{route('donation.index')}}" class="btn btn-default">Cancel</a
                                >
                                <button type="submit" class="btn btn-primary" >Save</button>
                            </div>
                        </div>
                            </div>
                        </div>
                    </fieldset>
            </form>
        </div>
    </div>
    <script>

        var map = L.map('map').setView([1.4599, 110.4883], 12);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1Ijoia2FhazIzMiIsImEiOiJja2I2aWR2NmIxZmFvMnZwN3p4YW1oeDB1In0.mB59_cpC-awJUFDXMRYC8A'
}).addTo(map);

marker = L.marker([0,0], {draggable: true});

var search =  new L.Control.Search({
		url: 'https://nominatim.openstreetmap.org/search?format=json&q={s}',
		jsonpParam: 'json_callback',
		propertyName: 'display_name',
		propertyLoc: ['lat','lon'],
		marker: marker,
		autoCollapse: true,
		autoType: false,
        minLength: 2,
        markerLocation: true,
        
    });
//     markerP.on('click', function(ev){
//   var latlng = mymap.mouseEventToLatLng(ev.originalEvent);
//   console.log(latlng.lat + ', ' + latlng.lng);
// });
        
        // // markerP.on('move', function(e){
        //     var lat = e.latlng.lat;
        //         var lng = e.latlng.lng;
        //         console.log("Latitude : " + lat + "\nLongitude : " + lng);
        // });
 var drawnItems = new L.FeatureGroup();
var drawControlFull = new L.Control.Draw({
    edit: {
        featureGroup: drawnItems
    },
    draw: {
             polygon: false,
             circle: false,
             rectangle: false,
             polyline:false,
             circlemarker:false
    }
});


var drawControlEditOnly = new L.Control.Draw({
    edit: {
        featureGroup: drawnItems, search
    },
    draw: false
});

map.addControl(drawControlFull);
map.addControl(search);

map.addLayer(drawnItems);

map.on('draw:created', function(e) {
    var layer = e.layer;
    layer.addTo(drawnItems);
    drawnItems.addTo(map);

    drawControlFull.remove();
    drawControlEditOnly.addTo(map);
    search.remove();
});

map.on('draw:deleted', function(e) {
    drawControlEditOnly.remove();
    drawControlFull.addTo(map);
    search.addTo(map);
});

var geocodeService = L.esri.Geocoding.geocodeService(); //reverse geocoding to get the address name

search.on('search:locationfound', function(e){
    drawControlFull.remove();
    drawControlEditOnly.remove();
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;
    geocodeService.reverse().latlng(e.latlng).run(function (error, result) { //reverse geocoding to get the address name
      if (error) {
        return;
      }
      var address = result.address.Match_addr;
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
        document.getElementById('address').value = address;
        //console.log(typeof lat);
    });
});

marker.on('moveend', function(e){
    var lat = this._latlng.lat;
    var lng = this._latlng.lng;
    geocodeService.reverse().latlng(this._latlng).run(function (error, result) { //reverse geocoding to get the address name
      if (error) {
        return;
      }
      var address = result.address.Match_addr;
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
        document.getElementById('address').value = address;
    });
});

    </script>
@endsection