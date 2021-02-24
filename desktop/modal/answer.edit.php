<?php

require_once dirname(__FILE__) . '/../php/jeerhasspy.desktop.inc.php';

if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

$_answerId = $_GET['id'];
sendVarToJS('answerId', $_answerId);

?>
    <div id="div_alertAnswer"></div>
    <div class="pull-right d-inline-flex">
        <a class="btn btn-success" onclick="saveAnswerClick()"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a>
    </div>

    <br/><br/>

    <div role="tabpanel" class="tab-pane active">
        <br/>
        <form class="form-horizontal" id="answerForm">
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Nom de la réponse}}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" placeholder="Réponse yes/no"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Phrases (une par ligne)}}</label>
                    <div class="col-sm-9">
                        <textarea style="padding: 14px" rows="4" class="form-control" name="configuration"
                                  placeholder="bien sur que ($YesNo)"></textarea>
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
include_file('desktop', 'jeerhasspy.answer.edit.modal.ui', 'js', jeerhasspy_id);
?>