var map = new mapboxgl.Map({
    container: 'map', // container id
    style: 'mapbox://styles/mapbox/dark-v9', //hosted style id
    center: [-77.38, 39], // starting position
    zoom: 3 // starting zoom
});
// map.addSource('some id', {
//     type: 'geojson',
//     data: /datasets/v1/pixelipo/cj23dgkvq00192qo6k2lzvazn
// });
// map.on('load', function () {
//
//     map.addLayer({
//         "id": "terrain-data",
//         "type": "line",
//         "source": {
//             type: 'vector',
//             url: 'mapbox://mapbox.mapbox-terrain-v2'
//         },
//         "source-layer": "contour",
//         "layout": {
//             "line-join": "round",
//             "line-cap": "round"
//         },
//         "paint": {
//             "line-color": "#ff69b4",
//             "line-width": 1
//         }
//     });
// });
map.on('load', function(e) {
  // Add the data to your map as a layer
  map.addLayer({
    id: 'locations',
    type: 'symbol',
    // Add a GeoJSON source containing place coordinates and information.
    source: {
      type: 'geojson',
      data: stores
    },
    layout: {
      'icon-image': 'restaurant-15',
      'icon-allow-overlap': true,
    }
  });
});
