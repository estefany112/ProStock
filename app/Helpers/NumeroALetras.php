<?php

if (!function_exists('numeroALetras')) {

    function numeroALetras($numero): string
    {
        $numero = number_format((float) $numero, 2, '.', '');

        [$entero, $decimal] = explode('.', $numero);

        $entero = (int) $entero;
        $decimal = (int) $decimal;

        if ($entero === 0) {
            $letras = 'CERO';
        } else {
            $letras = convertirNumero($entero);
        }

        return strtoupper(
            $letras .
            ' QUETZALES CON ' .
            str_pad($decimal, 2, '0', STR_PAD_LEFT) .
            '/100'
        );
    }
}

if (!function_exists('convertirNumero')) {

    function convertirNumero(int $numero): string
    {
        if ($numero < 1000) {
            return convertirCentenas($numero);
        }

        if ($numero < 1000000) {

            $miles = intdiv($numero, 1000);
            $resto = $numero % 1000;

            if ($miles === 1) {
                $resultado = 'MIL';
            } else {
                $resultado = convertirNumero($miles) . ' MIL';
            }

            if ($resto > 0) {
                $resultado .= ' ' . convertirNumero($resto);
            }

            return $resultado;
        }

        if ($numero < 1000000000) {

            $millones = intdiv($numero, 1000000);
            $resto = $numero % 1000000;

            if ($millones === 1) {
                $resultado = 'UN MILLÓN';
            } else {
                $resultado = convertirNumero($millones) . ' MILLONES';
            }

            if ($resto > 0) {
                $resultado .= ' ' . convertirNumero($resto);
            }

            return $resultado;
        }

        $milesMillones = intdiv($numero, 1000000000);
        $resto = $numero % 1000000000;

        if ($milesMillones === 1) {
            $resultado = 'MIL MILLONES';
        } else {
            $resultado = convertirNumero($milesMillones) . ' MIL MILLONES';
        }

        if ($resto > 0) {
            $resultado .= ' ' . convertirNumero($resto);
        }

        return $resultado;
    }
}

if (!function_exists('convertirCentenas')) {

    function convertirCentenas(int $numero): string
    {
        $unidades = [
            '',
            'UNO',
            'DOS',
            'TRES',
            'CUATRO',
            'CINCO',
            'SEIS',
            'SIETE',
            'OCHO',
            'NUEVE',
            'DIEZ',
            'ONCE',
            'DOCE',
            'TRECE',
            'CATORCE',
            'QUINCE',
            'DIECISÉIS',
            'DIECISIETE',
            'DIECIOCHO',
            'DIECINUEVE',
            'VEINTE'
        ];

        $decenas = [
            '',
            '',
            'VEINTE',
            'TREINTA',
            'CUARENTA',
            'CINCUENTA',
            'SESENTA',
            'SETENTA',
            'OCHENTA',
            'NOVENTA'
        ];

        $centenas = [
            '',
            'CIENTO',
            'DOSCIENTOS',
            'TRESCIENTOS',
            'CUATROCIENTOS',
            'QUINIENTOS',
            'SEISCIENTOS',
            'SETECIENTOS',
            'OCHOCIENTOS',
            'NOVECIENTOS'
        ];

        if ($numero <= 20) {
            return $unidades[$numero];
        }

        if ($numero < 30) {
            return 'VEINTI' . strtolower($unidades[$numero - 20]);
        }

        if ($numero < 100) {

            $decena = intdiv($numero, 10);
            $unidad = $numero % 10;

            return $decenas[$decena] .
                ($unidad > 0 ? ' Y ' . $unidades[$unidad] : '');
        }

        if ($numero === 100) {
            return 'CIEN';
        }

        $centena = intdiv($numero, 100);
        $resto = $numero % 100;

        return $centenas[$centena] .
            ($resto > 0 ? ' ' . convertirCentenas($resto) : '');
    }
}