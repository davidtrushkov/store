(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('display:default', function(t) {
        runOptionsTest(t, {});
    });

    test('display:relative', function(t) {
        runOptionsTest(t, {
            display: 'rel'
        });
    });

    test('display:absolute', function(t) {
        runOptionsTest(t, {
            display: 'abs'
        });
    });

    test('display:filename', function(t) {
        runOptionsTest(t, {
            display: 'name'
        });
    });
}());
