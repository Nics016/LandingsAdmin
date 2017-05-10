<?php
namespace landing;

class Place 
{
    ///////////////
    // Константы //
    ///////////////
    const STATE = 1;
    const STATE_READY = 10;
    const STATE_OTDELKA = 20;
    const STATE_CLEAR_OTDELKA = 30;
    const STATE_SELLING = 40;

    const PLANNING = 2;
    const PLANNING_OPEN = 10;
    const PLANNING_MIXED = 20;
    const PLANNING_CABINET = 30;

    const PRICE_SIGN = 3;
    const PRICE_SIGN_RUB = 10;
    const PRICE_SIGN_DOL = 20;
    const PRICE_SIGN_EUR = 30;

    public function getDdlText($val, $ddl_id)
    {
        $ddlText = [
            Place::STATE => [
                Place::STATE_READY => 'готово к въезду',
                Place::STATE_OTDELKA => 'под отделку',
                Place::STATE_CLEAR_OTDELKA => 'под чистовую отделку',
                Place::STATE_SELLING => 'продажа',
            ],
            Place::PLANNING => [
                Place::PLANNING_OPEN => 'открытая',
                Place::PLANNING_MIXED => 'смешанная',
                Place::PLANNING_CABINET => 'кабинетная',
            ],
            Place::PRICE_SIGN => [
                Place::PRICE_SIGN_RUB => 'Руб.',
                Place::PRICE_SIGN_DOL => '$',
                Place::PRICE_SIGN_EUR => '€',
            ],
        ];

        return $ddlText[$ddl_id][$val];
    }
}
