<?php

$str = 'スコープテスト';
function test_scope()
{
    print $_SERVER['REQUEST_METHOD'];
}

test_scope();
