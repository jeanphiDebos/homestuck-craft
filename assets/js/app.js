/*
 * not need look autoProvideVariables in webpack.config.js
 * const $ = require('jquery');
 */
require('bootstrap-sass');

// Routing.generate('...');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});