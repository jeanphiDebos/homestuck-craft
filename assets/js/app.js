/*
 * not need look autoProvideVariables in webpack.config.js
 * const $ = require('jquery');
 */
require('bootstrap-sass');

/*
$.get("demo_test.asp", function(data, status){
    alert("Data: " + data + "\nStatus: " + status);
});

$.post("demo_test_post.asp", {
    name: "Donald Duck",
    city: "Duckburg"
}, function(data, status){
    alert("Data: " + data + "\nStatus: " + status);
});
$.get('inc/user.json', function( data ) {
    $('#result').html( data.name + ' : ' +  data.email );
}, 'json');
*/

$(document).ready(function () {
    var homestuck = {
        selectorPrototypeItem: null,
        selectorInventoryPlayer: null,
        selectorCountInventory: null,
        itemImageDir: './uploads/images/items/',
        initApp: function (id, selectorPrototypeItem, selectorInventoryPlayer, selectorCountInventory) {
            this.selectorPrototypeItem = selectorPrototypeItem;
            this.selectorInventoryPlayer = selectorInventoryPlayer;
            this.selectorCountInventory = selectorCountInventory;
            this.user.id = id;
            this.user.setUser();
            this.inventory.setInventoryItems();
        },
        user: {
            apiUsersGetItem: './api/users/',
            id: null,
            lvl: 0,
            setUser: function () {
                $.get(this.apiUsersGetItem + homestuck.user.id, 'json').done(function(data) {
                    homestuck.user.lvl = data.lvl;
                }).fail(function(data) {
                    console.error("error: ajax apiUsersGetItem function setUser: " + data);
                })
            }
        },
        inventory: {
            apiInventoriesGetCollection: './api/inventories',
            inventoryItems: {},
            setInventoryItems: function () {
                $.get(this.apiInventoriesGetCollection, {'user.id': homestuck.user.id}, 'json').done(function(data) {
                    homestuck.inventory.inventoryItems = data;
                    $.each(data, function(index, value) {
                      homestuck.formatInput.addItemInInventory(homestuck.selectorInventoryPlayer, value.item);
                    });
                }).fail(function(data) {
                    console.error("error: ajax apiInventoriesGetCollection function setInventoryItems: " + data);
                })
            },
            addItemInventory: function (idItem) {
                // this.formatInput.addItemInInventory();
            },
            removeItemInventory: function (idItem) {

            }
        },
        craft: {
            resultsCraftingItem: {},
            currentSelectCraftingItem: null,
            listResultCraftingItem: function (idItemSourceOne, idItemSourceTwo, selectorSourceOne, selectorSourceTwo, selectorResultCaft) {
                // this.formatInput.refeshItemCraftSeleted(selectorSourceOne, itemSourceOne);
                // this.formatInput.refeshItemCraftSeleted(selectorSourceTwo, itemSourceTwo);
                this.formatInput.showCraftingItem(selectorResultCaft);
            },
            selectNextCraftingItem: function (selector) {
                // this.craft.currentSelectCraftingItem
                this.formatInput.showCraftingItem(selector);
            },
            selectBackCraftingItem: function (selector) {
                // this.craft.currentSelectCraftingItem
                this.formatInput.showCraftingItem(selector);
            },
            addItemInventoryByCraft: function () {
                this.inventory.addItemInventory(this.currentSelectCraftingItem);
                this.addVisibilityCraftItem();
            },
            addVisibilityCraftItem: function () {
                // this.craft.currentSelectCraftingItem
            }
        },
        item: {
            listItems: function () {

            },
            formatItem: function (array) {

            },
            isItem: function (item) {

            }
        },
        formatInput: {
            resetSelect: function (selector) {

            },
            listInventoryItemsForSelect: function (selector) {
                this.resetSelect(selector);
                // this.inventory.inventoryItems
            },
            listItemsForSelect: function (selector) {
                this.resetSelect(selector);
                this.item.listItems()
            },
            addItemInInventory: function (selector, item) {
                console.log(item);
                selector.append(this.initItemProto(item));
            },
            showCraftingItem: function (selector) {
                // this.craft.currentSelectCraftingItem
                // this.initItemProto(selector, craftingItem);
            },
            refeshItemCraftSeleted: function (selector, item) {
                // this.initItemProto(selector, item);
            },
            initItemProto: function (item) {
                var newItem = homestuck.selectorPrototypeItem.find('.inventory-player-item').clone();
                newItem.data('id-item', item.id);
                newItem.find('.inventory-player-item-id').empty().append(item.id);
                newItem.find('.inventory-player-item-name').empty().append(item.name);
                newItem.find('.inventory-player-item-image').attr('src', homestuck.itemImageDir + item.image);
                newItem.find('.inventory-player-item-remove').data('id-item', item.id);
                newItem.find('.inventory-player-item-description').attr('data-content', item.id).popover();

                return newItem;
            }
        }
    };

    var $selectInventoryRemoveItem = $('select#select-inventory-remove-item');
    var $selectInventoryAddItem = $('select#select-inventory-add-item');
    var $selectResultCraftingItem = $('#selected-result-crafting-item');
    var $inventoryItemSourceOne = $('#source-one');
    var $inventoryItemSourceTwo = $('#source-two');

    $('[data-toggle="popover"]').popover();

    homestuck.initApp(
        $('body').data('user-id'),
        $('#prototype-inventory-player-item'),
        $('.inventory-player-items'),
        $('#count-inventory-player-items')
    );

    $(document).on('change', 'select.select-listing-inventory-item', function () {
        homestuck.craft.listResultCraftingItem(
            $inventoryItemSourceOne.find('select.select-listing-inventory-item').val(),
            $inventoryItemSourceTwo.find('select.select-listing-inventory-item').val(),
            $inventoryItemSourceOne.find('.selected-inventory-item'),
            $inventoryItemSourceTwo.find('.selected-inventory-item'),
            $selectResultCraftingItem
        );
    }).on('click', '.inventory-player-item-remove', function () {
        homestuck.inventory.removeItemInventory($(this).data('id-item'));
    });

    $('#remove-item-inventory').on('shown', function () {
        homestuck.formatInput.listInventoryItemsForSelect($selectInventoryRemoveItem);
    }).find('button.submit').click(function () {
        homestuck.inventory.removeItemInventory($selectInventoryRemoveItem.val());
    });

    $('#add-item-inventory').on('shown', function () {
        homestuck.formatInput.listItemsForSelect($selectInventoryAddItem);
    }).find('button.submit').click(function () {
        homestuck.inventory.addItemInventory($selectInventoryAddItem.val());
    });

    $('#modal-action-add-item-inventory').click(function () {
        $(this).find('span').toggle();
        $('#modal-inventory-add-item, #modal-add-item').toggle();
    });

    $('#crafting-item').click(function () {
        homestuck.craft.addItemInventoryByCraft();
        // show modal result new crafting item ?
    });

    $('button.add-craft-item').click(function () {
        // init hidden input craft item create
    });

    $('.back-result-crafting-item').click(function () {
        homestuck.craft.selectBackCraftingItem($selectResultCraftingItem);
    });

    $('.next-result-crafting-item').click(function () {
        homestuck.craft.selectNextCraftingItem($selectResultCraftingItem);
    });
});