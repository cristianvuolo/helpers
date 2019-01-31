<?php
if (!function_exists('getLayoutData')) {
    function getLayoutData($data)
    {
        return config('ProjectConfig.layout.' . $data);
    }
}


if (!function_exists('getStatus')) {
    /**
     * @param $status
     * @param $module
     * @return mixed|string
     * @throws Exception
     */
    function getStatus($statusNumber, $module)
    {
        if (!is_array($module)) {
            $module = config('CvConfigs.cv_helpers.status.' . $module);
            if (!is_array($module)) {
                throw new \Exception('O array de status não encontrado no arquivo CvConfigs/cv_helpers Modulo:' . $module);
            }
        }

        if ($statusNumber === 'array') {
            return $module;
        }

        foreach ($module as $i => $s) {
            if ($i == $statusNumber) {
                return $s;
            }
        }
        return 'Indefinido';
    }
}

if (!function_exists('getSize')) {
    function getSize($module)
    {
        if (is_array($module)) {
            $sizes = $module;
        } else {
            $sizes = config('CvConfigs.cv_uploader.sizes.' . $module);
        }

        if (isset($sizes[0]) and isset($sizes[1])) {
            return "({$sizes[0]}x{$sizes[1]}px)";
        }

        if (isset($sizes[0])) {
            return '(Largura: ' . $sizes[0] . 'px)';
        }

        if (isset($sizes[1])) {
            return '(Altura: ' . $sizes[1] . 'px)';
        }
        return '';
    }
}

if (!function_exists('getFoneLink')) {
    function getFoneLink($foneConfigKey)
    {
        $fone = config('ProjectConfig.layout.' . $foneConfigKey, null);
        if (is_null($fone)) {
            $fone = $foneConfigKey;
        }
        $phone_number_cleaned = getFoneNumbers($foneConfigKey);

        if (is_numeric($phone_number_cleaned)) {
            return "<a href='phone:+55{$phone_number_cleaned}'>{$fone}</a>";
        }
        return;
    }
}

if (!function_exists('getFoneNumbers')) {
    function getFoneNumbers($foneConfigKey) {
        $fone = config('ProjectConfig.layout.' . $foneConfigKey, null);

        if (is_null($fone)) {
            $fone = $foneConfigKey;
        }

        return str_replace(['(', ')', ' ', '-'], '', $fone);
    }
}

if (!function_exists('getConfig')) {
    function getConfig($config_name, $default=null)
    {
        $config = \App\Models\Admin\Config::where('nome', $config_name)->first();
        if($config)
            return $config->value;

        return $default;
    }
}


if (!function_exists('redeS')) {
    function redeS(array $redes, $template)
    {
        $r = '';
        foreach ($redes as $rede => $icon) {
            $config = getConfig($rede);

            if ($config) {
                $r .= str_replace_array('?', [$config, $icon], $template);
            }
        }
        return $r;
    }
}