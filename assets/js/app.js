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
    selectInventoryRemoveItem: null,
    selectInventoryAddItem: null,
    resultCrafting: null,
    selectedResultCraftingItem: null,
    showCraftingItem: null,
    hiddenCraftingItem: null,
    selectInventoryItemSourceOne: null,
    selectInventoryItemSourceTwo: null,
    itemSourceOne: null,
    itemSourceTwo: null,
    itemImageDir: './uploads/images/items/',
    initApp: function (id, selectorPrototypeItem, selectorInventoryPlayer, selectorCountInventory, selectInventoryRemoveItem, selectInventoryAddItem, resultCrafting, selectedResultCraftingItem, showCraftingItem, hiddenCraftingItem, selectInventoryItemSourceOne, selectInventoryItemSourceTwo, itemSourceOne, itemSourceTwo) {
      this.selectorPrototypeItem = selectorPrototypeItem;
      this.selectorInventoryPlayer = selectorInventoryPlayer;
      this.selectorCountInventory = selectorCountInventory;
      this.selectInventoryRemoveItem = selectInventoryRemoveItem;
      this.selectInventoryAddItem = selectInventoryAddItem;
      this.resultCrafting = resultCrafting;
      this.selectedResultCraftingItem = selectedResultCraftingItem;
      this.showCraftingItem = showCraftingItem;
      this.hiddenCraftingItem = hiddenCraftingItem;
      this.selectInventoryItemSourceOne = selectInventoryItemSourceOne;
      this.selectInventoryItemSourceTwo = selectInventoryItemSourceTwo;
      this.itemSourceOne = itemSourceOne;
      this.itemSourceTwo = itemSourceTwo;
      this.user.id = id;
      this.user.setUser();
      this.inventory.setInventoryItems();
    },
    user: {
      apiUsersGetItem: './api/users/',
      apiCapacityGetItem: './api/capacities/',
      id: null,
      lvl: 0,
      capacity: 0,
      setUser: function () {
        $.get(this.apiUsersGetItem + homestuck.user.id, 'json').done(function (data) {
          homestuck.user.lvl = data.lvl;
          homestuck.user.setCapacity();
        }).fail(function (data) {
          console.error("error: ajax apiUsersGetItem function setUser: " + data);
        })
      },
      setCapacity: function () {
        $.get(this.apiCapacityGetItem + homestuck.user.lvl, 'json').done(function (data) {
          homestuck.user.capacity = data.capacity;
          homestuck.formatInput.counter();
        }).fail(function (data) {
          console.error("error: ajax apiCapacityGetItem function setCapacity: " + data);
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
          homestuck.formatInput.listInventoryItemsForSelect(homestuck.selectInventoryItemSourceOne);
          homestuck.formatInput.listInventoryItemsForSelect(homestuck.selectInventoryItemSourceTwo);
          homestuck.formatInput.counter();
        }).fail(function (data) {
          console.error("error: ajax apiInventories function setInventoryItems: " + data);
        })
      },
      addItemInventory: function (idItem) {
        // homestuck.formatInput.counter();
      },
      removeItemInventory: function (idInventoryItem) {
        $.ajax({
          url: this.apiInventories + '/' + idInventoryItem,
          type: 'DELETE',
          success: function () {
            homestuck.inventory.inventoryItems.splice(
              homestuck.inventory.findItemInventory(idInventoryItem),
              1
            );
            $('.inventory-player-item[id-inventory-item="' + idInventoryItem + '"]').remove();
            homestuck.selectInventoryItemSourceOne.find('option[value="' + idInventoryItem + '"]').remove();
            homestuck.selectInventoryItemSourceTwo.find('option[value="' + idInventoryItem + '"]').remove();
            homestuck.formatInput.counter();
          },
          error: function (request, msg, error) {
            console.error("error: ajax apiInventories function removeItemInventory: " + request + ', ' + msg + ', ' + error);
          }
        });
      },
      findItemInventory: function (idInventoryItem) {
        return homestuck.inventory.inventoryItems.filter(function (inventoryItem) {
          return parseInt(inventoryItem.id) === parseInt(idInventoryItem)
        });
      }
    },
    craft: {
      apiCrafts: './api/crafts',
      resultsCraftingItems: {itemResult: {}, visibilityCraftItems: []},
      currentSelectCraftingItem: 0,
      listResultCraftingItem: function () {
        let idItemSourceOne = homestuck.selectInventoryItemSourceOne.val();
        let idItemSourceTwo = homestuck.selectInventoryItemSourceTwo.val();

        homestuck.itemSourceOne.empty().append(homestuck.formatInput.initItemProto(
          homestuck.inventory.findItemInventory(idItemSourceOne)[0].item,
          idItemSourceOne
        )).removeClass('hide');
        homestuck.itemSourceTwo.empty().append(homestuck.formatInput.initItemProto(
          homestuck.inventory.findItemInventory(idItemSourceTwo)[0].item,
          idItemSourceTwo
        )).removeClass('hide');

        homestuck.craft.currentSelectCraftingItem = 0;

        homestuck.resultCrafting.addClass('hide');
        homestuck.showCraftingItem.addClass('hide');
        homestuck.hiddenCraftingItem.addClass('hide');
      },
      initCraftingItems: function (isOr) {
        $.get(this.apiCrafts, {
          'itemSourceOne.id': homestuck.inventory.findItemInventory(homestuck.selectInventoryItemSourceOne.val())[0].item.id,
          'itemSourceTwo.id': homestuck.inventory.findItemInventory(homestuck.selectInventoryItemSourceTwo.val())[0].item.id,
          'operation': isOr ? 'OR' : 'AND'
        }, 'json').done(function (data) {
          homestuck.craft.currentSelectCraftingItem = 0;
          homestuck.craft.resultsCraftingItems = data;

          homestuck.resultCrafting.removeClass('hide');

          if (homestuck.craft.resultsCraftingItems.length !== 0) {
            homestuck.craft.showCraftingItem(0);
          }
        }).fail(function (data) {
          console.error("error: ajax apiCrafts function showCraftingItem: " + data);
        })
      },
      craftItem: function() {
        // homestuck.selectedResultCraftingItem.attr('data-id-craft-item')
        // remove source item
        homestuck.inventory.addItemInventory(homestuck.selectedResultCraftingItem.attr('data-id-item'));
        // desable option & crafting
      },
      selectNextCraftingItem: function () {
        homestuck.craft.currentSelectCraftingItem++;
        if (homestuck.craft.currentSelectCraftingItem >= homestuck.craft.resultsCraftingItems.length) {
          homestuck.craft.currentSelectCraftingItem = 0;
        }
        homestuck.craft.showCraftingItem(homestuck.craft.currentSelectCraftingItem);
      },
      selectBackCraftingItem: function () {
        homestuck.craft.currentSelectCraftingItem--;
        if (homestuck.craft.currentSelectCraftingItem < 0) {
          homestuck.craft.currentSelectCraftingItem = homestuck.craft.resultsCraftingItems.length - 1;
        }
        homestuck.craft.showCraftingItem(homestuck.craft.currentSelectCraftingItem);
      },
      addItemInventoryByCraft: function () {
        this.inventory.addItemInventory(this.currentSelectCraftingItem);
        this.addVisibilityCraftItem();
      },
      addVisibilityCraftItem: function () {
        // this.craft.currentSelectCraftingItem
      },
      showCraftingItem: function (index) {
        if (homestuck.craft.resultsCraftingItems[index]) {
          homestuck.selectedResultCraftingItem
            .attr('data-id-craft-item', homestuck.craft.resultsCraftingItems[index].id)
            .attr('data-id-item', homestuck.craft.resultsCraftingItems[index].itemResult.id);
          if (homestuck.craft.resultsCraftingItems[index].visibilityCraftItems.filter(function (visibilityCraftItem) {
            return parseInt(visibilityCraftItem.user.id) === parseInt(homestuck.user.id)
          }).length === 0) {
            homestuck.hiddenCraftingItem.removeClass('hide');
            homestuck.showCraftingItem.addClass('hide');
          } else {
            homestuck.hiddenCraftingItem.addClass('hide');
            homestuck.showCraftingItem.empty().append(homestuck.formatInput.initItemProto(
              homestuck.craft.resultsCraftingItems[index].itemResult,
              ''
            )).removeClass('hide');
          }
        }
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
        selector.empty().addClass('hide');
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
      initItemProto: function (item, idInventory) {
        let newItem = homestuck.selectorPrototypeItem.find('.inventory-player-item').clone();
        newItem.attr('id-inventory-item', idInventory);
        newItem.find('.inventory-player-item-id').empty().append(item.id);
        newItem.find('.inventory-player-item-name').empty().append(item.name);
        newItem.find('.inventory-player-item-image').attr('src', homestuck.itemImageDir + item.image);
        newItem.find('.inventory-player-item-remove').attr('id-inventory-item', idInventory);
        newItem.find('.inventory-player-item-description').attr('data-content', item.id).popover();

        return newItem;
      },
      counter: function () {
        homestuck.selectorCountInventory.empty().append(homestuck.inventory.inventoryItems.length + '/' + homestuck.user.capacity);
      }
    }
  };

  $('[data-toggle="popover"]').popover();

  homestuck.initApp(
    $('body').data('user-id'),
    $('#prototype-inventory-player-item'),
    $('.inventory-player-items'),
    $('#count-inventory-player-items'),
    $('select#select-inventory-remove-item'),
    $('select#select-inventory-add-item'),
    $('#result-crafting'),
    $('#selected-result-crafting-item'),
    $('#show-crafting-item'),
    $('#hidden-crafting-item'),
    $('#source-one select.select-listing-inventory-item'),
    $('#source-two select.select-listing-inventory-item'),
    $('#selected-inventory-item-source-one'),
    $('#selected-inventory-item-source-two')
  );

  $(document).on('change', 'select.select-listing-inventory-item', function () {
    homestuck.craft.listResultCraftingItem();
  }).on('click', '.inventory-player-item-remove', function () {
    homestuck.inventory.removeItemInventory($(this).attr('id-inventory-item'));
  });

  $('#remove-item-inventory').on('shown.bs.modal', function () {
    homestuck.formatInput.listInventoryItemsForSelect(homestuck.selectInventoryRemoveItem);
  }).on('hidden.bs.modal', function () {
    homestuck.formatInput.resetSelect(homestuck.selectInventoryRemoveItem);
  }).find('.submit').click(function () {
    homestuck.inventory.removeItemInventory(homestuck.selectInventoryRemoveItem.val());
  });

  $('#add-item-inventory').on('shown.bs.modal', function () {
    homestuck.formatInput.listItemsForSelect(homestuck.selectInventoryAddItem);
  }).on('hidden.bs.modal', function () {
    homestuck.formatInput.resetSelect(homestuck.selectInventoryAddItem);
  }).find('.submit').click(function () {
    homestuck.inventory.addItemInventory(homestuck.selectInventoryAddItem.val());
  });

  $('#modal-action-add-item-inventory').click(function () {
    $(this).find('span').toggle();
    $('#modal-inventory-add-item, #modal-add-item').toggle();
  });

  $('#crafting-item-or').click(function () {
    homestuck.craft.initCraftingItems(true);
  });

  $('#crafting-item-and').click(function () {
    homestuck.craft.initCraftingItems(false);
  });

  $('#crafting-item').click(function () {
    homestuck.craft.addItemInventoryByCraft();
    // show modal result new crafting item ?
  });

  $('button.add-craft-item').click(function () {
    // init hidden input craft item create
  });

  $('.back-result-crafting-item').click(function () {
    homestuck.inventory.craftItem();
  });

  $('.next-result-crafting-item').click(function () {
    homestuck.craft.selectNextCraftingItem();
  });
});