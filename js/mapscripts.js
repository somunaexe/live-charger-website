document.getElementById("search").addEventListener('input', showPosition);
let searchQuery = document.getElementById("search");
let map = new OpenLayers.Map("Map");//Create a map layer
let fromProjection = new OpenLayers.Projection("EPSG:4326");
let toProjection = new OpenLayers.Projection("EPSG:900913");
let vectorLayer = new OpenLayers.Layer.Vector("Overlay");
showPosition();

/**
 * destroy the popup after the close button has been clicked
 * @param feature
 */
function removePopup(feature){
    feature.popup.destroy();
    feature.popup = null;
}

/**
 * Creates popup and displays info
 * @param feature
 */
function createPopup(feature) {
    //Displays the chargers address and price, including the request link
    feature.popup = new OpenLayers.Popup.FramedCloud(
        "pop",
        feature.geometry.getBounds().getCenterLonLat(),
        null,
        '<div>' + feature.attributes.description +'</div>' +
        '<a href="request.php" target="_blank">Request</a>',
        null,
        function(){controls['selector'].unselectAll();}
    )
    map.addPopup(feature.popup);//add the popup to the map
}

// Get the user's location using the Geolocation API
function showPosition() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showCharger, showError);//Returns the latitude and longitude or an error
    } else {
        alert('Geolocation is not supported by your browser');
    }
}

/**
 * Display markers of the charge points on the maps
 * @param position
 */
function showCharger(position) {
    map.addLayer(new OpenLayers.Layer.OSM());//add the layer to the map
    let lat = position.coords.latitude;
    let lon = position.coords.longitude;
    let center = new OpenLayers.LonLat(lon, lat).transform(fromProjection, toProjection);
    map.setCenter(center, 14);//Center the map on the users current location using Geolocation API


    let search = searchQuery.value;//Points to the search query

    let xhr = new XMLHttpRequest();


    xhr.onload = function () {
        if (this.status === 200 && Object.keys(this.responseText).length >= 0) {
            let data = JSON.parse(this.responseText);//converts the JSON string to a JavaScript object
            console.log(data);
            data.forEach(createMarkers);//create markers for the chargers
        } else if (this.status === 200 && Object.keys(this.responseText).length === 0) {
            console.log("No chargers");
        }
    }

    map.addLayer(vectorLayer);//add the vector layer to the map


    let controls = {
        //controller for the popup after the marker has been clicked
        selector: new OpenLayers.Control.SelectFeature(vectorLayer, {
            onSelect: createPopup, onUnselect: removePopup})
    }
    map.addControl(controls['selector']);//add controller to the map
    controls['selector'].activate();

    xhr.open('GET', 'search.php?search=' + search, true);//Makes an asynchronous call to the search function in search.php
    xhr.send();
}

/**
 * Creates markers for each charger coordinates
 * @param item
 */
function createMarkers(item) {
    let feature = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(item._longitude, item._latitude).transform(fromProjection, toProjection),
        //set the content of the feature
        {description: item._address + "\n£" + item._price},
        {
            //change the appearance of the marker
            externalGraphic: '../images/marker.png', graphicHeight: 30, graphicWidth: 30,
            graphicXOffset: -12, graphicYOffset: -25
        }
    );
    //add the new features to the layer
    vectorLayer.addFeatures(feature);
    console.log(feature);
}

/**
 *
 * @param error
 * Handle errors when trying to get the current position
 */
function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED://runs if user did not allow access to location
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE://runs if users location is not attainable
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT://runs if request to access users location timed out
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERR://runs if an unknown error prevented location access
            alert("An unknown error occurred.");
            break;
        default:
            alert("An error occurred");
    }
}