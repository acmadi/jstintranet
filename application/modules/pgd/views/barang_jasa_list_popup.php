  <div class="accordion">
 <h3 id="h3_harga_jasa_popup" href="<?php echo base_url(); ?>index.php/adm/gridpopup_barang_jasa/kom_barang_jasa">BARANG / JASA</h3>
            <div>
			<p>
			<div id="mysearch"></div>
                        <select id="myfieldbarangjasa" >
                            <option value="KODE_BARANG" >Kode Barang Jasa</option>
                            <option value="NAMA_BARANG" >Nama Barang Jasa</option>
                        </select>
                        
				<input type="text" id="kolombarangjasa" name="kolom"  value="" /> 
				<input type="button" id="btnSrcbarangjasa"  value="Cari" /> 
			</p>
			 
			
			
			 
			<div id="listpopup_barang_jasa" ></div>
			</div>
  </div>			
 <script>
  
 
  
  $(document).ready(function(){
	//$("#mysearch").jqGrid('filterGrid','#grid_ep_kom_kelompok_jasa');
	
	
    $(".accordion")
    .addClass("ui-accordion ui-widget ui-helper-reset")
    //.css("width", "auto")
    .find('h3')
    .addClass("current ui-accordion-header ui-helper-reset ui-state-active ui-corner-top")
    .css("padding", ".5em .5em .5em .7em")
    //.prepend('<span class="ui-icon ui-icon-triangle-1-s"><span/>')
    .next()
    .addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active")
    .css('overflow','visible')
	
	$("#btnSrcbarangjasa").click(function() {
	

	
		// alert($("#kolom").val());
		
		
		var myfield = $("#myfieldbarangjasa").val()
		srcval = $("#kolombarangjasa").val();
		var myfilter = { groupOp: "AND", rules: []};
		myfilter.rules.push({field: myfield ,op:"cn",data:srcval});
		
		var grid = $("#grid_kom_barang_jasa");
			
		
		alert(grid);
		
		grid[0].p.search = myfilter.rules.length>0;
		$.extend(grid[0].p.postData,{filters:JSON.stringify(myfilter)});
		grid.trigger("reloadGrid",[{page:1}]);
		alert(grid);
		 
		//$('#grid_ep_kom_kelompok_jasa').jqGrid().trigger("reloadGrid");
		
	});
	
	
	$(".accordion" ).each(function(){
                 
                
                $('#h3_harga_jasa_popup', $(this)).each(function(){
                    var uri = $(this).attr('href');
                    if(uri != '' && uri != '#'){
                        var ctn = $("#listpopup_barang_jasa") ;
                        //alert($(ctn).width());
                        //alert(uri);
                        if(ctn.html() == '')
                            ctn.load(uri);
                    }
                });
            });
 
	 

	 });
  
</script>   			