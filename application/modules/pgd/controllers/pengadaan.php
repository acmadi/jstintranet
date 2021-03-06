<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengadaan extends MY_Controller {
 	
	function __construct()
    {
        parent::__construct();	
      
	}
        

	function index() {
		$this->layout->view("pengadaan_list");
                
	}
	
        function add_tender_draft(){
             
            if ($this->input->post("KODE_PERENCANAAN")) {
                
                 
                
                $this->load->model('Nomorurut','urut');	 
                $urut = $this->urut->get($this->input->post("KODE_KANTOR"),"TENDER");	
                
                $sql = "INSERT INTO EP_PGD_TENDER (";
                $sql .= "KODE_TENDER";
                $sql .= ",KODE_KANTOR";
                $sql .= ",KODE_JAB_PEMOHON";
                $sql .= ",NAMA_PEMOHON";
                $sql .= ",JUDUL_PEKERJAAN";
                $sql .= ",LINGKUP_PEKERJAAN";
              //  $sql .= ",TIPE_KONTRAK";
                $sql .= ",KODE_PERENCANAAN";
                $sql .= ",KODE_KANTOR_PERENCANAAN";
                  $sql .= ",KODE_KANTOR_KIRIM ";
                 
                $sql .= ",  TGL_REKAM"; 
                $sql .= ", PETUGAS_REKAM";
                $sql .= ")";
                $sql .= "VALUES (";
                $sql .= "'" .  $urut . "'";
                $sql .= ",'" . $this->input->post("KODE_KANTOR") . "'";
                $sql .= ",'" . $this->input->post("KODE_JABATAN") . "'";
                $sql .= ",'" . $this->input->post("NAMA_JABATAN") . "'";
                $sql .= ",'" . $this->input->post("JUDUL_PEKERJAAN") . "'";
                $sql .= ",'" . $this->input->post("LINGKUP_PEKERJAAN") . "'";
              //  $sql .= ",'" . $this->input->post("TIPE_KONTRAK") . "'";
                $sql .= ",'" . $this->input->post("KODE_PERENCANAAN") . "'";
                $sql .= ",'" . $this->input->post("KODE_KANTOR_PERENCANAAN") . "'";
                  $sql .= ",'" . $this->input->post("KODE_KANTOR_KIRIM") . "'";
                
                $sql .= " ,   TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')  ";
                $sql .= ",'" . $this->session->userdata("kode_user") . "'";    
                $sql .= ")";
                
                 
                
                if ($this->db->simple_query($sql)) {
                  
                    $this->urut->set_plus( $this->input->post("KODE_KANTOR"),"TENDER");	
                
                    $urut_komentar = $this->urut->get( "ALL","KOMENTARTENDER");
                    
                    $sql  = " INSERT INTO EP_PGD_KOMENTAR_TENDER  (";
                    $sql  .= "KODE_KOMENTAR   ";
                    $sql  .= ",KODE_TENDER      ";
                    $sql  .= ",KODE_KANTOR  "; 
                    $sql  .= ",KODE_JABATAN ";
                    $sql  .= ",NAMA_JABATAN	 "; 
                    $sql  .= ",NAMA 	 "; 
                    
                    $sql  .= ",KODE_AKTIFITAS  ";
                    $sql  .= ",NAMA_AKTIFITAS	 ";
                    $sql  .= ",KODE_TRANSISI  ";
                    $sql  .= ",NAMA_TRANSISI	 ";
                    $sql  .= ",KOMENTAR	 ";
                    $sql  .= ",ATTACHMENT  ";
                    $sql  .= ",TGL_MULAI	 ";
                    $sql  .= ",TGL_REKAM ";
                    $sql  .= ",PETUGAS_REKAM  "; 
                    $sql .= ", KODE_ALURKERJA ) ";
                    $sql .= " VALUES (". $urut_komentar."";
                    $sql .= ", '" . $urut . "'  "; 
                    $sql .= ", '" . $this->input->post("KODE_KANTOR") . "'  ";
                    $sql .= ", '" .  $this->input->post("KODE_JABATAN") . "'  ";
                    $sql .= ", '" . $this->input->post("NAMA_JABATAN") . "'  ";
                     $sql .= ", '" . $this->session->userdata("kode_user") . "' "; 
                    $sql .= ", '1001'  ";
                    $sql .= ", 'PEMBUATAN DRAFT  PERMINTAAN'  ";
                    $sql .= ", '200'  ";
                    $sql .= ", 'INPUT DRAFT PERMINTAAN'  ";
                    $sql .= ", 'INPUT OLEH USER'  ";
                    $sql .= ", ''  ";
                    $sql .= ", TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS' )   ";
                     
                   
                    $sql .= ", TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS' )   ";
                    $sql .= ", '" . $this->session->userdata("kode_user") . "' "; 
                    $sql .= ",  5   )  ";
              
                    
                     
                    
                    if ($this->db->simple_query($sql)) {
                        
                        $this->urut->set_plus( "ALL","KOMENTARTENDER");
                    
                        echo $urut_komentar;
                        
                        
                        // redirect(base_url() . "index.php/pgd/pekerjaan_pgd/editor?KODE_KOMENTAR=" . $urut_komentar);
                    }
                    
                    
                    
                    
                    
                    
                } else {
                    echo "0";
                    
                } 
             
        }
        
        }
        
        function add_draft(){
                $this->load->model("opsi", "opsi");
                $data["arr_tipekontrak"] = $this->opsi->getTipeKontrak();
            
                $this->load->model('alurkerja','alur');
                        
                $this->alur->mulai(5);
                $data["kode_alurkerja"] = 5;
                $data["kode_komentar"] = 0;
                $data["rs_transisi"] = $this->alur->getTransisi(1001);
 
                $sql = "SELECT KODE_KANTOR, NAMA_KANTOR ";
                $sql .= " FROM MS_KANTOR ";
                $sql .= " WHERE KODE_TIPE = 2 AND KODE_KELAS = '0' ";
                
                $query  = $this->db->query($sql);
                $data["rs_kantor"] = $query->result();
                
                
		$this->layout->view("pengadaan_add_draft", $data);
        }
        
        
        
        function add() {
                $this->load->model("opsi", "opsi");
                $data["arr_tipekontrak"] = $this->opsi->getTipeKontrak();
            
                $this->load->model('alurkerja','alur');
                        
                $this->alur->mulai(5);
                $data["kode_alurkerja"] = 5;
                $data["kode_komentar"] = 0;
                $data["rs_transisi"] = $this->alur->getTransisi(1001);
 
                $sql = "SELECT KODE_KANTOR, NAMA_KANTOR ";
                $sql .= " FROM MS_KANTOR ";
                $sql .= " WHERE KODE_TIPE = 2 AND KODE_KELAS = '0' ";
                
                $query  = $this->db->query($sql);
                $data["rs_kantor"] = $query->result();
                
                
		$this->layout->view("pengadaan_add", $data);
	}
        
        
        function delete_item_tender() {
                print_r($_POST);
                $sql  = " DELETE FROM EP_PGD_ITEM_TENDER ";
                $sql .= " WHERE KODE_TENDER = '" . $this->input->post("KODE_TENDER") . "' ";
                $sql .= " AND KODE_KANTOR = '" . $this->input->post("KODE_KANTOR") . "' ";
                $sql .= " AND KODE_BARANG_JASA = '" . $this->input->post("KODE_BARANG_JASA") . "' ";
                $sql .= " AND KODE_SUB_BARANG_JASA = '" . $this->input->post("KODE_SUB_BARANG_JASA") . "' ";

                if ($this->db->simple_query($sql)) {
                    echo "1"  . $sql  ;
                } else {
                    echo "0";
                }
                
                
        }
        
        
        function add_item_tender(){
            if ($this->input->post("KODE_BARANG_JASA")) {
                
                
              //   print_r($_POST);
                
               $sql = "SELECT KODE_TENDER ";
               $sql .= " FROM EP_PGD_ITEM_TENDER ";
               $sql .= " WHERE KODE_TENDER = '" . $this->input->post("KODE_TENDER") . "' ";
               $sql .= " AND KODE_KANTOR = '" . $this->input->post("KODE_KANTOR") . "' ";
               $sql .= " AND KODE_BARANG_JASA = '" . $this->input->post("KODE_BARANG_JASA") . "' ";
               $sql .= " AND KODE_SUB_BARANG_JASA = '" . $this->input->post("KODE_SUB_BARANG_JASA") . "' ";
                 
               
               
               $query = $this->db->query($sql);
               $result = $query->result();
               
               if (count($result)) { 
                        $sql = "UPDATE EP_PGD_ITEM_TENDER ";
                        $sql .= " SET KETERANGAN = '" . $this->input->post("KETERANGAN") . "' ";
                        $sql .= ", JUMLAH = " . str_replace(",","",$this->input->post("JUMLAH")) . "  ";
                        $sql .= ", UNIT = '" . $this->input->post("UNIT") . "' ";
                        $sql .= ", HARGA = " . str_replace(",","",$this->input->post("HARGA")) . "  ";
                        $sql .= ", TGL_UBAH = TO_DATE('" . date("Y-m-d") . "','YYYY-MM-DD')  ";
                        $sql .= ", PETUGAS_UBAH = '" . $this->session->userdata("kode_user") . "'";    
                        $sql .= " WHERE KODE_TENDER = '" . $this->input->post("KODE_TENDER") . "' ";
                        $sql .= " AND KODE_KANTOR = '" . $this->input->post("KODE_KANTOR") . "' ";
                        $sql .= " AND KODE_BARANG_JASA = '" . $this->input->post("KODE_BARANG_JASA") . "' ";
                        $sql .= " AND KODE_SUB_BARANG_JASA = '" . $this->input->post("KODE_SUB_BARANG_JASA") . "' ";
                
               } else {

                        $sql = "INSERT INTO EP_PGD_ITEM_TENDER (
                            KODE_TENDER
                            , KODE_KANTOR
                            , KODE_BARANG_JASA
                            , KODE_SUB_BARANG_JASA
                            , KETERANGAN
                            , JUMLAH
                            , UNIT
                            , HARGA
                            , TGL_REKAM
                            , PETUGAS_REKAM ) ";
                        $sql .= " VALUES (";
                        $sql .= "'" . $this->input->post("KODE_TENDER") . "' ";
                        $sql .= ",'" . $this->input->post("KODE_KANTOR") . "' ";
                        $sql .= ",'" . $this->input->post("KODE_BARANG_JASA") . "' ";
                        $sql .= ",'" . $this->input->post("KODE_SUB_BARANG_JASA") . "' ";
                        $sql .= ",'" . $this->input->post("KETERANGAN") . "' ";
                        $sql .= "," . str_replace(",","",$this->input->post("JUMLAH")) . "  ";
                        $sql .= ",'" . $this->input->post("UNIT") . "' ";
                        $sql .= "," . str_replace(",","",$this->input->post("HARGA")) . "  ";
                        $sql .= " ,   TO_DATE('" . date("Y-m-d") . "','YYYY-MM-DD')  ";
                        $sql .= ",'" . $this->session->userdata("kode_user") . "'";    
                        $sql .= ")";
                       }
               // echo $sql; 
                if ($this->db->simple_query($sql)) {
                    echo "1"    ;
                } else {
                    echo "0";
                } 
                
                return;
                
            }
        }
        
        function add_tender(){
            if ($this->input->post("KODE_PERENCANAAN")) {
                
                 // print_r($_POST);
                 if ($this->input->post("KODE_TENDER") > 0 ) {
                     
                    echo  $this->input->post("KODE_TENDER");
                    return;
                 }
                
                
                
                
                $this->load->model('Nomorurut','urut');	 
                $urut = $this->urut->get($this->input->post("KODE_KANTOR"),"TENDER");	
                
                $sql = "INSERT INTO EP_PGD_TENDER (";
                $sql .= "KODE_TENDER";
                $sql .= ",KODE_KANTOR";
                $sql .= ",KODE_JAB_PEMOHON";
                $sql .= ",NAMA_PEMOHON";
                $sql .= ",JUDUL_PEKERJAAN";
                $sql .= ",LINGKUP_PEKERJAAN";
              //  $sql .= ",TIPE_KONTRAK";
                $sql .= ",KODE_PERENCANAAN";
                $sql .= ",KODE_KANTOR_PERENCANAAN";
                  $sql .= ",KODE_KANTOR_KIRIM ";
                 
                $sql .= ",  TGL_REKAM"; 
                $sql .= ", PETUGAS_REKAM";
                $sql .= ")";
                $sql .= "VALUES (";
                $sql .= $urut;
                $sql .= ",'" . $this->input->post("KODE_KANTOR") . "'";
                $sql .= ",'" . $this->input->post("KODE_JABATAN") . "'";
                $sql .= ",'" . $this->input->post("NAMA_JABATAN") . "'";
                $sql .= ",'" . $this->input->post("JUDUL_PEKERJAAN") . "'";
                $sql .= ",'" . $this->input->post("LINGKUP_PEKERJAAN") . "'";
              //  $sql .= ",'" . $this->input->post("TIPE_KONTRAK") . "'";
                $sql .= ",'" . $this->input->post("KODE_PERENCANAAN") . "'";
                $sql .= ",'" . $this->input->post("KODE_KANTOR_PERENCANAAN") . "'";
                  $sql .= ",'" . $this->input->post("KODE_KANTOR_KIRIM") . "'";
                
                $sql .= " ,   TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')  ";
                $sql .= ",'" . $this->session->userdata("kode_user") . "'";    
                $sql .= ")";
                
                
                if ($this->db->simple_query($sql)) {
                    echo $urut   ;
                    $this->urut->set_plus( $this->input->post("KODE_KANTOR"),"TENDER");	
                
                    
                } else {
                    echo "0";
                    
                } 
                
                
                
                
                
             return;   
                
                
            }
        }
        
        
        function add_item() {
		$this->layout->view("pengadaan_add_item");
	}
        
	
}	