<?php

namespace App\Classes;


class Functions
{
    function calcularIncome($usuario)
    {
        $units = getUnits($usuario);
        $income = $units->untrained * untrained_income + $units->berserkers * berserkers_income + $units->paladins * paladins_income + $units->merchants * merchants_income;
        if ($usuario->race == 2) $income = $income * 1.2;

        return $income;
    }

    function calcularAttack($usuario)
    {
        $units = getUnits($usuario);
        $berserkers = $units->berserkers;
        $paladins = $units->paladins;
        $untrained = $units->untrained;
        $force = ($untrained * untrained_atk) + ($berserkers * berserkers_atk) + ($paladins * paladins_atk);
        $siege = $usuario->siege;
        $attack = $force * currentAtkBonus($siege);
        if ($usuario->race == 0) $attack = $attack * 1.25;

        return round($attack, 0);
    }

    function calcularDefense($usuario)
    {
        $units = getUnits($usuario);
        $berserkers = $units->berserkers;
        $paladins = $units->paladins;
        $untrained = $units->untrained;
        $force = ($untrained * untrained_def) + ($berserkers * berserkers_def) + ($paladins * paladins_def);
        $fort = $usuario->fort;
        $defense = $force * currentDefBonus($fort);
        if ($usuario->race == 1) $defense = $defense * 1.25;

        return round($defense, 0);
    }

    function calcularInjureds($attacker, $defender)
    {
        $attack = calcularAttack($attacker);
        $defense = calcularDefense($defender);
        if ($attack > $defense) {
            $ratio = round($defense * 100 / $attack);
            $ar = $ratio / 100;
            $dr = (100 - $ratio) / 100;
        } else {
            $ratio = round($attack * 100 / $defense);
            $ar = (100 - $ratio) / 100;
            $dr = $ratio / 100;
        }
        $a_units = getUnits($attacker);
        $a_units = $a_units->untrained + $a_units->berserkers + $a_units->paladins + $a_units->merchants;
        $d_units = getUnits($defender);
        $d_units = $d_units->untrained + $d_units->berserkers + $d_units->paladins + $d_units->merchants;
        //echo $ratio," ", $ar, " ", $dr, " ", "<br />";
        $injureds = ['attacker' => round(mt_rand($a_units / 500, $a_units / 100) * $ar), 'defender' => round(mt_rand($d_units / 500, $d_units / 100) * $dr)];

        //echo $injureds['attacker'], " ", $injureds['defender'];
        return $injureds;
    }

    function formatNum($num)
    {
        return number_format($num, 0, ",", ".");
    }

    function currentAtkBonus($final)
    {
        if ($final != 0) {
            return round(currentAtkBonus($final - 1) * (1 + atk_percent), 2);
        } else return 1;
    }

    function currentDefBonus($final)
    {
        if ($final != 0) {
            return round(currentDefBonus($final - 1) * (1 + def_percent), 2);
        } else return 1;
    }

//Para funciones
    function getRankF($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val[1] == $id) {
                return $key + 1;
            }
        }

        return null;
    }

//Para páginas
    function getRank($id)
    {
        $sql = mysql_query("select * from rankings where id_usuario=$id");

        return mysql_fetch_object($sql);
    }

//Por referencia para poder modificarlos en REGLAS.PHP y que lo pueda usar la página que la llame.
    function updateRank()
    {
        $sql = mysql_query("SELECT * FROM usuarios");
        $i = 0;
        while ($row = mysql_fetch_object($sql)) { //Los inserto desordenados, en pares de Valor-Usuario
            $attack[$i] = [calcularAttack($row), $row->usuario];
            $defense[$i] = [calcularDefense($row), $row->usuario];
            $i++;
        }
        //Los ordeno de mayor a menor.
        array_multisort($defense, SORT_DESC);
        array_multisort($attack, SORT_DESC);

        foreach ($attack as $key => $value) {//0=ataque, 1=usuario, 2=ranking
            $attack[$key] = [$value[0], $value[1], $key + 1];
        }
        foreach ($defense as $key => $value) {//0=ataque, 1=usuario, 2=ranking
            $defense[$key] = [$value[0], $value[1], $key + 1];
        }
        $sql = mysql_query("SELECT * FROM usuarios"); //Vuelvo a correr la consulta para el segundo while.
        $i = 0;
        while ($row = mysql_fetch_object($sql)) {
            $overall[$i] = [getRankF($row->usuario, $attack) + getRankF($row->usuario, $defense), $row->usuario, calcularAttack($row) + calcularDefense($row)];
            $i++;
        }
        //Tengo que crear dos arrays nuevos donde almaceno los valores de SumaRankings y SumaStats, que es el que desempata en caso de que
        //dos jugadores tengan el mismo SumaRankings.
        foreach ($overall as $value) {
            $overallRank[] = $value[0];
        }
        foreach ($overall as $value) {
            $overallStats[] = $value[2];
        }
        //Ordeno primero por sumaRank y dsp por sumaStats.
        array_multisort($overallRank, SORT_ASC, $overallStats, SORT_DESC, $overall);

        foreach ($overall as $key => $value) {//0=sumaRankings, 1=sumaStats, 2=usuario, 3=ranking
            $overall[$key] = [$value[0], $value[1], $value[2], $key + 1];
        }
        $sql = mysql_query("select id, usuario from usuarios");
        while ($result = mysql_fetch_object($sql)) {
            $ar = getRankF($result->usuario, $attack);
            $dr = getRankF($result->usuario, $defense);
            $or = getRankF($result->usuario, $overall);
            $sql2 = mysql_query("select 1 from rankings where id_usuario=$result->id");
            if (mysql_num_rows($sql2) > 0) {
                $sql2 = mysql_query("update rankings set id_usuario=$result->id, attack_rank=$ar, defense_rank=$dr, overall_rank=$or where id_usuario=$result->id");
            } else {
                $sql2 = mysql_query("insert into rankings (id_usuario, attack_rank, defense_rank, overall_rank) values ($result->id, $ar, $dr, $or)");
            }
        }
    }

    function generarNoticia($fecha, $noticia)
    {
        return "<p><span class='fecha'>" . $fecha . "</span>: " . $noticia . "</p>";
    }

    function makeLog($attacker, $defender, $result, $attacker_dmg, $defender_dmg, $attacker_losses, $defender_losses)
    {
        $sql = mysql_query("INSERT INTO logs (id, date, attacker_id, defender_id, result, attacker_dmg, defender_dmg, attacker_losses, defender_losses) VALUES (NULL, NOW(),'$attacker->id','$defender->id','$result','$attacker_dmg','$defender_dmg', '$attacker_losses', '$defender_losses')");
    }

    function setRace($race)
    {
        if ($race == 0) {
            $units_type = $racestyle = constant('string_race0');
        } else if ($race == 1) {
            $units_type = $racestyle = constant('string_race1');
        } else if ($race == 2) {
            $units_type = $racestyle = constant('string_race2');
        } else if ($race == 3) {
            $units_type = $racestyle = constant('string_race3');
        }
    }

    /**
     *  Given a file, i.e. /css/base.css, replaces it with a string containing the
     *  file's mtime, i.e. /css/base.1221534296.css.
     *
     * @param $file  The file to be loaded.  Must be an absolute path (i.e.
     *                starting with slash).
     */
    function autoVer($url)
    {
        $path = pathinfo($url);
        $ver = '.' . filemtime($url) . '.';
        echo $path['dirname'] . '/' . str_replace('.', $ver, $path['basename']);
    }

    function generar_texto($longitud, $especiales)
    {
        // Array con los valores a escoger
        $clave = "";
        $semilla = [];

        $semilla[] = ['a', 'e', 'i', 'o', 'u'];
        $semilla[] = ['b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'];
        $semilla[] = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $semilla[] = ['A', 'E', 'I', 'O', 'U'];
        $semilla[] = ['B', 'C', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'V', 'W', 'X', 'Y', 'Z'];
        $semilla[] = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        // si puede contener caracteres especiales, aumentamos el array $semilla
        if ($especiales) {
            $semilla[] = ['$', '#', '%', '&', '@', '-', '?', '¿', '!', '¡', '+', '-', '*'];
        }
        // creamos la clave con la longitud indicada
        for ($bucle = 0; $bucle < $longitud; $bucle++) {
            // seleccionamos un subarray al azar
            $valor = mt_rand(0, count($semilla) - 1);
            // selecccionamos una posición al azar dentro del subarray
            $posicion = mt_rand(0, count($semilla[$valor]) - 1);
            // cogemos el carácter y lo agregamos a la clave
            $clave .= $semilla[$valor][$posicion];
        }

// devolvemos la clave
        return $clave;
    }

    function mailActivacion($dir_correo, $usuario, $url)
    {
        $destinatario = $dir_correo;
        $nombre_pagina = "Color Nations";
        $asunto = $nombre_pagina . " - Activate account";
        $cuerpo = $nombre_pagina . ' - Activate account<h2><br />Welcome aboard,  ';
        $cuerpo .= $usuario;
        $cuerpo .= '</h2><strong>Thanks for registering on ' . $nombre_pagina . '</strong>.<br/>To finish up the activation, just follow the link below:<p style="text-align: center;">';
        $cuerpo .= '<a href="' . $url . '">' . $url . '</a>';
        $cuerpo .= '</p>';
        $cuerpo .= 'Best of luck!. <br /><strong>' . $nombre_pagina . '</strong>\'s staff';
//para el envío en formato HTML
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
//dirección del remitente
        $headers .= "From: Admin " . $nombre_pagina . "\r\n";
//dirección de respuesta, si queremos que sea distinta que la del remitente
        $headers .= "Reply-To: direccion_respuesta@dominio.com \r\n";
//direcciones que recibián copia
//$headers .= "Cc: correocopia@dominio.com\r\n";
//direcciones que recibirán copia oculta
//$headers .= "Bcc: copiaocula1@dominio.com, copiaocula1@dominio.com \r\n";
        mail($destinatario, $asunto, $cuerpo, $headers);
    }

    function validarUsuario($usuario)
    {
        return preg_match('/^\w+$/i', $usuario);
    }

    function validarMail($mail)
    {
        return preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $mail);
    }

    function updateGold($gold)
    {
        echo '<script type="text/javascript">'
        , 'changeValue("oro","' . constant('string_oro') . ": " . formatNum($gold) . " " . constant('string_moneda') . '");'
        , '</script>';
    }

    function getUnits($usuario)
    {
        $sql = "select * from units where id_usuario = $usuario->id";
        if (!$sql) {
            echo "Error en la consulta SQL para getUnits";
        } else {
            $result = mysql_query($sql);
            if (mysql_num_rows($result) <= 0) {
                echo "El usuario no existe o no tiene unidades";
            } else return mysql_fetch_object($result);
        }

    }

    function getTFF($units)
    {
        return $units->untrained + $units->berserkers + $units->paladins + $units->merchants;
    }

    function updateUnits($usuario, $casualties = 0)
    {
        if ($casualties != 0) {
            $units = getUnits($usuario);
            $berserkers = $units->berserkers;
            $paladins = $units->paladins;
            $merchants = $units->merchants;
            $injured = $units->injured;
            $untrained = $units->untrained;
            if ($casualties <= $untrained) {
                $untrained -= $casualties;
                $injured += $casualties;
                //UPDATE
                $sql = mysql_query("update units set untrained = $untrained, injured = $injured, berserkers = $berserkers, paladins = $paladins, merchants = $merchants where id_usuario = $usuario->id");
                //echo $untrained, " ", $injured, " ", $berserkers, " ", $paladins, " ", $merchants, " ", "<br/>";
            } else {
                $casualties = $casualties - $untrained;
                $untrained = 0;
                for ($i = 0; $i < $casualties; $i++) {
                    $aux_casualties[] = mt_rand(1, 2); //1 Berserker, 2 Paladin
                }
                //Orden de lesionarse: Si sale 1: berserkers > paladins > merchants
                //Si sale 2: paladins > berserkers > merchants
                foreach ($aux_casualties as $value) {
                    if ($value == 1) {
                        if ($berserkers > 0) $berserkers -= 1;
                        else if ($paladins > 0) $paladins -= 1;
                        else if ($merchants > 0) $merchants -= 1;
                    } else if ($value == 2) {
                        if ($paladins > 0) $paladins -= 1;
                        else if ($berserkers > 0) $berserkers -= 1;
                        else if ($merchants > 0) $merchants -= 1;
                    }
                }
                $injured += $casualties;
                $sql = mysql_query("update units set untrained = $untrained, injured = $injured, berserkers = $berserkers, paladins = $paladins, merchants = $merchants where id_usuario = $usuario->id");
                //echo $untrained, " ", $injured, " ", $berserkers, " ", $paladins, " ", $merchants, "<br/>";
            }
        } else {

        }
    }
}