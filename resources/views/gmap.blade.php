<div id="map"></div>
<script>
    let response = {{ $response }};
    let markers = response.data;

    function initMap() {
        let map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 50.7593, lng: 25.3424},
            zoom: 3
        });

        console.log(response)

        markers.map(element => {
            let marker = new google.maps.Marker({
                position: { lat: element.lat, lng: element.lng },
                animation: google.maps.Animation.DROP,
                map: map
            });

            // html block
            const markerTitle = `<h1>${element.title}</h1>`;
            const markerDescription = `<p>${element.description}</p>`;
            const markerLink = `<a href="/place/${element.id}">See more</a>`;

            // popup info window
            let infoWindow = new google.maps.InfoWindow({
                content: markerTitle + markerDescription + markerLink
            });

            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });
        });


        if (response.total > 10) {
            // html block
            let showMore = document.createElement('a');
            showMore.innerText = 'Show more'
            showMore.href = response.next_page_url
            showMore.style.cursor = 'pointer'
            showMore.style.borderRadius = '5px'
            showMore.style.backgroundColor = 'white'
            showMore.style.padding = '15px 30px'
            showMore.style.marginBottom = '15px'
            showMore.style.fontSize = '20px'
            showMore.style.fontWeight = '600'

            map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(showMore);
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtRwPhPwGJgjuQJhNXq__cjCo6oU_XQdM&callback=initMap"
        async defer></script>
