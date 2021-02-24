<?php

require_once dirname(__FILE__) . '/../php/jeerhasspy.desktop.inc.php';

if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

$_siteId = $_GET['siteId'];
sendVarToJS('siteId', $_siteId);

?>
    <div id="div_alertAssistant"></div>
    <div class="pull-right d-inline-fex">
	<span class="btn-group">
		<a class="btn btn-info" onclick="syncAssistantClick()"><i class="fas fa-sync"></i> {{Synchroniser l'assistant}}</a>
		<a class="btn btn-warning" onclick="configureRhasspyProfileClick()"><i class="fas fa-users-cog"></i> {{Configuration du profile Rhasspy}}</a>
		<a class="btn btn-default" onclick="advancedConfigClick()"><i class="fas fa-cogs"></i> {{Configuration avancée}}</a>
        <a class="btn btn-success" onclick="saveAssistantClick()"><i
                    class="fas fa-check-circle"></i> {{Sauvegarder}}</a>
	</span>
    </div>
    <br/><br/>
    <div role="tabpanel" class="tab-pane active" id="assistantForm">
        <br/>
        <form class="form-horizontal">
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Nom de l'assistant}}</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="name"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Objet parent}}</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="parentObjectId">
                            <option value="">{{Aucun}}</option>
                            <?php
                            $options = '';
                            foreach ((jeeObject::buildTree(null, false)) as $object) {
                                $decay = $object->getConfiguration('parentNumber');
                                $options .= '<option value="' . $object->getId() . '">' . str_repeat('&nbsp;&nbsp;', $decay) . $object->getName() . '</option>';
                            }
                            echo $options;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Catégorie}}</label>
                    <div class="col-sm-9">
                        <?php
                        foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                            echo '<label class="checkbox-inline">';
                            echo '<input type="checkbox" name="category" data-categoryId="' . $key . '" />' . $value['name'];
                            echo '</label>';
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <label class="checkbox-inline"><input type="checkbox" name="isEnable"/>{{Activer}}</label>
                        <label class="checkbox-inline"><input type="checkbox" name="isVisible"/>{{Visible}}</label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Uri}}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="uri" placeholder="http://192.168.0.1:12101"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">{{Type assistant}}</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="type">
                            <option value="<?php echo jeerhasspy_master_type ?>">{{Maître}}</option>
                            <option value="<?php echo jeerhasspy_sat_type ?>">{{Satellite}}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label">{{Synchroniser les interactions Jeedom}}</label>
                    <div class="col-sm-6">
                        <input type="checkbox" name="syncJeedomInteractions"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label">{{Synchroniser les réponses}}</label>
                    <div class="col-sm-6">
                        <input type="checkbox" name="syncAnswers"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label">{{Synchroniser les Slots}}</label>
                    <div class="col-sm-6">
                        <input type="checkbox" name="syncSlots"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Site ID}}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="siteId" readonly/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Version}}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="assistantVersion" readonly/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Langue}}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="defaultLang" readonly/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Informations Importées le}}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="importTime" readonly/>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>

<?php
include_file('desktop', 'jeerhasspy.assistant.edit.modal.ui', 'js', jeerhasspy_id);
?>