<?php
function getLayoutData($data)
{
    return config('ProjectConfig.layout.' . $data);
}



function getStatus($n, $array)
{
    $array = config('ProjectConfig.status.' . $array);
    if (!is_array($array)) {
        throw new \Exception('O array de status não encontrado no arquivo config/ProjectConfig.php');
    }
    foreach ($array as $i => $s) {
        if ($i == $n) {
            return $s;
        }
    }
    return 'Indefinido';
}

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

function getFoneLink($foneConfigKey)
{
    $fone = config('ProjectConfig.layout.' . $foneConfigKey);
    if (is_null($fone)) {
        throw new \Exception('Key não encontrada na nas configurações!');
    }
    $fone_link = str_replace(['(', ')', ' ', '-'], '', $fone);
    return "<a href='phone:+55{$fone_link}'>{$fone}</a>";
}