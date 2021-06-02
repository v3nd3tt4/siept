<div class="main-content-inner">
    
    
    <!-- market value area start -->
    <div class="row mt-5 mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    <p>
                    <!-- <button class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</button> -->
                    <a href="<?=base_url()?>surat_tugas/tambah_sendiri" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Buat SPT Sendiri</a>
                    <br>
                    </p>
                    <!-- <form action="" method="POST">
                        <div class="form-group">
                            <label for="">Filter Status SPT:</label>
                            <select class="form-control" name="id_status" id="id_status" style="min-height: 50px">
                                <option value="">--pilih--</option>
                                <?php
                                $this->db->from('db_siept.tb_status');
                                $this->db->where_not_in('id_status', array(3));
                                $qstat=$this->db->get();
                                    foreach($qstat->result() as $rstat){ ?>
                                <option value="<?=$rstat->id_status?>" <?=$rstat->id_status == $this->input->post('id_status',true) ? 'selected' : '' ?>><?=$rstat->nama_status?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Filter</button>
                        <?php if($this->input->post('id_status',true)){?>
                        <a href="<?=base_url()?>surat_tugas" class="btn btn-warning">Reset Filter</a>
                        <?php }?>
                    </form> -->
                    <br><br>
                    <div class="table-responsive">
                    <table id="dataTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Surat</th>
                                <th>Nomor Perkara</th>
                                <th>Agenda</th>
                                <th>Kepada</th>
                                <th>Status</th>
                                <th>PP</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;foreach($surat->result() as $rsurat){ 
                                $q = $this->db->get_where('sipp320.pihak', array('id' => $rsurat->id_pihak_penerima));
                                $pihak = $q->row()->nama;
                                
                                if($rsurat->id_status == 1){
                                    $label = 'secondary';
                                }else if($rsurat->id_status == 2){
                                    $label = 'warning';
                                }else if($rsurat->id_status == 3){
                                    $label = 'danger';
                                }else if($rsurat->id_status == 4){
                                    $label = 'dark';
                                }else if($rsurat->id_status == 5){
                                    $label = 'info';
                                }else if($rsurat->id_status == 6){
                                    $label = 'success';
                                }
                            ?>
                            <tr>
                                <td><?=$no++?>.</td>
                                <td><?=$rsurat->nomor_surat_full?></td>
                                <td><?=$rsurat->nomor_perkara?></td>
                                <td><?=$rsurat->text?></td>
                                <td><?=$pihak?></td>
                                <td>
                                    <span class="badge badge-<?=$label?>">
                                    <?=$rsurat->nama_status?>
                                    </span>
                                </td>
                                <td>
                                    <?=$rsurat->nama_user?>
                                </td>
                                <td>
                                    <?=$rsurat->keterangan != '' ? $rsurat->keterangan : 'Tidak ada'?>
                                </td>
                                <td>
                                    <!-- <button class="btn btn-warning btn-sm">Detail</button> -->
                                    <?php
                                    if($rsurat->id_status == 1){ ?>
                                        <!-- <a href="<?=base_url()?>surat_tugas/teruskan/<?=$rsurat->id_surat?>" class="btn btn-secondary btn-xs" onclick="return confirm('Apakah anda yakin meneruskan SPT ini ke Panitera?');"> <i class="fa fa-mail-forward"></i> Teruskan Ke Panitera</a> -->
                                        <a href="#" class="btn btn-secondary btn-xs btn-teruskan-panitera" id="<?=$rsurat->id_surat?>"> <i class="fa fa-mail-forward"></i> Teruskan Ke Panitera</a>
                                        <a href="<?=base_url()?>surat_tugas/cetak/<?=$rsurat->id_surat?>" > <i class="fa fa-file-word-o"></i> Lihat SPT</a>
                                    <?php }else if($rsurat->id_status == 2){
                                        
                                    }else if($rsurat->id_status == 3){ ?>
                                        <a href="<?=base_url()?>surat_tugas/teruskan/<?=$rsurat->id_surat?>" class="btn btn-secondary btn-xs" onclick="return confirm('Apakah anda yakin meneruskan SPT ini ke Panitera?');"> <i class="fa fa-mail-forward"></i> Teruskan Ke Panitera</a>
                                        <a href="<?=base_url()?>surat_tugas/cetak/<?=$rsurat->id_surat?>" > <i class="fa fa-file-word-o"></i> Lihat SPT</a>
                                    <?php }else if($rsurat->id_status == 4){ ?>
                                        <a href="<?=base_url()?>surat_tugas/cetak/<?=$rsurat->id_surat?>" class="btn btn-light btn-sm"> <i class="fa fa-file-word-o"></i> Lihat SPT</a>                                    
                                    <?php }else if($rsurat->id_status == 5){ ?>
                                        <a href="<?=base_url()?>surat_tugas/tambah/<?=$rsurat->id_surat?>" class="btn btn-info btn-sm"> <i class="fa fa-pencil"></i> Buat Surat Tugas</a>
                                    <?php }else if($rsurat->id_status == 6){ ?>
                                        <!-- <a href="<?=base_url()?>surat_tugas/cetak/<?=$rsurat->id_surat?>" class="btn btn-success btn-xs"> <i class="fa fa-download"></i> Download SPT</a> -->
                                        <a href="<?=base_url()?>upload/relaas/<?=$rsurat->file_relaas?>" class="btn btn-danger btn-sm"> <i class="fa fa-download"></i> Lihat Relaas</a>
                                    <?php }
                                    ?>
                                    
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    </div>
                    <!-- <div class="d-sm-flex justify-content-between align-items-center">
                        <h4 class="header-title mb-0">Market Value And Trends</h4>
                        <select class="custome-select border-0 pr-3">
                            <option selected>Last 24 Hours</option>
                            <option value="0">01 July 2018</option>
                        </select>
                    </div>
                    <div class="market-status-table mt-4">
                        <div class="table-responsive">
                            <table class="dbkit-table">
                                <tr class="heading-td">
                                    <td class="mv-icon">Logo</td>
                                    <td class="coin-name">Coin Name</td>
                                    <td class="buy">Buy</td>
                                    <td class="sell">Sells</td>
                                    <td class="trends">Trends</td>
                                    <td class="attachments">Attachments</td>
                                    <td class="stats-chart">Stats</td>
                                </tr>
                                <tr>
                                    <td class="mv-icon"><img src="<?=base_url()?>assets_srtdash/images/icon/market-value/icon1.png" alt="icon">
                                    </td>
                                    <td class="coin-name">Dashcoin</td>
                                    <td class="buy">30% <img src="<?=base_url()?>assets_srtdash/images/icon/market-value/triangle-down.png" alt="icon"></td>
                                    <td class="sell">20% <img src="<?=base_url()?>assets_srtdash/images/icon/market-value/triangle-up.png" alt="icon"></td>
                                    <td class="trends"><img src="<?=base_url()?>assets_srtdash/images/icon/market-value/trends-up-icon.png" alt="icon"></td>
                                    <td class="attachments">$ 56746,857</td>
                                    <td class="stats-chart">
                                        <canvas id="mvaluechart"></canvas>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mv-icon">
                                        <div class="mv-icon"><img src="<?=base_url()?>assets_srtdash/images/icon/market-value/icon2.png" alt="icon"></div>
                                    </td>
                                    <td class="coin-name">LiteCoin</td>
                                    <td class="buy">30% <img src="<?=base_url()?>assets_srtdash/images/icon/market-value/triangle-down.png" alt="icon"></td>
                                    <td class="sell">20% <img src="<?=base_url()?>assets_srtdash/images/icon/market-value/triangle-up.png" alt="icon"></td>
                                    <td class="trends"><img src="<?=base_url()?>assets_srtdash/images/icon/market-value/trends-down-icon.png" alt="icon"></td>
                                    <td class="attachments">$ 56746,857</td>
                                    <td class="stats-chart">
                                        <canvas id="mvaluechart2"></canvas>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mv-icon">
                                        <div class="mv-icon"><img src="<?=base_url()?>assets_srtdash/images/icon/market-value/icon3.png" alt="icon"></div>
                                    </td>
                                    <td class="coin-name">Euthorium</td>
                                    <td class="buy">30% <img src="<?=base_url()?>assets_srtdash/images/icon/market-value/triangle-down.png" alt="icon"></td>
                                    <td class="sell">20% <img src="<?=base_url()?>assets_srtdash/images/icon/market-value/triangle-up.png" alt="icon"></td>
                                    <td class="trends"><img src="<?=base_url()?>assets_srtdash/images/icon/market-value/trends-up-icon.png" alt="icon"></td>
                                    <td class="attachments">$ 56746,857</td>
                                    <td class="stats-chart">
                                        <canvas id="mvaluechart3"></canvas>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mv-icon">
                                        <div class="mv-icon"><img src="<?=base_url()?>assets_srtdash/images/icon/market-value/icon4.png" alt="icon"></div>
                                    </td>
                                    <td class="coin-name">Bitcoindash</td>
                                    <td class="buy">30% <img src="<?=base_url()?>assets_srtdash/images/icon/market-value/triangle-down.png" alt="icon"></td>
                                    <td class="sell">20% <img src="<?=base_url()?>assets_srtdash/images/icon/market-value/triangle-up.png" alt="icon"></td>
                                    <td class="trends"><img src="<?=base_url()?>assets_srtdash/images/icon/market-value/trends-up-icon.png" alt="icon"></td>
                                    <td class="attachments">$ 56746,857</td>
                                    <td class="stats-chart">
                                        <canvas id="mvaluechart4"></canvas>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- market value area end -->

    <div class="modal" id="modal-teruskan-panitera" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Teruskan Ke Panitera</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form-teruskan-panitera">
                <div class="modal-body">
                    
                    <div class="form-group">
                        <input type="hidden" name="id_surat" id="id_surat">
                        <label for="">Jenis File SPT:</label>
                        <select name="jenis_spt" class="form-control" id="jenis_spt" required>
                            <option value="">--pilih--</option>
                            <option value="sama dengan sistem">Sama Dengan Sistem</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                    <div class="form-group file-spt" style="display:none">
                        <label for="">File SPT (Rtf): max. 1 Mb</label>
                        <input type="file" name="file_spt" class="form-control">
                    </div>
                    <div class="notif"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    
    
</div>