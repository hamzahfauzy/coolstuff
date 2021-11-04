<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Detail ZNT : <?=$data["KD_ZNT"]?></h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <div class="form-group mb-2">
            <label>Kecamatan</label>
            <select disabled name="KD_KECAMATAN" class="p-2 w-full border rounded" onchange="kecamatanChange(this)">
                <option value="" selected readonly>- Pilih Kecamatan -</option>
                <?php foreach($kecamatans as $kecamatan):?>
                    <option <?= $data['KD_KECAMATAN'] == $kecamatan['KD_KECAMATAN'] ? 'selected' : ''?> value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group mb-2 <?=isset($_GET['kelurahan']) && $_GET['kelurahan'] ? '' : 'hidden' ?>" id="kelurahan">
            <label>Kelurahan</label>
            <select disabled name="KD_KELURAHAN" class="p-2 w-full border rounded" onchange="kelurahanChange(this)">
                <option value="" selected readonly>- Pilih Kelurahan -</option>
                <?php foreach($kelurahans as $kelurahan):?>
                    <option <?= $_GET['kelurahan'] == $kelurahan['KD_KELURAHAN'] && $_GET['kecamatan'] == $kelurahan['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$kelurahan['KD_KELURAHAN']?>"><?=$kelurahan['KD_KELURAHAN']." - ".$kelurahan['NM_KELURAHAN']?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group mb-2 <?=isset($_GET['blok']) && $_GET['blok'] ? '' : 'hidden' ?>" id="blok">
            <label>Blok</label>
            <select disabled name="KD_BLOK" class="p-2 w-full border rounded">
                <option value="" selected readonly>- Pilih Blok -</option>
                <?php foreach($bloks as $blok):?>
                    <option <?= $_GET['blok'] == $blok['KD_BLOK'] && $_GET['kelurahan'] == $blok['KD_KELURAHAN'] && $_GET['kecamatan'] == $blok['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$blok['KD_BLOK']?>"><?=$blok['KD_BLOK']?></option>
                <?php endforeach ?>
            </select>
        </div>
        <?php 
        foreach($fields as $key => $val): 
            $label = str_replace("_"," ",$key);
                $label = str_replace("KD","KODE",$label);
            $label = str_replace("NM","NAMA",$label);
        ?>
        <div class="form-group mb-2">
            <label><?=ucwords($label)?></label>
            <?= Form::input($val['type'], $key, ['disabled'=>'disabled','class'=>"p-2 w-full border rounded","value"=>$val['value'],"placeholder"=>$label,'maxlength'=>$val['character_maximum_length'] ]) ?>
        </div>
        <?php endforeach ?>
        <div class="form-group mb-2">
            <label for="latitude">
                Latitude:
            </label>
            <input id="txtLat" type="text" style="color:red" value="28.47399" />
        </div>
        <div class="form-group mb-2">
            <label for="longitude">
                Longitude:
            </label>
            <input id="txtLng" type="text" style="color:red" value="77.026489" /><br />
        </div>
        <div class="form-group mb-2">
            <div id="map_canvas" style="width: auto; height: 400px;"></div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3_euJs5nXQ2yIloYBgvNTroQa2i9SfUM"></script>
<script type="text/javascript">
    function initialize() {
        // Creating map object
        var map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoom: 12,
            center: new google.maps.LatLng(28.47399, 77.026489),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        // creates a draggable marker to the given coords
        var vMarker = new google.maps.Marker({
            position: new google.maps.LatLng(28.47399, 77.026489),
            draggable: true
        });
        // adds a listener to the marker
        // gets the coords when drag event ends
        // then updates the input with the new coords
        google.maps.event.addListener(vMarker, 'dragend', function (evt) {
            $("#txtLat").val(evt.latLng.lat().toFixed(6));
            $("#txtLng").val(evt.latLng.lng().toFixed(6));
            map.panTo(evt.latLng);
        });
        // centers the map on markers coords
        map.setCenter(vMarker.position);
        // adds the marker on the map
        vMarker.setMap(map);
    }
</script>

<?php load('builder/partials/bottom') ?>
