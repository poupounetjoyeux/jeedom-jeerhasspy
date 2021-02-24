<?php
const jeerhasspy_id = 'jeerhasspy';

const jeerhasspy_config_interactionsIntentName = 'interactionsIntentName';
const jeerhasspy_config_interactionsIntentName_default = 'JeedomInteractions';
const jeerhasspy_config_askAnswerIntentName = 'askAnswerIntentName';
const jeerhasspy_config_askAnswerIntentName_default = 'JeedomAskAnswers';
const jeerhasspy_config_setWakeVariables = 'setWakeVariables';
const jeerhasspy_config_ignoredInteractions = 'ignoredInteractions';

const jeerhasspy_eqLogic_type = 'type';
const jeerhasspy_eqLogic_uri = 'uri';
const jeerhasspy_eqLogic_defaultLang = 'defaultLang';
const jeerhasspy_eqLogic_assistantDate = 'assistantDate';
const jeerhasspy_eqLogic_assistantVersion = 'assistantVersion';
const jeerhasspy_eqLogic_syncJeedomInteractions = 'syncJeedomInteractions';
const jeerhasspy_eqLogic_syncAnswers = 'syncAnswers';
const jeerhasspy_eqLogic_syncSlots = 'syncSlots';
const jeerhasspy_eqCategory = 'multimedia';

const jeerhasspy_cmd_dynamicSpeak = 'dynamicSpeak';
const jeerhasspy_cmd_speak = 'speak';
const jeerhasspy_cmd_ask = 'ask';
const jeerhasspy_cmd_ledOn = 'ledOn';
const jeerhasspy_cmd_ledOff = 'ledOff';
const jeerhasspy_cmd_volume = 'volume';
const jeerhasspy_cmd_setVolume = 'setVolume';
const jeerhasspy_cmd_repeat = 'repeat';

const jeerhasspy_master_type = 'Master';
const jeerhasspy_sat_type = 'Satellite';

const rhasspy_min_supported_version = '2.5.0';
const rhasspy_unsupported_version = 'unsupported';
const rhasspy_jeedom_sentences_file = 'intents/jeedom.ini';
const rhasspy_jeedom_answers_sentences_file = 'intents/jeedomAnswers.ini';

const rhasspy_api = '/api';
const rhasspy_api_hermes = rhasspy_api . '/mqtt/hermes';
const rhasspy_api_version = rhasspy_api . '/version';
const rhasspy_api_profile = rhasspy_api . '/profile';
const rhasspy_api_profiles = rhasspy_api . '/profiles';
const rhasspy_api_sentences = rhasspy_api . '/sentences';
const rhasspy_api_slots = rhasspy_api . '/slots';
const rhasspy_api_restart = rhasspy_api . '/restart';
const rhasspy_api_train = rhasspy_api . '/train';
const rhasspy_api_tts = rhasspy_api . '/text-to-speech';
const rhasspy_api_setVolume = rhasspy_api . '/set-volume';
const rhasspy_api_listenCommand = rhasspy_api . '/listen-for-command';
const rhasspy_api_hermes_leds = rhasspy_api_hermes . '/leds';
const rhasspy_api_hermes_leds_on = rhasspy_api_hermes_leds . '/toggleOn';
const rhasspy_api_hermes_leds_off = rhasspy_api_hermes_leds . '/toggleOff';

//Assistants
const jeerhasspy_ajax_allAssistants = 'allAssistants';
const jeerhasspy_ajax_bySiteIdAssitant = 'bySiteIdAssitant';
const jeerhasspy_ajax_saveAssistant = 'saveAssistant';
const jeerhasspy_ajax_deleteAssistant = 'deleteAssistant';
const jeerhasspy_ajax_syncAssistants = 'syncAssistants';
const jeerhasspy_ajax_syncAssistant = 'syncAssistant';
const jeerhasspy_ajax_configureAssitantProfile = 'configureAssistantProfile';
const jeerhasspy_ajax_testAssistant = 'testAssistant';
//Interactions
const jeerhasspy_ajax_allInteractions = 'allInteractions';
const jeerhasspy_ajax_saveInteractions = 'saveInteractions';
//Slots
const jeerhasspy_ajax_allSlots = 'allSlots';
const jeerhasspy_ajax_byIdSlot = 'byIdSlot';
const jeerhasspy_ajax_saveSlot = 'saveSlot';
const jeerhasspy_ajax_deleteSlot = 'deleteSlot';
//Answers
const jeerhasspy_ajax_allAnswers = 'allAnswers';
const jeerhasspy_ajax_byIdAnswer = 'byIdAnswer';
const jeerhasspy_ajax_saveAnswer = 'saveAnswer';
const jeerhasspy_ajax_deleteAnswer = 'deleteAnswer';
