<div class="hidden">

    <div>
        <i class="fa fa-exclamation-triangle warning"></i> {{Configuration du profile Rhasspy}}
        <br><br>
        <form id="configRhasspyProfileForm" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-6">{{Configurer l'intent handler}}</label>
                <div class="col-sm-6">
                    <input type="checkbox" class="form-control" name="configHandler" checked/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">{{Adresse}}</label>
                <div class="col-sm-8">
                    <select name="useInternalUrl">
                        <option value="true">{{Utiliser l'url interne}}</option>
                        <option value="false">{{Utiliser l'url externe}}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-6">{{Configurer l'event Wakeword Detected}}</label>
                <div class="col-sm-6">
                    <input type="checkbox" class="form-control" name="configWakeEvent" checked/>
                </div>
            </div>
        </form>
    </div>

    <div>
        <i class="fa fa-exclamation-triangle warning"></i> {{Ajout d'un assistant}}
        <br><br>
        <form id="addAssistantForm" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3">{{Adresse}}</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="uri" placeholder="http://192.168.0.10:12101"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">{{Type assistant}}</label>
                <div class="col-sm-8">
                    <select class="form-control" name="type">
                        <option value="<?php echo jeerhasspy_master_type ?>" selected>{{Maître}}</option>
                        <option value="<?php echo jeerhasspy_sat_type ?>">{{Satellite}}</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <div>
        <i class="fa fa-exclamation-triangle warning"></i> {{Synchronisation}}
        <br><br>
        <form id="syncAssistantsForm" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-6">{{Récupérer les informations Rhasspy (siteId,
                    defaultLang...)}}</label>
                <div class="col-sm-6">
                    <input type="checkbox" class="form-control" name="syncInformations" checked/>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-6">{{Envoyer les interactions et les slots Jeedom}}</label>
                <div class="col-sm-6">
                    <input type="checkbox" class="form-control" name="syncInteractions" checked/>
                </div>
            </div>
        </form>
    </div>

    <div>
        <i class="fa fa-exclamation-triangle warning"></i> {{Synchronisation}}
        <br><br>
        <form id="syncAssistantForm" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-6">{{Récupérer les informations Rhasspy (siteId,
                    defaultLang...)}}</label>
                <div class="col-sm-6">
                    <input type="checkbox" class="form-control" name="syncInformations" checked/>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-6">{{Envoyer les interactions et les slots Jeedom}}</label>
                <div class="col-sm-6">
                    <input type="checkbox" class="form-control" name="syncInteractions" checked/>
                </div>
            </div>
        </form>
    </div>

</div>