(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('combination:before, after, beforeEach, afterEach', function(t) {
        runOptionsTest(t, {
            before: 'beforeTest!',
            after: 'afterTest!',
            beforeEach: 'beforeEachTest!',
            afterEach: 'afterEachTest!'
        });
    });

    test('combination:extname, basename, prefix, suffix', function(t) {
        runOptionsTest(t, {
            extname: 'extnameTest!',
            basename: 'basenameTest!',
            prefix: 'prefixTest!',
            suffix: 'suffixTest!'
        });
    });

    test('combination:readme options', function(t) {
        runOptionsTest(t, {
            before: 'Starting Gzip...',
            after: 'Gzipping complete!',
            extname: '.js.gz',
            showChange: true
        });
    });
}());
