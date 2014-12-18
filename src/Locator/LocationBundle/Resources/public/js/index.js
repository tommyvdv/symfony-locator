searchLocations = {
    init: function() {
        resultLocations.init();
        $('.jsSearchLocations').submit(searchLocations.submitForm);
    },
    submitForm: function(e) {
        e.preventDefault();
        form.submitWithAjax(
            this,
            function (response) {
                var searchForm = $('.jsSearchLocations');

                form.addErrors(searchForm, response.fieldErrors);

                if (response.error) {
                    flash.addError(response.error);
                }
                if (response.success) {
                    flash.addSuccess(response.success);
                    resultLocations.addMarkers(response.data.markers, true);
                }
            }
        );
    }
}

resultLocations = {
    map: null,
    bounds: null,
    init: function() {
        resultLocations.map = locator_google_map_container;
    },
    addMarkers: function(locations, reset) {
        if (reset)
        {
            $('.all-locations .location').hide();
            $.each(resultLocations.map.markers, resultLocations.decouple);
        }

        resultLocations.bounds = new google.maps.LatLngBounds();
        $.each(locations, resultLocations.addMarker);
    },
    decouple: function(i, el) {
        el.setMap(null);
    },
    addMarker: function(i, el) {
        $('.all-locations .location#location-'+el.id).show();

        var latlng = new google.maps.LatLng(el.lat, el.lng);
        resultLocations.bounds.extend(latlng);
        var marker = new google.maps.Marker({
            position: latlng,
            map: resultLocations.map.map
        });
        resultLocations.map.markers[el.label] = marker;
        resultLocations.map.map.fitBounds(resultLocations.bounds);
        resultLocations.map.map.panToBounds(resultLocations.bounds);
    }
}

$(document).ready(searchLocations.init);
