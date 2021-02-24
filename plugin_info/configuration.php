<?php

require_once dirname(__FILE__) . '/../core/utils/jeerhasspy.constants.config.php';

include_file('core', 'authentification', 'php');
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<form class="form-horizontal">
    <fieldset>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Nom de l'Intent des interactions}}
                <sup><i class="fas fa-question-circle"
                        title="{{Nom de l'Intent utilisé pour synchroniser les interactions Jeedom sur les équipements Rhasspy. L'Intent ne sera pas récupéré lors de l'import des assistant. JeedomInteractions par defaut}}"></i></sup>
            </label>
            <div class="col-lg-4">
                <input class="configKey form-control"
                       data-l1key="<?php echo jeerhasspy_config_interactionsIntentName ?>"
                       placeholder="JeedomInteractions"/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-4 control-label">{{Nom de l'Intent des réponses Ask}}
                <sup><i class="fas fa-question-circle"
                        title="{{Nom de l'Intent utilisé pour récupérer les réponses à la commande Ask de Jeedom sur les équipements Rhasspy. L'Intent ne sera pas récupéré lors de l'import des assistant. JeedomAskAnswers par defaut}}"></i></sup>
            </label>
            <div class="col-lg-4">
                <input class="configKey form-control" data-l1key="<?php echo jeerhasspy_config_askAnswerIntentName ?>"
                       placeholder="JeedomAskAnswers"/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-4 control-label">{{Variables rhasspyWakeWord / rhasspyWakeSiteId}}
                <sup><i class="fas fa-question-circle"
                        title="{{Assigne ces deux variables avec le wakeId et le siteId ayant déclenché le wakeword.}}"></i></sup>
            </label>
            <div class="col-lg-4">
                <input type="checkbox" class="configKey" data-l1key="<?php jeerhasspy_config_setWakeVariables ?>"
                       checked/>
            </div>
        </div>
    </fieldset>
</form>