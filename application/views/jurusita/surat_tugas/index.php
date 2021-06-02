<div class="main-content-inner">
    
    
    <!-- market value area start -->
    <div class="row mt-5 mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p>
                        <!-- <button class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</button> -->
                        <!-- <a href="<?=base_url()?>jurusitasurat_tugas/tambah" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Buat Panggilan</a> -->
                    <br><br><br>
                    </p>
                    <div class="table-responsive">
                    <table id="dataTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Surat</th>
                                <th>Nomor Perkara</th>
                                <th>Tanggal Surat</th>
                                <th>Agenda</th>
                                <th>Kepada</th>
                                <th>Status</th>
                                <th>Dokumen</th>
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
                                    $label = 'success';
                                }else if($rsurat->id_status == 5){
                                    $label = 'info';
                                }else if($rsurat->id_status == 6){
                                    $label = 'default';
                                }
                            ?>
                            <tr>
                                <td><?=$no++?>.</td>
                                <td><?=$rsurat->nomor_surat_full?></td>
                                <td><?=$rsurat->nomor_perkara?></td>
                                <td><?=date('d-m-Y', strtotime($rsurat->tanggal_surat))?></td>
                                <td><?=$rsurat->text?></td>
                                <td><?=$pihak?></td>
                                <td>
                                    <span class="badge badge-<?=$label?>">
                                    <?=$rsurat->nama_status?>
                                    </span>
                                </td>
                                <td align="center">
                                    <a href="<?=base_url()?>jurusita/surat_tugas/cetak/<?=$rsurat->id_surat?>" > <i class="fa fa-file-word-o"></i> </a>
                                </td>
                                <td>
                                    <!-- <button class="btn btn-warning btn-sm">Detail</button> -->
                                    <?php 
                                        $arr = array(6);
                                        if(!in_array($rsurat->id_status, $arr) ){
                                    ?>
                                        <!-- <a href="<?=base_url()?>jurusita/surat_tugas/selesai/<?=$rsurat->id_surat?>" class="btn btn-warning btn-xs" onclick="return confirm('Apakah anda yakin akan menyelesaikan SPT ini?');"> <i class="fa fa-check"></i> Selesai</a> -->
                                        <a href="#" class="btn btn-warning btn-xs btn-selesai-relaas" id="<?=$rsurat->id_surat?>"> <i class="fa fa-check"></i> Upload Relaas</a>
                                        <!-- <a href="<?=base_url()?>panitera/surat_tugas/tolak/<?=$rsurat->id_surat?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah anda yakin tidak menyetujui SPT ini?');"> <i class="fa fa-remove"></i> Tidak disetujui</a> -->
                                    <?php

                                        }
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

    <div class="modal" id="modal-selesai-relaas" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Selesai Relaas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form-selesai-relaas">
                <div class="modal-body">
                    
                    <div class="form-group">
                        <input type="hidden" name="id_surat" id="id_surat">
                        <label for="">Tanggal Relaas: (wajib diisi)</label>
                        <input type="date" name="tanggal_relaas" class="form-control" required>
                    </div>
                    <div class="form-group file-spt">
                        <label for="">File Relaas (pdf): max. 1 Mb</label>
                        <input type="file" name="file_relaas" class="form-control">
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