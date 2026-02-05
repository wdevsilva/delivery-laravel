<!DOCTYPE html>
<html>
<head>
    <?php require_once 'site-base.php'; ?>
    <script>
        function initMap() {
            const directionsRenderer = new google.maps.DirectionsRenderer();
            const directionsService = new google.maps.DirectionsService();
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: {
                    lat: <?=$data['config']->config_lat;?>,
                    lng: <?=$data['config']->config_lng;?>
                },
            });
            directionsRenderer.setMap(map);
            calculateAndDisplayRoute(directionsService, directionsRenderer);
            document.getElementById("mode").addEventListener("change", () => {
                calculateAndDisplayRoute(directionsService, directionsRenderer);
            });
        }

        function calculateAndDisplayRoute(directionsService, directionsRenderer) {
            const selectedMode = document.getElementById("mode").value;
            directionsService
                .route({
                    origin: {
                        lat: <?=$data['config']->config_lat;?>,
                        lng: <?=$data['config']->config_lng;?>
                    },
                    destination: {
                        lat: <?=$data['endereco']->endereco_lat;?>,
                        lng: <?=$data['endereco']->endereco_lng;?>
                    },
                    travelMode: google.maps.TravelMode[selectedMode],
                })
                .then((response) => {
                    directionsRenderer.setDirections(response);
                })
                .catch((e) => window.alert("A solicitação de rota falhou devido a falta de endereço correto " + status));
        }
    </script>
    <style>
        #map {
            height: 100%;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #floating-panel {
            position: absolute;
            top: 10px;
            left: 25%;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: "Roboto", "sans-serif";
            line-height: 30px;
            padding-left: 10px;
        }
    </style>
</head>
<?php //var_dump($data);?>
<body>
    <div id="floating-panel">
        <b>Modo de viagem: </b>
        <select id="mode">
            <option value="DRIVING">Dirigindo</option>
            <option value="WALKING">Andando</option>
            <option value="TRANSIT">Transito</option>
        </select>
    </div>
    <div id="map"></div>
     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaElTUnYKaWWW_EzqYpzBZLEyi9HKtyGY&callback=initMap&libraries=&v=weekly" async></script>
</body>
</html>