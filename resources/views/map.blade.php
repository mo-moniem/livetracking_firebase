<!DOCTYPE html>
<html>
<head>
    <title>Complex Marker Icons</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <style>
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
            margin: 40px auto;
            height: 400px;
            width: 70%;
        }
        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .custom-map-control-button {
            background-color: #fff;
            border: 0;
            border-radius: 2px;
            box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
            margin: 10px;
            padding: 0 0.5em;
            font: 400 18px Roboto, Arial, sans-serif;
            overflow: hidden;
            height: 40px;
            cursor: pointer;
        }
        .custom-map-control-button:hover {
            background: #ebebeb;
        }

    </style>
</head>
<body>
<div>
    <div id="branches">
        @foreach($branches as $branch)
            <div>
                <input type="radio" value='{"lat":"{{$branch['lat']}}","lng":"{{$branch['lng']}}"}' id="{{$branch['title']}}" name="branch" class="branches">
                <label for="#{{$branch['title']}}">{{$branch['title']}}</label>
            </div>
        @endforeach
    </div>

</div>
<div id="map"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.9.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.9.3/firebase-database.js"></script>
<script>
    // Import the functions you need from the SDKs you need
    // import { initializeApp } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-app.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyCmSUKDvESKTLrwm2bhMXKBNKsZhmvYgpc",
        authDomain: "live-tracking-ccf87.firebaseapp.com",
        databaseURL: "https://live-tracking-ccf87-default-rtdb.firebaseio.com",
        projectId: "live-tracking-ccf87",
        storageBucket: "live-tracking-ccf87.appspot.com",
        messagingSenderId: "424056800074",
        appId: "1:424056800074:web:a9cc570eec1fab7c02b7b3"
    };

    // Initialize Firebase
    const app = firebase.initializeApp(firebaseConfig);
    const database = firebase.database();
    </script>
<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4saBT04W6hCXtK5uwxBDsupssHpPhyFk&callback=initMap&v=weekly" async></script>
<script>
    // The following example creates complex markers to indicate beaches near
    // Sydney, NSW, Australia. Note that the anchor is set to (0,32) to correspond
    // to the base of the flagpole.
    let flightPlanCoordinates = [];
    const branches = [];
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 4,
            center: { lat: 25.9, lng: 32.2 },
        });
        setButton(map);
        chooseBranch(map)
    }
    function getUserLocation(map){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    setUserPosition(map,pos)
                },
            );
        }
    }
    function setButton(map){
        const locationButton = document.createElement("button");
        locationButton.textContent = "get location";
        locationButton.classList.add("custom-map-control-button");
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
        locationButton.addEventListener("click", () => {
            // Try HTML5 geolocation.
            getUserLocation(map)
        });
    }
    function setUserPosition(map,pos){
        pos.is_branch=false;
        flightPlanCoordinates.push(pos)

        new google.maps.Marker({
            position: pos,
            map,
        });
        // console.log(flightPlanCoordinates);
        drawPolyline(flightPlanCoordinates,map)
    }
    function chooseBranch(map){
        $('.branches').change(function (){
            let position = JSON.parse($(this).val());
            branches.push({lat:parseFloat(position.lat),lng:parseFloat(position.lng)});
            const image = "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
            if(branches.length>1){
                let oldMarker = branches.shift()
            }
            new google.maps.Marker({
                position: branches[0],
                map,
                icon:image
            });
            branches[0].is_branch = true;
            flightPlanCoordinates.push(branches[0])
            $('#branches').remove();
            drawPolyline(flightPlanCoordinates,map)
        });

    }
    function drawPolyline(flightPlanCoordinates,map){
        // console.log(flightPlanCoordinates);
        if(flightPlanCoordinates.length == 2){
            const flightPath = new google.maps.Polyline({
                path: flightPlanCoordinates,
                geodesic: true,
                strokeColor: "green",
                strokeOpacity: 1.0,
                strokeWeight: 2,
            });
            flightPath.setMap(map);
            const rootRef = database.ref('influencers')
            rootRef.child(0).set({
                location:flightPlanCoordinates
            })
        }
    }


</script>



</body>
</html>
