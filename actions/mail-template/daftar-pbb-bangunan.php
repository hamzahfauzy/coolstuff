<div style="width:500px;margin:auto;">
    <center>
    <img src="<?=url()?>/dist/images/logo.png" width="32" alt="">
    <h1>Pemberitahuan Pendaftaran PBB Kabupaten Pakpak Bharat</h1>
    </center>
    
    <?php require 'subjek-pajak.php' ?>
    
    <h2>Data Objek Pajak</h2>
    
    <?php
        $NOP = explode(".", $bangunan['NOP']);
        $BLOK = explode("-", $NOP[4]);
        $kecamatan = $qb->select('REF_KECAMATAN')->where('KD_KECAMATAN', $NOP[2])->first();
        $kelurahan = $qb->select('REF_KELURAHAN')->where('KD_KELURAHAN', $NOP[3])->first();
    ?>
    <table cellpadding="5" cellspacing="0" border="1" width="100%">
        <tr>
            <td>NOP</td>
            <td><?=$bangunan['NOP']?></td>
        </tr>
        <tr>
            <td>Kecamatan</td>
            <td><?=$kecamatan['KD_KECAMATAN']?> - <?=$kecamatan['NM_KECAMATAN']?></td>
        </tr>
        <tr>
            <td>Kelurahan</td>
            <td><?=$kelurahan['KD_KELURAHAN']?> - <?=$kelurahan['NM_KELURAHAN']?></td>
        </tr>
        <tr>
            <td>Blok</td>
            <td><?=$BLOK[0]?></td>
        </tr>
        <tr>
            <td>No Urut</td>
            <td><?=$BLOK[1]?></td>
        </tr>
        <tr>
            <td>Jenis OP</td>
            <td><?=$NOP[5]?></td>
        </tr>
        <tr>
            <td>No Bangunan</td>
            <td><?=$bangunan['NO_BNG']?></td>
        </tr>
        <tr>
            <td>No Formulir LSPOP</td>
            <td><?=$bangunan['NO_FORMULIR_LSPOP']?></td>
        </tr>
        <tr>
            <td>Tahun Dibangun</td>
            <td><?=$bangunan['THN_DIBANGUN_BNG']?></td>
        </tr>
        <tr>
            <td>Tahun Renovasi</td>
            <td><?=$bangunan['THN_RENOVASI_BNG']?></td>
        </tr>
        <tr>
            <td>Luas</td>
            <td><?=$bangunan['LUAS_BNG']?></td>
        </tr>
        <tr>
            <td>Jumlah Lantai</td>
            <td><?=$bangunan['JML_LANTAI_BNG']?></td>
        </tr>
    </table>
    
    <h2>Lampiran</h2>
    
    <table cellpadding="5" cellspacing="0" border="1" width="100%">
        <tr>
            <td>KTP</td>
            <td>
                <a href="<?=url().'/'.get_file_storage('ktp/'.$bangunan['KTP'])?>" class="font-medium p-2 bg-green-500 text-white rounded" target="_blank">Lihat File</a>
            </td>
        </tr>
        <tr>
            <td>FOTO OBJEK</td>
            <td>
                <a href="<?=url().'/'.get_file_storage('foto-objek/'.$bangunan['FOTO_OBJEK'])?>" class="font-medium p-2 bg-green-500 text-white rounded" target="_blank">Lihat File</a>
            </td>
        </tr>
        <tr>
            <td>SURAT TANAH</td>
            <td>
                <a href="<?=url().'/'.get_file_storage('surat-tanah/'.$bangunan['SURAT_TANAH'])?>" class="font-medium p-2 bg-green-500 text-white rounded" target="_blank">Lihat File</a>
            </td>
        </tr>
    </table>

</div>
