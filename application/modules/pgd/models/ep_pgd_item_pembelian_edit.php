<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of crud
 *
 * @author  
 */
class Ep_pgd_item_pembelian_edit extends MY_Model {

    public $table = "EP_PGD_ITEM_TENDER";
 
    public $elements_conf = array('KODE_TENDER',
						'KODE_KANTOR',
						'KODE_BARANG_JASA',
						'KODE_SUB_BARANG_JASA',
						'KETERANGAN',
						'JUMLAH',
						'UNIT',
						'HARGA' );
			 
    public $columns_conf = array('KODE_TENDER' =>array('hidden'=>true, 'width'=>10) ,
								 'KODE_KANTOR' =>array('hidden'=>true, 'width'=>10),  
                                                                 'KODE_SUB_BARANG_JASA'  =>array('hidden'=>false, 'width'=>10),				 
                                                                 'KODE_BARANG_JASA'  =>array('hidden'=>false, 'width'=>10),
								 'KETERANGAN'  =>array('hidden'=>false, 'width'=>40),
								 'JUMLAH'  =>array('hidden'=>false, 'width'=>10, 'align'=>'center'),
        							 'UNIT'  =>array('hidden'=>false, 'width'=>10, 'align'=>'center'),
        
								 'HARGA'  =>array('hidden'=>false, 'width'=>10, 'align'=>'right'),
								 'SUBTOTAL'   =>array('hidden'=>false, 'width'=>10, 'align'=>'right')
	 ,   'EDIT'  =>array('hidden'=>false, 'width'=>5, 'align'=>'center') 
       
        );							 
 
	
    function setParam() {
                 if ($this->input->get("KODE_TENDER")){
                //echo "xxxx";
                $this->session->set_userdata("KODE_TENDER",$this->input->get("KODE_TENDER")  );
                
                
            }
            if ($this->input->get("KODE_KANTOR")){
                
                    $this->session->set_userdata("KODE_KANTOR_TENDER",$this->input->get("KODE_KANTOR")  );
            }

                $this->sql_select  = $this->sql_select . " AND T.KODE_TENDER = '" .  $this->session->userdata("KODE_TENDER"). "'  ";
                $this->sql_select  = $this->sql_select . " AND T.KODE_KANTOR = '" .  $this->session->userdata("KODE_KANTOR_TENDER"). "'  ";
            
                
            $this->sql_select  = $this->sql_select . ")";  
            
          //  echo $this->sql_select; 
        
    }
	
    public $sql_select = "( SELECT T.KODE_TENDER, T.KODE_KANTOR ,T.KODE_BARANG_JASA , T.KODE_SUB_BARANG_JASA AS KODE_SUB_BARANG_JASA, T.KETERANGAN,    COALESCE(T.JUMLAH,0) AS JUMLAH , T.UNIT, COALESCE(B.HARGA,0) AS HARGA ,  COALESCE(T.JUMLAH,0) *  COALESCE(B.HARGA,0) AS SUBTOTAL
                ,  '' as \"EDIT\"
                ,  '' as \"HAPUS\" 
		FROM EP_PGD_ITEM_TENDER T
		LEFT JOIN  (SELECT KODE_JASA AS KODE_BARANG_JASA , KODE_KEL_JASA AS  KODE_SUB_BARANG_JASA, NAMA_JASA AS NAMA_BARANG_JASA
                FROM EP_KOM_JASA
                UNION ALL
                SELECT KODE_BARANG, KODE_SUB_BARANG, NAMA_BARANG
                FROM MS_BARANG) J ON T.KODE_BARANG_JASA = J.KODE_BARANG_JASA  AND T.KODE_SUB_BARANG_JASA = J.KODE_SUB_BARANG_JASA
                LEFT JOIN EP_PGD_PEMBELIAN_DETAIL B ON T.KODE_TENDER = B.KODE_TENDER AND T.KODE_KANTOR = B.KODE_KANTOR
                AND T.KODE_BARANG_JASA = B.KODE_BARANG_JASA AND  J.KODE_SUB_BARANG_JASA = B.KODE_SUB_BARANG_JASA
                WHERE 1 = 1
		 ";
	
	function __construct() {
        parent::__construct();
        $this->init();	 
        $this->setParam();
        
        $this->js_grid_completed = 'var ids = jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'getDataIDs\');
		for(var i=0;i < ids.length;i++){
                    var cl = ids[i];
                    
                    be = "<button onclick=\"fnEditBarangJasa(\'"+cl+"\');\"  >EDIT</button>"; 
                    jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'setRowData\',ids[i],{EDIT:be});
                   
                        
		}';

            
    }
	
}	