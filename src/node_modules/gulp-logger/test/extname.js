(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('extname', function(t) {
        runOptionsTest(t, {
            extname: 'extnameTest!'
        });
    });
}());
