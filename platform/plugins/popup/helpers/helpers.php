<?php

function popup_view()
{
    if(empty(\Session::get('dont_show_popup'))) {
        return view('plugins/popup::popup')->render();
    }
}