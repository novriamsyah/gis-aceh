<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ACEH</title>

    <!-- css & script leflet  -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="crossorigin=""></script>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <style>
        #map { height: 620px; }
        .lable-icon {
          font-size: 8pt;
          color: black;
          font-weight:bold;
          /* text-align: center; */
          /* transform:translate(-50%, -50%); */
        }
        .legend{
          background: #ffffff;
          padding: 10px;
        }
    </style>

</head>
<body>

    <div id="map"></div>
    
<script>
    
    var geoLayer;

   //center map view and zoom   
   var map = L.map('map').setView([4.108, 96.702], 8);
    
    //untuk mengubah jenis peta
    //lyrs:
    // Hybrid: s,h;
    // Satellite: s;
    // Streets: m;
    // Terrain: p;
        
   L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
     maxZoom: 18,
     subdomains:['mt0','mt1','mt2','mt3']
  }).addTo(map);

  $(document).ready(function() {

    var kotaColors = {"Aceh Barat":"#ff3135", "Aceh Barat Daya":"#ff3135", "Aceh Besar":"#009b2e", "Aceh Jaya":"#cc3300",
    "Aceh Selatan":"#009b2e", "Aceh Singkil":"#ff3135", "Aceh Tamiang":"#ce06cb", "Aceh Tengah":"#fd9a00", "Aceh Tenggara":"#fd9a00",
    "Aceh Timur":"#000099", "Aceh Utara":"#009b2e","Bener Meriah":"#ce06cb", "Bireuen":"#ffff00", "Gayo Lues":"#ffff00",
    "Kota Banda Aceh":"#ffff00", "Kota Langsa":"#ffff00", "Kota Lhokseumawe":"#ffff00", "Kota Sabang":"#9ace00", "Kota Subulussalam":"#000099",
    "Nagan Raya":"#6e6e6e", "Pidie":"#976900", "Pidie Jaya":"#969696", "Simeulue":"#ce06cb" };

    //GET gojson dengan menggunakan AJAX
    $.getJSON('geojson/aceh.geojson', function(json) {
        geoLayer = L.geoJson(json, {
            style: function(feature) {
                return {
                        fillOpacity:0.7,
                        weight: 3,
                        color: kotaColors[feature.properties.WADMKK],
                        opacity: 1,
                        dashArray: "10 10",
                        lineCap: 'square'
                };
            },
            onEachFeature: function(feature, layer) {
                    console.log(feature.properties.WADMKK);

                    const iconLable = L.divIcon({
                          className: 'lable-icon',
                          html: '<b>'+feature.properties.WADMKK+'</b>',
                          // iconSize: [100, 30],
                    });
                    var marker = L.marker(layer.getBounds().getCenter(), {icon: iconLable}).addTo(map);
                    
                    layer.on({
                      mouseover: function (e) {
                        var layer = e.target;
                        layer.setStyle({
                          weight: 3,
                          color: "#00FFFF",
                          opacity: 1
                        });
                        if (!L.Browser.ie && !L.Browser.opera) {
                          layer.bringToFront();
                        }
                      },
                      mouseout: function (e) {
                        geoLayer.resetStyle(e.target);
                      }
                    });
                
                layer.addTo(map);
                   
            }
        });
    });

  });

</script>

</body>
</html>