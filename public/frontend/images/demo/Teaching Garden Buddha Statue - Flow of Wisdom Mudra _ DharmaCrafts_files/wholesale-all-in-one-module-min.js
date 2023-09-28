if(typeof window.WSAIO==='undefined'){window.WSAIO={};}if(typeof WSAIO.App==='undefined'){WSAIO.App={};}


  // ----------------------     Start order limit code --------------------------------
var $jscomp=$jscomp||{};$jscomp.scope={};$jscomp.arrayIteratorImpl=function(a){var b=0;return function(){return b<a.length?{done:!1,value:a[b++]}:{done:!0}}};$jscomp.arrayIterator=function(a){return{next:$jscomp.arrayIteratorImpl(a)}};$jscomp.makeIterator=function(a){var b="undefined"!=typeof Symbol&&Symbol.iterator&&a[Symbol.iterator];return b?b.call(a):$jscomp.arrayIterator(a)};
function log(a,b,c){if(WSAIO.debug)if("undefined"!==typeof c)switch(c){case "warning":console.warn(a,b);break;case "error":console.error(a,b);break;case "info":console.info(a,b);break;default:console.log(a,b)}else console.log(a,b)};
function mF(a){if(isNaN(a)||null==a)return 0;a=a.toString();if("string"==typeof a&&-1<a.indexOf("."))return 2>a.split(".")[1].length?Number(a).toFixed(2).toString():a.toString();a=(Number(a)/100).toFixed(2);return a.toString()};
window.WSAIO_MODULEJS=function($){
var alert_msg = '';WSAIO.ol_message = '';	
WSAIO.wsaioUpSell_msg = '';	
WSAIO.disable_checkout_define = function(a, b, d) {
            d = d || WSAIO.checkout_selector;
                if(a || WSAIO.disable_checkout){ 
                  if(0 < $(".waio-orderControl-message").length){ 
                  } else{
                    WSAIO.default_limit = true;
                  }
                }else{
                  WSAIO.default_limit = false;
                } 
} 
function convert_subtotal_weight(weight,unit) {
    // Convert weight to shop weight since we have weight in grams from shopify
                 var cart_total_weight = 0;
                  if(typeof unit !== "undefined" && unit){
                    switch (unit) {
                        case "lb": // approximate (Unit system => Imperial)
                            cart_total_weight = Number((weight / 453.592).toFixed(3));
                            break;
                  
                        case "kg": // Exact (Unit system => Metric)
                            cart_total_weight = weight / 1000;
                            break;
                  
                        case "oz": // approximate (Unit system => Imperial)
                            cart_total_weight = Number((weight / 28.3495).toFixed(3));
                            break;
                  
                        default:
                            cart_total_weight = weight;
                            break;
                    }
                  }
                 return cart_total_weight;
}
function getMsg_define(scope,relation,value,allow) {
   if(!allow){
      if(relation == "equal" || relation == "not_equal"){
         if(jQuery.isEmptyObject(WSAIO.ol_message)){
             WSAIO.ol_message = scope+' must be '+relation+' to '+value;
          } else{ 
             WSAIO.ol_message = WSAIO.ol_message+' AND '+scope+' must be '+relation+' to '+value;
          }
      }else{
          if(jQuery.isEmptyObject(WSAIO.ol_message)){
             WSAIO.ol_message = scope+' must be '+relation+' '+value;
          } else{
             WSAIO.ol_message = WSAIO.ol_message+' AND '+scope+' must be '+relation+' '+value;
          }
      }
    }
    return WSAIO.ol_message;
}
WSAIO.minOrderControl_define = function() {
   for (var a = [], b = 0; b < waioMOC.rules.length; b++) {
                  var d = waioMOC.rules[b];
                  "active" === d.status && mocIsValidCustomer(d) && a.push(d);
                }
                if (0 < a.length) {
                  b = {};
                  if (1 === a.length) b = a[0];
                  else {
                    d = a.findIndex(function (a) {
                      return "tag_based" === a.customer_group;
                    });
                    var c = a.findIndex(function (a) {
                      return "logged_in" === a.customer_group;
                    }),
                        e = a.findIndex(function (a) {
                          return "all" === a.customer_group;
                        });
                    -1 < d ? (b = a[d]) : -1 < c ? (b = a[c]) : -1 < e && (b = a[e]);
                  }
                  log(b);
                 var opening_rule_applied = false;
                  if("undefined" !== typeof b.rules && "undefined" !== typeof b.condition_scope &&
                     "undefined" !== typeof b.opening_rules && "undefined" !== typeof customer_order_info &&
                     (b.condition_scope == 'separate' || b.condition_scope == 'opening_only') && 
                     customer != '' && parseInt(customer_order_info) == 0){
                    opening_rule_applied = true;
                   
                  }
                if("undefined" !== typeof b.condition_scope && b.condition_scope == 'opening_only') b.rules = [];
                 if(opening_rule_applied){
                      b.rules = b.opening_rules;
                  }
                  if ("undefined" !== typeof b.rules) {
                    a = [];WSAIO.ol_message = '';
                    d = $jscomp.makeIterator(b.rules);
                    for (c = d.next(); !c.done; c = d.next()){
                    switch (((c = c.value), c.column)) {
                      case "cart_original_total_price":
                        switch (c.relation) {
                          case "equal":
                            Number(c.condition) == mF(Number(waioMOC.cart.original_total_price)) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('subtotal',c.relation,Number(c.condition),Number(c.condition) == mF(Number(waioMOC.cart.original_total_price)));
                            break;
                          case "not_equal":
                            Number(c.condition) != mF(Number(waioMOC.cart.original_total_price)) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('subtotal',c.relation,Number(c.condition),Number(c.condition) != mF(Number(waioMOC.cart.original_total_price)));
                            break;
                          case "greater_than":
                            Number(c.condition) < mF(Number(waioMOC.cart.original_total_price)) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Subtotal',c.relation,Number(c.condition),Number(c.condition) < mF(Number(waioMOC.cart.original_total_price)));
                            break;
                          case "less_than":
                            Number(c.condition) > mF(Number(waioMOC.cart.original_total_price)) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Subtotal',c.relation,Number(c.condition),Number(c.condition) > mF(Number(waioMOC.cart.original_total_price)));
                            break;
                          case "greater_than_equal_to":
                            Number(c.condition) <= mF(Number(waioMOC.cart.original_total_price)) ? a.push("yes") : a.push("no");
                             alert_msg = getMsg_define('Subtotal',c.relation,Number(c.condition),Number(c.condition) <= mF(Number(waioMOC.cart.original_total_price)));
                            break;
                          case "less_than_equal_to":
                            Number(c.condition) >= mF(Number(waioMOC.cart.original_total_price)) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Subtotal',c.relation,Number(c.condition),Number(c.condition) >= mF(Number(waioMOC.cart.original_total_price)));
                            break;
                          default:
                            console.log("invalid relation value");
                        }
                        break;
                      case "cart_item_count":
                        switch (c.relation) {
                          case "equal":
                            Number(c.condition) == Number(waioMOC.cart.item_count) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Items',c.relation,Number(c.condition),Number(c.condition) == Number(waioMOC.cart.item_count));
                            break;
                          case "not_equal":
                            Number(c.condition) != Number(waioMOC.cart.item_count) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Items',c.relation,Number(c.condition),Number(c.condition) != Number(waioMOC.cart.item_count));
                            break;
                          case "greater_than":
                            Number(c.condition) < Number(waioMOC.cart.item_count) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Items',c.relation,Number(c.condition),Number(c.condition) < Number(waioMOC.cart.item_count));
                            break;
                          case "less_than":
                            Number(c.condition) > Number(waioMOC.cart.item_count) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Items',c.relation,Number(c.condition),Number(c.condition) > Number(waioMOC.cart.item_count));
                            break;
                          case "greater_than_equal_to":
                            Number(c.condition) <= Number(waioMOC.cart.item_count) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Items',c.relation,Number(c.condition),Number(c.condition) <= Number(waioMOC.cart.item_count));
                             break;
                          case "less_than_equal_to":
                            Number(c.condition) >= Number(waioMOC.cart.item_count) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Items',c.relation,Number(c.condition),Number(c.condition) >= Number(waioMOC.cart.item_count));
                            break;
                          default:
                            console.log("invalid relation valueh");
                        }
                        break;
                      case "cart_total_weight":
                        var subtotal_weight = convert_subtotal_weight(Number(waioMOC.cart.total_weight),'g');
                        if("undefined" !== typeof b.weight_unit){
                           subtotal_weight = convert_subtotal_weight(Number(waioMOC.cart.total_weight),b.weight_unit);
                        }
                        switch (c.relation) {
                          case "equal":
                            Number(c.condition) == subtotal_weight ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Total Weight',c.relation,Number(c.condition),Number(c.condition) == subtotal_weight);
                            break;
                          case "not_equal":
                            Number(c.condition) != subtotal_weight ? a.push("yes") : a.push("no");
                             alert_msg = getMsg_define('Cart Total Weight',c.relation,Number(c.condition),Number(c.condition) != subtotal_weight);
                            break;
                          case "greater_than":
                            Number(c.condition) < subtotal_weight ? a.push("yes") : a.push("no");
                             alert_msg = getMsg_define('Cart Total Weight',c.relation,Number(c.condition),Number(c.condition) < subtotal_weight);
                            break;
                          case "less_than":
                            Number(c.condition) > subtotal_weight ? a.push("yes") : a.push("no");
                             alert_msg = getMsg_define('Cart Total Weight',c.relation,Number(c.condition),Number(c.condition) > subtotal_weight );
                            break;
                          case "greater_than_equal_to":
                            Number(c.condition) <= subtotal_weight ? a.push("yes") : a.push("no");
                             alert_msg = getMsg_define('Cart Total Weight',c.relation,Number(c.condition),Number(c.condition) <= subtotal_weight);
                            break;
                          case "less_than_equal_to":
                            Number(c.condition) >= subtotal_weight ? a.push("yes") : a.push("no");
                             alert_msg = getMsg_define('Cart Total Weight',c.relation,Number(c.condition),Number(c.condition) >= subtotal_weight);
                            break;
                          default:
                            console.log("invalid relation");
                        }
                        break;
                      default:
                        console.log("invalid column");
                      }
                    }
                    log(a);

                    if(opening_rule_applied && "undefined" !== typeof b.opening_message){
                      b.message = b.opening_message;
                      b.rules_operator = b.opening_rules_operator;
                      if(WSAIO.show_dynamic_OL_msg || b.opening_message == '') b.message = alert_msg;
                    }else{
                      if(WSAIO.show_dynamic_OL_msg || b.message == '') b.message = alert_msg;
                    }
                    waioMOC.oc = b;
                    "and" === b.rules_operator
                    ? -1 < a.indexOf("no")
                    ? ((WSAIO.disable_checkout = !0), (WSAIO.checkout_message = b.message), WSAIO.disableCheckout(!0, b.message))
                    : ((WSAIO.disable_checkout = !1), (WSAIO.checkout_message = b.message), WSAIO.disableCheckout(!1, b.message))
                    : -1 === a.indexOf("yes")
                    ? ((WSAIO.disable_checkout = !0), (WSAIO.checkout_message = b.message), WSAIO.disableCheckout(!0, b.message))
                    : ((WSAIO.disable_checkout = !1), (WSAIO.checkout_message = b.message), WSAIO.disableCheckout(!1, b.message));
                  } else log("Something missing in MOC");
                } else log("Minimum Order Control"), log("Minimum Order Control");
}
 function mocIsValidCustomer(a){var b=!0;"all"!==a.customer_group?(is_loggedIn||(b=!1),"tag_based"===a.customer_group?isTagged(a.customer_tags)||(b=!1):a.except_tags&&isTagged(a.excepted_tags)&&(b=!1)):(a.except_tags&&isTagged(a.excepted_tags)&&(b=!1),a.except_logged_in&&is_loggedIn&&(b=!1));return b}
function isTagged(a){if("undefined"===typeof a||!is_loggedIn)return!1;var b=!1,d=customer_tags.map(function(a){return a.toLowerCase()});a=a.map(function(a){return a.toLowerCase()});a=$jscomp.makeIterator(a);for(var c=a.next();!c.done;c=a.next())if(-1<d.indexOf(c.value)){b=!0;break}return b};


//  --------------------- Start buy now order limit code -----------------------

 WSAIO.BuyNoworderControl = function(c,m,e,b,d,v){
                var Total_quantity = m;
                var check_volumeTable = false;
                var compare_row = 0;
                var variant_id = v;
                var variant_inventory_info = {};
                var inventory_issue = false;
                if(typeof WSAIO.default_product_variant != 'undefined' && WSAIO.default_product_variant.length > 0){
                    variant_inventory_info = WSAIO.default_product_variant.find(function(e,r){return e.variant_id == variant_id})
                }
                if(variant_inventory_info != undefined && Object.keys(variant_inventory_info).length){
                      if(variant_inventory_info.variant_inventory_management != undefined && variant_inventory_info.variant_inventory_management != ''){
                           if(variant_inventory_info.variant_inventory_policy == 'deny'){
                             if(Total_quantity > variant_inventory_info.variant_inventory_quantity){
                               Total_quantity = variant_inventory_info.variant_inventory_quantity;
                               inventory_issue = true;
                             }
                           }
                      }
                }
              var total_price = (c*Total_quantity)/100;
                try{
                if(b.length > 0 && Total_quantity >= Number(WSAIO.volume_values[0].qty)){
                  check_volumeTable = true;
                  $(WSAIO.volume_values).each(function(e){
                    if(Total_quantity >= Number(WSAIO.volume_values[e].qty)){
                      compare_row = e;
                    }
                  }) 
                   total_price = (Number(d/100)-Number(WSAIO.get_discount(d/100,WSAIO.volume_values[compare_row].type,WSAIO.volume_values[compare_row].value)))*Total_quantity;
                }
                }catch(e){}
               for (var a = [], b = 0; b < waioMOC.rules.length; b++) {
                 var d = waioMOC.rules[b];
                 "active" === d.status && mocIsValidCustomer(d) && a.push(d);
               }
                if (0 < a.length) {
                  b = {};
                  if (1 === a.length) b = a[0];
                  else {
                    d = a.findIndex(function (a) {
                      return "tag_based" === a.customer_group;
                    });
                    var c = a.findIndex(function (a) {
                      return "logged_in" === a.customer_group;
                    }),
                        e = a.findIndex(function (a) {
                          return "all" === a.customer_group;
                        });
                    -1 < d ? (b = a[d]) : -1 < c ? (b = a[c]) : -1 < e && (b = a[e]);
                  }
                  var opening_rule_applied = false;
                  if("undefined" !== typeof b.rules && "undefined" !== typeof b.condition_scope &&
                     "undefined" !== typeof b.opening_rules && "undefined" !== typeof customer_order_info &&
                     (b.condition_scope == 'separate' || b.condition_scope == 'opening_only') && 
                     customer != '' && parseInt(customer_order_info) == 0){
                    opening_rule_applied = true;
                   
                  }
                if("undefined" !== typeof b.condition_scope && b.condition_scope == 'opening_only') b.rules = [];
                 if(opening_rule_applied){
                      b.rules = b.opening_rules;
                  }
                  if ("undefined" !== typeof b.rules) {
                    a = [];WSAIO.ol_message = '';
                    d = $jscomp.makeIterator(b.rules);
                    for (c = d.next(); !c.done; c = d.next())
                   switch (((c = c.value), c.column)) {
                      case "cart_original_total_price":
                        switch (c.relation) {
                          case "equal":
                            Number(c.condition) == Number(total_price) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('subtotal',c.relation,Number(c.condition),Number(c.condition) == Number(total_price));
                            break;
                          case "not_equal":
                            Number(c.condition) != Number(total_price) ? a.push("yes") : a.push("no");
                             alert_msg = getMsg_define('subtotal',c.relation,Number(c.condition),Number(c.condition) != Number(total_price));
                            break;
                          case "greater_than":
                              Number(c.condition) < Number(total_price) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('subtotal',c.relation,Number(c.condition), Number(c.condition) < Number(total_price));
                            break;
                          case "less_than":
                            Number(c.condition) > Number(total_price) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg('subtotal',c.relation,Number(c.condition), Number(c.condition) > Number(total_price));
                            break;
                          case "greater_than_equal_to":
                            Number(c.condition) <= Number(total_price) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('subtotal',c.relation,Number(c.condition), Number(c.condition) <= Number(total_price));
                             break;
                          case "less_than_equal_to":
                            Number(c.condition) >= Number(total_price) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('subtotal',c.relation,Number(c.condition), Number(c.condition) >= Number(total_price));
                            break;
                          default:
                            console.log("invalid relation value in MOC's nested switch");
                        }
                        break;
                      case "cart_item_count":
                        switch (c.relation) {
                          case "equal":
                            Number(c.condition) == Number(Total_quantity) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Items',c.relation,Number(c.condition),Number(c.condition) == Number(Total_quantity));
                            break;
                          case "not_equal":
                            Number(c.condition) != Number(Total_quantity) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Items',c.relation,Number(c.condition),Number(c.condition) != Number(Total_quantity));
                            break;
                          case "greater_than":
                            Number(c.condition) < Number(Total_quantity) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Items',c.relation,Number(c.condition),Number(c.condition) < Number(Total_quantity));
                            break;
                          case "less_than":
                            Number(c.condition) > Number(Total_quantity) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Items',c.relation,Number(c.condition),Number(c.condition) > Number(Total_quantity));
                            break;
                          case "greater_than_equal_to":
                            Number(c.condition) <= Number(Total_quantity) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Items',c.relation,Number(c.condition),Number(c.condition) <= Number(Total_quantity));
                            break;
                          case "less_than_equal_to":
                            Number(c.condition) >= Number(Total_quantity) ? a.push("yes") : a.push("no");
                            alert_msg = getMsg_define('Cart Items',c.relation,Number(c.condition),Number(c.condition) >= Number(Total_quantity));
                            break;
                          default:
                            console.log("invalid relation valueswitch");
                        }
                        break;
                      default:
                        console.log("invalid column value  switch");
                    }
                    if(opening_rule_applied && "undefined" !== typeof b.opening_message){
                      b.message = b.opening_message;
                      b.rules_operator = b.opening_rules_operator;
                      if(WSAIO.show_dynamic_OL_msg || b.opening_message == '') b.message = alert_msg;
                    }else{
                      if(WSAIO.show_dynamic_OL_msg || b.message == '') b.message = alert_msg;
                    }
                    waioMOC.oc = b;
                    "and" === b.rules_operator
                    ? -1 < a.indexOf("no")
                    ? ((WSAIO.disable_buy_now_button = !0), (WSAIO.buyNow_message = b.message))
                    : ((WSAIO.disable_buy_now_button = !1), (WSAIO.buyNow_message = b.message))
                    : -1 === a.indexOf("yes")
                    ? ((WSAIO.disable_buy_now_button = !0), (WSAIO.buyNow_message = b.message))
                    : ((WSAIO.disable_buy_now_button = !1), (WSAIO.buyNow_message = b.message));
                    if(WSAIO.disable_buy_now_button){
                      $('.waio_buy_message').remove();
                      if(WSAIO.buyNow_message != '' && $('.waio_buy_message').length == 0){
                        if(typeof WSAIO.allow_normal_checkout__OC == 'undefined' || WSAIO.allow_normal_checkout__OC == false){
                          $(WSAIO.shopify_payment_button_wrapper).after('<p class="waio_buy_message" style="font-size: 14px;">'+WSAIO.buyNow_message+'</p>');
                             if(inventory_issue) $(WSAIO.shopify_payment_button_wrapper).after('<p class="waio_buy_message" style="font-size: 14px;">Maximum allowable quantity for selected variant is '+Total_quantity+'.</p>');
                        }else{
                           $(WSAIO.shopify_payment_button_wrapper).after('<p class="waio_buy_message" style="font-size: 14px;">Fulfill minimum order requirements to avail discount</p>');
                            $(WSAIO.shopify_payment_button_wrapper).after('<p class="waio_buy_message" style="font-size: 14px;">'+WSAIO.buyNow_message+'</p>');
                         }
                      }
                      $(WSAIO.buy_now_button_selector).addClass('checkout-disabled').attr('disabled','disabled')
                      setTimeout(function(){
                       $(WSAIO.buy_now_button_selector).removeClass('checkout-disabled').removeAttr('disabled')
                       $('.waio_buy_message').remove();
                      },2500);
                    }else{
                      $(WSAIO.buy_now_button_selector).removeClass('checkout-disabled').removeAttr('disabled')
                    }
                  }
                }
    };

// -------------------------- get cart info object ------------------
WSAIO.fetchCart_define  = function(){
    if(!WSAIO.fetchCart){
                WSAIO.fetchCart = function(b) {
                var url_string = WSAIO.local_param+"cart.js";
                if(typeof Shopify.currency.active != 'undefined' && Shopify.currency.active != null && Shopify.currency.active != ''){
                  url_string = url_string+'?currency='+Shopify.currency.active;
                }
                $.ajax({type:"GET", url:url_string, cache:!1, dataType:"json", success:function(f) {
                  var d = [];
                  f && f.items && 0 < f.items.length && (f.items.forEach(function(e, c) {
                    try {
                      delete e.product_description, delete e.featured_image, delete e.url, delete e.options_with_values, delete e.variant_options, delete e.product_description;
                    } catch (h) {
                      k(h);
                    }
                    d.push(e);
                  }), f.items = d);
                  try {
                    "undefined" === typeof window.waioMOC && (window.waioMOC = {});
                    "undefined" === typeof waioMOC.cart && (waioMOC.cart = {});
                    try {
                      waioMOC.cart.item_count = f.item_count;
                    } catch (e) {
                    }
                  } catch (e) {
                  }
                  "function" === typeof b && b(null, f);
                }, error:function(f) {
                  "function" === typeof b && b(f, null);
                }});
              };
            }
};


// ---------------------  append wholesale link code start ----------

WSAIO.loginLink = function() {
  if(WSAIO.app_mode_applied){
              function append_link(){
                      if($('.wsaio_form').length == 0){
                          var selector_wsf = $(WSAIO.default_create_account_selector);
                          if(!selector_wsf.length){
                          if(!$('form[action$="/account/login"]').siblings().find('a[href$="/account/register"]').length){
                              selector_wsf  = $('form[action$="/account/login"]').siblings('a[href$="/account/register"]');  
                          }else{
                              selector_wsf  = $('form[action$="/account/login"]').siblings().find('a[href$="/account/register"]');
                          }
                          selector_wsf.after('<br><a href="'+WSAIO.create_wholesale_account_link+'" class="wsaio_form">'+WSAIO.create_wholesale_account_link_label+'</a>');
                  
                      }else{
                      $(WSAIO.default_create_account_selector).after('<br><a href="'+WSAIO.create_wholesale_account_link+'" class="wsaio_form">'+WSAIO.create_wholesale_account_link_label+'</a>');
                      }
                  }
              }
            if(WSAIO.wholesale_signup_link_on_login_page == 'replace'){
              $('a[href$="/account/register"]').hide();
              append_link();
               var NewSignupPageLink = WSAIO.create_wholesale_account_link;
              if(document.querySelector('a[href$="/account/register"]') != null){
                try {
                  document.querySelectorAll('a[href$="/account/register"]').forEach(function(element,i){
                    element.addEventListener("click", function(e){
                      e.preventDefault();
                      window.location.href = NewSignupPageLink;
                    });
                  });
                } catch (e) {}
              }
              if(window.location.pathname == WSAIO.local_param+"account/register"){
                window.location.href = NewSignupPageLink;
              }
            }
            else if(  WSAIO.wholesale_signup_link_on_login_page == 'append'){
              append_link();
            }
          }
}

// ----------------------

WSAIO.cart_qty_handler_define = function(){
   window.HandlecartQty=function(){
        var init_module=function(){}
        return {
        init:init_module
        }
    }()
    HandlecartQty.init();
        WSAIO.cart_qty_change_event = function(){
            if( window.wsaio_involved != undefined && window.wsaio_involved == true && WSAIO.app_mode_applied){
                $(document).on('click',WSAIO.cart_qty_btn_selector,function(){
                    setTimeout(function(){
                    if( typeof WSAIO.checkoutEventListner != 'undefined'){WSAIO.checkoutEventListner();} 
                    WSAIO.preCheckout(); 
                    },WSAIO.qty_change_delay);
                })
                $(document).on('change',WSAIO.cart_qty_input_selector,function(){
                    setTimeout(function(){
                    if(typeof WSAIO.checkoutEventListner != 'undefined'){WSAIO.checkoutEventListner();} 
                    WSAIO.preCheckout(); 
                    },WSAIO.qty_change_delay);
                })
                $(document).on('keyup',WSAIO.cart_qty_input_selector,function(){
                  $(WSAIO.checkout_selector+','+WSAIO.duplicate_checkout_selector+','+WSAIO.netTerm_checkout_selector).addClass('wsaio_hideCheckout')
                })
            }
        }
}


// -------------- app enable preview bar ---------------

WSAIO.app_enable_preview_define = function(){
   if(!WSAIO.removeQueryString){
    WSAIO.removeQueryString = function(m, k) {
      var r = document.location.href, u = location.search;
      "" != m ? (k = encodeURIComponent(k), m = m + "=" + k, "-1" != u.indexOf("?" + m + "&") ? r = r.replace("?" + m + "&", "?") : "-1" != u.indexOf("&" + m + "&") ? r = r.replace("&" + m + "&", "&") : "-1" != u.indexOf("?" + m) ? r = r.replace("?" + m, "") : "-1" != u.indexOf("&" + m) && (r = r.replace("&" + m, ""))) : (u = location.search, r = r.replace(u, ""));
      history.pushState({state:1, rand:Math.random()}, "", r);
    };
  }
  if(!WSAIO.getParameterByName){
    WSAIO.getParameterByName = function(m) {
      for (var k = [], r = window.location.search.substring(1).split("&"), u = 0; u < r.length; u++) {
        var a = r[u].split("=");
        a[0] == m && k.push(decodeURIComponent(a[1]));
      }
      return k;
    };
  }
  if(!window.wsaioClosePreview){
    window.wsaioClosePreview = function() {
      WSAIO.removeQueryString("test-mode", WSAIO.getParameterByName("test-mode")[0]);
      localStorage.removeItem("wsaio-app-mode");
      WSAIO.user_mode = "live";
      setTimeout(function() {
        window.location.href = "https://" + Shopify.shop;
      }, 500);
    };
  }
  if(!window.wsaioHidePreview){
    window.wsaioHidePreview = function() {
      $(".wholesaleAllInOnePreview").remove();
      $("html").css("padding-bottom", "");
    };
  }
  if(!WSAIO.addPreviewBar){
    WSAIO.addPreviewBar = function() {
      0 == $(".wholesaleAllInOnePreview").length && $("body").append('<div class="wholesaleAllInOnePreview"> <div class="wholesale_bar__stack"> <div class="wholesale_bar__item"> <div> <strong style="font-weight: 600 !important;">Wholesale All In One Preview: </strong> Wholesale pricing are only visible to you. <a href="https://support.digitalcoo.com/hc/en-us/articles/360042800512"><u>Learn More</u></a> </div> </div> <div> <div class="wsaio_bar_dropdown" style="display:none;"> <button onclick="WSAIO.wsaio_actions()" class="wsaio_bar_dropbtn wholesale-button-group">Actions <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 16px !important; position: absolute !important; right: 15px !important;top: 11px !important;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button> <div id="wsaio_bar_myDropdown" class="wsaio_bar_dropdown-content" style="background: white !important;"> <button class="wsaio_bar_btn wholesale-button-group" onclick="wsaioClosePreview();" type="button" name="button" style="color: #212b36 !important;border: none !important;border-bottom: 1px solid #80808038 !important; border-radius: unset !important;">Close preview</button> <button class="wholesale-button-group wsaio_bar_btn  wholesale-button-group2" onclick="wsaioHidePreview();" type="button" name="button" style="color:#007ace !important">Hide bar</button> </div> </div> </div> <ul class="wholesale_bar__button_group"> <li class="wholesale-button-group__item"> <button class="wholesale-button-group" onclick="wsaioClosePreview();" type="button" name="button" style="color: #212b36;">Close preview</button> <li class="wholesale-button-group__item"> <button class="wholesale-button-group wholesale-button-group2" onclick="wsaioHidePreview();" type="button" name="button" style="color:#007ace !important;">Hide bar</button> </li> </ul> </div> </div>');
      $("html").css("padding-bottom", "60px");
    };
  }
     
  "undefined" !== typeof WSAIO.getParameterByName("test-mode")[0] && (WSAIO.user_mode = "test", localStorage.setItem("wsaio-app-mode", "test"), WSAIO.addPreviewBar());
  null !== localStorage.getItem("wsaio-app-mode") && WSAIO.addPreviewBar();
      WSAIO.app_mode = WSAIO.general_settings.app_mode || "live";
    WSAIO.user_mode = localStorage.getItem("wsaio-app-mode") || "live";
     WSAIO.app_mode_applied = false;
    if(WSAIO.app_mode == 'live'){
      if(WSAIO.user_mode == 'test' || WSAIO.user_mode == 'live'){
       WSAIO.app_mode_applied = true;
    }
    }else if(WSAIO.app_mode == 'test'){
        if(WSAIO.user_mode == 'test'){
        WSAIO.app_mode_applied = true;
        }
    }
    WSAIO.wsaio_actions =  function() {
       document.getElementById("wsaio_bar_myDropdown").classList.toggle("wsaio_bar_show");
     }
     window.onclick = function(event) {
       if (!event.target.matches('.wsaio_bar_dropbtn')) {
         var dropdowns = document.getElementsByClassName("wsaio_bar_dropdown-content");
         var i;
         for (i = 0; i < dropdowns.length; i++) {
           var openDropdown = dropdowns[i];
           if (openDropdown.classList.contains('wsaio_bar_show')) {
             openDropdown.classList.remove('wsaio_bar_show');
           }
         }
       }
     }
}

// ---------------- QOF_links append on account page--------------
  
WSAIO.QOF_links_append = function(){
  if(WSAIO.app_mode_applied && typeof WSAIO.QOF_links != 'undefined' && WSAIO.QOF_links.length){
    var selector_qof = $(WSAIO.default_qof_link_selector);
     if(selector_qof.length){
        if(typeof window.location != 'undefined' && typeof window.location.pathname != 'undefined'){
          if(window.location.pathname.indexOf('/account') > -1){
            if(typeof WSAIO.qof_navigation_enable != 'undefined' && WSAIO.qof_navigation_enable){
                      selector_qof.after('<br><a href="'+WSAIO.local_param+WSAIO.QOF_links[0].page_link+'" class="wsaio_qof_form">'+WSAIO.QOF_links[0].title+'</a>');
            }else{
                    var links_option = '';
                    for (let i = 0; i < WSAIO.QOF_links.length; i++) {
                      links_option += ' <tr style="padding: 10px !important;display: block;border-top: 1px solid #dddddd63 !important;" redirect_link="'+WSAIO.local_param+WSAIO.QOF_links[i].page_link+'" class="redirect_to_qof"><td style="padding:0px !important;display: block !important;"><a href="#" class="wsaio_qof_form" style="padding: 5px 28px !important;text-decoration: underline !important;display:block;text-align: center !important;border: none !important; box-shadow: none !important;">'+WSAIO.QOF_links[i].title+'</a></td></tr>';
                    }
                    selector_qof.after('<table class="qof_links_dropdown" style="margin-top: 15px;cursor: pointer;border: 1px solid  #dddddd63 !important; width: fit-content !important; padding: 10px 0px; box-shadow: none !important;    border-top: none !important;"><tbody>'+links_option+'</tbody></table>');     
                     $('.redirect_to_qof').on('click',function(){window.location.href = $(this).attr('redirect_link');})
            }
        }
      }
    }
  }
}

// ---------------- Buy noew define --------------

WSAIO.buy_now_define = function(){
      if( window.wsaio_involved != undefined && window.wsaio_involved == true && WSAIO.app_mode_applied && typeof WSAIO.buyNowEventListener == "undefined"){
            WSAIO.buy_it_now = function () {
                $(WSAIO.buy_now_button_selector).on("click",function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                $(this).prop("disabled", !0);
                var c = $(this).parents("form");
                var product_handle = c.parents(WSAIO.product_parent_grid_selector).find('[name="id"]').attr("data-handle") || current_product.handle,
                variant_id = c.parents(WSAIO.product_parent_grid_selector).find('[name="id"]').val(),
                product_quantity = c.parents(WSAIO.product_parent_grid_selector).find('[name="quantity"]').val();
            void 0 === product_quantity && (product_quantity = 1);
  
                WSAIO.getProduct(product_handle, function (pr) {
                    WSAIO.buy_now_product = pr;
                    proccedToBuyItNow();
                });
                function proccedToBuyItNow(){
                    if (typeof WSAIO.buy_now_product !== 'undefined' && WSAIO.buy_now_product !== null) {
                        var product = WSAIO.buy_now_product;
                        if (product) {
                            var selected_variant_index = product.variants.findIndex(function (a) {
                                return a.id == variant_id
                            }),
                                variant = {};
                            if (-1 < selected_variant_index) {
                                variant = product.variants[selected_variant_index];
                            }   
                            if(typeof MOQ_applied != 'undefined' && MOQ_applied.length > 0){
                                if((Number(product_quantity)%MOQ_applied[0]._qtyInc) == 0 && Number(product_quantity) >= MOQ_applied[0]._qtyMin){
                                    if(MOQ_applied[0]._qtyMax != 0 && Number(product_quantity) <= MOQ_applied[0]._qtyMax){
                                    $(WSAIO.buy_now_button_selector).removeClass('checkout-disabled').removeAttr('disabled')
                                    WSAIO.disable_buy_now_button_moq = false;
                                    }else{
                                    $(WSAIO.buy_now_button_selector).removeClass('checkout-disabled').removeAttr('disabled')
                                    WSAIO.disable_buy_now_button_moq = false; 
                                    }
                                }else{
                                    if(WSAIO.buyNow_message != '' ){
                                    $(WSAIO.shopify_payment_button_wrapper).after('<p class="waioMOQ_buy_message" style="font-size: 14px;">Minimum Requirements not fulfilled</p>');
                                    }
                                    $(WSAIO.buy_now_button_selector).addClass('checkout-disabled').attr('disabled','disabled')
                                    WSAIO.disable_buy_now_button_moq = true; 
                                    setTimeout(function(){
                                    $(WSAIO.buy_now_button_selector).removeClass('checkout-disabled').removeAttr('disabled')
                                    $('.waio_buy_message, .waioMOQ_buy_message').remove();
                                    },2500);
                                }
                                }
                                setTimeout(function(){
                                $('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find('.wsaio_buynow').css('cssText','display:inline-block !important')
                                },10)
                                WSAIO.BuyNoworderControl(Number(variant.price),Number(product_quantity),WSAIO.buy_now_button_selector,[],Number(variant.price));
                                if (WSAIO.disable_buy_now_button || WSAIO.disable_buy_now_button_moq) {
                                return false;
                                }
                                else{
                                    return window.location.href = WSAIO.local_param+ 'cart/' + variant_id + ':' + product_quantity;
                                }
                        }
                    }
                }
            });
            };
            WSAIO.getProduct = function (handle, callback) {
                $.getJSON(WSAIO.local_param + 'products/' + handle + '.js', function (product) {
                if (typeof callback === "function") {
                    callback(product);
                }
                });
                return "Use callback function to get product";
            };
            WSAIO.addBuyNowBtnHTML = function () {
            var is_replace = false;
            if(WSAIO.buy_now_btn_replace){
            is_replace = true;
            }
            if((WSAIO.subscription_variant_selector != '' || WSAIO.subscription_variant_selector != 'false') && WSAIO.buy_now_btn_replace){
                if($(WSAIO.subscription_variant_selector).is(':checked')){
                    is_replace = false;
                }else{
                    is_replace = true;
                }
              }
                var is_append = setInterval(function(){
                    if(typeof current_product != 'undefined' && current_product != null){
                        $(WSAIO.product_price_selector).addClass('wsaio_'+current_product.id)
                        if( is_replace == false){
                        $('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find('.wsaio_buynow').remove()
                        }
                        
                    if($('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find(WSAIO.shopify_payment_button_wrapper).find(WSAIO.buy_now_button_selector).length > 0){
                        $('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find(WSAIO.shopify_payment_button_wrapper).hide()
                        if($('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find('.wsaio_buynow').length == 0 && is_replace){
                            $('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find(WSAIO.shopify_payment_button_wrapper).find(WSAIO.buy_now_button_selector).addClass('wsaio_hide_btn').css('cssText','display:none !important') 
                            $('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find(WSAIO.shopify_payment_button_wrapper).find('.shopify-payment-button__more-options').addClass('wsaio_hide_btn').css('cssText','display:none !important')  
                            $(WSAIO.shopify_payment_button_wrapper).append(WSAIO.buy_now_button_html);
                            $('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find('.wsaio_buynow').css('cssText','display:inline-block !important')
                        }else{
                            if(WSAIO.buy_now_btn_replace == false || is_replace == false){
                        $(WSAIO.product_parent_grid_selector).find('.wsaio_buynow').remove();
                        $('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find(WSAIO.shopify_payment_button_wrapper).find(WSAIO.buy_now_button_selector).removeClass('wsaio_hide_btn') 
                        $('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find(WSAIO.shopify_payment_button_wrapper).find('.shopify-payment-button__more-options').removeClass('wsaio_hide_btn')
                        $('.shopify-payment-button .shopify-payment-button__button').css('cssText','display:inline-block !important')
                        }                        
                        }
                        WSAIO.buy_it_now();

                        if(typeof WSAIO.showBuy != 'undefined'){WSAIO.showBuy()}
                        if($('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find('.wsaio_buynow').length != 0){
                        $('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find(WSAIO.shopify_payment_button_wrapper).find('button').siblings('div').find(WSAIO.buy_now_button_selector).addClass('wsaio_hide_btn').css('cssText','display:none !important') 
                        $('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find(WSAIO.shopify_payment_button_wrapper).find('button').siblings('div').find(WSAIO.buy_now_button_selector).siblings('button').addClass('wsaio_hide_btn').css('cssText','display:none !important')
                        }

                        clearInterval(is_append)
                        
                    }
                    }else{ 
                        clearInterval(is_append)
                    }
                },100)
            
              };
                $(document).ready(function(){
                        setTimeout(function(){
                            WSAIO.buyNowEventListener = function () {
                                    WSAIO.addBuyNowBtnHTML();
                            };
                        setTimeout(function(){
                            try{
                            $('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find(WSAIO.shopify_payment_button_wrapper).show()
                            }catch(e){}
                            WSAIO.showBuyevent = function(){
                                WSAIO.showBuy = function(){
                                    $('.wsaio_'+current_product.id).parents(WSAIO.product_parent_grid_selector).find(WSAIO.shopify_payment_button_wrapper).show()
                                }
                            }
                            if(typeof WSAIO.showBuyevent != 'undefined'){WSAIO.showBuyevent()}
                            },500)      
                        },5000)   
                    })
                WSAIO.buyNowEventListener = function () {
                        WSAIO.addBuyNowBtnHTML();
                };
              }
}

//---------------- Cart Level UpSell message -------------

WSAIO.cartLevelUpSell = function () {
  if(typeof WSAIO.show_cart_level_upsell_message != 'undefined' && WSAIO.show_cart_level_upsell_message){
      WSAIO.wsaioUpSell_msg = '';
      WSAIO.cartLevelUpSell_applied = [];
      var cart_subtotal_value = parseFloat(WSAIO.discount_response.checkout_price_from_items_subtotal_price);
      var cart_quantity = parseInt(cart_data.item_count);
      var upsell_msg_condition = [];
      var is_cld = false;
      if (WSAIO.cart_ld_discounts && WSAIO.cart_ld_discounts.length) {
            // filter applied rule
            for (var cld_index = 0; cld_index < WSAIO.cart_ld_discounts.length; cld_index++) {
              var rule_item = WSAIO.cart_ld_discounts[cld_index];
              if (rule_item.state != 'published') continue;
              if (WSAIO.checkCustomer(rule_item.customer_group, rule_item.tags, rule_item.tags_excluded)){
                WSAIO.cartLevelUpSell_applied.push(rule_item);
              }
            }
            // set priority value based on customer_group
            for (var cld_index2 = 0; cld_index2 < WSAIO.cartLevelUpSell_applied.length; cld_index2++) {
                 var single_rule = WSAIO.cartLevelUpSell_applied[cld_index2];
                 if(single_rule.customer_group == 'has_tag'){
                     WSAIO.cartLevelUpSell_applied[cld_index2].priority = 1;
                 }else if(single_rule.customer_group == 'has_account'){
                     WSAIO.cartLevelUpSell_applied[cld_index2].priority = 2;
                 }else if(single_rule.customer_group == 'all'){
                     WSAIO.cartLevelUpSell_applied[cld_index2].priority = 3;
                 }
            }
    
            WSAIO.cartLevelUpSell_applied.sort(function(a, b){
                  if(a.priority < b.priority) { return 1; }
                  if(a.priority > b.priority) { return -1; }
                  return 0;
           })
          
          for (var cld_index3 = 0; cld_index3 < WSAIO.cartLevelUpSell_applied.length; cld_index3++) {
                var single_rule = WSAIO.cartLevelUpSell_applied[cld_index3];
                     switch(single_rule.customer_group) {
                        case 'all':
                                  for (var i = 0; i < single_rule.discounts.length; i++) {
                                  if(single_rule.calculation_type == 'cart_quantity'){
                                      if(cart_quantity < single_rule.discounts[i].value){
                                          single_rule.discounts[i].type = 'item';
                                           upsell_msg_condition.find(function(e,r){ if(typeof e != 'undefined' && e.type == 'item'){ upsell_msg_condition.splice(r,1)  }})
                                          upsell_msg_condition.push(single_rule.discounts[i]);
                                          break;
                                      }
                                  }else{
                                       if(cart_subtotal_value < single_rule.discounts[i].value){
                                          single_rule.discounts[i].type = 'subtotal';
                                            upsell_msg_condition.find(function(e,r){ if(typeof e != 'undefined' && e.type == 'subtotal'){ upsell_msg_condition.splice(r,1)  }})
                                          upsell_msg_condition.push(single_rule.discounts[i]);
                                          break;
                                      }
                                  }
                              }
                          break;
                        case 'has_account':
                                 for (var i = 0; i < single_rule.discounts.length; i++) {
                                  if(single_rule.calculation_type == 'cart_quantity'){
                                      if(cart_quantity < single_rule.discounts[i].value){
                                          single_rule.discounts[i].type = 'item';
                                           upsell_msg_condition.find(function(e,r){ if(typeof e != 'undefined' && e.type == 'item'){ upsell_msg_condition.splice(r,1)  }})
                                         upsell_msg_condition.push(single_rule.discounts[i]);
                                          break;
                                      }
                                  }else{
                                       if(cart_subtotal_value < single_rule.discounts[i].value ){
                                          single_rule.discounts[i].type = 'subtotal';
                                          upsell_msg_condition.find(function(e,r){ if(typeof e != 'undefined' && e.type == 'subtotal'){ upsell_msg_condition.splice(r,1)  }})
                                          upsell_msg_condition.push(single_rule.discounts[i]);
                                          break;
                                      }
                                  }
                              }
                          break;
                        default:
                             for (var i = 0; i < single_rule.discounts.length; i++) {
                                  if(single_rule.calculation_type == 'cart_quantity'){
                                      if(cart_quantity < single_rule.discounts[i].value){
                                          single_rule.discounts[i].type = 'item';
                                          upsell_msg_condition.find(function(e,r){if(typeof e != 'undefined' && e.type == 'item'){ upsell_msg_condition.splice(r,1)  }})
                                          upsell_msg_condition.push(single_rule.discounts[i]);
                                          break;
                                      }
                                  }else{
                                       if(cart_subtotal_value < single_rule.discounts[i].value){
                                           single_rule.discounts[i].type = 'subtotal';
                                           upsell_msg_condition.find(function(e,r){ if(typeof e != 'undefined' && e.type == 'subtotal'){ upsell_msg_condition.splice(r,1)  }})
                                           upsell_msg_condition.push(single_rule.discounts[i]);
                                          break;
                                      }
                                  }
                              }
                      }
        }
        for (var ij = 0; ij < upsell_msg_condition.length; ij++) {
            if(upsell_msg_condition[ij].type == 'subtotal'){
                WSAIO.wsaioUpSell_msg = WSAIO.wsaioUpSell_msg + "<li style='display: flex !important;'><span style='text-align: left !important; padding-left: 10px !important;'>You're "+WSAIO.formatMoney(upsell_msg_condition[ij].value-cart_subtotal_value)+" away from getting "+upsell_msg_condition[ij].discount_value+"% discount</span></li>";
            }else{
                WSAIO.wsaioUpSell_msg = WSAIO.wsaioUpSell_msg + "<li style='display: flex !important;'><span style='text-align: left !important; padding-left: 10px !important;'>Only "+(upsell_msg_condition[ij].value-cart_quantity)+" cart item left from getting "+upsell_msg_condition[ij].discount_value+"% discount</span></li>";
            }
        }
    }
  }
}

// code to stop event for old Net Term submit button when new Net Term is in use
window.addEventListener("load", function(){
  setTimeout(function(){
      if($('.new_net_mobile_div').length != 0){
      try{$('.NetTerm_div').find('input[type="submit"]').parents('form').off()}catch(e){}
      }
  },200);
})

}

/* -----------------------CALL MODULE (Start)------------------------------ */
if(typeof window.WSAIO_MODULE !== "undefined"){
  var jQ = typeof window.WSAIO_GET_JQUERY === "function" ? window.WSAIO_GET_JQUERY() : jQuery;
  if(jQ)window.WSAIO_MODULEJS(jQ);window.WSAIO_MODULE(jQ);
};
/* -----------------------CALL MODULE (End)------------------------------ */