  <div class="accordion">
 <h3 href="<?php echo base_url()?>index.php/adm/gridr/ep_ms_mata_uang_kurs">KURS MATA UANG</h3>
            <div>
			<fieldset class="ui-widget-content">
			<legend>Pencarian</legend>
			<form id="frmSearch" method="POST" action="" >
			
			<div id="mysearch"></div>
			<p>	
				<label>
					<select id="myfield" >
						<option value="MATA_UANG_DARI" >Mata Uang Dari</option>
						<option value="MATA_UANG_KE" >Mata Uang Ke</option>
					</select>
				</label>
				<input type="text" id="kolom" name="kolom"  value="" /> 
				<input type="button" id="btnSrc"  value="Cari" /> 
			</p>
			</form>
			</fieldset>	
			<br/>
			<p>
                            <button type="button" id="btnAdd"  >Tambah Kurs</button> 
                                <button type="button" id="btnEdit"  >Edit Kurs</button> 
			
			</p>
			
			
			 
			<div id="list" ></div>
			</div>
  </div>			
 <script>
  
  $(document).ready(function(){
  
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
	
	
	$("#btnSrc").click(function() {
	

	
		//alert($("#kolom").val());
		
		
		
		srcval = $("#kolom").val();
		var myfilter = { groupOp: "AND", rules: []};
		var myfield = $("#myfield").val();
		
		myfilter.rules.push({field: myfield ,op:"cn",data:srcval});
		
		var grid = $("#grid_ep_ms_mata_uang_kurs");
			
	 
		grid[0].p.search = myfilter.rules.length>0;
		$.extend(grid[0].p.postData,{filters:JSON.stringify(myfilter)});
		grid.trigger("reloadGrid",[{page:1}]);
	 
		 
		 
		//$('#grid_ep_kom_kelompok_jasa').jqGrid().trigger("reloadGrid");
		
	});
	
	
	$(".accordion" ).each(function(){
                 
                
                $('h3', $(this)).each(function(){
                    var uri = $(this).attr('href');
                    if(uri != '' && uri != '#'){
                        var ctn = $("#list") ;
                        //alert($(ctn).width());
                        //alert(uri);
                        if(ctn.html() == '')
                            ctn.load(uri);
                    }
                });
            });
	$("#btnAdd" ).click(function() {
		window.location = "<?php echo base_url() ."index.php/adm/kurs/add"; ?>";  
	});
	
	$("#btnEdit" ).click(function() {
	 	 var selected = $('#grid_ep_ms_mata_uang_kurs').jqGrid('getGridParam', 'selrow');
		 if (selected) {
                    selected = jQuery('#grid_ep_ms_mata_uang_kurs').jqGrid('getRowData',selected);
                    var keys = <?php echo json_encode(Array ( 0  => "MATA_UANG_DARI" , 1  => "MATA_UANG_KE", 2  => "TGL_KURS" )); ?>;
                    var count = 0;
                
                    var data = {};
                    var str ="";
                    $.each(keys, function(k, v) { 
                        data = {v:selected[v]};
                        str += v + "=" + selected[v] + "&";
                        count++; 
                    });
                    window.location = "<?php echo base_url() . "index.php/adm/kurs/edit"; ?>?" + str;
		}			
	});

	 });
  
  function fnDeleteKurs(str){
  
  
    $('#grid_ep_ms_mata_uang_kurs').jqGrid('setSelection',str); 
    var selected = $('#grid_ep_ms_mata_uang_kurs').jqGrid('getGridParam', 'selrow');
    selected = jQuery('#grid_ep_ms_mata_uang_kurs').jqGrid('getRowData',selected );
    
    var MATA_UANG_DARI = selected["MATA_UANG_DARI"];
    var MATA_UANG_KE = selected["MATA_UANG_KE"];
    var TGL_KURS = selected["TGL_KURS"];
    
    
    if (confirm("Akan Menghapus Kurs")) { 
         window.location = "<?php echo base_url(); ?>index.php/adm/kurs/delete?MATA_UANG_DARI=" +  MATA_UANG_DARI + "&MATA_UANG_KE=" +  MATA_UANG_KE + "&TGL_KURS=" +  TGL_KURS;
    }
    
  }
  
  
</script>   			