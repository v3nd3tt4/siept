<div class="main-content-inner">
    <!-- market value area start -->
    <div class="row mt-5 mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p>
                    <button class="btn btn-default" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Kembali</button>
                    <br><br><br>
                    </p>
                    <form action="<?=base_url()?>surat_tugas/simpan" method="POST">
                    <div class="form-group">
                        <label for="">Nomor Perkara:</label>
                        <input type="hidden" class="form-control" name="id_surat" value="<?=$get_surat->row()->id_surat?>">
                        <input type="hidden" class="form-control" name="aksi" value="buatsurattugas">
                        <select class="form-control" name="nomor_perkara" style="min-height:50px" required disabled>
                            <option value="<?=$get_surat->row()->id_perkara?>"><?=$get_surat->row()->nomor_perkara?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Penerima Panggilan/Pemberitahuan:</label>
                        <select name="tujuan" id="tujuan" class="form-control" disabled required>
                            <option value="">--pilih--</option>
                            <option value="<?=$pihak->row()->id?>" selected><?=$pihak->row()->nama?></option>
                        </select>
                    </div>                    
                    <div class="form-group">
                        <label for="">Tanggal Pemanggilan:</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?=$get_surat->row()->hari?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="">Pukul:</label>
                        <input type="text" name="pukul" id="pukul" class="form-control" value="<?=$get_surat->row()->pukul?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="">Agenda:</label>
                        <select name="acara" id="acara" readonly disabled class="form-control" style="min-height:50px" required>
                            <option value="">--pilih--</option>
                            <?php foreach($acara->result() as $racara){?>
                            <option value="<?=$racara->id_acara?>" <?=$get_surat->row()->id_acara == $racara->id_acara ? 'selected' : ''?>><?=$racara->text?></option>
                            <?php }?>
                        </select>
                    </div>
                    
                    <!-- <div class="form-group">
                        <label for="">Nomor Surat:</label>
                        <input type="text" class="form-control" name="nomor_surat">
                    </div> -->
                    <div class="form-group">
                        <label for="">Jurusita:</label>
                        <select name="jurusita"  readonly id="jurusita" class="form-control" required>
                            <option value="">--pilih--</option>
                            <?php foreach($js->result() as $rjs){?>
                            <option value="<?=$rjs->id?>" <?=$jurusita->row()->jurusita_id == $rjs->id ? 'selected' : ''?> ><?=$rjs->nama?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Surat:</label>
                        <input type="date" name="tanggal_surat" id="tanggal_surat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Dasar Hukum Pemanggilan/Pemberitahuan:</label>
                        <select name="dasar" id="dasar" class="form-control select2" style="min-height:50px"  required>
                            <option value="">--pilih--</option>
                            <?php foreach($dasar->result() as $rdasar){?>
                            <option value="<?=$rdasar->id_dasar?>"><?=$rdasar->text?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Hal:</label>
                        <select name="perihal" id="perihal" class="form-control select2" style="min-height:50px" required>
                            <option value="">--pilih--</option>
                            <?php foreach($perihal->result() as $rperihal){?>
                            <option value="<?=$rperihal->id_perihal?>"><?=$rperihal->text?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tujuan Panggilan/Pemberitahuan:</label>
                        <select name="guna" id="guna" class="form-control select2" style="min-height:50px" required>
                            <option value="">--pilih--</option>
                            <?php foreach($guna->result() as $rguna){?>
                            <option value="<?=$rguna->id_guna?>"><?=$rguna->text?></option>
                            <?php }?>
                        </select>
                    </div>
                    <button type="submit" onsubmit="return confirm('Apakah anda yakin memroses Surat Tugas ini?');" class="btn btn-success pull-right"><i class="fa fa-refresh"></i> Proses</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- market value area end -->
</div>