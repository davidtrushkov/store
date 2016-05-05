'use strict';

/**
 * Module dependencies
 */

var endsWith = require('ends-with');
var normalize = require('normalize-path');

/**
 * Return true if `filepath` ends with the given `string`
 *
 * @param  {String} `filepath`
 * @param  {String} `string`
 * @return {Boolean}
 */

module.exports = function(fp, str) {
  return endsWith(normalize(fp, false), normalize(str, false));
};
