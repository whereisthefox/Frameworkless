var map = new mapboxgl.Map({
    container: 'map', // container id
    style: 'mapbox://styles/mapbox/satellite-v9', //hosted style id
    center: [-77.38, 39], // starting position
    zoom: 6 // starting zoom
});

// Create a popup, but don't add it to the map yet.
var popup = new mapboxgl.Popup({
    closeButton: true
});

var uniqueSpecies = []; // Holds visible location features for filtering
var filterEl = document.getElementById('feature-filter');
var listingEl = document.getElementById('feature-listing');
var fromEl = document.getElementById('from-filter');
var toEl = document.getElementById('to-filter');
var exportBtn = document.getElementById('export-button');
var mapContainer = document.getElementById('map');

// Set map height to window height
mapContainer.style.height = ((window.innerHeight-96) + "px");

exportBtn.onclick = function exportBtn(exportBtn) {
    $.ajax({
         url: "/export",
         type: "GET",
         data: {uniqueFeatures},
         cache: false,
         success: function (response) {
             console.log(response)
             //$('#thenode').html(response);
         }
     });
}


function renderListings(features) {
    // Clear any existing listings
    listingEl.innerHTML = '';
    if (features.length) {
        features.forEach(function(feature) {
            var prop = feature.properties;
            var item = document.createElement('a');
            item.href = prop.wikipedia;
            item.target = '_blank';
            item.textContent = prop.species;
            item.addEventListener('mouseover', function() {
                // Highlight corresponding feature on the map
                popup.setLngLat(feature.geometry.coordinates)
                    .setText(feature.properties.species)
                    .addTo(map);
            });
            listingEl.appendChild(item);
        });

        // Show the filter input
        //filterEl.parentNode.style.display = 'block';
    } else {
        var empty = document.createElement('p');
        empty.textContent = 'Drag the map to populate results';
        listingEl.appendChild(empty);

        // Hide the filter input
        //filterEl.parentNode.style.display = 'none';

        // remove features filter
        map.setFilter('locations', ['has', 'species']);
    }
}

function normalize(string) {
    return string.trim().toLowerCase();
}

function getUniqueFeatures(array, comparatorProperty) {
    var existingFeatureKeys = {};
    // Because features come from tiled vector data, feature geometries may be split
    // or duplicated across tile boundaries and, as a result, features may appear
    // multiple times in query results.
    var uniqueFeatures = array.filter(function(el) {
        if (existingFeatureKeys[el.properties[comparatorProperty]]) {
            return false;
        } else {
            existingFeatureKeys[el.properties[comparatorProperty]] = true;
            return true;
        }
    });

    return uniqueFeatures;
}

map.on('load', function(e) {

  // Add the data to your map as a layer
  map.addLayer({
    "id": 'locations',
    "type": 'symbol',
    // Add a GeoJSON source containing place coordinates and information.
    "source": {
        "type": 'geojson',
        "data": datapoints
    },
    "layout": {
      'icon-image': 'dog-park-15',
      'icon-allow-overlap': false,
    }
  });

  map.on('moveend', function() {
      var features = map.queryRenderedFeatures({layers:['locations']});

      if (features) {
          var uniqueFeatures = getUniqueFeatures(features, "species");
          // Populate features for the listing overlay.
          renderListings(uniqueFeatures);

          // Clear the input container
          filterEl.value = '';

          // Store the current features in sn `uniqueSpecies` variable to
          // later use for filtering on `keyup`.
          uniqueSpecies = uniqueFeatures;
      }
  });

  map.on('mousemove', 'locations', function(e) {
      // Change the cursor style as a UI indicator.
      map.getCanvas().style.cursor = 'pointer';

      // Populate the popup and set its coordinates based on the feature.
      var feature = e.features[0];
      popup.setLngLat(feature.geometry.coordinates)
          .setText(feature.properties.picture + ' (' + feature.properties.species + ')')
          .setHTML('<h1>' + feature.properties.species + '</h1><img src="http://res.cloudinary.com/foxtail/image/upload/h_200/' + feature.properties.picture + '">')
          .addTo(map);
  });

  map.on('mouseleave', 'locations', function() {
      map.getCanvas().style.cursor = '';
      popup.remove();
  });

  filterEl.addEventListener('keyup', function(e) {
      var value = normalize(e.target.value);

      // Filter visible features that don't match the input value.
      var filtered = uniqueSpecies.filter(function(feature) {
          var name = normalize(feature.properties.picture);
          var code = normalize(feature.properties.species);
          return name.indexOf(value) > -1 || code.indexOf(value) > -1;
      });

      // Populate the sidebar with filtered results
      renderListings(filtered);

      // Set the filter to populate features into the layer.
      map.setFilter('locations', ['in', 'species'].concat(filtered.map(function(feature) {
          return feature.properties.species;
      })));
  });

  // Call this function on initialization
  // passing an empty array to render an empty state
  renderListings([]);
});
