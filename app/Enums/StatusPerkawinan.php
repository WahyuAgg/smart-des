<?php
namespace App\Enums;

enum StatusPerkawinan: string
{
    case BELUM_KAWIN = 'Belum Kawin';
    case KAWIN_TERCATAT = 'Kawin Tercatat';
    case KAWIN_BELUM_TERCATAT = 'Kawin Belum Tercatat';
    case CERAI_HIDUP = 'Cerai Hidup';
    case CERAI_MATI = 'Cerai Mati';
}