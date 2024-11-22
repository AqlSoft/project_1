<?php

namespace App;

function testingHelper () {
    return 'hello world';
}


trait Helper {
    public function testingHelper () {
        return 'hello world';
    }
}
