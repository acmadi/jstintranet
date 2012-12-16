  <div class="accordion">
 <h3 href="<?php echo base_url()?>index.php/adm/gridr/ep_kom_jasa">JASA</h3>
            <div>
 
			<p>
                            <button type="button" id="btnAdd"  >Tambah Jasa</button> 
				<button type="button" id="btnEdit"  >Edit Jasa   </button> 
				<button type="button" id="btnDelete"  >Hapus Jasa   </button>
			
			</p>
			
			
			 
			<div id="list" ></div>
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
	
	$("#btnSrc").click(function() {
	
/*
	
		//alert($("#kolom").val());
	 
		var myfilter = { groupOp: "AND", rules: []};
		myfilter.rules.push({field:"KODE_KEL_JASA",op:"eq",data:"J01"});
		
		var grid = $("#grid_ep_kom_jasa");
			
		
		alert(grid);
		
		grid[0].p.search = myfilter.rules.length>0;
		$.extend(grid[0].p.postData,{filters:JSON.stringify(myfilter)});
		grid.trigger("reloadGrid",[{page:1}]);
		alert(grid);
*/		 
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
		window.location = "<?php echo base_url() ."index.php/adm/jasa/add"; ?>";  
	});
	
	$("#btnEdit" ).click(function() {
	 
	 var selected = $('#grid_ep_kom_jasa').jqGrid('getGridParam', 'selrow');
		 if (selected) {
                    selected = jQuery('#grid_ep_kom_jasa').jqGrid('getRowData',selected);
                    var keys = <?php echo json_encode(Array ( 0  => "KODE_JASA" )); ?>;
                    var count = 0;
                
                    var data = {};
                    var str ="";
                    $.each(keys, function(k, v) { 
                        data = {v:selected[v]};
                        str += v + "=" + selected[v] + "&";
                        count++; 
                    });
                    window.location = "<?php echo base_url() . "index.php/adm/jasa/edit"; ?>?" + str;
		}			
	});
	
		
	$("#btnDelete" ).click(function() {
	if (confirm("Akan Menghapus Jasa")) {
            var selected = $('#grid_ep_kom_jasa').jqGrid('getGridParam', 'selrow');
                    if (selected) {
                       selected = jQuery('#grid_ep_kom_jasa').jqGrid('getRowData',selected);
                       var keys = <?php echo json_encode(Array ( 0  => "KODE_JASA" )); ?>;
                       var count = 0;

                       var data = {};
                       var str ="";
                       $.each(keys, function(k, v) { 
                           data = {v:selected[v]};
                           str += v + "=" + selected[v] + "&";
                           count++; 
                       }); 

                       window.location = "<?php echo base_url() . "index.php/adm/jasa/delete"; ?>?" + str;
                   }			
           } 
	 
           });
	
         

	 });
  
</script>   			