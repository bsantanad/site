<?php

$word_list = [
    'vim', 'python', 'php', 
    'flask', 'html', 'podman', 
    'jinja2', 'git', 'c',
    'matlab', 'numpy', 'pandas',
];
$idx = array_rand($word_list, 1);
$word = $word_list[$idx];

$color_list = ['#ffcc00', '#ff3b30', '#34c759', '#007afc'];
$idx = array_rand($color_list, 1);
$color = $color_list[$idx];

?>
