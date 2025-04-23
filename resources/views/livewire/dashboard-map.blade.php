<div class="">
    <div class="border rounded-t">
        <h1 class="px-2 py-3 text-2xl font-semibold text-center text-primary-400">Mapa de Asistencias</h1>
    </div>
    <div class="w-full px-4 py-8 -mt-4 border-b rounded-md border-x aspect-video">
        <div id="map"></div>
    </div>
</div>

<script>
    const cords = @json($cords);

    cords.forEach((cord, i) => {
        if (cord.university_total == 0) {
            return;
        }

        simplemaps_worldmap_mapdata.locations[i] = {
            name: cord.university_name,
            lat: cord.lat,
            lng: cord.lng,
            description: `De la universidad ${cord.university_name} hay ${cord.university_total} asistentes`,
        };
    });

    simplemaps_worldmap.refresh();
</script>
