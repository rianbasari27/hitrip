<style>
    @media only screen and (max-width: 768px){
        .container-utama{
            font-size: 5px;
        }

        .tanggal-isi{
            font-size: 5px;
            padding: 2px;
        }

        .harga-isi{
            padding: 2px;
        }

        .pesawat-isi{
            font-size: 6px;
            padding: 2px;
        }

        #non-mobile{
            display: none;
        }

        .detail-button{
            font-size: 6px;
        }
    }
    @media only screen and (min-width: 768px){

        .container-utama{
            font-size: 14px;
            padding: 4px;
        }

        .pesawat-isi{
            font-size: 10px;
            padding: 4px;
        }

        .tanggal-isi{
            padding: 4px;
        }

        .harga-isi{
            padding: 4px;
        }

        #mobile{
            display: none;
        }

        .detail-button{
            font: 12px;
        }

        .header{
            padding: 16px;
        }
    }

    .header{
        background-color: black;
        font-weight: bold;
        color: white;
        text-align: center;

        margin-bottom: 4px;
    }

    .divider-bulan{
        background-color: #F1B900;
        color: white;
        
        text-align: center;
        font-weight: bolder;
        justify-content: center;
    }

    .konten{
        background-color: white;
        text-align: center;
        margin: 4px 0px 4px 0px;
    }

    .container-utama{
        display: flex;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        align-items: center;

        font-family:'Montserrat',sans-serif;
    }

    .container-nama {
        flex: 2;
        font-weight: bold;
    }

    .container-tanggal {
        flex: 1;
    }

    .container-pesawat {
        flex: 1;
    }

    .container-hotel-mk {
        flex: 1.25;
    }

    .container-hotel-md {
        flex: 1.25;
    }

    .container-harga {
        flex: 0.5;
    }

    .container-seat {
        flex: 0.5;
        font-weight: bold;
    }

    .container-detail{
        flex: 0.5;
    }

    .detail-button{
        background-color: #F1B900;
        color: black;
        text-align: center;
        font-weight: bolder;
        border-radius: 4px;
    }

    .tanggal-isi{
        background-color: black;
        text-align: center;
        border-radius: 4px;

        color: white;
        font-weight: bold;
    }

    .harga-isi{
        background-color: black;
        text-align: center;
        border-radius: 4px;

        color: white;
        font-weight: bold;
    }

    .seat-isi{
        text-align: center;
    }

    .pesawat-isi{
        border-radius: 4px;
        font-weight: bolder;
    }

    #kosong{
        justify-content: center;
    }
</style>

<?php 
$prevMonth = '';
if(empty($paket)){
    echo "<div class='container-utama header' id='kosong'>Paket Belum Tersedia</div>";

} else { ?>

    <div class="container-utama header">
        <div class="container-nama">Nama Paket</div>
        <div class="container-tanggal">Keberangkatan</div>
        <div class="container-pesawat">Maskapai</div>
        <div class="container-hotel-mk">Hotel Mekah</div>
        <div class="container-hotel-md">Hotel Madinah</div>
        <div class="container-harga">Harga</div>
        <div class="container-seat">Sisa Seat</div>
        <div class="container-detail">Detail</div>
    </div>

    <?php
    foreach($paket as $p){ 

        $currentMonth = $p->bulan;
        
        if($prevMonth !== $currentMonth){
            echo "<div class='container-utama divider-bulan'> $currentMonth</div>";
            $prevMonth = $currentMonth;
        } ?>
        <div class="container-utama konten">
            <div class="container-nama nama-isi"> <?php echo $p->nama_paket ?></div>
            <div class="container-tanggal tanggal-isi"> <?php echo $p->keberangkatan ?></div>
            <div class="container-pesawat pesawat-isi">
                <?php if(isset($p->url)){ 
                    $mob= substr_replace($p->url,'-mob',-4,0);
                    echo"<img id='non-mobile' src='$p->url' width='80px' />";
                    echo "<img id= 'mobile' src='$mob' height='15px' width='15px'/>";
                } else { echo 'Belum Tersedia'; } ?>
            </div>
            <div class="container-hotel-mk mk-isi"> <?php echo $p->hotels[0]?></div>
            <div class="container-hotel-md md-isi"> <?php echo $p->hotels[1]?></div>
            <div class="container-harga harga-isi"> <?php echo $p->harga/1000000 . " jt" ?></div>
            <div class="container-seat seat-isi"> <?php echo $p->sisa_seat?></div>
            <a class="container-detail" href="<?php echo base_url() . '/jamaah/detail_paket?id=' . $p->id_paket ?>">
                <button class="detail-button">detail</button>
            </a>
        </div>
    <?php }
    
} ?>