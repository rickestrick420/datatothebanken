
    <h1>Kategorie</h1>
<div class="Kategorie">
    @forelse($data as $a)
        <li>{{$a['name']}}</li>
    @empty
        <li>Keine Daten vorhanden.</li>
    @endforelse
</div>
<style>
    li:nth-child(2n){
        font-weight: bold;
    }
</style>



