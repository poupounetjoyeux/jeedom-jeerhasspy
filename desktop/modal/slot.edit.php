<?php

require_once dirname(__FILE__) . '/../php/jeerhasspy.desktop.inc.php';

if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

$_slotId = $_GET['id'];
sendVarToJS('slotId', $_slotId);

?>
    <div id="div_alertSlot"></div>
    <div class="pull-right d-inline-flex">
        <a class="btn btn-success" onclick="saveSlotClick()"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a>
    </div>

    <br/><br/>

    <div role="tabpanel" class="tab-pane active">
        <br/>
        <form class="form-horizontal" id="slotForm">
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Nom du slot}}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" placeholder="YesNo"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Termes (un par ligne)}}</label>
                    <div class="col-sm-9">
                        <textarea style="padding: 14px" rows="4" class="form-control" name="configuration"
                                  placeholder="oui"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Synchroniser}}</label>
                    <div class="col-sm-3">
                        <input type="checkbox" name="isSync" checked/>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>

<?php
include_file('desktop', 'jeerhasspy.slot.edit.modal.ui', 'js', jeerhasspy_id);
?>