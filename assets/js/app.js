/*
 * not need look autoProvideVariables in webpack.config.js
 * const $ = require('jquery');
 */
require('bootstrap-sass');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});