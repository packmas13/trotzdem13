@props(['subject' => ''])

<?php
$href = 'mailto:trotzdem13@dpsg1300.de';
if (!empty($subject)) {
    $href .= '?'.http_build_query(['subject'=>$subject], "", "&", PHP_QUERY_RFC1738);
}
?>

<a {{ $attributes->merge(['href'=>$href, 'class'=>'text-mango-700 hover:underline'])}}>trotzdem13@dpsg1300.de</a>
