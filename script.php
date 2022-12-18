<?php
include "connect.php";
include "functions.php";

function randomName()
{
    $firstname = array(
        'Johnathon',
        'Anthony',
        'Erasmo',
        'Raleigh',
        'Nancie',
        'Tama',
        'Camellia',
        'Augustine',
        'Christeen',
        'Luz',
        'Diego',
        'Lyndia',
        'Thomas',
        'Georgianna',
        'Leigha',
        'Alejandro',
        'Marquis',
        'Joan',
        'Stephania',
        'Elroy',
        'Zonia',
        'Buffy',
        'Sharie',
        'Blythe',
        'Gaylene',
        'Elida',
        'Randy',
        'Margarete',
        'Margarett',
        'Dion',
        'Tomi',
        'Arden',
        'Clora',
        'Laine',
        'Becki',
        'Margherita',
        'Bong',
        'Jeanice',
        'Qiana',
        'Lawanda',
        'Rebecka',
        'Maribel',
        'Tami',
        'Yuri',
        'Michele',
        'Rubi',
        'Larisa',
        'Lloyd',
        'Tyisha',
        'Samatha',
    );

    $lastname = array(
        'Mischke',
        'Serna',
        'Pingree',
        'Mcnaught',
        'Pepper',
        'Schildgen',
        'Mongold',
        'Wrona',
        'Geddes',
        'Lanz',
        'Fetzer',
        'Schroeder',
        'Block',
        'Mayoral',
        'Fleishman',
        'Roberie',
        'Latson',
        'Lupo',
        'Motsinger',
        'Drews',
        'Coby',
        'Redner',
        'Culton',
        'Howe',
        'Stoval',
        'Michaud',
        'Mote',
        'Menjivar',
        'Wiers',
        'Paris',
        'Grisby',
        'Noren',
        'Damron',
        'Kazmierczak',
        'Haslett',
        'Guillemette',
        'Buresh',
        'Center',
        'Kucera',
        'Catt',
        'Badon',
        'Grumbles',
        'Antes',
        'Byron',
        'Volkman',
        'Klemp',
        'Pekar',
        'Pecora',
        'Schewe',
        'Ramage',
    );

    $name = $firstname[rand(0, count($firstname) - 1)];
    $name .= ' ';
    $name .= $lastname[rand(0, count($lastname) - 1)];

    return $name;
}

function randomAddress()
{
    $city = array(
        'Chernihiv',
        'Lviv',
        'Kiyv'
    );

    $street = array(
        'Shevchenka',
        'Mazepi',
        'Harkivska'
    );

    $name = $city[rand(0, count($city) - 1)];
    $name .= ', ';
    $name .= $street[rand(0, count($street) - 1)];
    $name .= rand(1,128);

    return $name;
}


for($i=0;$i<10;$i++){
    // pg_execute($connection, "insert_filiation", array(randomAddress(),3));
    // pg_execute($connection, "insert_workers", array(randomName(),"worker",rand(100000,200000)/100,3,1));
    pg_execute($connection, "insert_clients", array(randomName(),rand(4,14)));
}




?>