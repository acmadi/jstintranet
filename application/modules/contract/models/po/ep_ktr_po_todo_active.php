<?php

class ep_ktr_po_todo_active extends MY_Model {

    public $table = 'EP_KTR_KONTRAK';
    
    public $sql_select = "( select a.*, '' as ACT 
        from EP_KTR_KONTRAK a 
        where TIPE_KONTRAK = 'HARGA SATUAN' and STATUS = 'O'
    )";
    
    public $columns_conf = array(
        'KODE_KONTRAK',
        'KODE_TENDER',
        'KODE_VENDOR',
        'KODE_KANTOR',
        'NAMA_VENDOR',
        'JUDUL_PEKERJAAN',
        'LINGKUP_KERJA',
        'TIPE_KONTRAK',
        'STATUS',
        'NILAI_KONTRAK',
        'ACT',
    );
    public $dir = 'po';
    
    function __construct() {
        parent::__construct();
        $this->init();
        
        $this->js_grid_completed = '
                var ids = jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'getDataIDs\');
		for(var i=0;i < ids.length;i++){
                    var cl = ids[i];
                    
                    var data = jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'getRowData\', cl);
                    
                    //alert(data[\'KODE_PROSES\']);
                    
                    var param = "referer_url=/contract/po/todo&KODE_KONTRAK=" + data[\'KODE_KONTRAK\'] 
                        + "&KODE_KANTOR=" + data[\'KODE_KANTOR\']
                        + "&KODE_VENDOR=" + data[\'KODE_VENDOR\'];
                    var href = $site_url + "/wkf/start?kode_wkf=64&" + param;
                    
                    be = "<button onclick=\"javascript:window.location=\'" +href+ "\'\" type=\"button\" id=\"btnProses\" class=\"ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only\" role=\"button\" aria-disabled=\"false\"><span class=\"ui-button-text\">PROSES</span></button>";
                    jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'setRowData\',ids[i],{ACT:be});
		}';
    }

}

?>