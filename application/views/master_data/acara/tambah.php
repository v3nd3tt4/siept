<div class="main-content-inner">
    
    
    <!-- market value area start -->
    <div class="row mt-5 mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p>
                    <button class="btn btn-default" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Kembali</button>
                    <br>
                    </p>
                    <br><br>
                    <form action="<?=base_url()?>master/acara/simpan" method="POST">
                        <div class="form-group">
                            <label for="">Text:</label>
                            <textarea name="text" id="text" class="form-control"></textarea>
                        </div>
                        <button class="btn btn-success pull-right" > <i class="fa fa-save"></i> Simpan</button>
                    </form>
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
    
    
</div>