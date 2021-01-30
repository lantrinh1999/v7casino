<?php

function popup_view()
{

    if(empty(request()->cookie('popup'))) {
        return view('plugins/popup::popup')->render();
    }
}