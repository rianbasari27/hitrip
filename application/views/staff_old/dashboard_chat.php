<html>
    <head>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <link href="<?php echo base_url(); ?>asset/chat/style.css" rel="stylesheet">
        <!------ Include the above in your HEAD tag ---------->
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-comment"></span> Message Center
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-chevron-down"></span>
                                </button>
                                <ul class="dropdown-menu slidedown">
                                    <li><a href="#" id="chatRefresh"><span class="glyphicon glyphicon-refresh">
                                            </span>Refresh</a></li>
                                    <li><a href="#" id="chatDelete"><span class="glyphicon glyphicon-remove">
                                            </span>Delete Last Send</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <ul class="chat">
                                <?php
                                $class = 'right';
                                $prevId = '';
                                ?>
                                <?php foreach ($pesan as $key => $p) { ?>
                                    <?php
                                    if ($prevId != $p->id_staff) {
                                        if ($class == 'right') {
                                            $class = 'left';
                                        } else {
                                            $class = 'right';
                                        }
                                    }
                                    $prevId = $p->id_staff;
                                    ?>
                                    <li class="<?php echo $class; ?> clearfix"><span class="chat-img pull-<?php echo $class; ?>">
                                            <img style="width: 50px" src="<?php echo base_url() . 'asset/images/staff/' . $p->image; ?>" alt="<?php echo base_url() . 'asset/images/staff/default-avatar.png'; ?>" onerror="this.onerror=null;this.src=this.alt;" class="img-circle" />
                                        </span>
                                        <div class="chat-body clearfix">
                                            <div class="header">
                                                <?php if ($class == 'left') { ?>
                                                    <span class="primary-font">
                                                        <strong><?php echo $p->nama; ?></strong> 
                                                        <small class="text-muted"><?php echo $p->bagian; ?></small> 
                                                    </span>
                                                    <small class="pull-right text-muted">
                                                        <span class="glyphicon glyphicon-time"></span><?php echo date_format(date_create($p->tanggal_post), 'j-M-y G:i:s'); ?>
                                                    </small>
                                                <?php } else { ?>
                                                    <small class="text-muted">
                                                        <span class="glyphicon glyphicon-time"></span><?php echo date_format(date_create($p->tanggal_post), 'j-M-y G:i:s'); ?>
                                                    </small>
                                                    <span class="primary-font pull-<?php echo $class; ?>">
                                                        <strong><?php echo $p->nama; ?></strong>
                                                        <small class="text-muted"><?php echo $p->bagian; ?></small> 
                                                    </span>
                                                <?php } ?>

                                            </div>
                                            <p>
                                                <?php echo $p->pesan; ?>
                                            </p>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="panel-footer">
                            <div class="input-group">
                                <form action="<?php echo base_url(); ?>staff/dashboard/send_chat" method="post" style="display: contents">
                                    <input name="message" id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                                    <span class="input-group-btn">
                                        <button class="btn btn-warning btn-sm" id="btn-chat">
                                            Send</button>
                                    </span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#chatRefresh').click(function () {
                    reload();
                });
                $('#chatDelete').click(function () {
                    var r = confirm("Hapus chat terakhir Anda?");
                    if (r === true) {
                        window.location.href = "<?php echo base_url(); ?>staff/dashboard/delete_chat";
                    }
                });
                function reload(){
                    window.location.href = "<?php echo base_url(); ?>staff/dashboard/chat";
                }
            });
        </script>
    </body>
</html>