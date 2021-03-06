<?php

class ep_ktr_perubahan extends MY_Model {

    public $table = 'EP_KTR_PERUBAHAN';
    public $elements_conf = array(
//        'KODE_PERUBAHAN',
//        'KODE_KONTRAK',
//        'KODE_KANTOR',
        'TGL_MULAI',
        'TGL_AKHIR',
        'NILAI_KONTRAK',
        'TGL_PERUBAHAN',
        'MATA_UANG' => array('type' => 'label'),
//        'STATUS',
//        'POSISI_PERSETUJUAN',
        'TIPE_KONTRAK' => array('type' => 'label'),
        'JENIS_KONTRAK' => array('type' => 'label'),
        'NO_KONTRAK' => array('type' => 'label'),
//        'PERIODE_BAYAR_SEWA',
//        'UNIT_BAYAR_SEWA',
//        'TERMIN_BAYAR_SEWA',
        'KET_PERUBAHAN' => array('type' => 'label'),
        'ALASAN_PERUBAHAN' => array('type' => 'label'),
        'LAMPIRAN' => array('type' => 'file'),
    );
    public $dir = 'ammend';

    function __construct() {
        parent::__construct();
        $this->init();

        if (isset($_REQUEST['KODE_KONTRAK'])) {
            
//            $this->elements_conf['KODE_KONTRAK']['value'] = $_REQUEST['KODE_KONTRAK'];
//            
//            $row = $this->db->query("select * 
//                from EP_KTR_PERUBAHAN 
//                where KODE_KONTRAK = '" . $_REQUEST['KODE_KONTRAK'] . "'")->row_array();
//
//            if (!count($row)) {
//                // get default selected
//                $row = $this->db->query("select * 
//                    from EP_KTR_KONTRAK 
//                    where KODE_KONTRAK = '" . $_REQUEST['KODE_KONTRAK'] . "'")->row_array();
//            } else {
//                $this->attributes['KODE_PERUBAHAN'] = $row['KODE_PERUBAHAN'];
//            }
            
//            $this->attributes['KODE_KONTRAK'] = $row['KODE_KONTRAK'];
//            $this->attributes['KODE_KANTOR'] = $row['KODE_KANTOR'];
//            $this->attributes['TIPE_KONTRAK'] = $row['TIPE_KONTRAK'];
//            $this->attributes['TGL_MULAI'] = $row['TGL_MULAI'];
//            $this->attributes['TGL_AKHIR'] = $row['TGL_AKHIR'];
//            $this->attributes['JENIS_KONTRAK'] = $row['JENIS_KONTRAK'];
//            $this->attributes['NO_KONTRAK'] = $row['NO_KONTRAK'];
//            $this->attributes['MATA_UANG'] = $row['MATA_UANG'];
//            $this->attributes['NILAI_KONTRAK'] = $row['NILAI_KONTRAK'];
        }

    }

    public function _before_save() {
        parent::_before_save();
        
        if (isset($this->attributes['LAMPIRAN']) && strlen($this->attributes['LAMPIRAN']) == 0)
            unset($this->attributes['LAMPIRAN']);
    }
    
    public function _after_insert() {
        parent::_after_insert();

        if (isset($this->attributes['KODE_PERUBAHAN']) != "" &&
                isset($this->attributes['KODE_KANTOR']) != "" &&
                isset($this->attributes['KODE_KONTRAK']) != "") {

            $sql = "INSERT INTO EP_KTR_PERUBAHAN_ITEM  (KODE_PERUBAHAN, KODE_KONTRAK, KODE_KANTOR, KODE_BARANG_JASA, KODE_SUB_BARANG_JASA, KETERANGAN, HARGA, JUMLAH)
                    SELECT " . $this->attributes['KODE_PERUBAHAN'] . " as \"KODE_PERUBAHAN\", KODE_KONTRAK, KODE_KANTOR, KODE_BARANG_JASA, KODE_SUB_BARANG_JASA, KETERANGAN, HARGA, JUMLAH  
                    FROM EP_KTR_KONTRAK_ITEM
                    WHERE 
                        KODE_KONTRAK = '" . $this->attributes['KODE_KONTRAK'] . "' 
                        AND KODE_KANTOR = '" . $this->attributes['KODE_KANTOR']. "'";

            $query = $this->db->query($sql);

            $sql = "INSERT INTO EP_KTR_PERUBAHAN_JANGKA (KODE_PERUBAHAN, KODE_JANGKA, KODE_KONTRAK, KODE_KANTOR, PERSENTASI, JUMLA_UANG, TGL_TARGET, KETERANGAN)
                    SELECT " . $this->attributes['KODE_PERUBAHAN'] . " as \"KODE_PERUBAHAN\", KODE_JANGKA, KODE_KONTRAK, KODE_KANTOR, PERSENTASI, JUMLA_UANG, TGL_TARGET, KETERANGAN  
                    FROM EP_KTR_JANGKA_KONTRAK
                    WHERE 
                        KODE_KONTRAK = '" . $this->attributes['KODE_KONTRAK'] . "' 
                        AND KODE_KANTOR = '" . $this->attributes['KODE_KANTOR']. "'";

            $query = $this->db->query($sql);
        }
    }

}
?>