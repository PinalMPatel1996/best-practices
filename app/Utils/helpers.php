<?php

function success($message = 'success')
{
    return response()->json($message);
}
