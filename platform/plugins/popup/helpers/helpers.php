<?php

function popup_view()
{
    // dd(\Session::get('popup'));
    if(empty(\Session::get('popup'))) {
        return view('plugins/popup::popup')->render();
    }
}