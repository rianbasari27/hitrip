<style>
@media only screen and (max-width: 768px) {
    .mobile-margin {
        margin-left: 0px;
    }

    .container-utama {
        font-size: 12px;
        padding: 10px;
    }

    .container-tanggal {
        margin-left: 10px;
        margin-right: 10px;
    }

    .tanggal-isi {
        font-size: 12px;
        padding: 2px;
    }

    .harga-isi {
        font-size: 12px;
        padding: 4px;
    }

    .pesawat-isi {
        font-size: 12px;
        padding: 2px;
    }

    #non-mobile {
        display: none;
    }

    .detail-button {
        font-size: 12px;
    }

    .container-harga {
        padding: 4px;
    }

    .container-hotel-mk {
        /* flex: 0.5; */
        display: none;
    }

    .container-hotel-md {
        /* flex: 0.5; */
        display: none;
    }

    .container-pesawat {
        /* flex: 0.75; */
        display: none;
    }

    .container-detail {
        display: none;
    }
}

@media only screen and (min-width: 768px) {
    .mobile-margin {
        margin-left: 0px;
    }

    .container-utama {
        font-size: 14px;
        padding: 4px;
    }

    .pesawat-isi {
        font-size: 14px;
        padding: 4px;
    }

    .tanggal-isi {
        padding: 4px;
    }

    .harga-isi {
        padding: 4px;
    }

    #mobile {
        display: none;
    }

    .detail-button {
        font: 12px;
    }

    .header {
        padding: 16px;
    }

    .container-hotel-mk {
        flex: 1.25;
    }

    .container-hotel-md {
        flex: 1.25;
    }

    .container-pesawat {
        flex: 1;
    }

    .dropbtn {
        display: none;
    }

    .container-lainnya {
        display: none;
    }
}

s,
strike {
    text-decoration: none;
    position: relative;
}

s::before,
strike::before {
    top: 50%;
    /*tweak this to adjust the vertical position if it's off a bit due to your font family */
    background: red;
    /*this is the color of the line*/
    opacity: .7;
    content: '';
    width: 200%;
    position: absolute;
    height: .1em;
    border-radius: .1em;
    left: -100%;
    white-space: nowrap;
    display: block;
    transform: rotate(-8deg);
}

s.straight::before,
strike.straight::before {
    transform: rotate(0deg);
    left: -1%;
    width: 102%;
}

s,
strike {
    font-weight: bold;
    font-style: italic;
    /* Atur tebal teks */
}

.header {
    background-image: linear-gradient(to right, #D27E00, #F1B900);
    font-weight: bold;
    color: white;
    text-align: center;

    margin-bottom: 4px;
}

.divider-bulan {
    background-color: black;
    color: white;
    text-align: center;
    font-weight: bolder;
    justify-content: center;
}

.konten {
    background-color: white;
    /* text-align: center; */
    margin: 4px 0px 4px 0px;
}

.container-utama {
    display: flex;
    box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    align-items: center;

    font-family: 'Montserrat', sans-serif;
}

.container-nama {
    flex: 1.25;
    width: 60%;
    font-weight: bold;
}

.container-tanggal {
    flex: 0.8;
}

/* .container-pesawat {
        flex: 1;
    } */

/* .container-hotel-mk {
        flex: 1.25;
    }

    .container-hotel-md {
        flex: 1.25;
    } */

.container-harga {
    flex: 0.5;
}

.container-seat {
    flex: 0.5;
    font-weight: bold;
}

.container-detail {
    flex: 0.5;
}

.detail-button {
    background-color: black;
    color: white;
    text-align: center;
    font-weight: bolder;
    border-radius: 4px;
}

.detail-button {
    background-color: yellow;
    color: black;
    text-align: center;
    font-weight: bolder;
    border-radius: 4px;
}

.tanggal-isi {
    background-color: #F1B900;
    text-align: center;
    border-radius: 4px;

    color: white;
    font-weight: bold;
}

.harga-isi {
    background-color: #F1B900;
    text-align: center;
    border-radius: 4px;

    color: white;
    font-weight: bold;
}

.seat-isi {
    text-align: center;
}

.pesawat-isi {
    border-radius: 4px;
    font-weight: bolder;
}

#kosong {
    justify-content: center;
}

.other-button {
    background-color: lightgray;
    border-radius: 4px;
    border: none;
    /* width: 48px;
        height: 48px; */
}

.dropbtn {
    background-color: #fff;
    color: #333;
    /* padding: 10px; */
    font-size: 16px;
    border: none;
    cursor: pointer;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    z-index: 1;
    left: auto;
    right: 100%;
    top: 0;
}

.dropdown-content a {
    color: #333;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content .content-lainnya {
    color: #333;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

/* .dropdown:hover .dropdown-content {display: block;} */

.dropdown:hover .dropbtn {
    background-color: #f9f9f9;
}
</style>

<?php 
$prevMonth = '';
if(empty($paket)){
    echo "<div class='container-utama header' id='kosong'>Paket Belum Tersedia</div>";

} else { ?>

<div class="container-utama header">
    <div class="container-nama mobile-margin">Nama Paket</div>
    <div class="container-tanggal">Keberangkatan</div>
    <div class="container-pesawat">Maskapai</div>
    <div class="container-hotel-mk">Hotel Mekah</div>
    <div class="container-hotel-md">Hotel Madinah</div>
    <div class="container-harga">Harga</div>
    <div class="container-seat">Sisa Seat</div>
    <div class="container-detail">Detail</div>
    <div class="container-lainnya">Lainnya</div>
</div>

<?php
    foreach($paket as $p){ 

        $currentMonth = $p->bulan;
        
        if($prevMonth !== $currentMonth){
            echo "<div class='container-utama divider-bulan'> $currentMonth</div>";
            $prevMonth = $currentMonth;
        }
    ?>
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
    <div>
        <?php if ($p->default_diskon > 0) { ?>
        <s>
            <p style="text-align: center; margin-top: 0; margin-bottom: 3px; color: black; font-size: 12px;">
                <?php echo $p->hargaHome . " jt" ?>
            </p>
        </s>
        <?php //echo $p->hargaHome . " jt" ?>
        <div class="container-harga harga-isi">
            <?php echo $p->hargaHomeDiskon . " jt" ?>
        </div>
        <?php } else { ?>
        <div class="container-harga harga-isi">
            <?php echo $p->hargaHome . " jt" ?>
        </div>
        <?php } ?>
    </div>
    <div class="container-seat seat-isi" style="font-size:10px; color: <?php echo $p->sisa_seat <= 20 ? 'red' : 'green'; ?>"><?php echo $p->sisa_seat <= 20 ? $p->sisa_seat . " Tersisa" : 'Tersedia'?></div>
    <a class="container-detail" href="<?php echo base_url() . '/jamaah/detail_paket?id=' . $p->id_paket ?>">
        <button class="detail-button">Detail</button>
    </a>
    <div class="dropdown" id="myDropdown">
        <button onclick="toggleDropdown(this)" class="dropbtn">
            <svg class="other-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z" />
                <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
            </svg>
        </button>
        <div class="dropdown-content">
            <!-- Dropdown menu links -->
            <div class="content-lainnya">
                <div><strong>Maskapai</strong></div>
                <?php if(isset($p->url)){ 
                            $mob= substr_replace($p->url,'-mob',-4,0);
                            echo"<img id='non-mobile' src='$p->url' width='80px' />";
                            echo "<img id= 'mobile' src='$mob' height='60px' width='60px'/>";
                        } else { echo 'Belum Tersedia'; } ?>
            </div>
            <div class="content-lainnya">
                <div><strong>Hotel Mekkah</strong></div>
                <div><?php echo $p->hotels[0] ?></div>
            </div>
            <div class="content-lainnya">
                <div><strong>Hotel Madinah</strong></div>
                <div><?php echo $p->hotels[1] ?></div>
            </div>
            <a class="container-detail" href="<?php echo base_url() . '/jamaah/detail_paket?id=' . $p->id_paket ?>">
                <button class="detail-button">Detail</button>
            </a>
        </div>
    </div>

    <!-- <a class="container-lainnya" href="#">
                <button class="other-button">
                <svg class="other-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z"/>
                    <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
                </svg>
                </button>
            </a> -->
</div>
<?php } 
} ?>

<script>
function toggleDropdown(button) {
    var dropdownButton = button;
    var dropdownMenu = button.nextElementSibling;

    if (dropdownMenu.style.display === "block") {
        dropdownMenu.style.display = "none";
    } else {
        dropdownMenu.style.display = "block";
    }

    // Hide dropdown menu when clicking outside of it
    document.addEventListener("click", function(event) {
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = "none";
        }
    });
}
</script>