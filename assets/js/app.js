/*
 * not need look autoProvideVariables in webpack.config.js
 * const $ = require('jquery');
 */
require('bootstrap-sass');

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
        $.get(this.apiUsersGetItem + homestuck.user.id, 'json').done(function (data) {
          homestuck.user.lvl = data.lvl;
        }).fail(function (data) {
          console.error("error: ajax apiUsersGetItem function setUser: " + data);
        })
      }
    },
    inventory: {
      apiInventories: './api/inventories',
      inventoryItems: {},
      setInventoryItems: function () {
        $.get(this.apiInventories, {'user.id': homestuck.user.id}, 'json').done(function (data) {
          homestuck.inventory.inventoryItems = data;
          $.each(data, function (index, value) {
            homestuck.formatInput.addItemInInventory(homestuck.selectorInventoryPlayer, value.item, value.id);
          });
        }).fail(function (data) {
          console.error("error: ajax apiInventories function setInventoryItems: " + data);
        })
      },
      addItemInventory: function (idItem) {

      },
      removeItemInventory: function (idInventoryItem) {
        $.ajax({
          url: this.apiInventories + '/' + idInventoryItem,
          type: 'DELETE',
          success: function () {
            $('.inventory-player-item[id-inventory-item="' + idInventoryItem + '"]').remove();
          },
          error: function (request, msg, error) {
            console.error("error: ajax apiInventories function removeItemInventory: " + request + ', ' + msg + ', ' + error);
          }
        });
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
      Items: {},
      listItems: function () {

      },
      formatItem: function (array) {

      },
      isItem: function (item) {

      }
    },
    formatInput: {
      apiItemsGetCollection: './api/items',
      resetSelect: function (selector) {
        selector.addClass('hide').empty();
      },
      listInventoryItemsForSelect: function (selector) {
        $.each(homestuck.inventory.inventoryItems, function (index, value) {
          selector.append('<option value="' + value.id + '">' + value.item.name + '</option>')
        });
        selector.removeClass('hide');
      },
      listItemsForSelect: function (selector) {
        $.get(this.apiItemsGetCollection, {'isVisible': true, 'isValid': true}, 'json').done(function (data) {
          homestuck.item.Items = data;
          $.each(data, function (index, item) {
            selector.append('<option value="' + item.id + '">' + item.name + '</option>')
          });
          selector.removeClass('hide');
        }).fail(function (data) {
          console.error("error: ajax apiItemsGetCollection function listItemsForSelect: " + data);
        })
      },
      addItemInInventory: function (selector, item, idInventory) {
        selector.append(this.initItemProto(item, idInventory));
      },
      showCraftingItem: function (selector) {
        // this.craft.currentSelectCraftingItem
        // this.initItemProto(selector, craftingItem);
      },
      refeshItemCraftSeleted: function (selector, item) {
        // this.initItemProto(selector, item);
      },
      initItemProto: function (item, idInventory) {
        var newItem = homestuck.selectorPrototypeItem.find('.inventory-player-item').clone();
        newItem.attr('id-inventory-item', idInventory);
        newItem.find('.inventory-player-item-id').empty().append(item.id);
        newItem.find('.inventory-player-item-name').empty().append(item.name);
        newItem.find('.inventory-player-item-image').attr('src', homestuck.itemImageDir + item.image);
        newItem.find('.inventory-player-item-remove').attr('id-inventory-item', idInventory);
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
    homestuck.inventory.removeItemInventory($(this).attr('id-inventory-item'));
  });

  $('#remove-item-inventory').on('shown.bs.modal', function () {
    homestuck.formatInput.listInventoryItemsForSelect($selectInventoryRemoveItem);
  }).on('hidden.bs.modal', function () {
    homestuck.formatInput.resetSelect($selectInventoryAddItem);
  }).find('.submit').click(function () {
    homestuck.inventory.removeItemInventory($selectInventoryRemoveItem.val());
  });

  $('#add-item-inventory').on('shown.bs.modal', function () {
    homestuck.formatInput.listItemsForSelect($selectInventoryAddItem);
  }).on('hidden.bs.modal', function () {
    homestuck.formatInput.resetSelect($selectInventoryAddItem);
  }).find('.submit').click(function () {
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