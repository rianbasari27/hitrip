<style>
    .main-body-paket{
        display: flex;

        overflow: hidden;
        justify-content: flex-start;
        align-items: center;
        padding: 10px;
        overflow-x: auto;
        scrollbar-width: thin;
    }
    .container-utama{
        padding:8px 16px 8px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-right: 8px;
        width: 260px;
        height: 500px;

        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);
        border-radius: 20px;
        font-family: 'Montserrat', sans-serif;

        transition: transform 0.3s ease;

        background-color: white;
    }

    /* Optional: Style for scrollbar */
    .main-body-paket::-webkit-scrollbar {
        width: 8px;
    }

    .main-body-paket::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 4px;
    }

    .main-body-paket::-webkit-scrollbar-track {
    background-color: #f1f1f1;
    }

    .container-poster{
        flex: 4;
        padding: 4px;
    }
    .container-judul{
        flex: 3;
        width: 100%;
        font-size: small;

        font-weight: bold;
        padding: 8px 16px 8px 16px;
        text-align: center;

        overflow: hidden;
    }
    .container-konten{
        flex:4;
        display: flex;
        flex-direction: column;
        width: 100%;
        padding-left: 28px;
    }
    .container-highlight{
        flex: 2;
        display: flex;
        width: 50%;
        text-align: center;
        padding: 16px 8px 8px 8px;

        background-color: #f4f4f4;
        color: black;
        border-radius: 4px;
    }
    .container-button{
        flex: 5;
        width: 50%;
        padding: 8px 8px 16px 8px;
    }

    .baris-konten{
        display: flex;
        flex: 1;
        margin-left: 4px;

        font-size: small;
        padding: 4px;
    }

    .konten-ikon{
        flex: 1;
        margin-right: 4px;
    }
    .konten-judul{
        flex: 2;
        font-weight: bold;
        font-size: smaller;
        white-space: nowrap;
    }
    .konten-isi{
        flex: 4;
        font-size: smaller;
        margin-left: 4px;
    }

    .ikon{
        height: 16px;
    }

    .container-harga{
        flex: 2;
        /*background-color: #F4F4F4;*/
        margin-right: 4px;
        border-radius: 4px;
    }
    .container-seat{
        flex: 1.5;
        /*background-color: #F4F4F4;*/
        border-radius: 4px;
    }
    .judul-highlight{
        font-weight: bold;
        font-size: smaller;
    }
    .isi-highlight{
        font-size: medium;
    }

    .detail-button{
        width: 100%;
        background-color: #FFDC72;
        color:black;
        font-weight: bold;
        border-radius: 8px;
        border: none;
        padding: 8px;
    }

    .tidak-tersedia{
        background-color: #F1B900;
        color: black;
        text-align: center;
        font-weight: bolder;
        font-family: 'Montserrat', sans-serif;
        padding: 16px 32px 16px 32px;
        border-radius: 4px;
    }

    .poster-paket{
        border-radius: 16px;
    }
</style>

<div class = main-body-paket>
    <?php 
    $prevMonth = '';
    if(empty($paket)){
        echo "<div class='tidak-tersedia'>Paket Belum Tersedia</div>";

    } else { 
        
        foreach($paket as $p){

        
    ?>

    <div class="container-utama">
        <div class="container-poster">
            <img class="poster-paket"
            src="<?php echo ($p->banner_image) ? base_url() . $p->banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>"
            width="200px" height="150px"
            />
        </div>
        <div class="container-judul"><?php echo $p->nama_paket ?></div>
        <div class="container-konten">

            <div class="baris-konten">
                <div class="konten-ikon">
                    <img class="ikon" src="<?php echo base_url() . "/asset/appkit/images/icons/api/tanggal.png" ?>" />
                </div>
                <div class="konten-judul">Keberangkatan</div>
                <div class="konten-isi"><?php echo $this->date->convert("j F Y", $p->tanggal_berangkat); ?></div>
            </div>

            <div class="baris-konten">
                <div class="konten-ikon">
                    <img class="ikon" src="<?php echo base_url() . "/asset/appkit/images/icons/api/hotel.png" ?>" />
                </div>
                <div class="konten-judul">Hotel Mekah</div>
                <div class="konten-isi"> <?php echo $p->hotels[0]?></div>
            </div>

            <div class="baris-konten">
                <div class="konten-ikon">
                    <img class="ikon" src="<?php echo base_url() . "/asset/appkit/images/icons/api/hotel.png" ?>" />
                </div>
                <div class="konten-judul">Hotel Madinah</div>
                <div class="konten-isi"><?php echo $p->hotels[1]?></div>
            </div>

            <div class="baris-konten">
                <div class="konten-ikon">
                    <img class="ikon" src="<?php echo base_url() . "/asset/appkit/images/icons/api/maskapai.png" ?>" />
                </div>
                <div class="konten-judul">Maskapai</div>
                <div class="konten-isi">
                    <?php if(isset($p->url)){ 
                        $mob= substr_replace($p->url,'-mob',-4,0);
                        echo"<img id='non-mobile' src='$p->url' width='80px' />";
                        echo "<img id= 'mobile' src='$mob' height='15px' width='15px'/>";
                    } else { echo 'Belum Tersedia'; } ?>
                </div>
            </div>

        </div>
        <div class="container-highlight">
            <div class="container-harga">
                <div class="judul-highlight">Harga</div>
                <div class="isi-highlight"><?php echo $p->harga/1000000?><SUP> Jt</SUP></div>
            </div>
            <div class="container-seat">
                <div class="judul-highlight">Sisa Seat</div>
                <div class="isi-highlight"><?php echo $p->sisa_seat?></div>
            </div>
        </div>
        <div class="container-button">
            <a href="<?php echo base_url() . '/jamaah/detail_paket?id=' . $p->id_paket ?>">
                <button class="detail-button">Detail</button>
            </a>
        </div>
    </div>

    <?php 
        }
    } 
    ?>
</div>