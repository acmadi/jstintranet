<?php $this->load->helper('form'); ?>
<?php echo form_open($form->action, $form->form_params); ?>
<!--<h3 class="ui-widget ui-widget-header ui-corner-all"><span>Form Detail</span></h3>-->
<legend>Fields with remark (*) is required.</legend>
<table class="table table-hover" id="table-checklist-doc">
    <thead>
        <tr>
            <th>No.</th>
            <th>Persyaratan Administrasi</th>
            <th>Status</th>
            <th>Catatan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($form->model->checklist_doc as $k => $v): ?>
            <tr style="display:<?php echo $v['KATEGORI'] == 0 ? "table-row" : "none"; ?>;" class="kategori-<?php echo $v['KATEGORI']; ?>">
                <td>
                    <div class="rownum"><?php echo $v['NO']; ?></div>
                    <input type="hidden" name="EP_VENDOR_DOKUMEN[<?php echo $v['KODE_DOKUMEN_REF']; ?>][KODE_DOKUMEN_REF]" value="<?php echo $v['KODE_DOKUMEN_REF']; ?>" />
                    <input type="hidden" name="EP_VENDOR_DOKUMEN[<?php echo $v['KODE_DOKUMEN_REF']; ?>][TIPE]" value="<?php echo $v['TIPE']; ?>" />
                </td>
                <td>
                    <?php echo $v['NAMA']; ?>
                </td>
                <td>
                    <label class="radio">
                        <input type="radio" name="EP_VENDOR_DOKUMEN[<?php echo $v['KODE_DOKUMEN_REF']; ?>][STATUS]" value="1" <?php echo $v['STATUS'] == '1' ? 'checked' : ''; ?>/> ADA
                    </label><br>
                    <label class="radio">
                        <input type="radio" name="EP_VENDOR_DOKUMEN[<?php echo $v['KODE_DOKUMEN_REF']; ?>][STATUS]" value="2" <?php echo $v['STATUS'] == '2' ? 'checked' : ''; ?>/>TIDAK
                    </label><br>
                    <label class="radio">
                        <input type="radio" name="EP_VENDOR_DOKUMEN[<?php echo $v['KODE_DOKUMEN_REF']; ?>][STATUS]" value="3" <?php echo $v['STATUS'] == '3' ? 'checked' : ''; ?>/>PERLU KONFIRMASI
                    </label>
                </td>
                <td>
                    <textarea name="EP_VENDOR_DOKUMEN[<?php echo $v['KODE_DOKUMEN_REF']; ?>][NOTE]"><?php echo $v['NOTE']; ?></textarea>
                </td>
                <td>
                    <textarea name="EP_VENDOR_DOKUMEN[<?php echo $v['KODE_DOKUMEN_REF']; ?>][KETERANGAN]"><?php echo $v['KETERANGAN']; ?></textarea>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<button type="button" id="btnShowAll">TAMPILKAN SEMUA KATEGORI</button>
<?php if (!isset($read_only) || $read_only != true): ?>
    <button type="button" id="btnSimpan">SIMPAN</button>
    <button type="button" id="btnBatal">BATAL</button>
    
    
<?php endif; ?>
<script>
        $(document).ready(function(){
            $('.tabs').tabs({
                select: function( event, ui ) {
                    $("table#table-checklist-doc tbody tr").hide();
                    $("table#table-checklist-doc tbody tr.kategori-" + ui.index).show();
                    //console.log($("table#table-checklist-doc tbody tr:visible"));
                    //console.log(ui.index);
                    $("table#table-checklist-doc tbody tr:visible").each(function(i){
                        $(".rownum", this).html(i+1);
                    });
                },
                activate : function(evt, ui) {
                    //console.log(ui);
                }
            });
            
            $('#btnShowAll').click(function(){
                $("table#table-checklist-doc tbody tr").show();                
            });
            
            $("table#table-checklist-doc tbody tr:visible").each(function(i){
                $(".rownum", this).html(i+1);
            });
                    
            // stylish button and input date
            $(function() {
                $( "input:submit, button").button();
                $( ".datepicker" ).datepicker();
                //$( ".datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
                    
            });
                
            var validator = $("#<?php echo $form->id; ?>").validate({
                meta: "validate",
                submitHandler: function(form) {
                    jQuery(form).ajaxSubmit();
                }
            });
                
            // attach event to button
            $("#<?php echo $form->id; ?> #btnSimpan").click(function() {
                if(validator.form()) {
                    jQuery("#<?php echo $form->id; ?>").ajaxSubmit({
                        clearForm: false,
                        success: function(){
                            alert('Data berhasil disimpan');
                            //reload grid
                            $('#grid_<?php echo strtolower(get_class($form->model)); ?>').trigger("reloadGrid");
                        },
                        error: function(){
                            alert('Data gagal disimpan')
                        }
                    });
                }
            });
                    
            $("#<?php echo $form->id; ?> #btnBatal").click(function() {
                $("#<?php echo $form->id; ?>").resetForm();
                validator.prepareForm();
                validator.hideErrors();
            });
        });
                
    </script>
</form>