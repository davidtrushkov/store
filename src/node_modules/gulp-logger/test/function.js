(function() {
    'use strict';

    var test = require('colored-tape'),
        runFunctionTest = require('./common.js').runFunctionTest;

    test('function:default', function(t) {
        runFunctionTest(t, {});
    });

    test('function:relative', function(t) {
        runFunctionTest(t, {
            display: 'rel'
        });
    });

    test('function:absolute', function(t) {
        runFunctionTest(t, {
            display: 'abs'
        });
    });

    test('function:filename', function(t) {
        runFunctionTest(t, {
            display: 'name'
        });
    });

    test('function:before', function(t) {
        runFunctionTest(t, {
            before: 'functionBeforeTest!'
        });
    });

    test('function:after', function(t) {
        runFunctionTest(t, {
            after: 'functionAfterTest!'
        });
    });
}());
