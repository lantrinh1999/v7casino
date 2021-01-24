<?php

if(!function_exists('stripAttributes')) {
    function stripAttributes($html,$attribs) {
        $dom = new simple_html_dom();
        $dom->load($html);
        foreach($attribs as $attrib)
            foreach($dom->find("*[$attrib]") as $e)
                $e->$attrib = null;
        $dom->load($dom->save());
        return $dom->save();
    }
}