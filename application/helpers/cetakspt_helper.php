<?php 

function cetak_spt($id_surat){
    $ci =& get_instance();

    $qu = $ci->db->get_where('db_siept.tb_surat', array('id_surat' => $id_surat));
    $qu = $qu->row();
    $nomor_surat = $qu->nomor_surat_full;

    if($qu->jenis_surat_acc == 'custom'){
        $ttdel = './assets_srtdash/qrcode/'.$qu->qrcode; 
    
        include './application/libraries/Image.php';
        $functions = new Image($ttdel, 150, 150);
        $ttdarr = array('4', '6');
        if(in_array($qu->id_status, $ttdarr)){
            $hex = $functions->getContent();
        }else{
            $hex = '';
        }

        $document = file_get_contents("./upload/".$qu->file_custome);	
        
        $document = str_replace("%%ttdel%%", $hex, $document);
        header("Content-type: application/msword");
        header("Content-disposition: inline; filename=".$nomor_surat.".rtf");
        header("Content-length: " . strlen($document));
        return $document;
        exit();
    }

    
    $nomor_perkara = $qu->nomor_perkara;

    $perkara_id = $qu->id_perkara;
    $qperkara = $ci->db->get_where('sipp320.perkara', array('perkara_id' => $perkara_id));

    $tglregister = tgl_indo($qperkara->row()->tanggal_pendaftaran);

    $dasar = $ci->db->get_where('db_siept.tb_dasar', array('id_dasar' => $qu->id_dasar));
    $perihal = $ci->db->get_where('db_siept.tb_perihal', array('id_perihal' => $qu->id_perihal));
    $guna = $ci->db->get_where('db_siept.tb_guna', array('id_guna' => $qu->id_guna));
    $acara = $ci->db->get_where('db_siept.tb_acara', array('id_acara' => $qu->id_acara));

    $perihal = $perihal->row()->text;
    $tanggal_surat = tgl_indo($qu->tanggal_surat);
    $dasar = $dasar->row()->text;

    $guna = $guna->row()->text;
    $acara = $acara->row()->text;

    
    $hari_ini = hari_ini(date('D', strtotime($qu->hari)));
    $hari = $hari_ini.', '.tgl_indo($qu->hari);
    $pukul = $qu->pukul;
    
    $pecah = explode('/', $nomor_perkara);
    $kode = $pecah[1];

    //query get jenis perkara
    $qkode = $ci->db->get_where('sipp320.alur_perkara', array('kode' => $kode));
    $jnspkr = $qkode->row()->nama;
    $kodejnspkr = $qkode->row()->kode;

    //cek1
    $sbg = '';
    $qp1 = $ci->db->get_where('sipp320.perkara_pihak1', array('perkara_id' => $qu->id_perkara, 'pihak_id' => $qu->id_pihak_penerima));
    $cek_gugatan = stripos('Gugatan', $jnspkr);


    // $arrp = array('Pdt.P');
    
    $cek_perm = $ci->db->get_where('db_siept.tb_kode_permohonan', array('kode_perkara' => $kodejnspkr));
    
    if($qp1->num_rows() > 0){
        if($cek_perm->num_rows() != 0){
            $sbb = 'Pemohon';
        }else{
            $sbb = 'Penggugat';
        }
        $qpm1 = $ci->db->get_where('sipp320.perkara_pihak1', array('perkara_id' => $qu->id_perkara));
        if($qpm1->num_rows() > 1){
            $sbg = ' {\b '.$sbb.' '. KonDecRomawi($qp1->row()->urutan).'}';
        }else{
            $sbg = ' {\b '.$sbb.'}';
        }			
    }else{
        $qp2 = $ci->db->get_where('sipp320.perkara_pihak2', array('perkara_id' => $qu->id_perkara, 'pihak_id' => $qu->id_pihak_penerima));
        if($qp2->num_rows() > 0){
            if($cek_perm->num_rows() != 0){
                $sbb = 'Termohon';
            }else{
                $sbb = 'Tergugat';
            }
            $qpm2 = $ci->db->get_where('sipp320.perkara_pihak2', array('perkara_id' => $qu->id_perkara));
            if($qpm2->num_rows() > 1){
                $sbg = ' {\b '.$sbb.' '. KonDecRomawi($qp2->row()->urutan).'}';
            }else{
                $sbg = ' {\b '.$sbb.'}';
            }	
        }else{
            $qp4 = $ci->db->get_where('sipp320.perkara_pihak4', array('perkara_id' => $qu->id_perkara, 'pihak_id' => $qu->id_pihak_penerima));
            if($qp4->num_rows() > 0){
                if($cek_perm->num_rows() != 0){
                    $sbb = 'Turut Termohon';
                }else{
                    $sbb = 'Turut Tergugat';
                }
                $qpm4 = $ci->db->get_where('sipp320.perkara_pihak4', array('perkara_id' => $qu->id_perkara));
                if($qpm4->num_rows() > 1){
                    $sbg = ' {\b '.$sbb.' '. KonDecRomawi($qp4->row()->urutan).'}';
                }else{
                    $sbg = ' {\b '.$sbb.'}';
                }
            }
        }
    }

    $qtujuan = $ci->db->get_where('sipp320.pihak', array('id' => $qu->id_pihak_penerima));
    $pihak = $qtujuan->row()->nama;
    $nmtujuan = $pihak;
    $almtujuan = $qtujuan->row()->alamat.', dalam hal ini disebut sebagai '.$sbg.';';

    $js = $ci->db->get_where('sipp320.jurusita', array('aktif' => 'Y', 'id' => $qu->id_jurusita));
    $nmjs = $js->row()->nama;
    $nipjs = $js->row()->nip;

    $jabatanjs = 'Jurusita';
    
    $ttdel = './assets_srtdash/qrcode/'.$qu->qrcode; 
    
    include './application/libraries/Image.php';
    $functions = new Image($ttdel, 150, 150);
    $ttdarr = array('4', '6');
    if(in_array($qu->id_status, $ttdarr)){
        $hex = $functions->getContent();
    }else{
        $hex = '';
    }
    
    // $hex = 'url:{concat("https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2Fwww.google.com%2F&choe=UTF-8&chld=H&chl=",value)}';

    $document = file_get_contents("./assets_srtdash/SPT_temp_permohonan.rtf");		

    $qpihak1 = $ci->db->get_where('sipp320.perkara_pihak1', array('perkara_id' => $qu->id_perkara));

    $pihak1 = '';
    foreach($qpihak1->result()  as $rpihak1){
        // $pihak1 .= '{\pard ';
        $pihak1 .=  '{\b '.$rpihak1->nama.'}, beralamat di '.$rpihak1->alamat.'; '; 
        // $pihak1 .=  $rpihak1->nama.', beralamat di '.$rpihak1->alamat.'; \line'; 
        // $pihak1 .= ' \par}';
    }

    $qpihak2 = $ci->db->get_where('sipp320.perkara_pihak2', array('perkara_id' => $qu->id_perkara));

    $pihak2 = '';
    foreach($qpihak2->result()  as $rpihak2){
        // $pihak1 .= '{\pard ';
        $pihak2 .=  '{\b '.$rpihak2->nama.'}, beralamat di '.$rpihak2->alamat.'; '; 
        // $pihak1 .=  $rpihak1->nama.', beralamat di '.$rpihak1->alamat.'; \line'; 
        // $pihak1 .= ' \par}';
    }

    $qpihak4 = $ci->db->get_where('sipp320.perkara_pihak4', array('perkara_id' => $qu->id_perkara));

    $pihak4 = '';
    $no4=1;
    if($qpihak4->num_rows() > 0){
        $pihak4 .= ' {\pard\qc Dan \par}';
    }
    if($qpihak4->num_rows() > 1){
        // $pihak4 .= '{\rtf1 ';
        // $pihak4 .= '\pard{\pntext\f0 1.\tab}\*\pn\pnlvlbody\pnf0\pnindent0\pnstart1\pndec{\pntxta.}';
        // $pihak4 .= '\fi-360\li480\sa50\sl0\slmult1';
        
        
        foreach($qpihak4->result()  as $rpihak4){
            $pihak1 .= '{\pard ';
            $pihak4 .=  '{\b '.$no4.'. '.$rpihak4->nama.'}, beralamat di '.$rpihak4->alamat.';\line\line'; 
            // $pihak4 .= $rpihak4->nama.' beralamat di '.$rpihak4->alamat.';\par';
            // $pihak1 .=  $rpihak1->nama.', beralamat di '.$rpihak1->alamat.'; \line'; 
            $pihak1 .= '\par}';
            $no4++;
        }
        // $pihak4 .= '\pard\par normal text';
        // $pihak4 .= '}';
    }else if($qpihak4->num_rows() == 1){
        foreach($qpihak4->result()  as $rpihak4){
            // $pihak1 .= '{\pard ';
            $pihak4 .=  '{\b '.$rpihak4->nama.'}, beralamat di '.$rpihak4->alamat.';\line \line '; 
            // $pihak1 .=  $rpihak1->nama.', beralamat di '.$rpihak1->alamat.'; \line'; 
            // $pihak1 .= '\par}';
        }
    }

    // mereplace tanda %%%NAMA% dengan data nama dari form
    $document = str_replace("%%nosur%%", $nomor_surat, $document);
    $document = str_replace("%%noper%%", $nomor_perkara, $document);
    $document = str_replace("%%perihal%%", $perihal, $document);
    $document = str_replace("%%tglbuat%%", $tanggal_surat, $document);
    $document = str_replace("%%nmtujuan%%", $nmtujuan, $document);
    $document = str_replace("%%almtujuan%%", $almtujuan, $document);
    $document = str_replace("%%nmjs%%", $nmjs, $document);
    $document = str_replace("%%nipjs%%", $nipjs, $document);
    $document = str_replace("%%jabatanjs%%", $jabatanjs, $document);
    $document = str_replace("%%dasar%%", $dasar, $document);
    $document = str_replace("%%ttdel%%", $hex, $document);
    $document = str_replace("%%jnspkr%%", $jnspkr, $document);
    $document = str_replace("%%pihak1%%", $pihak1, $document);
    $document = str_replace("%%p2%%", $pihak2, $document);
    $document = str_replace("%%pemdll%%", $pihak4, $document);
    $document = str_replace("%%guna%%", $guna, $document);
    $document = str_replace("%%acara%%", $guna, $document);
    $document = str_replace("%%haritgl%%", $hari, $document);
    $document = str_replace("%%pukul%%", $pukul, $document);
    $document = str_replace("%%emnhp%%", '', $document);
    $document = str_replace("%%tglregister%%", $tglregister, $document);

    header("Content-type: application/msword");
    header("Content-disposition: inline; filename=".$nomor_surat.".rtf");
    header("Content-length: " . strlen($document));
    return $document;
    // redirect(base_url().'surat_tugas', 'refresh');
    // echo '<script>window.location.href = "'.base_url().'surat_tugas";</script>';
}
?>