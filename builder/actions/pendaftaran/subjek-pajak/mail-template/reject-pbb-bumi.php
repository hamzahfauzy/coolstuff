<div style="width:500px;margin:auto;">
    <center>
    <img src="<?=url()?>/dist/images/logo.png" width="32" alt="">
    <h1>Pemberitahuan Pendaftaran PBB Kabupaten Pakpak Bharat</h1>
    <p>Bahwa pendaftaran PBB Anda telah kami <b><span style="color:red">TOLAK</span></b> dengan catatan <?=$_GET['reason']?></p>
    </center>

    <?php require 'subjek-pajak.php' ?>

    <?php 
    $kecamatan = $qb->select('REF_KECAMATAN')->where('KD_KECAMATAN', $bumi['KD_KECAMATAN'])->first();
    $kelurahan = $qb->select('REF_KELURAHAN')->where('KD_KELURAHAN', $bumi['KD_KELURAHAN'])->first();
    ?>
    <h2>Data Objek Pajak</h2>

    <table cellpadding="5" cellspacing="0" border="1" width="100%">
            <tr>
                <td>NOP</td>
                <td>
                    <?=$bumi['KD_PROPINSI'].'.'.$bumi['KD_DATI2'].'.'.$bumi['KD_KECAMATAN']. '.' . $bumi['KD_KELURAHAN'] . '.' . $bumi['KD_BLOK'] . '-' . $bumi['NO_URUT'] . '.' . $bumi['KODE']?>
                </td>
            </tr>
            <tr>
                <td>NO SPOP</td>
                <td>
                    <?=$bumi['NO_SPOP']?>
                </td>
            </tr>
            <tr>
                <td>Tahun</td>
                <td>
                    <?=$bumi['TAHUN']?>
                </td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td>
                    <?=$bumi['KD_KECAMATAN']?> - <?=$kecamatan['NM_KECAMATAN']?>
                </td>
            </tr>
            <tr>
                <td>Kelurahan</td>
                <td>
                    <?=$bumi['KD_KELURAHAN']?> - <?=$kelurahan['NM_KELURAHAN']?>
                </td>
            </tr>
            <tr>
                <td>Blok</td>
                <td>
                    <?=$bumi['KD_BLOK']?>
                </td>
            </tr>
            <tr>
                <td>ZNT</td>
                <td>
                    <?=$bumi['KD_ZNT']?>
                </td>
            </tr>
            <tr>
                <td>No Urut</td>
                <td>
                    <?=$bumi['NO_URUT']?>
                </td>
            </tr>
            <tr>
                <td>Kode</td>
                <td>
                    <?=$bumi['KODE']?>
                </td>
            </tr>
            <tr>
                <td>No Persil</td>
                <td>
                    <?=$bumi['NO_PERSIL']?>
                </td>
            </tr>
            <tr>
                <td>Luas</td>
                <td>
                    <?=$bumi['LUAS_TANAH']?>
                </td>
            </tr>
        </tbody>
    </table>

    <h2>Lampiran</h2>

    <table cellpadding="5" cellspacing="0" border="1" width="100%">
        <tr>
            <td>KTP</td>
            <td>
                <a href="<?=url().'/'.get_file_storage('ktp/'.$bumi['KTP'])?>" class="font-medium p-2 bg-green-500 text-white rounded" target="_blank">Lihat File</a>
            </td>
        </tr>
        <tr>
            <td>FOTO OBJEK</td>
            <td>
                <a href="<?=url().'/'.get_file_storage('foto-objek/'.$bumi['FOTO_OBJEK'])?>" class="font-medium p-2 bg-green-500 text-white rounded" target="_blank">Lihat File</a>
            </td>
        </tr>
        <tr>
            <td>SURAT TANAH</td>
            <td>
                <a href="<?=url().'/'.get_file_storage('surat-tanah/'.$bumi['SURAT_TANAH'])?>" class="font-medium p-2 bg-green-500 text-white rounded" target="_blank">Lihat File</a>
            </td>
        </tr>
    </table>
</div>