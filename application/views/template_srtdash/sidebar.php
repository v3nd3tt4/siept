<!-- sidebar menu area start -->
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo">
                <!-- <a href="index.html"><img src="<?=base_url()?>assets_srtdash/images/icon/logo.png" alt="logo"></a> -->
                <h3 style="color:#fff">SIE PT</h3>
                <p style="color: #fff">Pengadilan Negeri Rantau</p>
            </div>
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                <nav>
                    <ul class="metismenu" id="menu">
                        <?php if($this->session->userdata('level') == 'admin'){?>
                        <li <?php if(@$link=='dasar' || @$link=='perihal' || @$link=='guna' || @$link=='acara'){?> class="active" <?php }?>>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Master Data</span></a>
                            <ul class="collapse">
                                <li <?php if(@$link=='dasar'){?> class="active" <?php }?>><a href="<?=base_url()?>master/dasar">Dasar</a></li>
                                <li <?php if(@$link=='perihal'){?> class="active" <?php }?>><a href="<?=base_url()?>master/perihal">Perihal</a></li>
                                <li <?php if(@$link=='guna'){?> class="active" <?php }?>><a href="<?=base_url()?>master/guna">Guna</a></li>
                                <li <?php if(@$link=='acara'){?> class="active" <?php }?>><a href="<?=base_url()?>master/acara">Acara</a></li>
                            </ul>
                        </li>
                        <li <?php if(@$link=='nst'){?> class="active" <?php }?>>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>setting</span></a>
                            <ul class="collapse">
                                <li <?php if(@$link=='nst'){?> class="active" <?php }?>><a href="<?=base_url()?>setting/nst">Nomor Surat Terakhir</a></li>
                            </ul>
                        </li>
                        <?php }?>
                        
                        <?php $arr = array('admin', 'perdata');
                        if(in_array($this->session->userdata('level', true),$arr) ){
                            $l = 'surat_tugas';
                            $ltext = 'Surat Tugas';
                        }else if($this->session->userdata('level', true) == 'panitera'){
                            $l = 'panitera/surat_tugas';
                            $ltext = 'Surat Tugas';
                        }else if($this->session->userdata('level', true) == 'pp'){
                            $l = 'pp/surat_tugas';
                            $ltext = 'Panggilan';
                        }else if($this->session->userdata('level', true) == 'jurusita'){
                            $l = 'jurusita/surat_tugas';
                            $ltext = 'Surat Tugas';
                        }?>
                        <li <?php if(@$link=='surat_tugas'){?> class="active" <?php }?>><a href="<?=base_url()?><?=$l?>"><i class="ti-map-alt"></i> <span><?=$ltext?></span></a></li>

                        <?php if($this->session->userdata('level') == 'admin'){?>
                        <li <?php if(@$link=='user'){?> class="active" <?php }?>><a href="<?=base_url()?>user"><i class="ti-user"></i> <span>User</span></a></li>
                        <?php }?>
                        
                    </ul>
                </nav>
            </div>
        </div>
    </div>
<!-- sidebar menu area end -->
