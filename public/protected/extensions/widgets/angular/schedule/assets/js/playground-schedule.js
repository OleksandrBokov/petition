'use strict';

angular.module("playgroundSchedule", ['angularUtils.directives.dirPagination']).controller('playground-schedule',['$scope',  function($scope){

    $scope.init = function (init){
        $scope.config = init;

        $scope.errorList = init.errorList;
    }

}]).directive('playgroundScheduleView',['service', '$filter', 'dateTime', 'collection', function factory(service, $filter, dateTime, collection){
    return {
        restrict: 'AE',
        replace: true,
        link: function ($scope, element, attrs) {

            $scope.schedule = [];
            $scope.schedule.week = [];
            $scope.hidePrevButton = true;
            $scope.cart = [];

            /*** start render schedule ***/
            renderSchedule();

            function renderSchedule( step, date ) {
                var data = { step:step, date: date};
                service.update( data , $scope.config.getSchedule).then(function(response){
                    $scope.schedule = response.data;

                    console.log($scope.schedule);

                    $scope.initCart();
                    $scope.hidePrevButton = dateTime.togglePreviewButton($scope.schedule.startWeek);
                });
            }


            $scope.reinit = function(step, date){
                var data = { step:step, date: date};
                service.update( data , $scope.config.getSchedule).then(function(response){
                    $scope.schedule = response.data;
                    $scope.hidePrevButton = dateTime.togglePreviewButton($scope.schedule.startWeek);
                });
            };


            /** установить цену по тек. времени и дате **/
            $scope.setPrice = function( hour, day) {
                if($scope.schedule.items["'" + hour+day + "'"]['price'])
                    return $scope.schedule.items["'" + hour+day + "'"]['price']+' ₴';
            };

            /** доступность кнопки  **/
            $scope.checkAvailableItemByCurrentTime = function( key, date ){

                var enabled = true;
                var item = $scope.schedule.items["'" + key+date.day_number + "'"];

                /*** есть ли цена ***/
                if(!item['price'])
                    enabled = enabled && false;
                /*** доступность на момент загрузки ***/
                if(!item['used'])
                    enabled = enabled && false;
                /*** доступность по текущему времени загрузки страницы  ***/
                if(!dateTime.checkInterval(item['timestamp'], $scope.schedule.margin_of_time))
                    enabled = enabled && false;

                if(!enabled){
                    item['used'] = false;
                }
               // enabled = true;

                return enabled;
            };

            $scope.checkActive = function( key, date ){
                var item = $scope.schedule.items["'" + key+date.day_number + "'"];
                return item['selected'];
            };

            /** обновить таблицу при смене недели **/
            $scope.updateSchedule = function(step, date){
                collection.interval = [];
                renderSchedule( step, date );
            };
        }
    }
}]).directive('scheduleCart',['service', 'collection', '$filter', 'dateTime', function factory(service, collection, $filter, dateTime){
    return {
        restrict: 'AE',
        replace: true,
        link: function ($scope) {

            $scope.initCart = function(){

                if($scope.schedule.error){
                    $scope.modalFadeIn = true;
                    $scope.error = $scope.errorList[$scope.schedule.error];
                }
                if($scope.schedule.cart){
                  //  collection.interval = $scope.schedule.cart;
                    collection.checkItems($scope.schedule, $scope.config);

                }
                renderCart();
            };



            $scope.addToCart = function(key, date){

                var item = $scope.schedule.items["'"+key+date.day_number+"'"];
                item['selected'] = !item['selected'];

                if(item['selected'] && !checkError(item)){
                    collection.addItem(item, $scope.schedule, $scope.config);
                }else{
                    collection.removeItem(item, $scope.schedule, $scope.config);
                }
                renderCart();
            };

            /** удалить из корзины**/
            $scope.removeByCart = function(items){
                collection.deleteStack(items, $scope.schedule, $scope.config);
                renderCart();
            };



            /** бронирование **/
            $scope.reservationCart = function () {
                var error = false;
                angular.forEach(collection.interval, function(item){
                    if(checkCartError(item)){
                        collection.removeItem(item, $scope.schedule, $scope.config);
                        error =  true;
                    }
                });
                if(!error){
                    location.href = $scope.config.order;
                }else{
                    renderCart();
                }

            };


            function renderCart()
            {
                $scope.stack = [];

                var col = angular.copy( collection.interval );
                col = $filter('orderByTimestamp')(col);

                var keys = Object.keys(col);
                var innerKeys = Object.keys(col);
                var arr = [];

                for (var i = 0; i < keys.length; i++) {

                    if(typeof col[keys[i]] === typeof undefined){
                        continue;
                    }
                    arr[i] = [];
                    arr[i].push(col[keys[i]]);
                    var nextTimestamp = null;

                    for (var j = 0; j < innerKeys.length; j++)
                    {
                        if(!nextTimestamp)
                            nextTimestamp = dateTime.findNeighborTimestamp(col[keys[i]].timestamp, $scope.schedule.time_interval);
                        if(typeof col[innerKeys[j]] !== typeof undefined){
                            if(nextTimestamp == col[innerKeys[j]].timestamp){
                                arr[i].push(col[innerKeys[j]]);
                                nextTimestamp = dateTime.findNeighborTimestamp(col[innerKeys[j]].timestamp, $scope.schedule.time_interval);
                                delete col[keys[i]];
                                delete col[innerKeys[j]];
                            }
                        }
                    }
                }
                $scope.stack = $filter('orderByTimestamp')(arr);

                countTotalPrice($scope.stack);
            }

            /*** подсчет интервала времени заказа ***/
            $scope.setTimeInterval = function(item) {



                var start;
                var finish;

                for (var i = 0; i < item.length; i++) {
                    if(i == 0)
                        start = item[i].timestamp * 1000;
                    if(i+1 == item.length)
                        finish = item[i].timestamp * 1000;
                }

                var step = 60 * parseFloat($scope.schedule.time_interval);

                finish = finish + ( step * 60* 1000);
                return $filter('date')(start, 'HH:mm')+' - '+ $filter('date')(finish, 'HH:mm')
            };



            /*** подсчет суммы заказа одного интервала ***/
            $scope.countStackPrice = function(item){
                var price = 0;
                for (var i = 0; i < item.length; i++) {
                    price += parseInt(item[i].price);
                }
                return formatPrice(price);
            };

            /** общая сумма заказа **/
            function countTotalPrice (stack) {
                var total = 0;

                var keys = Object.keys(stack);
                for (var i = 0; i < keys.length; i++) {
                    var price = 0;
                    for (var j = 0; j < stack[i].length; j++) {
                        price += parseInt(stack[i][j].price);
                    }
                    total += price;
                }
                $scope.total = formatPrice(total);
            }

            /*** форматирование стоимости ***/
            function formatPrice(price){
                var str = price.toString();
                return str.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
            }


            /** проверка при выборе даты **/
            function checkError(item){
                var error = false;
                if(!dateTime.checkInterval(item.timestamp, $scope.schedule.margin_of_time)){
                    $scope.modalFadeIn = true;
                    $scope.error = $scope.errorList[1];
                    $scope.reinit();
                    error =  true;
                }
                return error;
            }

            /** проверка при перезагрузке страницы и кнопке забронировать **/
            function checkCartError(item){
                var error = false;
                if(!dateTime.checkInterval(item.timestamp, $scope.schedule.margin_of_time)){//
                    $scope.modalFadeIn = true;
                    $scope.error = $scope.errorList[4];
                    error =  true;
                }
                return error;
            }



            $scope.checkStack = function (stack) {
                return (typeof stack === typeof undefined || stack.length == 0) ? false: true;
            };

            $scope.translite = function(month)
            {
                return Yii.t('main', month);
            }

            $scope.booking = function($event){

                $event.stopPropagation();
                $event.preventDefault();
                var error = false;

                angular.forEach(collection.interval, function(item){
                    if(checkCartError(item)){
                        error =  true;
                    }
                });

                if(!error){
                   document.getElementById('booking-form').submit();
                }else{
                    $scope.modalFadeIn = true;
                    $scope.error = $scope.errorList[4];
                    renderCart();
                }
            }


        }
    }
}]).factory('collection',['dateTime','$filter','service',function(dateTime, $filter, service){
    var collections = {};
    collections.interval = [];
    var neighbor = {};
    collections.stack = null;

    collections.addItem = function(item, schedule, config)
    {
        collections.interval.push(item);


        if(parseInt(schedule.time_interval) != 1)
        {
            var nextItemTimestamp = dateTime.findNeighborTimestamp(item.timestamp , schedule.time_interval);
            var prevItemTimestamp = dateTime.findNeighborTimestamp(item.timestamp , -schedule.time_interval);

            var nextItem = findItemByTimestamp(nextItemTimestamp, schedule.items);
            var prevItem = findItemByTimestamp(prevItemTimestamp, schedule.items);

            if(nextItem && !nextItem['selected'] && prevItem && !prevItem['selected']){
                nextItem['selected'] = true;
                collections.interval.push(nextItem);
            } else if(!nextItem && prevItem && !prevItem['selected']){
                prevItem['selected']  = true;
                collections.interval.push(prevItem);
            } else if(!prevItem && nextItem && !nextItem['selected']){
                nextItem['selected'] = true;
                collections.interval.push(nextItem);
            }
        }

        service.update( collections.interval , config.updateCart).then(function(response){
           console.log(response.data);
        });
    };

    collections.checkItems = function(schedule, config)
    {
        angular.forEach(schedule.cart, function (item) {
            collections.addItem(item, schedule, config);
        })
    };


    /** удаление из коллекцию элемента и соседнего элемента по условию**/
    collections.removeItem = function(item, schedule, config){

        neighbor.next = [];
        neighbor.prev = [];

        this.deleteItem( item, schedule.items);

        if(parseInt(schedule.time_interval) != 1){
            collections.findNext(item, schedule.time_interval);
            collections.findPrev(item, schedule.time_interval);

            if (neighbor.next.length == 0 && neighbor.prev.length == 1){ // (2 эл.) - удаление предыд.эл.
                this.deleteItem(neighbor.prev[0], schedule.items);
            }else if (neighbor.prev.length == 0 && neighbor.next.length == 1){ // (2 эл.) - удаление след.эл.
                this.deleteItem(neighbor.next[0], schedule.items);
            } else if (neighbor.prev.length == 1 && neighbor.next.length == 1){ // (3 эл.) - удаление след.эл. и предыд.эл.
                this.deleteItem(neighbor.next[0], schedule.items);
                this.deleteItem(neighbor.prev[0], schedule.items);
            } else if (neighbor.prev.length > 1 && neighbor.next.length == 1){ // (4 и более эл.) - удаление след.эл.
                this.deleteItem(neighbor.next[0], schedule.items);
            } else if (neighbor.next.length > 1 && neighbor.prev.length == 1){ // (4 и более эл.) - удаление предыд.эл.
                this.deleteItem(neighbor.prev[0], schedule.items);
            }
        }

        service.update( collections.interval , config.updateCart).then(function(response){
            console.log(response.data);
        });
    };

    collections.deleteStack = function(stack, schedule, config){
        angular.forEach(stack, function (item) {
            collections.deleteItem( item, schedule.items);
        });
        service.update( collections.interval , config.updateCart);
    };

    collections.deleteItem = function( item, items ) {

        angular.forEach(collections.interval, function (val, key) {
            if(val.timestamp == item.timestamp) {
                delete collections.interval[key];
            }
        });
        angular.forEach(items, function (val, key) {
             if(items[key].timestamp == item.timestamp) {
                    items[key].selected = false;
             }
             if(!item.used){
                 items[key].used = false;
             }
        });
        collections.interval = $filter('orderByTimestamp')(collections.interval);
    };

    collections.findNext = function (item, interval){

        var nextItemTimestamp = dateTime.findNeighborTimestamp(item.timestamp , interval);
        var nextItem = findItemByTimestamp(nextItemTimestamp, collections.interval);
        if(nextItem){
            neighbor.next.push(nextItem);
            collections.findNext(nextItem, interval);
        }
    };

    collections.findPrev = function (item, interval){

        var prevItemTimestamp = dateTime.findNeighborTimestamp(item.timestamp , -interval);
        var prevItem = findItemByTimestamp(prevItemTimestamp, collections.interval);
        if(prevItem){
            neighbor.prev.push(prevItem);
            collections.findPrev(prevItem, interval);
        }
    };


    function findItemByTimestamp(timestamp, items)
    {
        var findItem;//= false;
        angular.forEach(items, function(item){
            if(typeof item.timestamp != typeof undefined && item.timestamp == timestamp){
                findItem = item;
            }
        });

        if(findItem && !findItem.used){
            findItem = false;
        }

        return findItem;
    }

    return collections;

}]).factory('dateTime',['$filter',function($filter){
    var dt = {};
    dt.result = false;

    dt.checkInterval = function(timestamp, margin_of_time) {
        var currentDtime = new Date().getTime();
        var marginTime = currentDtime + (60*60*1000*margin_of_time);

        return (marginTime > (timestamp * 1000)) ? false : true;
    };

    dt.togglePreviewButton = function(startWeek)
    {
        var currentDtime = new Date().getTime();
        var currentDate = $filter('date')(currentDtime, 'yyyyMMdd');
        var startWeek = $filter('date')(startWeek * 1000, 'yyyyMMdd');
        return ( startWeek > currentDate ) ? false : true;
    };

    dt.findNeighborTimestamp = function(timestamp, step){
        var t = step * 60 * 60;
        return timestamp + t
    };

    return dt;
}]).factory('service', ['$http', function($http){
    var service = {};
    service.update = function(data, url){
        var result = $http.post(url, {'data':data})
            .success(function(data) {
                return data;
            }).error(function(response) {
                // Never gets called & dies with error described below.
                console.log(response);
            });
        return result;
    };
    return service;
}]).filter('orderByTimestamp', function() {
    return function(items, field, reverse) {
        var filtered = [];
        if(typeof items !== typeof undefined){

            angular.forEach(items, function(item) {
                filtered.push(item);
            });
            filtered.sort(function (a, b) {
                return (parseInt(a.timestamp) > parseInt(b.timestamp) ? 1 : -1);
            });
            if(reverse) filtered.reverse();
        }
        return filtered;
    };
}).filter('orderByStack', function() {
    return function(items, field, reverse) {
        var filtered = [];
        if(typeof items !== typeof undefined){
            angular.forEach(items, function(item) {
                filtered.push(item);
            });
            filtered.sort(function (a, b) {
                return (parseInt(a[0].timestamp) > parseInt(b[0].timestamp) ? 1 : -1);
            });
            if(reverse) filtered.reverse();
        }
        return filtered;
    }
});
new AppFactory("playground-schedule", "playgroundScheduleFactory", ["playgroundSchedule"]);