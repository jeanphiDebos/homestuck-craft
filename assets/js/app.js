/*
 * not need look autoProvideVariables in webpack.config.js
 * const $ = require('jquery');
 */
require('bootstrap-sass');

// Routing.generate('...');
var objet = {
    inventoryItems: [],
    listingResultCraftingItem: [],
    thisfunction: function () {
        var test = this.thisvar;

        test += 'test';

        return test;
    }
};
$(document).ready(function() {
    $('[data-toggle="popover"]').popover();

    console.log(objet.thisfunction());
});