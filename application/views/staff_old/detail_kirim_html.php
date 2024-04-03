<html>

    <head>
        <style>
            td {
                vertical-align: top;
            }
            .rounded-box {
                border-radius: 30px;
            }
            .rounded-box1 {
                border-radius: 15px;
            }
            .border-out {
                border: 4px solid black;
            }
            .border-in {
                border: 2px solid black;
            }
            .bold {
                font-weight: 700;
            }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>

    <body>
        <div>
                <div class="border-out rounded-box p-3">
                        <div>
                        
                        <!-- <div class="row">
                            <div class="col-md-7"> -->
                                <table>
                                    <tr>
                                        <td style="width: 70%;"><span class="bold">Penerima</span></td>
                                        <td><span class="ms-5 bold">Pengirim</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td style="width: 120px;">Nama</td>
                                                    <td>&emsp;: </td>
                                                    <td><?php echo $nama; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>No HP/WA </td>
                                                    <td>&emsp;: </td>
                                                    <td><?php echo $no_wa; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td>&emsp;: </td>
                                                    <td><?php echo $alamat; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td><span class="ms-5">VENTOUR TRAVEL</span></td>
                                    </tr>
                                </table>
                                <!-- <table>
                                    <tr>
                                        <td>Nama</td>
                                        <td>&emsp;: </td>
                                        <td><?php echo $nama; ?></td>
                                    </tr>
                                    <tr>
                                        <td>No HP/WA </td>
                                        <td>&emsp;: </td>
                                        <td><?php echo $no_wa; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>&emsp;: </td>
                                        <td><?php echo $alamat; ?></td>
                                    </tr>
                                </table> -->
                            </div>
                            <!-- <div class="col-md-5"> -->
                                <!-- <p class="mb-1"><strong>Pengirim</strong></p>
                                <p>VENTOUR TRAVEL</p> -->
                            <!-- </div> -->
                        <!-- </div> -->
                        <div class="mt-3 p-2 border-in rounded-box1">
                            <ol>
                                <?php foreach ($perlengkapan as $item) : ?>
                                    <li><?php echo $item ?></li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>

</html>