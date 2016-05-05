(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('dest:relative', function(t) {
        runOptionsTest(t, {
            dest: 'dest/test'
        });
    });

    test('dest:absolute', function(t) {
        runOptionsTest(t, {
            display: 'abs',
            dest: 'dest/test'
        });
    });

    test('dest:filename', function(t) {
        runOptionsTest(t, {
            display: 'name',
            dest: 'dest/test'
        });
    });
}());
