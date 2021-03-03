<?php

require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

require_once dirname(__FILE__) . '/../utils/jeerhasspy.constants.config.php';
require_once dirname(__FILE__) . '/../utils/rhasspy.requests.utils.class.php';
require_once dirname(__FILE__) . '/../utils/jeerhasspy.utils.class.php';

require_once dirname(__FILE__) . '/../class/jeerhasspy.class.php';
require_once dirname(__FILE__) . '/../class/jeerhasspy.assistant.class.php';
require_once dirname(__FILE__) . '/../class/jeerhasspy.interaction.class.php';
require_once dirname(__FILE__) . '/../class/jeerhasspy.response.class.php';
require_once dirname(__FILE__) . '/../class/jeerhasspy.slot.class.php';
require_once dirname(__FILE__) . '/../class/jeerhasspy.answer.class.php';

require_once dirname(__FILE__) . '/../ajax/jeerhasspy.assistant.ajax.php';
require_once dirname(__FILE__) . '/../ajax/jeerhasspy.interaction.ajax.php';
require_once dirname(__FILE__) . '/../ajax/jeerhasspy.slot.ajax.php';
require_once dirname(__FILE__) . '/../ajax/jeerhasspy.answer.ajax.php';

/*
 * Non obligatoire mais peut être utilisé si vous voulez charger en même temps que votre
 * plugin des librairies externes (ne pas oublier d'adapter plugin_info/info.xml).
 * 
 * 
 */
