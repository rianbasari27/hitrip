<style>
    /* General */
    #misc-on{
        background-color: #12100D;
        color: #FED800;
    }
    #misc-off{
        background-color: #12100D;
        color: #686868;
    }
    #daftar{
        background-color: #FED800;
        color: #12100D;
    }
    .spanduk{
        border-radius: 14px;
    }
    .bulan {
        color: #FED800;
        text-align: center;
        font-size: x-large;
        font-weight: bold;
        font-family: 'Montserrat', sans-serif;
    }

    /* Desktop */
    @media only screen and (min-width: 700px) {
        
        .kartu-mobile{
            display: none;
        }

        .kartu{
            display: flex;
            justify-content: center;

            
            margin-bottom: 20px;
            padding:8px;
            background-color: white;
            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);
            border-radius: 20px;
        }

        .mini-elemen{
            flex: 1;
            margin: 0px;
            
        }

        .mid-elemen{
            flex: 4;
            margin: 8px;
        }

        .spanduk{
            height:240px;
        }

        .tombol-container{
            display: flex;
            flex-direction: column;
            padding-top: 20px;
        }

        .tombol{
            font-size:small;
            font-weight: bold;
            border-radius: 12px;
            margin: 16px 0px 0px 0px;
        }

        .flyer{
            padding: 8px 20px 8px 20px;
        }

        .itinerary{
            padding: 8px 26px 8px 26px;
        }

        .daftar{
            padding: 8px 32px 8px 32px;
        }

        .informasi-container{
            display: flex;
            flex-direction: column;
        }

        .judul-utama{
            flex: 1;
            text-align: center;
            font-weight: bold;
            font-size: large;
            font-family: 'Montserrat', sans-serif;
            padding-bottom: 20px;
        }

        .info-utama{
            flex: 2;
        }

        .info-utama-container{
            display: flex;
            height: 180px;
        }

        .cotainer-konten{
            display: flex;
            flex-direction: column;
            margin: 4px;
            flex: 1;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
        }

        .info-judul{
            padding-top: 16px;
            font-weight: bolder;
            font-size: 12px;
            padding-bottom: 8px;
        }

        .info-konten{
            font-size: 14px;
        }
    }

    /* Phone */
    @media only screen and (max-width: 700px) {
        
        .kartu{
            display: none;
        }

        .popup{
            display: block;
            transform: scale(2);
            position: fixed;
            top: 35%;
            left: 25%;
        }

        .kartu-mobile{
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            align-items: center;

            margin-bottom: 20px;
            padding:8px;
            background-color: white;
            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);
            border-radius: 20px;
        }

        .inside-info-mobile{
            display: flex;
        }

        .wider-elemen-mobile{
            flex: 2;
            height: 25%;
            padding: 8px;
        }

        .judul-utama-mobile{
            font-size: 18px;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            font-weight: bolder;
        }

        .taller-elemen-mobile {
            flex: 1;
            padding: 8px;
        }

        .tombol-mob{
            font-size:14px;
		    font-weight:bold;
		    border-radius:5px;
            font-family: 'Montserrat', sans-serif;
            padding: 8px;
        }

        .judul-mob{
            font-size: 12px;
            font-weight:bolder;
            color: #e3c452;
            font-family: 'Montserrat', sans-serif;
            margin-bottom: 0px;
        }

        .isi-mob{
            font-size: 14px;
            font-family: 'Montserrat', sans-serif;
            margin-bottom: 0px;
        }

        .spanduk{
            max-height: 200px;
        }

        .informasi-mob{
            display: flex;
            flex-direction: column;
        }
    }

</style>

<?php $prevMonth = '';?>
<?php foreach ($paket as $p) { ?>

    <!-- SETUP & MONTH SECTIONING -->
    <?php
    $tanggal = $this->date->convert("j F Y", $p->tanggal_berangkat);
    $currentMonth = explode(" ",$tanggal)[1];
    ?>

    <?php if (!$partial) { ?>
        <?php if($prevMonth !== $currentMonth){ ?>
            <h1 class="bulan"><?php echo $currentMonth ?></h1>
        <?php } ?>

        <?php $prevMonth = $currentMonth; ?>
    <?php }?>
    
    <!-- MOBILE-ONLY -->
    <div class="kartu-mobile">

        <!-- title -->
        <div class="judul-utama-mobile wider-elemen-mobile">
            <?php echo $p->nama_paket ?>
        </div>

        <!-- info paket -->
        <div class="inside-info-mobile">

            <!-- image -->
            <img class="taller-elemen-mobile spanduk"
                src="<?php echo ($p->banner_image) ? base_url() . $p->banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>"
                alt="Banner" onclick="change(this)">


            <!-- detail -->
            <div class="informasi-mob taller-elemen-mobile">
                <h1 class="judul-mob">Harga</h1>
                <p class="isi-mob">
                    <?php echo $this->money->format($p->harga);?>
                </p>

                <h1 class="judul-mob">Keberangkatan</h1>
                <p class="isi-mob">
                    <?php echo $tanggal; ?>
                </p>

                <h1 class="judul-mob">Seat Tersisa</h1>
                <p class="isi-mob">
                    <?php echo $p->jumlah_seat ?>
                </p>

            </div>
        </div>

        <!-- buttons -->
        <div class="wider-elemen-mobile">

            <?php if ($p->paket_flyer != null) {?>
                <a href="<?php echo base_url() . $p->paket_flyer ?>" download><button class="tombol-mob" id="misc-on" >Lihat Flyer</button></a>
            <?php } else {?>
                <a><button class="tombol-mob" id="misc-off">Lihat Flyer</button></a>
            <?php }?>

            <?php if ($p->itinerary != null) {?>
                <a href="<?php echo base_url() . $p->itinerary; ?>" download><button class="tombol-mob" id="misc-on" style="padding-right: 16px; padding-left: 16px;">Itinerary</button></a>
            <?php } else { ?>
                <a><button class="tombol-mob" id="misc-off">Itinerary</button></a>
            <?php } ?>

            <a href="<?php echo base_url() . '/jamaah/detail_paket?id=' . $p->id_paket?>"><button class="tombol-mob" id="daftar">Daftar</button></a>
    
        </div>

    </div>
    <!-- MOBILE END -->

    <!-- DESKTOP -->
    <div class="kartu">

        <!-- image -->
        <img class="mini-elemen spanduk"
                src="<?php echo ($p->banner_image) ? base_url() . $p->banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>"
                alt="Banner" onclick="change(this)">

        <!-- content -->
        <div class="mid-elemen informasi-container">
            <div class="judul-utama">
                <?php echo $p->nama_paket ?>
            </div>
            <div class="info-utama">
                <div class="info-utama-container">

                    <div class="cotainer-konten harga-container">
                        <div class="simbol" id="img-uang">
                            <img class="simbol-img"  src="<?php echo base_url() . "/asset/appkit/images/icons/api/harga.png" ?>" alt="Icon Harga" width="40" style="padding-top: 14px;"> 
                        </div>

                        <div class="info-judul">Harga</div>

                        <div class="info-konten"> <?php echo $this->money->format($p->harga);?></div>
                    </div>

                    <div class="cotainer-konten seat-container">
                        <div class="simbol">
                            <img id="simbol-img" src="<?php echo base_url() . "/asset/appkit/images/icons/api/kursi.png" ?>"alt="Icon Kursi" width="40" height="40">
                        </div>

                        <div class="info-judul">Seat Tersisa</div>

                        <div class="info-konten"><?php echo $p->jumlah_seat ?></div>
                    </div>

                    <div class="cotainer-konten berangkat-container">
                        <div class="simbol">
                            <img id="simbol-img" src="<?php echo base_url() . "/asset/appkit/images/icons/api/tanggal.png" ?>" alt="Icon Tanggal" width="35" height="35">
                        </div>

                        <div class="info-judul">Keberangkatan</div>

                        <div class="info-konten"><?php echo $tanggal;?></div>
                    </div>

                    <div class="cotainer-konten maskapai-container">
                        <div class="simbol">
                            <img id="simbol-img" src="<?php echo base_url() . "/asset/appkit/images/icons/api/maskapai.png" ?>" alt="Icon Maskapai" width="35" height="35"> 
                        </div>

                        <div class="info-judul">Maskapai</div>

                        <div class="info-konten">
                            <?php
                            $maskapai = "Maskapai Belum Tersedia";

                            if(strpos(strtolower($p->nama_paket )," sv") == true){
                                $maskapai = "SAUDIA";
                            } 
                            elseif(strpos(strtolower($p->nama_paket )," qr") == true){
                                $maskapai = "QATAR";
                            }
                            else if(strpos(strtolower($p->nama_paket )," wy") == true){
                                $maskapai = "OMAN";
                            }
                            else if(strpos(strtolower($p->nama_paket )," ek") == true){
                                $maskapai = "EMIRATES";
                            }
                            else if(strpos(strtolower($p->nama_paket )," jt") == true){
                                $maskapai = "LION AIR";
                            } 
                            echo $maskapai;
                            ?>
                        </div>
                    </div>

                    <div class="cotainer-konten hotel-container">
                        <div class="simbol">
                            <img id="simbol-img" src="<?php echo base_url() . "/asset/appkit/images/icons/api/hotel.png" ?>" alt="Icon Hotel" width="35" height="35"> 
                        </div>

                        <div class="info-judul">Hotel</div>

                        <div class="info-konten">
                        <?php 
                        if(empty($p->hotel)){
                            echo ' Hotel Belum Tersedia';
                        
                        } else {
                            $namaHotel = [];
                            foreach($p->hotel as $h){
                                $namaHotel[] = $h->nama_hotel;
                            }
                            echo implode(" dan ", $namaHotel);
                        }
                        ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- buttons -->
        <div class="mini-elemen tombol-container">
            <?php if ($p->paket_flyer != null) {?>
                <a href="<?php echo base_url() . $p->paket_flyer ?>" download><button class="tombol flyer" id="misc-on">Lihat Flyer</button></a>
            <?php } else {?>
                <a><button class="tombol flyer" id="misc-off">Lihat Flyer</button></a>
            <?php }?>

            <?php if ($p->itinerary != null) {?>
                <a href="<?php echo base_url() . $p->itinerary; ?>" download><button class="tombol itinerary" id="misc-on" >Itinerary</button></a>
            <?php } else { ?>
                <a><button class="tombol itinerary" id="misc-off">Itinerary</button></a>
            <?php } ?>

            <a href="<?php echo base_url() . '/jamaah/detail_paket?id=' . $p->id_paket?>"><button class="tombol daftar" id="daftar">Daftar</button></a>
        </div>
 

    </div>
    <!-- DESKTOP END -->

<?php } ?>

<script>
    function change(element) {
        element.classList.toggle("popup");
    }
</script>



