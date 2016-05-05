(function() {
    'use strict';

    var gulp = require('gulp'),
        logger = require('../index.js'),
        FILES_TO_STREAM = 'test/files-to-stream/**/*.js';

    module.exports = {
        runOptionsTest: function(t, config) {
            t.plan(1);

            gulp.src(FILES_TO_STREAM)
                .pipe(logger(config))
                .on('data', function() {}).on('end', function() {
                    t.equals(true, true);
                });
        },

        runFunctionTest: function(t, config) {
            t.plan(1);

            gulp.src(FILES_TO_STREAM)
                .pipe(logger(function(filePath) {
                    console.log(filePath);
                }, config))
                .on('data', function() {}).on('end', function() {
                    t.equals(true, true);
                });
        }
    };
}());
