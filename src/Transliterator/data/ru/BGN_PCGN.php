<?php

/*
 * This file is part of the Transliterator package.
 *
 * (c) Саша Стаменковић <umpirsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Russian mapping (BGN/PCGN system).
 *
 * @see http://en.wikipedia.org/wiki/Romanization_of_Russian
 */
return array (
    'cyr' => array(
        'щ', 'ж', 'х', 'ц', 'ч', 'ш', 'ю', 'я',
        'Щ', 'Ж', 'Х', 'Ц', 'Ч', 'Ш', 'Ю', 'Я',
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'ъ', 'ы', 'ь', 'э',
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Ъ', 'Ы', 'Ь', 'Э'
    ),

    'cyr_regexp' => array(
        'pattern' => array(
            '/^Е/', '/^е/', '/([\sъьйЪЬЙуеыаоэяиюУЕЫАОЭЯИЮ])Е/', '/([\sъьйЪЬЙуеыаоэяиюУЕЫАОЭЯИЮ])е/',
            '/^Ё/', '/^ё/', '/([\sъьйЪЬЙуеыаоэяиюУЕЫАОЭЯИЮ])Ё/', '/([\sъьйЪЬЙуеыаоэяиюУЕЫАОЭЯИЮ])ё/',
        ),
        'replacement' => array(
            'Ye', 'ye', '$1Ye', '$1ye',
            "Yë", "yë", "\$1Yë", "\$1yë",
        )
    ),

    'lat' => array(
        'shch', 'zh', 'kh', 'ts', 'ch', 'sh', 'yu', 'ya',
        'Shch', 'Zh', 'Kh', 'Ts', 'Ch', 'Sh', 'Yu', 'Ya',
        'a', 'b', 'v', 'g', 'd', 'e', 'ë', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'ˮ', 'y', 'ʼ', 'e',
        'A', 'B', 'V', 'G', 'D', 'E', 'Ë', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'ˮ', 'Y', 'ʼ', 'E'
    ),

    'lat_regexp' => array(
        'pattern' => array(
            '/Ye/', '/ye/',
            '/Y[ёë]/', '/y[ёë]/',
            '/([^euioaEUIOA\s])y/'
        ),
        'replacement' => array(
            'E', 'е',
            "Ё", "ё",
            '$1ы'
        )
    ),
);
