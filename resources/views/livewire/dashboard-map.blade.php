<div class="">
    <div class="border rounded-t">
        <h1 class="px-2 py-3 text-2xl font-semibold text-center text-primary-400">Mapa de Asistencias</h1>
    </div>
    <div class="w-full px-4 py-8 -mt-4 border-b rounded-md border-x aspect-video">
        <div id="map"></div>
    </div>
</div>

<script>
    const locations = @json($mapLocations);

    locations.forEach((loc, i) => {
        simplemaps_worldmap_mapdata.locations[i] = {
            name: loc.university,
            lat: loc.lat,
            lng: loc.lng,
            description: `De la universidad ${loc.university} hay ${loc.total_assistants} asistentes`,
        };
    });

    simplemaps_worldmap.refresh();
</script>
