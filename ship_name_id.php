<?php

include_once("./inc.php");
include_once("./func.php");

function ED_getShipNameID()
{
    $res1 = ED_getContentFromEvent("Loadout", "ShipName");
    $res2 = ED_getContentFromEvent("Loadout", "ShipIdent");
    $ship = strtolower(ED_getContentFromEvent("Loadout", "Ship"));

    $ships = [
        'adder',
        'belugaliner'              => 'Beluga Liner',
        'anaconda',
        'asp'                      => 'Asp Explorer',
        'asp_scout'                => 'Asp Scout',
        'cobramkiii'               => 'Cobra Mk. III',
        'cobramkiv'                => 'Cobra Mk. IV',
        'cutter'                   => 'Imperial Cutter',
        'diamondback'              => 'Diamondback Scout',
        'diamondbackxl'            => 'Diamondback Explorer',
        'dolphin',
        'eagle',
        'empire_courier'           => 'Imperial Courier',
        'empire_eagle'             => 'Imperial Eagle',
        'empire_trader'            => 'Imperial Clipper',
        'federation_corvette'      => 'Federal Corvette',
        'federation_dropship'      => 'Federal Dropship',
        'federation_dropship_mkii' => 'Federal Assault Ship',
        'federation_gunship'       => 'Federal Gunship',
        'ferdelance'               => 'Fer-de-lance',
        'hauler',
        'krait_mkii'               => 'Krait Mk. II',
        'krait_light'              => 'Krait Phantom',
        'independant_trader'       => 'Keelback',
        'mamba',
        'orca',
        'python',
        'sidewinder',
        'type6'                    => 'Type-6 Transporter',
        'type7'                    => 'Type-7 Transporter',
        'type9'                    => 'Type-9 Transporter',
        'type9_military'           => 'Type-10 Defender',
        'typex'                    => 'Alliance Chieftain',
        'typex_2'                  => 'Alliance Crusader',
        'typex_3'                  => 'Alliance Challenger',
        'viper',
        'viper_mkiv'               => 'Viper Mk. IV',
        'vulture',
    ];

    if (array_key_exists($ship, $ships)) {
        $res3 = $ships[$ship];
    } elseif (in_array($ship, $ships)) {
        $res3 = ucfirst($ship);
    } else {
        $res3 = $ship;
    }

    $res = array($res1, $res2, $res3);

    return $res;
}

?>
