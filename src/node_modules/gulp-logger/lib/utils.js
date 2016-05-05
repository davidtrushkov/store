(function() {
    'use strict';

    var path = require('path'),
        chalk = require('chalk'),

        Utils;

    Utils = {
        getRelativePath: function(filePath) {
            return path.relative(process.cwd(), filePath);
        },

        colorsEnabled: true,

        colorTrans: function(message, color) {
            var result = message;

            if (Utils.colorsEnabled) {
                result = chalk[color](message);
            }

            return result;
        },

        getDisplayPath: function(filePath, display) {
            var newPath;

            switch (display) {
                case 'name':
                    newPath = '';
                    break;
                case 'abs':
                    newPath = path.dirname(filePath) + '/';
                    break;
                case 'rel':
                    /* falls through */
                default:
                    newPath = path.dirname(Utils.getRelativePath(filePath)) + '/';
                    break;
            }

            return newPath;
        }
    };

    module.exports = Utils;
}());
