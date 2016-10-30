<?php

use Carbon\Carbon;


if (!function_exists('getUri')) {
    /**
     * @param $n
     * @param bool $ignoreGet
     * @return bool|null
     */
    function getUri($n, $ignoreGet = false)
    {
        $uri = $_SERVER['REQUEST_URI'];
        if ($ignoreGet) {
            $uri = explode('?', $uri)[0];
        }
        $uri = explode('/', $uri);
        if (is_numeric($n)) {
            if (isset($uri[$n])) {
                return $uri[$n];
            } else {
                return null;
            }
        } elseif ($n == 'last') {
            $countSegments = count($uri);
            $countSegments--;
            return $uri[$countSegments];
        } else {
            return false;
        }
    }
}

if (!function_exists('getFavicons')) {
    function getFavicons($version=1, $path='/uploads/favicon/')
    {
        return "<link rel=\"icon\" href=\"{$path}16.png?v={$version}\" sizes=\"16x16\">
    <link rel=\"icon\" href=\"{$path}32.png?v={$version}\" sizes=\"32x32\">
    <link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"{$path}144.png?v={$version}\">
    <link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"{$path}114.png?v={$version}\">
    <link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"{$path}72.png?v={$version}\">
    <link rel=\"apple-touch-icon\" href=\"{$path}57.png?v={$version}\">
    <link rel=\"apple-touch-icon-precomposed\" href=\"{$path}57.png?v={$version}\">";
    }
}

if (!function_exists('setActive')) {
    /**
     * @param $p1 = Primeiro Parametro
     * @param $uriSegment = Segmento da URL
     * @param string $class = Classe a ser aplicada
     * @return string
     */
    function setActive($p1, $uriSegment, $class = 'active')
    {
        if(is_numeric($uriSegment)) {
            if ($p1 == getUri($uriSegment)) {
                return $class;
            }
        }
        if ($p1 == $uriSegment) {
            return $class;
        }
        return '';

    }
}

if (!function_exists('moneyRemoveMask')) {
    /**
     * @param $money
     * @return mixed
     */
    function moneyRemoveMask($money)
    {
        $money = str_replace('.', '', $money);
        return str_replace(',', '.', $money);
    }
}


if (!function_exists('dataUser')) {
    /**
     * @param $data
     * @param string $mask
     * @param string $format
     * @return string
     */
    function dataUser($data, $format = 'd/m/Y', $mask = 'Y-m-d H:i:s')
    {
        return Carbon::createFromFormat($mask, $data)->format($format);
    }
}


if (!function_exists('moeda')) {
    /**
     * @param null $valor
     * @param bool $onlyNumbers
     * @return bool|int|mixed|null|string
     */
    function moeda($valor = null, $onlyNumbers = false)
    {

        if ($valor == null) {
            return 'R$ 0,00';
        }
        if (is_array($valor)) {
            $total = 0;
            foreach ($valor as $valor_array) {
                $total = $total + $valor_array;
            }
            $valor = $total;
        }
        // Pegando valor para retornar no spam com cor
        setlocale(LC_MONETARY, 'pt_BR'); //'pt_BR.UTF-8

        $valor = number_format($valor, 2, ',', '.');
        if ($onlyNumbers) return $valor;
        $valor = 'R$ ' . $valor;
        return $valor;
    }
}

if (!function_exists('slug')) {
    /**
     * @param $string
     * @param $table
     * @return string
     */
    function slug($string, $table)
    {
        $slug = str_slug($string, '-');
        $count = DB::table($table)->where('slug', $slug)->count();
        if ($count == 0) {
            return $slug;
        } else {
            $numSlug = 0;

            while ($count <> 0) {
                $numSlug++;
                $newSlug = $numSlug . '-' . $slug;
                $count = DB::table($table)->where('slug', $newSlug)->count();
            }
            return $newSlug;
        }
    }
}

if (!function_exists('clearMoneyMask')) {
    /**
     * @param $string
     * @return double
     * Essa funÃ§Ã£o funciona junto com o Mask em https://bitbucket.org/snippets/cristianvuolo/dn4Kr
     */
    function clearMoneyMask($string)
    {
        if (str_contains($string, 'R$')) {
            $string = trim(str_replace('R$', '', $string));
        }
        $string = str_replace('.', '', $string);
        $string = str_replace(',', '.', $string);
        return floatval(trim($string));
    }
}

if (!function_exists('formBtn')) {
    /**
     * @param null $route
     * @param string $btnText
     * @return string
     *
     * Para passar o link, setar "showback = true" e passar o link no index "link" com o link
     */
    function formBtn($route = null, $btnText = 'Salvar')
    {
        if (is_array($route)) {
            if ($route['showBack'] === true AND isset($route['link'])) {
                $a = '<a href="' . $route['link'] . '">Voltar</a>';
            } else {
                $a = '';
            }
        } else {
            if (!is_null($route)) {
                $a = '<a href="' . route($route) . '">Voltar</a>';
            } else {
                $a = '';
            }
        }

        $s = '<span style="margin:0 0.5em"></span>';
        if ($btnText == null) {
            $b = '<button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Salvar</button>';
        } else {
            $b = '<button type="submit" class="btn btn-success btn-lg"> ' . $btnText . ' </button>';
        }

        return '<div class="text-center">' . $a . $s . $b . '</div>';
    }
}

if (!function_exists('cortaString')) {
    function cortaString($string, $tamanho = '100', $cont = '...')
    {
        $string = strip_tags($string);
        if ($tamanho >= strlen($string)) {
            return $string;
        }
        $string = substr($string, 0, $tamanho) . $cont;
        $string = trim($string);
        return $string;
    }
}

if (!function_exists('youtubeVID')) {
    function youtubeVID($link)
    {
        parse_str(parse_url($link, PHP_URL_QUERY), $my_array_of_vars);
        return $my_array_of_vars['v'];
    }
}

if (!function_exists('ufs')) {
    function ufs()
    {
        return [
            "" => "---------------",
            "SC" => "Santa Catarina",
            "RS" => "Rio Grande do Sul",
            "AC" => "Acre",
            "AL" => "Alagoas",
            "AM" => "Amazonas",
            "AP" => "Amapá",
            "BA" => "Bahia",
            "CE" => "Ceará",
            "DF" => "Distrito Federal",
            "ES" => "Espírito Santo",
            "GO" => "Goiás",
            "MA" => "Maranhão",
            "MT" => "Mato Grosso",
            "MS" => "Mato Grosso do Sul",
            "MG" => "Minas Gerais",
            "PA" => "Pará",
            "PB" => "Paraíba",
            "PR" => "Paraná",
            "PE" => "Pernambuco",
            "PI" => "Piauí",
            "RJ" => "Rio de Janeiro",
            "RN" => "Rio Grande do Norte",
            "RO" => "Rondônia",
            "RR" => "Roraima",
            "SE" => "Sergipe",
            "SP" => "São Paulo",
            "TO" => "Tocantins"
        ];
    }
}
if (!function_exists('tinymce')) {
    function tinymce($type = 'admin')
    {
        if ($type == 'admin') {
    //        <script src="/admin_assets/tinymce/tinymce.min.js"></script>
            return '
                    
                    <script>
                    tinyMCE.baseURL = "/admin_assets/js/tinymce";
                    tinymce.init({
                        selector:\'textarea\',
                        plugins: [
                            \'advlist autolink lists link image charmap print preview anchor\',
                            \'searchreplace visualblocks code fullscreen\',
                            \'insertdatetime media table contextmenu paste code jbimages\'
                        ],
                        toolbar: \'insertfile undo redo | styleselect | bold italic | alignleft \' +
                        \'aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages\',
                        language: \'pt_BR\',
                        menubar: true,
                        relative_urls: false
                    });
                    </script>
            ';
        } else {
    //        <script src="/admin_assets/tinymce/tinymce.min.js"></script>
            return '
                    
                    <script>
                    tinyMCE.baseURL = "/admin_assets/js/tinymce";
                    tinymce.init({
                        selector:\'textarea\',
                        plugins: [
                            \'advlist autolink lists link image charmap print preview anchor\',
                            \'searchreplace visualblocks code fullscreen\',
                            \'insertdatetime media contextmenu paste\'
                        ],
                        toolbar: "undo | bold italic | alignleft aligncenter alignjustify | " +
                        "bullist numlist | link image",
                        language: \'pt_BR\',
                        menubar: false,
                    });
                    </script>
                ';
        }
    }
}

if (!function_exists('jsAlert')) {
    function jsAlert($msg = "Você tem certeza que deseja remover o registro?")
    {
        return "onclick=\"return confirm('" . $msg . "')\"";
    }
}

if (!function_exists('getDiaSemana')) {
    function getDiaSemana($dia = false)
    {

        $dias = [
            [
                'n' => 0,
                'nome' => 'Segunda-feira',
                'nomeCurto' => 'Segunda'
            ],
            [
                'n' => 1,
                'nome' => 'Terça-feira',
                'nomeCurto' => 'Terça'
            ],
            [
                'n' => 2,
                'nome' => 'Quarta-feira',
                'nomeCurto' => 'Quarta'
            ],
            [
                'n' => 3,
                'nome' => 'Quinta-feira',
                'nomeCurto' => 'Quinta'
            ],
            [
                'n' => 4,
                'nome' => 'Sexta-feira',
                'nomeCurto' => 'Sexta'
            ],
            [
                'n' => 5,
                'nome' => 'Sábado',
                'nomeCurto' => 'Sábado'
            ],
            [
                'n' => 6,
                'nome' => 'Domingo',
                'nomeCurto' => 'Domingo'
            ],
        ];

        if ($dia === 'select') {
            foreach ($dias as $dia) {
                $r[$dia['n']] = $dia['nome'];
            }
            return $r;
        }


        if ($dia === false) {
            return $dias;
        } else {
            foreach ($dias as $diax) {
                if ($dia === $diax['n']) {
                    return $diax['nome'];
                }
            }
        }
    }
}

if (!function_exists('getMesNome')) {
    function getMesNome($mes)
    {
        switch ($mes) {
            case 1:
                return 'Janeiro';
                break;
            case 2:
                return 'Fevereiro';
                break;
            case 3:
                return 'Março';
                break;
            case 4:
                return 'Abril';
                break;
            case 5:
                return 'Maio';
                break;
            case 6:
                return 'Junho';
                break;
            case 7:
                return 'Julho';
                break;
            case 8:
                return 'Agosto';
                break;
            case 9:
                return 'Setembro';
                break;
            case 10:
                return 'Outubro';
                break;
            case 11:
                return 'Novembro';
                break;
            case 12:
                return 'Dezembro';
                break;
        }
    }
}

if (!function_exists('shareBlock')) {
    function shareBlock($scryptsOnly = false)
    {
        $scripts = '<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
            <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
            <a class="a2a_button_facebook"></a>
            <a class="a2a_button_twitter"></a>
            <a class="a2a_button_google_plus"></a>
            <a class="a2a_button_email"></a>
            <a class="a2a_button_whatsapp hidden-lg hidden-md"></a>
        </div>
        <script>
            var a2a_config = a2a_config || {};
            a2a_config.onclick = 1;
            a2a_config.locale = "pt-BR";
        </script>
        <script async src="https://static.addtoany.com/menu/page.js"></script>';

        if ($scryptsOnly) {
            return $scripts;
        }

        return '<div class="social pull-right" style="margin: 1.5em 0">
        <h4>Gostou compartilhe:</h4>
        <p>
        ' . $scripts . '
        </p>
        <div class="clearfix"></div>
    </div>';
    }
}