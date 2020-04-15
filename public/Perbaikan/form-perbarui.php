<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo APP_NAME ?>Form Perbaikan</title>

    <?php
    
    inc("include/includeCSS") ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php inc("include/navigation") ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Form Perbarui</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Perbarui Data
                        </div>
                        <?php 
                                  
                        $request = new \engine\http\Request();
                        $perbaikan = new \model\Perbaikan();
                        $perbaikan->select($perbaikan->getTable())->where()
                        ->comparing("kode_permasalahan", $request->get(2))->ready();

                        $row = $perbaikan->getStatement()->fetch();

                        $notifikasi = $request->getNotification();
                    
                        echo $notifikasi;

                        ?>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" action="<?php url("perbaruiPerbaikan/") ?>" method="post">
                                        <input type="text" class="hide" name="kode_perbaikan" value="<?php echo $row['kode_perbaikan'] ?>">
                                        
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea class="form-control" rows="3" name="keterangan" placeholder="Masukan laporan penanganan terbaru"></textarea>
                                        </div>
                                        <p class="help-block">Note permasalahan: <?php echo $row['keterangan'] ?></p>

                                        <div class="form-group">
                                            <label>Lama Penanganan</label>
                                            <select class="form-control" name="lama_perbaikan">
                                                <option value="-----">---</option>
                                                <option value="secepatnya">Secepatnya</option>
                                                <option value="sehari">Sehari</option>
                                                <option value="2 hari">2 hari</option>
                                                <option value="3 hari">3 hari</option>
                                                <option value="lebih 3 hari">lebih dari 3 hari</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Penanganan</label>
                                            <select class="form-control" name="penanganan" id="penangananId">
                                                <option value="vendor">Vendor</option>
                                                <option value="pegawai">Pegawai</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="Ditunggu">Ditunggu</option>
                                                <option value="Selesai">Selesai</option>
                                            </select>
                                        </div>

                                        <div class="form-group hide">
                                            <label>Kode permasalahan</label>
                                            <input type="text" name="kode_permasalahan" id="kodePermasalahanId" class="form-control" value="<?php echo $row['kode_permasalahan'] ?>">
                                        </div>

                                        <!-- jika pegawai yang menangani permasalahan tersebut-->         
                                        <div class="form-group" id="pegawaiId">
                                            <label>Pegawai yang menangani</label>
                                            <select class="form-control" name="nip">
                                            <option value="">-</option>
                                            <?php
                                                $pegawai2 = new \model\Pegawai();
                        
                                                $pegawai2->select($pegawai2->getTable())->where()->comparing("kode_departement",$_SESSION['hak_akses'])->ready();

                                                while($rows = $pegawai2->getStatement()->fetch()){
                                                    ?><option value="<?php echo $rows[0]?>"><?php echo $rows['nip']."-".$rows[1] ?></option>
                                                    
                                            <?php 
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        
                                        <!-- jika vendor yang menangani permasalahan tersebut dan pegawai yang input yang bertanggung jawab -->         
                                        <div class="form-group" id="vendorTerkaitId">
                                            <label>Vendor terkait</label>
                                            <input type="text" name="vendor" id="vendorId" class="form-control" placeholder="Masukan nama vendor">
                                        </div>
                                        
                                        <button type="submit" class="btn btn-default" name="submit">Perbarui</button>
                                    </form>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php inc("include/includeJS") ?>
    <script type="text/javascript">
        $(document).ready(function (){
            $("#pegawaiId").hide();

            $('#penangananId').change(function (){
                
                var penanganan = $("#penangananId").val();

                if(penanganan == 'vendor'){
                    $("#pegawaiId").hide();
                    $("#vendorTerkaitId").show();
                }else if(penanganan == 'pegawai'){
                    $("#pegawaiId").show();
                    $("#vendorTerkaitId").hide();
                }
            });
            
        });
    </script>
</body>
</html>
