<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculator extends Model
{
    use HasFactory;

    const TABS = [
        'Fotowoltaika', 'Ocieplenie', 'Pompa ciepła', 'Instalacja CO'
    ];

    const INSTALLATION_TYPES = [
        "Instalacja fotowoltaiczna z magazynem energii",
        "Instalacja fotowoltaiczna",
        "Magazyn energii",
        "Instalacja fotowoltaiczna z magazynem energii i magazynem ciepła",
        "Instalacja fotowoltaiczna z magazynem ciepła",
        "Magazyn energii z magazynem ciepła"
    ];

    const PANELS  = [
        ["amount" => 6, "value" => "2.64", "text" => "6 panel(i) - 2.64kW"],
        ["amount" => 7, "value" => "3.08", "text" => "7 panel(i) - 3.08kW"],
        ["amount" => 8, "value" => "3.52", "text" => "8 panel(i) - 3.52kW"],
        ["amount" => 9, "value" => "3.96", "text" => "9 panel(i) - 3.96kW"],
        ["amount" => 10, "value" => "4.40", "text" => "10 panel(i) - 4.40kW"],
        ["amount" => 11, "value" => "4.84", "text" => "11 panel(i) - 4.84kW"],
        ["amount" => 12, "value" => "5.28", "text" => "12 panel(i) - 5.28kW"],
        ["amount" => 13, "value" => "5.72", "text" => "13 panel(i) - 5.72kW"],
        ["amount" => 14, "value" => "6.16", "text" => "14 panel(i) - 6.16kW"],
        ["amount" => 15, "value" => "6.60", "text" => "15 panel(i) - 6.60kW"],
        ["amount" => 16, "value" => "7.04", "text" => "16 panel(i) - 7.04kW"],
        ["amount" => 17, "value" => "7.48", "text" => "17 panel(i) - 7.48kW"],
        ["amount" => 18, "value" => "7.92", "text" => "18 panel(i) - 7.92kW"],
        ["amount" => 19, "value" => "8.36", "text" => "19 panel(i) - 8.36kW"],
        ["amount" => 20, "value" => "8.80", "text" => "20 panel(i) - 8.80kW"],
        ["amount" => 21, "value" => "9.24", "text" => "21 panel(i) - 9.24kW"],
        ["amount" => 22, "value" => "9.68", "text" => "22 panel(i) - 9.68kW"],
        ["amount" => 23, "value" => "10.12", "text" => "23 panel(i) - 10.12kW"],
        ["amount" => 24, "value" => "10.56", "text" => "24 panel(i) - 10.56kW"],
        ["amount" => 25, "value" => "11.00", "text" => "25 panel(i) - 11.00kW"],
        ["amount" => 26, "value" => "11.44", "text" => "26 panel(i) - 11.44kW"],
        ["amount" => 27, "value" => "11.88", "text" => "27 panel(i) - 11.88kW"],
        ["amount" => 28, "value" => "12.32", "text" => "28 panel(i) - 12.32kW"],
        ["amount" => 29, "value" => "12.76", "text" => "29 panel(i) - 12.76kW"],
        ["amount" => 30, "value" => "13.20", "text" => "30 panel(i) - 13.20kW"],
        ["amount" => 31, "value" => "13.64", "text" => "31 panel(i) - 13.64kW"],
        ["amount" => 32, "value" => "14.08", "text" => "32 panel(i) - 14.08kW"],
        ["amount" => 33, "value" => "14.52", "text" => "33 panel(i) - 14.52kW"],
        ["amount" => 34, "value" => "14.96", "text" => "34 panel(i) - 14.96kW"],
        ["amount" => 35, "value" => "15.40", "text" => "35 panel(i) - 15.40kW"],
        ["amount" => 36, "value" => "15.84", "text" => "36 panel(i) - 15.84kW"],
        ["amount" => 37, "value" => "16.28", "text" => "37 panel(i) - 16.28kW"],
        ["amount" => 38, "value" => "16.72", "text" => "38 panel(i) - 16.72kW"],
        ["amount" => 39, "value" => "17.16", "text" => "39 panel(i) - 17.16kW"],
        ["amount" => 40, "value" => "17.60", "text" => "40 panel(i) - 17.60kW"],
        ["amount" => 41, "value" => "18.04", "text" => "41 panel(i) - 18.04kW"],
        ["amount" => 42, "value" => "18.48", "text" => "42 panel(i) - 18.48kW"],
        ["amount" => 43, "value" => "18.92", "text" => "43 panel(i) - 18.92kW"],
        ["amount" => 44, "value" => "19.36", "text" => "44 panel(i) - 19.36kW"],
        ["amount" => 45, "value" => "19.80", "text" => "45 panel(i) - 19.80kW"],
        ["amount" => 46, "value" => "20.24", "text" => "46 panel(i) - 20.24kW"],
        ["amount" => 47, "value" => "20.68", "text" => "47 panel(i) - 20.68kW"],
        ["amount" => 48, "value" => "21.12", "text" => "48 panel(i) - 21.12kW"],
        ["amount" => 49, "value" => "21.56", "text" => "49 panel(i) - 21.56kW"],
        ["amount" => 50, "value" => "22.00", "text" => "50 panel(i) - 22.00kW"],
        ["amount" => 51, "value" => "22.44", "text" => "51 panel(i) - 22.44kW"],
        ["amount" => 52, "value" => "22.88", "text" => "52 panel(i) - 22.88kW"],
        ["amount" => 53, "value" => "23.32", "text" => "53 panel(i) - 23.32kW"],
        ["amount" => 54, "value" => "23.76", "text" => "54 panel(i) - 23.76kW"],
        ["amount" => 55, "value" => "24.20", "text" => "55 panel(i) - 24.20kW"],
        ["amount" => 56, "value" => "24.64", "text" => "56 panel(i) - 24.64kW"],
        ["amount" => 57, "value" => "25.08", "text" => "57 panel(i) - 25.08kW"],
        ["amount" => 58, "value" => "25.52", "text" => "58 panel(i) - 25.52kW"],
        ["amount" => 59, "value" => "25.96", "text" => "59 panel(i) - 25.96kW"],
        ["amount" => 60, "value" => "26.40", "text" => "60 panel(i) - 26.40kW"],
        ["amount" => 61, "value" => "26.84", "text" => "61 panel(i) - 26.84kW"],
        ["amount" => 62, "value" => "27.28", "text" => "62 panel(i) - 27.28kW"],
        ["amount" => 63, "value" => "27.72", "text" => "63 panel(i) - 27.72kW"],
        ["amount" => 64, "value" => "28.16", "text" => "64 panel(i) - 28.16kW"],
        ["amount" => 65, "value" => "28.60", "text" => "65 panel(i) - 28.60kW"],
        ["amount" => 66, "value" => "29.04", "text" => "66 panel(i) - 29.04kW"],
        ["amount" => 67, "value" => "29.48", "text" => "67 panel(i) - 29.48kW"],
        ["amount" => 68, "value" => "29.92", "text" => "68 panel(i) - 29.92kW"],
        ["amount" => 69, "value" => "30.36", "text" => "69 panel(i) - 30.36kW"],
        ["amount" => 70, "value" => "30.80", "text" => "70 panel(i) - 30.80kW"],
        ["amount" => 71, "value" => "31.24", "text" => "71 panel(i) - 31.24kW"],
        ["amount" => 72, "value" => "31.68", "text" => "72 panel(i) - 31.68kW"],
        ["amount" => 73, "value" => "32.12", "text" => "73 panel(i) - 32.12kW"],
        ["amount" => 74, "value" => "32.56", "text" => "74 panel(i) - 32.56kW"],
        ["amount" => 75, "value" => "33.00", "text" => "75 panel(i) - 33.00kW"],
        ["amount" => 76, "value" => "33.44", "text" => "76 panel(i) - 33.44kW"],
        ["amount" => 77, "value" => "33.88", "text" => "77 panel(i) - 33.88kW"],
        ["amount" => 78, "value" => "34.32", "text" => "78 panel(i) - 34.32kW"],
        ["amount" => 79, "value" => "34.76", "text" => "79 panel(i) - 34.76kW"],
        ["amount" => 80, "value" => "35.20", "text" => "80 panel(i) - 35.20kW"]
    ];

    const MONTAGE_SYSTEM_TYPES = [
        "BLACHODACHÓWKA",
        "DACHÓWKA",
        "DACHÓWKA PROSTA",
        "KARPIÓWKA",
        "PŁYTA WARSTWOWA",
        "BLACHA TRAPEZOWA",
        "BLACHA NA RĄBEK",
        "GONT / PAPA",
        "SYSTEM KLEJONY",
        "DACH PŁASKI",
        "" // wybierz / nie dotyczy
    ];


}
