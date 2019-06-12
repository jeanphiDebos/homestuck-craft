/*
 * not need look autoProvideVariables in webpack.config.js
 * const $ = require('jquery');
 */
require('bootstrap-sass');

$.ajaxSetup({
  contentType: "application/json; charset=utf-8"
});

$(document).ready(function () {
  var homestuck = {
    selectorPrototypeItem: null,
    selectorPrototypeRowBook: null,
    selectorInventoryPlayer: null,
    selectorCountInventory: null,
    selectorPlayerResource: null,
    selectAddCrystalsPlayer: null,
    selectInventoryRemoveItem: null,
    selectInventoryAddItem: null,
    selectTransferInventoryItem: null,
    selectTransferToUser: null,
    resultCrafting: null,
    selectedResultCraftingItem: null,
    showCraftingItem: null,
    hiddenCraftingItem: null,
    havNotResultCrafting: null,
    havNotCrystal: null,
    selectInventoryItemSourceOne: null,
    selectInventoryItemSourceTwo: null,
    itemSourceOne: null,
    itemSourceTwo: null,
    itemImageDir: './uploads/images/items/',
    initApp: function (id, selectorPrototypeItem, selectorPrototypeRowBook, selectorInventoryPlayer, selectorCountInventory, selectorPlayerResource, selectAddCrystalsPlayer, selectInventoryRemoveItem, selectInventoryAddItem, selectTransferInventoryItem, selectTransferToUser, resultCrafting, selectedResultCraftingItem, showCraftingItem, hiddenCraftingItem, havNotResultCrafting, havNotCrystal, selectInventoryItemSourceOne, selectInventoryItemSourceTwo, itemSourceOne, itemSourceTwo) {
      this.selectorPrototypeItem = selectorPrototypeItem;
      this.selectorPrototypeRowBook = selectorPrototypeRowBook;
      this.selectorInventoryPlayer = selectorInventoryPlayer;
      this.selectorCountInventory = selectorCountInventory;
      this.selectorPlayerResource = selectorPlayerResource;
      this.selectAddCrystalsPlayer = selectAddCrystalsPlayer;
      this.selectInventoryRemoveItem = selectInventoryRemoveItem;
      this.selectInventoryAddItem = selectInventoryAddItem;
      this.selectTransferInventoryItem = selectTransferInventoryItem;
      this.selectTransferToUser = selectTransferToUser;
      this.resultCrafting = resultCrafting;
      this.selectedResultCraftingItem = selectedResultCraftingItem;
      this.showCraftingItem = showCraftingItem;
      this.hiddenCraftingItem = hiddenCraftingItem;
      this.havNotResultCrafting = havNotResultCrafting;
      this.havNotCrystal = havNotCrystal;
      this.selectInventoryItemSourceOne = selectInventoryItemSourceOne;
      this.selectInventoryItemSourceTwo = selectInventoryItemSourceTwo;
      this.itemSourceOne = itemSourceOne;
      this.itemSourceTwo = itemSourceTwo;
      this.user.id = id;
      this.user.setUser();
      this.inventory.setInventoryItems();
      this.user.setUsers();
    },
    user: {
      apiUsers: './api/users',
      apiUsersGetItem: './api/users/',
      apiCapacityGetItem: './api/capacities/',
      id: null,
      lvl: 0,
      resource: 0,
      capacity: 0,
      listUser: null,
      setUser: function () {
        $.get(this.apiUsersGetItem + homestuck.user.id, 'json').done(function (data) {
          homestuck.user.lvl = data.lvl;
          homestuck.user.resource = parseInt(data.resource);
          homestuck.user.setCapacity();
          homestuck.formatInput.playerResource();
        }).fail(function (data) {
          console.error("error: ajax apiUsersGetItem function setUser: " + data);
        });
      },
      setUsers: function () {
        $.get(this.apiUsers, 'json').done(function (data) {
          homestuck.user.listUser = data;
        }).fail(function (data) {
          console.error("error: ajax apiUsers function setUsers: " + data);
        })
      },
      setCapacity: function () {
        $.get(this.apiCapacityGetItem + homestuck.user.lvl, 'json').done(function (data) {
          homestuck.user.capacity = data.capacity;
          homestuck.formatInput.counter();
        }).fail(function (data) {
          console.error("error: ajax apiCapacityGetItem function setCapacity: " + data);
        })
      },
      transferItemInventory: function () {
        let idInventoryItem = homestuck.selectTransferInventoryItem.val();
        let isUser = homestuck.selectTransferToUser.val();
        let inventoryItem = homestuck.inventory.findItemInventory(idInventoryItem);
        if (inventoryItem) {
          homestuck.inventory.addItemInventory(inventoryItem.item.id, isUser);
          homestuck.inventory.removeItemInventory(idInventoryItem);
        }
      },
      setCrystalsPlayer: function (resource) {
        homestuck.user.resource += parseInt(resource);
        $.ajax({
          url: this.apiUsersGetItem + homestuck.user.id,
          type: 'PUT',
          data: '{"resource": ' + homestuck.user.resource + '}',
          dataType: 'json',
          success: function() {
            homestuck.formatInput.playerResource();
          },
          error : function(result){
            console.error("error: ajax PUT apiUsersGetItem function addCrystalsPlayer: " + result);
          }
        });
      }
    },
    inventory: {
      apiInventories: './api/inventories',
      inventoryItems: {},
      setInventoryItems: function () {
        $.get(this.apiInventories, {'user.id': homestuck.user.id}, 'json').done(function (data) {
          homestuck.inventory.inventoryItems = data;
          $.each(data, function (index, value) {
            homestuck.inventory.addItemInInventory(value.item, value.id);
          });
          homestuck.formatInput.listInventoryItemsForSelect(homestuck.selectInventoryItemSourceOne);
          homestuck.formatInput.listInventoryItemsForSelect(homestuck.selectInventoryItemSourceTwo);
          homestuck.formatInput.counter();
        }).fail(function (data) {
          console.error("error: ajax apiInventories function setInventoryItems: " + data);
        })
      },
      addItemInventory: function (idItem, isUser) {
        let transfer = true;

        if (isUser === null) {
          isUser = homestuck.user.id;
          transfer = false;
        }

        $.post(
          this.apiInventories,
          "{\"user\": \"/api/users/" + isUser + "\", \"item\": \"/api/items/" + idItem + "\"}", 'json'
        ).done(function (data) {
          if (transfer === false){
            homestuck.inventory.inventoryItems.push(data);
            homestuck.inventory.addItemInInventory(data.item, data.id);
            homestuck.selectInventoryItemSourceOne.append('<option value="' + data.id + '">' + data.item.name + '</option>');
            homestuck.selectInventoryItemSourceTwo.append('<option value="' + data.id + '">' + data.item.name + '</option>');
            homestuck.formatInput.counter();
          }
        }).fail(function (data) {
          console.error("error: ajax apiInventories function addItemInventory: " + data);
        });
      },
      removeItemInventory: function (idInventoryItem) {
        $.ajax({
          url: this.apiInventories + '/' + idInventoryItem,
          type: 'DELETE',
          success: function () {
            let idItemSourceOne = homestuck.selectInventoryItemSourceOne.val();
            let idItemSourceTwo = homestuck.selectInventoryItemSourceTwo.val();
            let itemInventory = homestuck.inventory.findItemInventory(idInventoryItem);

            homestuck.inventory.inventoryItems.splice(
              homestuck.inventory.findIndexItemInventory(idInventoryItem),
              1
            );
            $('.inventory-player-item[id-inventory-item="' + idInventoryItem + '"]').remove();
            homestuck.selectInventoryItemSourceOne.find('option[value="' + idInventoryItem + '"]').remove();
            homestuck.selectInventoryItemSourceTwo.find('option[value="' + idInventoryItem + '"]').remove();

            if (idItemSourceOne ===  idInventoryItem || idItemSourceTwo ===  idInventoryItem) {
              homestuck.craft.listResultCraftingItem();
            }

            homestuck.user.setCrystalsPlayer(itemInventory.item.cost);
            homestuck.formatInput.counter();
          },
          error: function (request, msg, error) {
            console.error("error: ajax apiInventories function removeItemInventory: " + request + ', ' + msg + ', ' + error);
          }
        });
      },
      addItemInInventory: function (item, idInventory) {
        homestuck.selectorInventoryPlayer.append(homestuck.item.initItemProto(item, idInventory));
      },
      findItemInventory: function (idInventoryItem) {
        let itemFind = homestuck.inventory.inventoryItems.filter(function (inventoryItem) {
          return parseInt(inventoryItem.id) === parseInt(idInventoryItem)
        });
        
        if (itemFind.length !== 0) {
          return itemFind[0];
        }

        return null;
      },
      findIndexItemInventory: function (idInventoryItem) {
        return homestuck.inventory.inventoryItems.findIndex(function (inventoryItem) {
          return parseInt(inventoryItem.id) === parseInt(idInventoryItem)
        });
      }
    },
    visibilityCraftItem: {
      apiVisibilityCraftItem: './api/visibility_craft_items',
      addVisibilityCraftItem: function (idCraftItem) {
        $.post(
          this.apiVisibilityCraftItem,
          "{\"user\": \"/api/users/" + homestuck.user.id + "\", \"craft\": \"/api/crafts/" + idCraftItem + "\"}", 'json'
        ).fail(function (data) {
          console.error("error: ajax apiInventories function addItemInventory: " + data);
        });
      },
      findVisibilityCraftItemByIdUser: function (visibilityCraftItems, idUser) {
        return visibilityCraftItems.filter(function (visibilityCraftItem) {
          return parseInt(visibilityCraftItem.user.id) === parseInt(idUser)
        });
      }
    },
    craft: {
      apiCrafts: './api/crafts',
      resultsCraftingItems: {itemResult: {cost: 0}, visibilityCraftItems: []},
      idItemSourceOne: null,
      idItemSourceTwo: null,
      currentSelectCraftingItem: 0,
      currentVisibilityCraftingItem: false,
      listResultCraftingItem: function () {
        let idItemSourceOne = homestuck.selectInventoryItemSourceOne.val();
        let idItemSourceTwo = homestuck.selectInventoryItemSourceTwo.val();

        homestuck.resultCrafting.addClass('hide');
        homestuck.showCraftingItem.addClass('hide');
        homestuck.hiddenCraftingItem.addClass('hide');
        homestuck.havNotResultCrafting.addClass('hide');
        homestuck.havNotCrystal.addClass('hide');
        homestuck.showCraftingItem.empty();

        if (idItemSourceOne) {
          homestuck.selectInventoryItemSourceTwo.find('option[value="' + idItemSourceOne + '"]').prop('disabled', true);
          homestuck.itemSourceOne.empty().append(homestuck.item.initItemProto(
            homestuck.inventory.findItemInventory(idItemSourceOne).item,
            idItemSourceOne
          )).removeClass('hide');
        }else{
          homestuck.itemSourceOne.empty().addClass('hide');
        }

        if (idItemSourceTwo) {
          homestuck.selectInventoryItemSourceOne.find('option[value="' + idItemSourceTwo + '"]').prop('disabled', true);
          homestuck.itemSourceTwo.empty().append(homestuck.item.initItemProto(
            homestuck.inventory.findItemInventory(idItemSourceTwo).item,
            idItemSourceTwo
          )).removeClass('hide');
        }else{
          homestuck.itemSourceTwo.empty().addClass('hide');
        }

        if (homestuck.craft.idItemSourceOne && homestuck.craft.idItemSourceOne !== idItemSourceOne) {
          homestuck.selectInventoryItemSourceTwo
              .find('option[value="' + homestuck.craft.idItemSourceOne + '"]')
              .prop('disabled', false);
        }
        if (homestuck.craft.idItemSourceTwo && homestuck.craft.idItemSourceTwo !== idItemSourceTwo) {
          homestuck.selectInventoryItemSourceOne
              .find('option[value="' + homestuck.craft.idItemSourceTwo + '"]')
              .prop('disabled', false);
        }

        homestuck.craft.idItemSourceOne = idItemSourceOne;
        homestuck.craft.idItemSourceTwo = idItemSourceTwo;
        homestuck.craft.currentSelectCraftingItem = 0;
      },
      initCraftingItems: function (isOr) {
        let idItemSourceOne = homestuck.selectInventoryItemSourceOne.val();
        let idItemSourceTwo = homestuck.selectInventoryItemSourceTwo.val();

        homestuck.craft.currentSelectCraftingItem = 0;
        homestuck.resultCrafting.addClass('hide');
        homestuck.showCraftingItem.addClass('hide');
        homestuck.hiddenCraftingItem.addClass('hide');
        homestuck.havNotResultCrafting.addClass('hide');
        homestuck.havNotCrystal.addClass('hide');
        homestuck.showCraftingItem.empty();

        if (idItemSourceOne && idItemSourceTwo) {
          $.get(this.apiCrafts, {
            'itemSourceOne.id': homestuck.inventory.findItemInventory(idItemSourceOne).item.id,
            'itemSourceTwo.id': homestuck.inventory.findItemInventory(idItemSourceTwo).item.id,
            'operation': isOr ? 'OR' : 'AND'
          }, 'json').done(function (data) {
            homestuck.craft.resultsCraftingItems = data;

            if (homestuck.craft.resultsCraftingItems.length !== 0) {
              homestuck.resultCrafting.removeClass('hide');
              homestuck.craft.showCraftingItem(0);
            }else{
              homestuck.havNotResultCrafting.removeClass('hide');
            }
          }).fail(function (data) {
            console.error("error: ajax apiCrafts function showCraftingItem: " + data);
          })
        }
      },
      craftItem: function () {
        let idCraftItem = homestuck.selectedResultCraftingItem.attr('data-id-craft-item');
        let resourceCraftItem = parseInt(homestuck.selectedResultCraftingItem.attr('data-resource-craft-item'));
        let idItemSourceOne = homestuck.selectInventoryItemSourceOne.val();
        let idItemSourceTwo = homestuck.selectInventoryItemSourceTwo.val();

        if (homestuck.user.resource >= resourceCraftItem) {
          homestuck.inventory.addItemInventory(homestuck.selectedResultCraftingItem.attr('data-id-item'), null);
          homestuck.inventory.removeItemInventory(idItemSourceOne);
          homestuck.inventory.removeItemInventory(idItemSourceTwo);
          homestuck.user.setCrystalsPlayer(-resourceCraftItem);

          if (!homestuck.craft.currentVisibilityCraftingItem) {
            homestuck.visibilityCraftItem.addVisibilityCraftItem(idCraftItem);
          }

          homestuck.craft.currentSelectCraftingItem = 0;
          homestuck.craft.idItemSourceOne = null;
          homestuck.craft.idItemSourceTwo = null;
          homestuck.resultCrafting.addClass('hide');
          homestuck.showCraftingItem.addClass('hide');
          homestuck.hiddenCraftingItem.addClass('hide');
          homestuck.havNotResultCrafting.addClass('hide');
          homestuck.havNotCrystal.addClass('hide');
        }else{
          homestuck.havNotCrystal.removeClass('hide');
        }
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
      showCraftingItem: function (index) {
        if (homestuck.craft.resultsCraftingItems[index]) {
          homestuck.havNotCrystal.addClass('hide');
          homestuck.selectedResultCraftingItem
            .attr('data-id-craft-item', homestuck.craft.resultsCraftingItems[index].id)
            .attr('data-resource-craft-item', homestuck.craft.resultsCraftingItems[index].itemResult.cost)
            .attr('data-id-item', homestuck.craft.resultsCraftingItems[index].itemResult.id);
          if (homestuck.craft.resultsCraftingItems[index].visibilityCraftItems.filter(function (visibilityCraftItem) {
            return parseInt(visibilityCraftItem.user.id) === parseInt(homestuck.user.id)
          }).length === 0) {
            homestuck.hiddenCraftingItem.removeClass('hide');
            homestuck.showCraftingItem.addClass('hide');
            homestuck.craft.currentVisibilityCraftingItem = false;
          } else {
            homestuck.hiddenCraftingItem.addClass('hide');
            homestuck.showCraftingItem.empty().append(homestuck.item.initItemProto(
              homestuck.craft.resultsCraftingItems[index].itemResult,
              ''
            )).removeClass('hide');
            homestuck.craft.currentVisibilityCraftingItem = true;
          }
        }
      },
      initBook: function (selector) {
        $.get(this.apiCrafts, 'json').done(function (data) {
          $.each(data, function (index, value) {
            let itemCraftOne = '??????';
            let itemCraftTwo = '??????';
            let itemCraftResult = '??????';
            let itemCraftOperation = '+';
            let newCraftItem = homestuck.selectorPrototypeRowBook.clone();

            if (value.operation === 'AND') {
              itemCraftOperation = 'x';
            }

            if (value.visibilityCraftItems.length > 0 &&
              homestuck.visibilityCraftItem.findVisibilityCraftItemByIdUser(value.visibilityCraftItems, homestuck.user.id).length > 0
            ) {
              itemCraftOne = homestuck.item.initItemProto(value.itemSourceOne, null);
              itemCraftTwo = homestuck.item.initItemProto(value.itemSourceTwo, null);
              itemCraftResult = homestuck.item.initItemProto(value.itemResult, null);
            }

            newCraftItem.find('.item-craft-operation').empty().append(itemCraftOperation);
            newCraftItem.find('.item-craft-one').empty().append(itemCraftOne);
            newCraftItem.find('.item-craft-two').empty().append(itemCraftTwo);
            newCraftItem.find('.item-craft-result').empty().append(itemCraftResult);
            newCraftItem.find('.item-craft-number').empty().append('N°' + (index + 1) + ' : ');

            newCraftItem.removeClass('hide');
            newCraftItem.removeAttr('id');

            selector.append(newCraftItem);
          });
        }).fail(function (data) {
          console.error("error: ajax apiCrafts function initBook: " + data);
        })
      }
    },
    item: {
      apiItemsGetCollection: './api/items',
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
      initItemProto: function (item, idInventory) {
        let listTypeItem = [];
        let newItem = homestuck.selectorPrototypeItem.find('.inventory-player-item').clone();

        /** @namespace item.typeItems */
        /** @namespace typeItem.categoryItem */
        $.each(item.typeItems, function (index, typeItem) {
          if (!listTypeItem[typeItem.categoryItem.name]){
            listTypeItem[typeItem.categoryItem.name] = [];
          }
          listTypeItem[typeItem.categoryItem.name].push(typeItem.name);
        });

        let description = item.description + '<br />Coût: ' + item.cost;
        if (listTypeItem.length > 0) {
          description += '<br />';
          for (let categoryItemName in listTypeItem) {
            description += '<br />' + categoryItemName + ': ';
            for (let index in listTypeItem[categoryItemName]) {
              description += '<br /> - ' + listTypeItem[categoryItemName][index];
            }
          }
        }

        newItem.attr('id-inventory-item', idInventory);
        newItem.find('.inventory-player-item-id').empty().append(item.id);
        newItem.find('.inventory-player-item-name').empty().append(item.name);
        newItem.find('.inventory-player-item-image').attr('src', homestuck.itemImageDir + item.image);
        newItem.find('.inventory-player-item-remove').attr('id-inventory-item', idInventory);
        newItem.find('.inventory-player-item-description').attr('data-content', description).popover();

        return newItem;
      },
    },
    formatInput: {
      resetSelect: function (selector) {
        selector.empty().addClass('hide');
      },
      listInventoryItemsForSelect: function (selector) {
        $.each(homestuck.inventory.inventoryItems, function (index, value) {
          selector.append('<option value="' + value.id + '">' + value.item.name + '</option>')
        });
        selector.removeClass('hide');
      },
      listUserForSelect: function (selector) {
        $.each(homestuck.user.listUser, function (index, value) {
          if (parseInt(value.id) !== parseInt(homestuck.user.id)) {
            selector.append('<option value="' + value.id + '">' + value.username + '</option>');
          }
        });
        selector.removeClass('hide');
      },
      counter: function () {
        homestuck.selectorCountInventory.empty().append(homestuck.inventory.inventoryItems.length + '/' + homestuck.user.capacity);
      },
      playerResource: function () {
        homestuck.selectorPlayerResource.empty().append(homestuck.user.resource);
      }
    }
  };

  $('[data-toggle="popover"]').popover();

  homestuck.initApp(
    $('body').data('user-id'),
    $('#prototype-inventory-player-item'),
    $('#prototype-row-book'),
    $('.inventory-player-items'),
    $('.count-inventory-player-items'),
    $('.player-resource'),
    $('#input-player-add-crystals'),
    $('select#select-inventory-remove-item'),
    $('select#select-inventory-add-item'),
    $('select#select-transfer-inventory-item'),
    $('select#select-transfer-user'),
    $('#result-crafting'),
    $('#selected-result-crafting-item'),
    $('#show-crafting-item'),
    $('#hidden-crafting-item'),
    $('#hav-not-result-crafting'),
    $('#hav-not-crystal'),
    $('#source-one select.select-listing-inventory-item'),
    $('#source-two select.select-listing-inventory-item'),
    $('#selected-inventory-item-source-one'),
    $('#selected-inventory-item-source-two')
  );

  //@todo ajout d'un bouton sur les carte pour créer l'objet (consomme seulement les cristaux)

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
    homestuck.item.listItemsForSelect(homestuck.selectInventoryAddItem);
  }).on('hidden.bs.modal', function () {
    homestuck.formatInput.resetSelect(homestuck.selectInventoryAddItem);
  }).find('.submit').click(function () {
    homestuck.inventory.addItemInventory(homestuck.selectInventoryAddItem.val(), null);
  });

  $('#add-crystals-player').on('shown.bs.modal', function () {
    homestuck.selectAddCrystalsPlayer.val(1);
  }).find('.submit').click(function () {
    homestuck.user.setCrystalsPlayer(homestuck.selectAddCrystalsPlayer.val());
  });

  $('#player-book').on('shown.bs.modal', function () {
    homestuck.craft.initBook($(this).find('.modal-body'));
  }).on('hidden.bs.modal', function () {
    $(this).find('.modal-body').empty();
  });

  $('#player-transfer').on('shown.bs.modal', function () {
    homestuck.formatInput.listInventoryItemsForSelect(homestuck.selectTransferInventoryItem);
    homestuck.formatInput.listUserForSelect(homestuck.selectTransferToUser);
  }).on('hidden.bs.modal', function () {
    homestuck.formatInput.resetSelect(homestuck.selectTransferInventoryItem);
    homestuck.formatInput.resetSelect(homestuck.selectTransferToUser);
  }).find('.submit').click(function () {
    homestuck.user.transferItemInventory();
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
    homestuck.craft.craftItem();
  });

  $('button.add-craft-item').click(function () {

  });

  $('.back-result-crafting-item').click(function () {
    homestuck.craft.selectBackCraftingItem();
  });

  $('.next-result-crafting-item').click(function () {
    homestuck.craft.selectNextCraftingItem();
  });
});