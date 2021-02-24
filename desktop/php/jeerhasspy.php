<?php
require_once dirname(__FILE__) . '/jeerhasspy.desktop.inc.php';

if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<div class="row row-overflow">
    <div class="col-xs-12 eqLogicThumbnailDisplay">
        <legend><i class="fa fa-cog"></i> {{Gestion}}</legend>
        <div class="eqLogicThumbnailContainer">
            <div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf">
                <i class="fas fa-wrench"></i>
                <br>
                <span>{{Configuration du plugin}}</span>
            </div>
            <div class="cursor eqLogicAction logoSecondary" onclick="syncAssistantsClick()">
                <i class="fab fa-cloudsmith"></i>
                <br>
                <span>{{Synchroniser tous les assistants}}</span>
            </div>
        </div>

        <div>
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="" aria-expanded="false"
                               href="#apiInfosPanel">
                                <i class="fas fa-microphone-alt"></i> {{Informations API}}
                            </a>
                        </h3>
                    </div>

                    <div id="apiInfosPanel" class="panel-collapse collapse">
                        <div class="panel-body">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{URL interne}}
                                        <sup><i class="fas fa-question-circle"
                                                title="{{URL interne (Jeedom et Rhasspy sur le même réseau) à copier dans Rhasspy, onglet Settings.}}"></i></sup>
                                    </label>
                                    <div class="col-sm-8 callback">
                                        <input type="text" class="form-control" data-urlType="url_int" readonly
                                               value="<?php echo JeerhasspyUtils::getPluginApiUri(true); ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{URL externe}}
                                        <sup><i class="fas fa-question-circle"
                                                title="{{URL externe (Jeedom et Rhasspy sur deux réseaux différents) à copier dans Rhasspy, onglet Settings.}}"></i></sup>
                                    </label>
                                    <div class="col-sm-8 callback">
                                        <input type="text" class="form-control" data-urlType="url_ext" readonly
                                               value="<?php echo JeerhasspyUtils::getPluginApiUri(false); ?>"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="assistantsPanel" class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="" aria-expanded="false"
                           href="#assistantsContainer">
                            <i class="fas fa-egg"></i> {{Assistants}}
                        </a>
                    </h3>
                </div>
                <div id="assistantsContainer" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="pull-right d-inline-flex">
                                <a class="btn btn-success" onclick="addAssistantClick()"><i class="fas fa-plus"></i>
                                    {{Ajouter un assistant}}</a>
                            </div>
                        </div>
                        <div id="assistantsItems" class="row">
                        </div>
                        <br/>
                    </div>
                </div>
            </div>
        </div>

        <div id="slotsPanel" class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="" aria-expanded="false"
                           href="#slotsContainer">
                            <i class="fas fa-clipboard-list"></i> {{Slots}}
                        </a>
                    </h3>
                </div>
                <div id="slotsContainer" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="pull-right d-inline-flex">
                                <a class="btn btn-success" onclick="addSlotClick()"><i class="fas fa-plus"></i>
                                    {{Ajouter un Slot}}</a>
                            </div>
                        </div>
                        <div id="slotsItems" class="row">
                        </div>
                        <br/>
                    </div>
                </div>
            </div>
        </div>

        <div id="answersPanel" class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="" aria-expanded="false"
                           href="#answersContainer">
                            <i class="fas fa-question-circle"></i> {{Réponses}}
                        </a>
                    </h3>
                </div>
                <div id="answersContainer" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="pull-right d-inline-flex">
                                <a class="btn btn-success" onclick="addAnswerClick()"><i class="fas fa-plus"></i>
                                    {{Ajouter une réponse}}</a>
                            </div>
                        </div>
                        <div id="answersItems" class="row">
                        </div>
                        <br/>
                    </div>
                </div>
            </div>
        </div>

        <div id="interactionsPanel" class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="" aria-expanded="false"
                           href="#interactionsContainer">
                            <i class="fas fa-comments"></i> {{Interactions}}
                        </a>
                    </h3>
                </div>
                <div id="interactionsContainer" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-bordered table-condensed">
                            <thead>
                            <tr>
                                <th>Interaction</th>
                                <th>Nombre de phrases</th>
                                <th>Ignorer à la synchronisation</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="pull-right d-inline-flex">
                            <a class="btn btn-success" onclick="saveInteractionClick()"><i
                                        class="fas fa-check-circle"></i> {{Sauvegarder}}</a>
                        </div>
                        <br/>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_file('desktop', 'jeerhasspy.assistant.ajax', 'js', jeerhasspy_id);
include_file('desktop', 'jeerhasspy.assistant.panel.ui', 'js', jeerhasspy_id);
include_file('desktop', 'jeerhasspy.slot.ajax', 'js', jeerhasspy_id);
include_file('desktop', 'jeerhasspy.slot.panel.ui', 'js', jeerhasspy_id);
include_file('desktop', 'jeerhasspy.answer.ajax', 'js', jeerhasspy_id);
include_file('desktop', 'jeerhasspy.answer.panel.ui', 'js', jeerhasspy_id);
include_file('desktop', 'jeerhasspy.interaction.ajax', 'js', jeerhasspy_id);
include_file('desktop', 'jeerhasspy.interaction.panel.ui', 'js', jeerhasspy_id);
include_file('desktop', 'jeerhasspy.ui', 'js', jeerhasspy_id);
include_file('desktop', 'jeerhasspy.utils', 'js', jeerhasspy_id);
include_file('core', 'plugin.template', 'js');
?>
