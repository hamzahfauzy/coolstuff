<h2>Data Subjek Pajak</h2>

<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr>
        <td>Kode registrasi</td>
        <td><b><?= $subjek_pajak['reg_code']?></b></td>

    <tr>
        <td>NIK</td>
        <td><b><?= $subjek_pajak['NIK'] ? $subjek_pajak['NIK'] : "-"?></b></td>
    </tr>
    
    <tr>
        <td>Nama</td>
        <td><b><?= $subjek_pajak['NM_WP'] ? $subjek_pajak['NM_WP'] : "-"?></b></td>
    </tr>
</table>