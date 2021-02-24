<?php

class JeerhasspyUtils
{
    public static function getPluginApiUri($_internal)
    {
        $internal = boolval($_internal);
        return network::getNetworkAccess($internal ? 'internal' : 'external') . '/core/api/jeeApi.php?plugin=' . jeerhasspy_id . '&apikey=' . jeedom::getApiKey(jeerhasspy_id) . '&plugin=' . jeerhasspy_id . '&type=' . jeerhasspy_id;
    }

    public static function getConfig($_configKey)
    {
        return config::byKey($_configKey, jeerhasspy_id);
    }

    public static function setConfig($_configKey, $_configValue)
    {
        return config::save($_configKey, $_configValue, jeerhasspy_id);
    }

    public static function getInteractionsIntentNameOrDefault()
    {
        $interactionsIntentName = self::getConfig(jeerhasspy_config_interactionsIntentName);
        if (trim($interactionsIntentName) === '') {
            $interactionsIntentName = jeerhasspy_config_interactionsIntentName_default;
        }
        return $interactionsIntentName;
    }

    public static function getAskAnswerIntentNameOrDefault()
    {
        $askAnswerIntentName = self::getConfig(jeerhasspy_config_askAnswerIntentName);
        if (trim($askAnswerIntentName) === '') {
            $askAnswerIntentName = jeerhasspy_config_askAnswerIntentName_default;
        }
        return $askAnswerIntentName;
    }

    public static function isSupportedVersion($version)
    {
        if (version_compare($version, rhasspy_min_supported_version) < 0) {
            return false;
        }
        return true;
    }

    public static function generateAnswersPayload()
    {
        $askAnswerIntentName = JeerhasspyUtils::getAskAnswerIntentNameOrDefault();
        JeerhasspyUtils::logger('askAnswerIntentName: ' . $askAnswerIntentName);

        $answers = JeerhasspyAnswer::all();

        $payload = "\n[" . $askAnswerIntentName . "]\n";
        foreach ($answers as $answer) {
            if(!$answer->getIsSync())
            {
                continue;
            }
            foreach(preg_split("/\r?\n/", $answer->getConfiguration()) as $line){
                $payload .= $line."{".$answer->getName()."}\n";
            }
        }
        return json_encode([rhasspy_jeedom_answers_sentences_file => $payload]);
    }

    public static function generateSlotsPayload()
    {
        $slotsPayload = [];
        $slots = JeerhasspySlot::all();
        foreach ($slots as $slot) {
            if(!$slot->getIsSync())
            {
                continue;
            }
            $slotsPayload[$slot->getName()] = preg_split("/\r?\n/", $slot->getConfiguration());
        }
        return json_encode($slotsPayload);
    }

    public static function generateInteractionsPayload()
    {
        $interactionsIntentName = JeerhasspyUtils::getInteractionsIntentNameOrDefault();
        JeerhasspyUtils::logger('interactionsIntentName: '.$interactionsIntentName);

        $interactions = JeerhasspyInteraction::all();

        $payload = "[" . $interactionsIntentName . "]\n";
        foreach ($interactions as $interaction) {
            if($interaction->getIgnore())
            {
                continue;
            }
            foreach ($interaction->generateQueryVariant() as $queryVariant) {
                $variant = trim($queryVariant['query']);
                if ($variant == '') {
                    continue;
                }
                $payload .= $variant . "\n";
            }
        }
        return json_encode([rhasspy_jeedom_sentences_file => $payload]);
    }

    public static function evalDynamicString($_string)
    {
        if (strpos($_string, '{') !== false and strpos($_string, '}') !== false) {
            try {
                preg_match_all('/{(.*?)}/', $_string, $matches);
                foreach ($matches[0] as $expr_string) {
                    $expr = substr($expr_string, 1, -1);
                    $exprAr = explode('|', $expr);
                    $value = $exprAr[0];
                    array_shift($exprAr);

                    $valueString = '';
                    foreach ($exprAr as $thisExpr) {
                        $parts = explode(':', $thisExpr);
                        if ($parts[0][0] != '<' and $parts[0][0] != '>') {
                            $parts[0] = '==' . $parts[0];
                        }

                        $test = eval("return " . $value . $parts[0] . ";");
                        if ($test) {
                            $valueString = $parts[1];
                        }

                        if ($valueString != '') {
                            break;
                        }
                    }

                    $_string = str_replace($expr_string, $valueString, $_string);
                }

                return $_string;
            } catch (Exception $e) {
                return $_string;
            }
        } else {
            return $_string;
        }
    }

    public static function sanitizeLang($_lang)
    {
        switch ($_lang) {
            case 'fr':
                return 'fr-FR';
            case 'en':
                return 'en-US';
                break;
            case 'es':
                return 'es-ES';
            case 'de':
                return 'de-DE';
            default:
                return $_lang;
        }
    }

    public static function sanitizeString($_defaultLang, $_string)
    {
        if ($_defaultLang === 'fr-FR') {
            $_string = preg_replace('/ -(\d+)/', ' moins $1', $_string);
            $_string = preg_replace('/([0-9]+)\.([0-9]+)/', '$1 virgule $2', $_string);
            $_string = preg_replace('/([0-9]+),([0-9]+)/', '$1 virgule $2', $_string);
        }

        return $_string;
    }

    public static function logger($_str = '', $_level = 'debug')
    {
        $str = $_str;
        if (is_array($str)) {
            $str = json_encode($str);
        }
        $function_name = debug_backtrace(false, 2)[1]['function'];
        $class_name = debug_backtrace(false, 2)[1]['class'];
        $msg = '[' . $class_name . '] ' . $function_name . '() ' . $str;
        log::add(jeerhasspy_id, $_level, $msg);
    }

    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return substr($haystack, 0, $length) === $needle;
    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if (!$length) {
            return true;
        }
        return substr($haystack, -$length) === $needle;
    }

    public static function jsonResult($_object)
    {
        return json_encode(utils::o2a($_object));
    }

    public static function boolToInteger($value)
    {
        return self::toBool($value) ? 1 : 0;
    }

    public static function toBool($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
