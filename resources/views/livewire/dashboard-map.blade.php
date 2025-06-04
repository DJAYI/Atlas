<div class="">
    <div class="border rounded-t">
        <h1 class="px-2 py-3 text-2xl font-semibold text-center text-primary-400">Mapa de Asistencias</h1>
    </div>
    <div class="w-full px-4 py-8 -mt-4 border-b rounded-md border-x h-[570px] aspect-video">
        <div id="map"></div>
    </div>
</div>

@push('scripts')
    <!-- Make sure to include the SimpleMaps library before your script -->
    <script src="https://simplemaps.com/static/js/worldmap.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cords = @json($cords);

            function getColor(total) {
                if (total > 500) return '#b30000';
                if (total > 100) return '#e34a33';
                if (total > 50) return '#fc8d59';
                if (total > 10) return '#fdbb84';
                if (total > 0) return '#fdd49e';
                return '#fef0d9';
            }
            if (typeof simplemaps_worldmap_mapdata !== 'undefined') {
                cords.forEach((cord, i) => {
                    simplemaps_worldmap_mapdata.locations[i] = {
                        name: cord.university_name,
                        lat: cord.lat,
                        lng: cord.lng,
                        description: `De la universidad ${cord.university_name} (${cord.country ?? ''}) hay ${cord.university_total} asistentes`,
                        color: getColor(cord.university_total),
                    };
                });

                console.log(simplemaps_worldmap_mapdata.locations);
            } else {
                console.error(
                    'simplemaps_worldmap_mapdata is not defined. Make sure the SimpleMaps library is loaded.');
            }
        });
    </script>
@endpush
