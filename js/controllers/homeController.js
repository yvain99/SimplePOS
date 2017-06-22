angular.module("myApp")
        .controller("homeController", ["$scope", "$sce", "$filter", "$location", "$interval", "$timeout", "$compile", "$http", function ($scope, $sce, $filter, $location, $interval, $timeout, $compile, $http) {
                $("select").material_select();

                $scope.time = moment().format("MMMM Do YYYY, h:mm:ss A");
                var t = $interval(function () {
                    $scope.time = moment().format("MMMM Do YYYY, h:mm:ss A");
                }, 1000);

                $scope.reportStartTime = new Date();
                $scope.reportEndTime = new Date();
                $scope.datePickerMonth = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                $scope.datePickerMonthShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $scope.datePickerWeekdaysFull = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                $scope.datePickerWeekdaysLetter = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];

                // Dashboard
                if (angular.element(".dashboard-products").length) {
                    $scope.labels = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                    $scope.series = ["Purchase", "Sales"];
                    $scope.colors = ["#ff0000", "#00ff00"];
                    $scope.options = {
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        callback: function (label, index, labels) {
                                            return $scope.addCommas(label);
                                        }
                                    }
                                }
                            ]
                        },
                        tooltips: {
                            enabled: true,
                            mode: "single",
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var label = data.datasets[tooltipItem.datasetIndex].label;
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return label + ": " + $scope.addCommas(datasetLabel);
                                }
                            }
                        }
                    };

                    $http({
                        method: "GET",
                        url: "getSellingPurchasing?day=" + new Date().getDay(),
                        headers: {
                            "Content-Type": "application/json"
                        }
                    }).then(function successCallback(response) {
                        var purchasing = [0, 0, 0, 0, 0, 0, 0];
                        var selling = [0, 0, 0, 0, 0, 0, 0];
                        var day;

                        for (var i in response.data.purchasing) {
                            day = moment(response.data.purchasing[i].purchase_created).format('d');
                            purchasing[day] = response.data.purchasing[i].total
                        }

                        for (var i in response.data.selling) {
                            day = moment(response.data.selling[i].sales_created).format('d');
                            selling[day] = response.data.selling[i].total
                        }

                        $scope.data = [
                            purchasing,
                            selling
                        ];
                    });

                    $scope.addCommas = function (nStr) {
                        nStr += "";
                        var x = nStr.split(".");
                        var x1 = x[0];
                        var x2 = x.length > 1 ? "." + x[1] : "";
                        var rgx = /(\d+)(\d{3})/;
                        while (rgx.test(x1)) {
                            x1 = x1.replace(rgx, "$1" + "," + "$2");
                        }
                        return x1 + x2;
                    }

                    $scope.dproductsEmpty = false;
                    $scope.dproductsBox = false;
                    $scope.dproductsAlert = [];
                    $http({
                        method: "GET",
                        url: "getProductsAlert",
                        headers: {
                            "Content-Type": "application/json"
                        }
                    }).then(function successCallback(response) {
                        var productsLength = response.data.products.length;
                        var ingredientsLength = response.data.ingredients.length;

                        if (productsLength == 0 && ingredientsLength == 0) {
                            $scope.dproductsEmpty = true;
                        } else {
                            if (productsLength > 0) {
                                for (var i in response.data.products) {
                                    $scope.dproductsAlert.push({
                                        name: response.data.products[i].name,
                                        qty: response.data.products[i].qty,
                                        unit_name: 'Unit'
                                    });
                                }
                            }

                            if (ingredientsLength > 0) {
                                for (var i in response.data.ingredients) {
                                    $scope.dproductsAlert.push({
                                        name: response.data.ingredients[i].name,
                                        qty: response.data.ingredients[i].qty,
                                        unit_name: response.data.ingredients[i].unit_name
                                    });
                                }
                            }
                            $scope.dproductsBox = true;
                        }
                    });
                }

                //Sales
                $scope.salesId = angular.element("#sales-add-id").text();

                if (angular.element(".sales-data-temp").length) {
                    $scope.salesPaymentMethod = angular.element("#sales-data-payment-method").val();
                    $scope.salesPaymentMethodNumber = angular.element("#sales-data-payment-method-number").val();
                    $scope.salesCustomerUsername = angular.element("#sales-data-customer-username").val();
                    $scope.salesCustomer = angular.element("#sales-data-customer").val();
                    $scope.salesDescription = angular.element("#sales-data-description").val();

                    $scope.salesSubtotal = angular.element("#sales-data-subtotal").val();
                    $scope.salesTotal = $filter('number')(angular.element("#sales-data-total").val());

                    $scope.salesDiscValue = angular.element("#sales-data-disc-value").val();
                    $scope.salesTaxValue = angular.element("#sales-data-tax-value").val();
                    $scope.salesDisc = $scope.salesSubtotal * $scope.salesDiscValue / 100;
                    $scope.salesTax = $scope.salesSubtotal - $scope.salesDisc;
                    $scope.salesTax = $filter('number')($scope.salesTax * $scope.salesTaxValue / 100);
                    $scope.salesSubtotal = $filter('number')($scope.salesSubtotal);
                    $scope.salesDisc = $filter('number')($scope.salesDisc);

                    $scope.productIds = angular.element("#sales-product-ids").val().split(",");
                    $scope.productQtys = angular.element("#sales-product-qtys").val().split(",");

                    angular.element(".sales-data-temp").remove();
                } else {
                    $scope.salesPaymentMethod = "Cash";
                    $scope.salesPaymentMethodNumber = "";
                    $scope.salesCustomerUsername = "customer";
                    $scope.salesCustomer = "Walk-in Customer";
                    $scope.salesSubtotal = "0";
                    $scope.salesTotal = "0";
                    $scope.salesDiscValue = 0;
                    $scope.salesTaxValue = 0;
                    $scope.salesDisc = 0;
                    $scope.salesTax = 0;
                    $scope.salesDescription = "";
                }

                $scope.salesProductsCategory = "Appetizers";

                $scope.holdCloseSales = function (status) {
                    var title, text;
                    if (status == "Hold") {
                        title = "Hold This Order?";
                        text = "Sales Has Been Saved as Pending Order!"
                    } else {
                        title = "Close This Order?";
                        text = "Sales Has Been Saved as Complete Order!"
                    }

                    swal({
                        title: title,
                        type: "",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        confirmButtonText: "Yes"
                    },
                    function () {
                        swal({
                            title: "Add Description",
                            text: "Description For This Order",
                            type: "input",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            animation: "slide-from-top",
                            inputPlaceholder: "Table-N, Room-N, etc."
                        },
                        function (inputValue) {
                            if (inputValue === false)
                                return false;

                            if (inputValue === "") {
                                swal.showInputError("Please Insert Description First!");
                                return false;
                            }

                            $scope.salesProductId = [];
                            $scope.salesProductQty = [];
                            $scope.salesProductPrice = [];

                            angular.forEach(angular.element("input[name='sales-product-id[]']"), function (value, key) {
                                $scope.salesProductId.push(angular.element(value).val());
                            });

                            if ($scope.salesProductId.length > 0) {
                                $scope.salesDescription = inputValue;

                                angular.forEach(angular.element("input[name='sales-product-qty[]']"), function (value, key) {
                                    $scope.salesProductQty.push(angular.element(value).val());
                                });

                                angular.forEach(angular.element("input[name='sales-product-price[]']"), function (value, key) {
                                    $scope.salesProductPrice.push(angular.element(value).val());
                                });

                                $scope.loader = true;
                                $http({
                                    method: "POST",
                                    url: "holdCloseSales",
                                    data: {
                                        id: $scope.salesId,
                                        productId: $scope.salesProductId,
                                        productQty: $scope.salesProductQty,
                                        productPrice: $scope.salesProductPrice,
                                        customerUsername: $scope.salesCustomerUsername,
                                        discount: $scope.salesDiscValue,
                                        tax: $scope.salesTaxValue,
                                        subTotal: $scope.salesSubtotal,
                                        total: $scope.salesTotal,
                                        paymentMethod: $scope.salesPaymentMethod,
                                        paymentMethodNumber: $scope.salesPaymentMethodNumber,
                                        description: $scope.salesDescription,
                                        status: status
                                    }
                                }).then(function successCallback(result) {
                                    $scope.loader = false;
                                    if (result.data == "success") {
                                        swal({
                                            title: "Success",
                                            text: text,
                                            type: "success",
                                        }, function () {
                                            if (status == "Close")
                                                $scope.printSales();
                                            window.location.href = "sales_add";
                                        });
                                    }
                                }, function errorCallback(result) {
                                    $scope.loader = false;
                                    swal({
                                        title: "Warning",
                                        text: "Connection Timeout, Please Try Again!",
                                        type: "warning",
                                    });
                                });
                            } else {
                                swal({
                                    title: "Warning",
                                    text: "Please Add Products First!",
                                    type: "warning",
                                });
                            }
                        });
                    });
                }

                $scope.holdCloseEditSales = function (status) {
                    var title, text;
                    if (status == "Hold") {
                        title = "Hold This Order?";
                        text = "Sales Has Been Edited!"
                    } else {
                        title = "Close This Order?";
                        text = "Sales Has Been Closed!"
                    }

                    swal({
                        title: title,
                        type: "",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        confirmButtonText: "Yes"
                    },
                    function () {
                        swal({
                            title: "Add Description",
                            text: "Description For This Order",
                            type: "input",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            animation: "slide-from-top",
                            inputPlaceholder: "Table-N, Room-N, etc.",
                            inputValue: $scope.salesDescription
                        },
                        function (inputValue) {
                            if (inputValue === false)
                                return false;

                            if (inputValue === "") {
                                swal.showInputError("Please Insert Description First!");
                                return false;
                            }

                            $scope.salesProductId = [];
                            $scope.salesProductQty = [];
                            $scope.salesProductPrice = [];

                            angular.forEach(angular.element("input[name='sales-product-id[]']"), function (value, key) {
                                $scope.salesProductId.push(angular.element(value).val());
                            });

                            if ($scope.salesProductId.length > 0) {
                                $scope.salesDescription = inputValue;

                                angular.forEach(angular.element("input[name='sales-product-qty[]']"), function (value, key) {
                                    $scope.salesProductQty.push(angular.element(value).val());
                                });

                                angular.forEach(angular.element("input[name='sales-product-price[]']"), function (value, key) {
                                    $scope.salesProductPrice.push(angular.element(value).val());
                                });

                                $scope.loader = true;
                                $http({
                                    method: "POST",
                                    url: "/POS/holdCloseEditSales",
                                    data: {
                                        id: $scope.salesId,
                                        productId: $scope.salesProductId,
                                        productQty: $scope.salesProductQty,
                                        productPrice: $scope.salesProductPrice,
                                        customerUsername: $scope.salesCustomerUsername,
                                        discount: $scope.salesDiscValue,
                                        tax: $scope.salesTaxValue,
                                        subTotal: $scope.salesSubtotal,
                                        total: $scope.salesTotal,
                                        paymentMethod: $scope.salesPaymentMethod,
                                        paymentMethodNumber: $scope.salesPaymentMethodNumber,
                                        description: $scope.salesDescription,
                                        status: status,
                                        oldProductId: $scope.productIds,
                                        oldProductQty: $scope.productQtys
                                    }
                                }).then(function successCallback(result) {
                                    $scope.loader = false;
                                    if (result.data == "success") {
                                        swal({
                                            title: "Success",
                                            text: text,
                                            type: "success",
                                        }, function () {
                                            if (status == "Hold")
                                                window.location.href = $scope.salesId;
                                            else {
                                                $scope.printSales();
                                                window.location.href = "/POS/sales_complete";
                                            }
                                        });
                                    }
                                }, function errorCallback(result) {
                                    $scope.loader = false;
                                    swal({
                                        title: "Warning",
                                        text: "Connection Timeout, Please Try Again!",
                                        type: "warning",
                                    });
                                });
                            } else {
                                swal({
                                    title: "Warning",
                                    text: "Please Add Products First!",
                                    type: "warning",
                                });
                            }
                        });
                    });
                }

                $scope.printSales = function () {
                    var printContents = document.getElementById("sales-print-element").innerHTML;
                    var popupWin = window.open('', '_blank', 'width=800,height=600');
                    popupWin.document.open();
                    popupWin.document.write(
                            '<html>' +
                            '<head>' +
                            '<link rel="stylesheet" type="text/css" href="/POS/css/index.css" />' +
                            '<link rel="stylesheet" type="text/css" href="/POS/css/materialize.css" />' +
                            '</head>' +
                            '<body onload="window.print()">' +
                            '<div style="width:100%;text-align:center;">' +
                            printContents +
                            '<div class="divider" style="margin-top:18px;"></div>' +
                            '<div style="padding:10px;text-align:center;">' +
                            settings.receipt_text +
                            '</div>' +
                            '</div>' +
                            '</body>' +
                            '</html>'
                            );
                    popupWin.document.close();
                }

                $scope.getSalesAddProducts = function (id) {
                    $scope.salesProducts = [];
                    $scope.salesProductsLoader = false;
                    $scope.salesProductsEmpty = true;
                    $scope.salesProductsCategory = angular.element("#sales-add-products-category-" + id).text();
                    $http({
                        method: "GET",
                        url: "/POS/getSalesAddProducts?category=" + id,
                        headers: {
                            "Content-Type": "application/json"
                        }
                    }).then(function successCallback(response) {
                        $scope.salesProductsLoader = true;

                        if (response.data.length > 0) {
                            for (var i in response.data) {
                                if (response.data[i].stock == "-1")
                                    response.data[i].stock = '<div class="red-text">Out of Stock</div>';
                                else
                                    response.data[i].stock = 'Stock: <div style="display:inline;">' + response.data[i].stock + '</div>';

                                if (!response.data[i].image)
                                    response.data[i].image = 'img/product/product_default.jpg';
                                else
                                    response.data[i].image = 'img/product/' + response.data[i].image;

                                $scope.salesProducts.push({
                                    id: response.data[i].id,
                                    image: response.data[i].image,
                                    name: response.data[i].name,
                                    retail_price: response.data[i].retail_price,
                                    stock: $sce.trustAsHtml(response.data[i].stock)
                                });
                            }
                        } else {
                            $scope.salesProductsEmpty = false;
                            $scope.salesProducts = [];
                        }
                    }, function errorCallback(response) {
                        $scope.salesProductsLoader = true;
                        getSalesAddProducts(id);
                    });
                }

                $scope.addSalesProduct = function (id) {
                    var name = angular.element("." + id + "-name").text();
                    var price = parseInt(angular.element("." + id + "-price").text().split(",").join(""));
                    var qty = parseInt(angular.element("." + id + "-qty").find("div").text());

                    if (isNaN(qty))
                        swal("Product Out of Stock!", "Please Make a Purchase of This Product First!", "warning");
                    else {
                        if (angular.element("#sales-product-" + id + "-qty").length) {
                            var salesQty = parseInt(angular.element("#sales-product-" + id + "-qty").val()) + 1;
                            var salesTotal = salesQty * price;

                            if (angular.element("#sales-edit-identifier").length) {
                                var idx = $scope.productIds.indexOf(id.toString());

                                if (idx != -1) {
                                    if (salesQty > (qty + parseInt($scope.productQtys[idx])))
                                        swal("Product Out of Stock!", "Please Make a Purchase of This Product First!", "warning");
                                    else {
                                        angular.element("#sales-product-" + id + "-qty").val(salesQty);
                                        angular.element("#sales-product-" + id + "-qty").next().text(salesQty);
                                        angular.element("#sales-product-" + id + "-total").text($filter('number')(salesTotal));

                                        $scope.salesSubtotal = parseInt($scope.salesSubtotal.split(",").join("")) + price;
                                        $scope.calculateTotalSales();
                                    }
                                } else {
                                    if (salesQty > qty)
                                        swal("Product Out of Stock!", "Please Make a Purchase of This Product First!", "warning");
                                    else {
                                        angular.element("#sales-product-" + id + "-qty").val(salesQty);
                                        angular.element("#sales-product-" + id + "-qty").next().text(salesQty);
                                        angular.element("#sales-product-" + id + "-total").text($filter('number')(salesTotal));

                                        $scope.salesSubtotal = parseInt($scope.salesSubtotal.split(",").join("")) + price;
                                        $scope.calculateTotalSales();
                                    }
                                }
                            } else {
                                if (salesQty > qty)
                                    swal("Product Out of Stock!", "Please Make a Purchase of This Product First!", "warning");
                                else {
                                    angular.element("#sales-product-" + id + "-qty").val(salesQty);
                                    angular.element("#sales-product-" + id + "-qty").next().text(salesQty);
                                    angular.element("#sales-product-" + id + "-total").text($filter('number')(salesTotal));

                                    $scope.salesSubtotal = parseInt($scope.salesSubtotal.split(",").join("")) + price;
                                    $scope.calculateTotalSales();
                                }
                            }
                        } else {
                            var content =
                                    '<tr id="sales-product-' + id + '">' +
                                    '<td>' +
                                    '<input ' +
                                    'id="sales-product-' + id + '-qty" ' +
                                    'class="center-align"' +
                                    'type="hidden" ' +
                                    'name="sales-product-qty[]" ' +
                                    'value="1"/>' +
                                    '<div style="padding-left:8px;">1</div>' +
                                    '</td>' +
                                    '<td>' + name + '</td>' +
                                    '<td>' +
                                    '<input ' +
                                    'id="sales-product-' + id + '-price" ' +
                                    'class="center-align"' +
                                    'type="hidden" ' +
                                    'name="sales-product-price[]" ' +
                                    'value="' + price + '"/>' +
                                    $filter('number')(price) +
                                    '</td>' +
                                    '<td id="sales-product-' + id + '-total">' + $filter('number')(price) + '</td>' +
                                    '<td>' +
                                    '<input ' +
                                    'id="sales-product-' + id + '-id" ' +
                                    'class="center-align"' +
                                    'type="hidden" ' +
                                    'name="sales-product-id[]" ' +
                                    'value="' + id + '"/>' +
                                    '<div class="sales-add-product-remove-btn" ' +
                                    'ng-click="removeSalesAddProduct(\'' + id + '\');">' +
                                    '<i class="fa fa-times"></i>' +
                                    '</div>' +
                                    '</td>' +
                                    '</tr>';

                            angular.element("#sales-add-products-table").append($compile(content)($scope));

                            $scope.salesQty = 1;
                            $scope.salesSubtotal = parseInt($scope.salesSubtotal.split(",").join("")) + price;
                            $scope.calculateTotalSales();
                        }
                    }
                }

                $scope.removeSalesAddProduct = function (id) {
                    var total = parseInt(angular.element("#sales-product-" + id + "-total").text().split(",").join(""));

                    $scope.salesSubtotal = parseInt($scope.salesSubtotal.split(",").join("")) - total;
                    $scope.calculateTotalSales();

                    angular.element("#sales-product-" + id).remove();
                }

                $scope.setSalesDiscount = function () {
                    swal({
                        title: "Set Discount",
                        text: "Define discount in %",
                        type: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "Discount (%)"
                    },
                    function (inputValue) {
                        if (inputValue === false)
                            return false;

                        if (inputValue === "") {
                            swal.showInputError("Please Insert Discount First!");
                            return false;
                        }

                        if (inputValue != parseInt(inputValue)) {
                            swal.showInputError("Please Insert Integer Value!");
                            return false;
                        }

                        swal({
                            title: "",
                            text: "Discount has been set!",
                            type: "success"
                        }, function () {
                            $scope.salesDiscValue = inputValue;
                            $scope.salesSubtotal = parseInt($scope.salesSubtotal.split(",").join(""))
                            $scope.calculateTotalSales();
                        });
                    });
                }

                $scope.setSalesTax = function () {
                    swal({
                        title: "Set Tax",
                        text: "Define Tax in %",
                        type: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "Tax (%)"
                    },
                    function (inputValue) {
                        if (inputValue === false)
                            return false;

                        if (inputValue === "") {
                            swal.showInputError("Please Insert Tax First!");
                            return false;
                        }

                        if (inputValue != parseInt(inputValue)) {
                            swal.showInputError("Please Insert Integer Value!");
                            return false;
                        }

                        swal({
                            title: "",
                            text: "Tax has been set!",
                            type: "success"
                        }, function () {
                            $scope.salesTaxValue = inputValue;
                            $scope.salesSubtotal = parseInt($scope.salesSubtotal.split(",").join(""))
                            $scope.calculateTotalSales();
                        });
                    });
                }

                $scope.setSalesPaymentMethod = function () {
                    swal({
                        title: "Set Payment Method",
                        text: "Define Payment Method",
                        type: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "Cash, Bank Name (Credit Card), Cheque"
                    },
                    function (inputValue) {
                        if (inputValue === false)
                            return false;

                        if (inputValue === "") {
                            swal.showInputError("Please Insert Method First!");
                            return false;
                        }

                        swal({
                            title: "",
                            text: "Payment method has been set!",
                            type: "success"
                        }, function () {
                            $scope.salesPaymentMethod = inputValue;
                        });
                    });
                }

                $scope.setSalesPaymentMethodNumber = function () {
                    swal({
                        title: "Set Payment Method Number",
                        text: "Define Payment Method Number",
                        type: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "Credit Card Number, Cheque Number, etc."
                    },
                    function (inputValue) {
                        if (inputValue === false)
                            return false;

                        if (inputValue === "") {
                            swal.showInputError("Please Insert Number First!");
                            return false;
                        }

                        swal({
                            title: "",
                            text: "Payment method number has been set!",
                            type: "success"
                        }, function () {
                            $scope.salesPaymentMethodNumber = inputValue;
                        });
                    });
                }

                $scope.setSalesCustomer = function () {
                    swal({
                        title: "Set Customer",
                        text: "Define Customer by Username",
                        type: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "Customer Username"
                    },
                    function (inputValue) {
                        if (inputValue === false)
                            return false;

                        if (inputValue === "") {
                            swal.showInputError("Please Insert Customer Username First!");
                            return false;
                        }

                        $scope.loader = true;
                        $http({
                            method: "GET",
                            url: "/POS/getCustomerByUsername?username=" + inputValue,
                            headers: {
                                "Content-Type": "application/json"
                            }
                        }).then(function successCallback(response) {
                            $scope.loader = false;
                            if (response.data.length > 0) {
                                swal({
                                    title: "",
                                    text: "Customer has been set!",
                                    type: "success"
                                }, function () {
                                    $scope.salesCustomerUsername = response.data[0].username;
                                    $scope.salesCustomer = response.data[0].name;
                                });
                            } else {
                                swal({
                                    title: "",
                                    text: "Customer not found!",
                                    type: "error"
                                });
                            }
                        }, function errorCallback(response) {
                            $scope.loader = false;
                            swal({
                                title: "Warning",
                                text: "Connection Timeout, Please Try Again!",
                                type: "warning",
                            });
                        });
                    });
                }

                $scope.calculateTotalSales = function () {
                    $scope.salesDisc = $scope.salesSubtotal * $scope.salesDiscValue / 100;
                    $scope.salesTax = ($scope.salesSubtotal - $scope.salesDisc) * $scope.salesTaxValue / 100;

                    $scope.salesTotal = $scope.salesSubtotal + $scope.salesTax - $scope.salesDisc;

                    $scope.salesTax = $filter('number')($scope.salesTax);
                    $scope.salesDisc = $filter('number')($scope.salesDisc);
                    $scope.salesSubtotal = $filter('number')($scope.salesSubtotal);
                    $scope.salesTotal = $filter('number')($scope.salesTotal);
                }

                $scope.sales = [];
                $scope.salesLoader = false;

                $scope.getMoreCompleteSales = function () {
                    var offset = angular.element(".sales").length;
                    if (offset % 10 == 0) {
                        if (!$scope.salesLoader) {
                            $scope.salesLoader = true;

                            var sv = angular.element("#sales-sv").val();
                            var sc = angular.element("#sales-sc").val();

                            $http({
                                method: "GET",
                                url: "getMoreCompleteSales?sv=" + sv + "&sc=" + sc + "&offset=" + offset,
                                headers: {
                                    "Content-Type": "application/json"
                                }
                            }).then(function successCallback(response) {
                                if (response.data.length > 0) {
                                    for (var i in response.data) {
                                        $scope.sales.push({
                                            id: response.data[i].id,
                                            description: response.data[i].description,
                                            admin: response.data[i].admin,
                                            customer: response.data[i].customer,
                                            total_qty: response.data[i].total_qty,
                                            total: response.data[i].total,
                                            payment_method: response.data[i].payment_method,
                                            payment_method_number: response.data[i].payment_method_number
                                        });
                                    }
                                }
                                $scope.salesLoader = false;
                            }, function errorCallback(response) {
                                $scope.salesLoader = false;
                                getMoreCompleteSales();
                            });
                        }
                    } else
                        angular.element(".sales-content").unbind("scroll");
                }

                $scope.generateSalesReport = function () {
                    var startDate = angular.element("#sales-report-start-date").val();
                    var endDate = angular.element("#sales-report-end-date").val();

                    if (startDate && endDate) {
                        if (Date.parse(startDate) <= Date.parse(endDate)) {
                            $scope.loader = true;
                            $http({
                                method: "GET",
                                url: "generateSalesReport?startDate=" + startDate + "&endDate=" + endDate,
                                headers: {
                                    "Content-Type": "application/json"
                                }
                            }).then(function successCallback(response) {
                                if (response.data.length > 0) {
                                    angular.element("#sales-report-content").html(
                                            '<div id="sales-report-print-element">' +
                                            '<div class="center-align" id="sales-report-header">' +
                                            '<div id="sales-report-title" style="font-size:2em;">' +
                                            settings.name + ' Sales Report</h4>' +
                                            '</div>' +
                                            '<div id="sales-report-date" style="padding:5px;">' +
                                            moment(startDate).format('ll') + ' - ' + moment(endDate).format('ll') +
                                            '</div>' +
                                            '<div class="divider" style="margin:5px 0 5px 0;"></div>' +
                                            '<table class="centered striped" id="sales-report-table" width="100%">' +
                                            '<thead>' +
                                            '<tr>' +
                                            '<th>ID</th>' +
                                            '<th>Description</th>' +
                                            '<th>Admin</th>' +
                                            '<th>Customer</th>' +
                                            '<th>Total Qty</th>' +
                                            '<th>Total Price</th>' +
                                            '<th>Payment Method</th>' +
                                            '<th>Created</th>' +
                                            '</tr>' +
                                            '</thead>' +
                                            '<tbody>' +
                                            '</tbody>' +
                                            '</table>' +
                                            '<div class="divider" style="margin:5px 0 5px 0;"></div>' +
                                            '</div>' +
                                            '</div>'
                                            );
                                    for (var i in response.data) {
                                        angular.element("#sales-report-table tbody").append(
                                                '<tr>' +
                                                '<td>' + response.data[i].id + '</td>' +
                                                '<td>' + response.data[i].description + '</td>' +
                                                '<td>' + response.data[i].admin + '</td>' +
                                                '<td>' + response.data[i].customer + '</td>' +
                                                '<td>' + $filter('number')(response.data[i].total_qty) + '</td>' +
                                                '<td>' + $filter('number')(response.data[i].total) + '</td>' +
                                                '<td>' + response.data[i].payment_method + '</td>' +
                                                '<td>' + moment(response.data[i].Created).format('LLL') + '</td>' +
                                                '</tr>'
                                                );
                                    }
                                } else {
                                    angular.element("#sales-report-content").html('No Result.');
                                }

                                $scope.loader = false;
                            }, function errorCallback(response) {
                                $scope.loader = false;
                                swal({
                                    title: "Warning",
                                    text: "Connection Timeout, Please Try Again!",
                                    type: "warning",
                                });
                            });
                        } else {
                            swal({
                                title: "Warning",
                                text: "Start Date Must Be Less Than or Equal End Date!",
                                type: "warning",
                            });
                        }
                    } else {
                        swal({
                            title: "Warning",
                            text: "Please Set Start Date and End Date of Report First!",
                            type: "warning",
                        });
                    }
                }

                $scope.printSalesReport = function () {
                    if (angular.element("#sales-report-content").html().trim() == "No Result.") {
                        swal({
                            title: "Warning",
                            text: "No Result!",
                            type: "warning",
                        });
                    } else {
                        var printContents = document.getElementById("sales-report-print-element").innerHTML;
                        var popupWin = window.open('', '_blank', 'width=800,height=600');
                        popupWin.document.open();
                        popupWin.document.write(
                                '<html>' +
                                '<head>' +
                                '<link rel="stylesheet" type="text/css" href="/POS/css/index.css" />' +
                                '<link rel="stylesheet" type="text/css" href="/POS/css/materialize.css" />' +
                                '</head>' +
                                '<body onload="window.print()">' +
                                '<div style="width:100%;text-align:center;">' +
                                printContents +
                                '</div>' +
                                '</body>' +
                                '</html>'
                                );
                        popupWin.document.close();
                    }
                }

                //Purchase
                var t;
                $scope.purchaseAddProducts = [];
                $scope.purchaseAddEmpty = true;
                $scope.purchaseAddLoader = false;

                $scope.purchaseSearch = function () {
                    $timeout.cancel(t);

                    var sv = angular.element("#purchase-add-value").val();
                    var type = angular.element("#purchase-add-select").val();

                    t = $timeout(function () {
                        $scope.getPurchaseSearchResults(sv, type);
                    }, 400);
                }

                $scope.getPurchaseSearchResults = function (sv, type) {
                    $scope.purchaseAddEmpty = false;
                    $scope.purchaseAddLoader = true;
                    $http({
                        method: "GET",
                        url: "/POS/getPurchaseAddProducts?sv=" + sv + "&type=" + type,
                        headers: {
                            "Content-Type": "application/json"
                        }
                    }).then(function successCallback(response) {
                        $scope.purchaseAddProducts = [];
                        if (response.data.length > 0) {
                            var image;
                            for (var i in response.data) {
                                if (response.data[i].image)
                                    image = '/POS/img/product/' + response.data[i].image;
                                else
                                    image = '/POS/img/product/product_default.jpg';

                                $scope.purchaseAddProducts.push({
                                    id: response.data[i].id,
                                    image: image,
                                    name: response.data[i].name,
                                    purchase_price: response.data[i].purchase_price,
                                    stock: response.data[i].stock,
                                    unit_type: (response.data[i].unit_type) ? response.data[i].unit_type : "unit"
                                });
                            }
                        } else
                            $scope.purchaseAddEmpty = true;
                        $scope.purchaseAddLoader = false;
                    }, function errorCallback(response) {
                        $scope.purchaseAddLoader = false;
                        $scope.purchaseAddEmpty = true;
                    });

                    $scope.purchaseAddLoader = false;
                }

                $scope.purchaseId = angular.element("#purchase-add-id").val();
                $scope.purchaseTotal = 0;
                if (angular.element("#purchase-data-total").length) {
                    $scope.purchaseTotal = $filter('number')(angular.element("#purchase-data-total").val());
                    angular.element("#purchase-data-total").remove();
                }

                $scope.addPurchaseProduct = function (id) {
                    var name = angular.element("." + id + "-name").text();
                    var qty = parseInt(angular.element("." + id + "-qty").val());
                    var price = parseInt(angular.element("." + id + "-price").text().split(",").join(""));
                    var total = qty * price;
                    var supplier = angular.element("#purchase-add-suppliers-select").val();
                    var supplierName = angular.element("#purchase-add-suppliers-select option:selected").text();
                    var type = angular.element("#purchase-add-select").val();

                    if (qty) {
                        if (angular.element("#purchase-product-" + id + "-" + type).length) {
                            var purchaseQty = parseInt(angular.element("#purchase-product-" + id + "-" + type + "-qty").val()) + qty;
                            var purchaseTotal = purchaseQty * price;

                            angular.element("#purchase-product-" + id + "-" + type + "-qty").val(purchaseQty);
                            angular.element("#purchase-product-" + id + "-" + type + "-qty").next().text(purchaseQty);
                            angular.element("#purchase-product-" + id + "-" + type + "-total").text($filter('number')(purchaseTotal));

                            $scope.purchaseTotal = parseInt($scope.purchaseTotal.split(",").join(""));
                            $scope.purchaseTotal = $filter('number')($scope.purchaseTotal + total);
                        } else {
                            if (supplier) {
                                var content =
                                        '<tr id="purchase-product-' + id + '-' + type + '">' +
                                        '<td>' +
                                        '<input ' +
                                        'id="purchase-product-' + id + '-' + type + '-qty" ' +
                                        'class="center-align"' +
                                        'type="hidden" ' +
                                        'name="purchase-product-qty[]" ' +
                                        'value="' + qty + '"/>' +
                                        '<div style="padding-left:8px;">' + qty + '</div>' +
                                        '</td>' +
                                        '<td>' + name + '</td>' +
                                        '<td>' +
                                        '<input ' +
                                        'id="purchase-product-' + id + '-' + type + '-price" ' +
                                        'class="center-align"' +
                                        'type="hidden" ' +
                                        'name="purchase-product-price[]" ' +
                                        'value="' + price + '"/>' +
                                        $filter('number')(price) +
                                        '</td>' +
                                        '<td id="purchase-product-' + id + '-' + type + '-total">' + $filter('number')(total) + '</td>' +
                                        '<td>' +
                                        '<input ' +
                                        'id="purchase-product-' + id + '-' + type + '-supplier" ' +
                                        'class="center-align"' +
                                        'type="hidden" ' +
                                        'name="purchase-product-supplier[]" ' +
                                        'value="' + supplier + '"/>' +
                                        supplierName +
                                        '</td>' +
                                        '<td>' +
                                        '<input ' +
                                        'id="purchase-product-' + id + '-' + type + '-id" ' +
                                        'class="center-align"' +
                                        'type="hidden" ' +
                                        'name="purchase-product-id[]" ' +
                                        'value="' + id + '"/>' +
                                        '<input ' +
                                        'id="purchase-product-' + id + '-' + type + '-type" ' +
                                        'class="center-align"' +
                                        'type="hidden" ' +
                                        'name="purchase-product-type[]" ' +
                                        'value="' + type + '"/>' +
                                        '<div class="purchase-add-product-remove-btn" ' +
                                        'ng-click="removePurchaseAddProduct(\'' + id + '\',\'' + type + '\');">' +
                                        '<i class="fa fa-times"></i>' +
                                        '</div>' +
                                        '</td>' +
                                        '</tr>';

                                angular.element("#purchase-add-products-table").append($compile(content)($scope));

                                if ($scope.purchaseTotal != 0)
                                    $scope.purchaseTotal = parseInt($scope.purchaseTotal.split(",").join(""));
                                $scope.purchaseTotal = $filter('number')($scope.purchaseTotal + total);
                            } else {
                                swal({
                                    title: "Warning",
                                    text: "Please Define Supplier First!",
                                    type: "warning",
                                });
                            }
                        }
                    } else {
                        swal({
                            title: "Warning",
                            text: "Please Define Qty First!",
                            type: "warning",
                        });
                    }
                }

                $scope.removePurchaseAddProduct = function (id, type) {
                    var total = parseInt(angular.element("#purchase-product-" + id + "-" + type + "-total").text().split(",").join(""));
                    $scope.purchaseTotal = parseInt($scope.purchaseTotal.split(",").join(""));
                    $scope.purchaseTotal = $filter('number')($scope.purchaseTotal - total);

                    angular.element("#purchase-product-" + id + "-" + type).remove();
                }

                $scope.holdClosePurchase = function (status) {
                    var title, text;
                    if (status == "Hold") {
                        title = "Hold This Order?";
                        text = "Purchase Has Been Saved as Pending Order!"
                    } else {
                        title = "Close This Order?";
                        text = "Purchase Has Been Saved as Complete Order!"
                    }

                    swal({
                        title: title,
                        type: "",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        confirmButtonText: "Yes"
                    },
                    function () {
                        $scope.purchaseProductId = [];
                        $scope.purchaseProductQty = [];
                        $scope.purchaseProductPrice = [];
                        $scope.purchaseProductType = [];
                        $scope.purchaseProductSupplier = [];

                        angular.forEach(angular.element("input[name='purchase-product-id[]']"), function (value, key) {
                            $scope.purchaseProductId.push(angular.element(value).val());
                        });

                        if ($scope.purchaseProductId.length > 0) {
                            angular.forEach(angular.element("input[name='purchase-product-qty[]']"), function (value, key) {
                                $scope.purchaseProductQty.push(angular.element(value).val());
                            });

                            angular.forEach(angular.element("input[name='purchase-product-price[]']"), function (value, key) {
                                $scope.purchaseProductPrice.push(angular.element(value).val());
                            });

                            angular.forEach(angular.element("input[name='purchase-product-type[]']"), function (value, key) {
                                $scope.purchaseProductType.push(angular.element(value).val());
                            });

                            angular.forEach(angular.element("input[name='purchase-product-supplier[]']"), function (value, key) {
                                $scope.purchaseProductSupplier.push(angular.element(value).val());
                            });

                            $scope.loader = true;
                            $http({
                                method: "POST",
                                url: "/POS/holdClosePurchase",
                                data: {
                                    id: $scope.purchaseId,
                                    productId: $scope.purchaseProductId,
                                    productQty: $scope.purchaseProductQty,
                                    productPrice: $scope.purchaseProductPrice,
                                    productType: $scope.purchaseProductType,
                                    productSupplier: $scope.purchaseProductSupplier,
                                    total: $scope.purchaseTotal,
                                    status: status
                                }
                            }).then(function successCallback(result) {
                                $scope.loader = false;
                                if (result.data == "success") {
                                    swal({
                                        title: "Success",
                                        text: text,
                                        type: "success",
                                    }, function () {
                                        if (status == "Close")
                                            window.location.href = "/POS/purchase_complete";
                                        else if (angular.element("#purchase-edit-identifier").length)
                                            window.location.href = $scope.purchaseId;
                                        else
                                            window.location.href = "purchase_add";
                                    });
                                }
                            }, function errorCallback(result) {
                                $scope.loader = false;
                                swal({
                                    title: "Warning",
                                    text: "Connection Timeout, Please Try Again!",
                                    type: "warning",
                                });
                            });
                        } else {
                            swal({
                                title: "Warning",
                                text: "Please Add Products First!",
                                type: "warning",
                            });
                        }
                    });
                }

                $scope.purchases = [];
                $scope.purchaseLoader = false;

                $scope.getMoreCompletePurchases = function () {
                    var offset = angular.element(".purchase").length;
                    if (offset % 10 == 0) {
                        if (!$scope.purchaseLoader) {
                            $scope.purchaseLoader = true;

                            var sv = angular.element("#purchase-sv").val();
                            var sc = angular.element("#purchase-sc").val();

                            $http({
                                method: "GET",
                                url: "getMoreCompletePurchases?sv=" + sv + "&sc=" + sc + "&offset=" + offset,
                                headers: {
                                    "Content-Type": "application/json"
                                }
                            }).then(function successCallback(response) {
                                if (response.data.length > 0) {
                                    for (var i in response.data) {
                                        $scope.purchases.push({
                                            id: response.data[i].id,
                                            admin: response.data[i].admin,
                                            total_qty: response.data[i].total_qty,
                                            total: response.data[i].total
                                        });
                                    }
                                }
                                $scope.purchaseLoader = false;
                            }, function errorCallback(response) {
                                $scope.purchaseLoader = false;
                                getMoreCompletePurchases();
                            });
                        }
                    } else
                        angular.element(".purchase-content").unbind("scroll");
                }

                $scope.printPurchase = function () {
                    var printContents = document.getElementById("purchase-print-element").innerHTML;
                    var popupWin = window.open('', '_blank', 'width=800,height=600');
                    popupWin.document.open();
                    popupWin.document.write(
                            '<html>' +
                            '<head>' +
                            '<link rel="stylesheet" type="text/css" href="/POS/css/index.css" />' +
                            '<link rel="stylesheet" type="text/css" href="/POS/css/materialize.css" />' +
                            '</head>' +
                            '<body onload="window.print()">' +
                            '<div style="width:100%;">' +
                            printContents +
                            '</div>' +
                            '</body>' +
                            '</html>'
                            );
                    popupWin.document.close();
                }

                $scope.generatePurchaseReport = function () {
                    var startDate = angular.element("#purchase-report-start-date").val();
                    var endDate = angular.element("#purchase-report-end-date").val();

                    if (startDate && endDate) {
                        if (Date.parse(startDate) <= Date.parse(endDate)) {
                            $scope.loader = true;
                            $http({
                                method: "GET",
                                url: "generatePurchaseReport?startDate=" + startDate + "&endDate=" + endDate,
                                headers: {
                                    "Content-Type": "application/json"
                                }
                            }).then(function successCallback(response) {
                                if (response.data.length > 0) {
                                    angular.element("#purchase-report-content").html(
                                            '<div id="purchase-report-print-element">' +
                                            '<div class="center-align" id="purchase-report-header">' +
                                            '<div id="purchase-report-title" style="font-size:2em;">' +
                                            settings.name + ' Purchase Report</h4>' +
                                            '</div>' +
                                            '<div id="purchase-report-date" style="padding:5px;">' +
                                            moment(startDate).format('ll') + ' - ' + moment(endDate).format('ll') +
                                            '</div>' +
                                            '<div class="divider" style="margin:5px 0 5px 0;"></div>' +
                                            '<table class="centered striped" id="purchase-report-table" width="100%">' +
                                            '<thead>' +
                                            '<tr>' +
                                            '<th>ID</th>' +
                                            '<th>Admin</th>' +
                                            '<th>Total Qty</th>' +
                                            '<th>Total Price</th>' +
                                            '<th>Created</th>' +
                                            '</tr>' +
                                            '</thead>' +
                                            '<tbody>' +
                                            '</tbody>' +
                                            '</table>' +
                                            '<div class="divider" style="margin:5px 0 5px 0;"></div>' +
                                            '</div>' +
                                            '</div>'
                                            );
                                    for (var i in response.data) {
                                        angular.element("#purchase-report-table tbody").append(
                                                '<tr>' +
                                                '<td>' + response.data[i].id + '</td>' +
                                                '<td>' + response.data[i].admin + '</td>' +
                                                '<td>' + $filter('number')(response.data[i].total_qty) + '</td>' +
                                                '<td>' + $filter('number')(response.data[i].total) + '</td>' +
                                                '<td>' + moment(response.data[i].Created).format('LLL') + '</td>' +
                                                '</tr>'
                                                );
                                    }
                                } else {
                                    angular.element("#purchase-report-content").html('No Result.');
                                }

                                $scope.loader = false;
                            }, function errorCallback(response) {
                                $scope.loader = false;
                                swal({
                                    title: "Warning",
                                    text: "Connection Timeout, Please Try Again!",
                                    type: "warning",
                                });
                            });
                        } else {
                            swal({
                                title: "Warning",
                                text: "Start Date Must Be Less Than or Equal End Date!",
                                type: "warning",
                            });
                        }
                    } else {
                        swal({
                            title: "Warning",
                            text: "Please Set Start Date and End Date of Report First!",
                            type: "warning",
                        });
                    }
                }

                $scope.printPurchaseReport = function () {
                    if (angular.element("#purchase-report-content").html().trim() == "No Result.") {
                        swal({
                            title: "Warning",
                            text: "No Result!",
                            type: "warning",
                        });
                    } else {
                        var printContents = document.getElementById("purchase-report-print-element").innerHTML;
                        var popupWin = window.open('', '_blank', 'width=800,height=600');
                        popupWin.document.open();
                        popupWin.document.write(
                                '<html>' +
                                '<head>' +
                                '<link rel="stylesheet" type="text/css" href="/POS/css/index.css" />' +
                                '<link rel="stylesheet" type="text/css" href="/POS/css/materialize.css" />' +
                                '</head>' +
                                '<body onload="window.print()">' +
                                '<div style="width:100%;text-align:center;">' +
                                printContents +
                                '</div>' +
                                '</body>' +
                                '</html>'
                                );
                        popupWin.document.close();
                    }
                }

                //Products
                $scope.editProduct = function (id) {
                    window.location.href = "products_edit/" + id;
                }

                $scope.removeProduct = function (id) {
                    swal({
                        title: "Are you sure?", type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, remove it!"
                    },
                    function () {
                        $scope.loader = true;
                        $http({
                            method: "POST",
                            url: "removeProduct",
                            data: {
                                id: id
                            }
                        }).then(function successCallback(result) {
                            $scope.loader = false;
                            if (result.data == "success") {
                                swal({
                                    title: "Success",
                                    text: "Product Removed.",
                                    type: "success",
                                }, function () {
                                    window.location.href = "products";
                                });
                            } else {
                                swal({
                                    title: "Error",
                                    text: "Product Has Been Attached To Purchase or Sales History!",
                                    type: "error",
                                });
                            }
                        }, function errorCallback(result) {
                            $scope.loader = false;
                            swal({
                                title: "Warning",
                                text: "Connection Timeout, Please Try Again!",
                                type: "warning",
                            });
                        });
                    });
                }

                $scope.products = [];
                $scope.productsLoader = false;
                $scope.getMoreProducts = function () {
                    var offset = angular.element(".product").length;
                    if (offset % 10 == 0) {
                        if (!$scope.productsLoader) {
                            $scope.productsLoader = true;

                            var sv = angular.element("#product-sv").val();
                            var sc = angular.element("#product-sc").val();

                            $http({
                                method: "GET",
                                url: "getMoreProducts?sv=" + sv + "&sc=" + sc + "&offset=" + offset,
                                headers: {
                                    "Content-Type": "application/json"
                                }
                            }).then(function successCallback(response) {
                                if (response.data.length > 0) {
                                    var image;
                                    for (var i in response.data) {
                                        if (response.data[i].image)
                                            image = 'img/product/' + response.data[i].image;
                                        else
                                            image = 'img/product/product_default.jpg';

                                        $scope.products.push({
                                            id: response.data[i].id,
                                            image: image,
                                            sku: response.data[i].sku,
                                            name: response.data[i].name,
                                            purchase_price: response.data[i].purchase_price,
                                            retail_price: response.data[i].retail_price,
                                            stock: response.data[i].stock,
                                            ingredients: response.data[i].ingredients,
                                            category_name: response.data[i].category_name
                                        });
                                    }
                                }
                                $scope.productsLoader = false;
                            }, function errorCallback(response) {
                                $scope.productsLoader = false;
                                getMoreProducts();
                            });
                        }
                    } else
                        angular.element(".product-content").unbind("scroll");
                }

                $scope.editProductIngredientsFilter = function (val) {
                    angular.forEach(angular.element(".edit-product-ingredient"), function (value, key) {
                        var name = angular.element(value).find(".edit-product-ingredient-name").text().toLowerCase();

                        if (name.indexOf(val.toLowerCase()) == -1)
                            angular.element(value).addClass("hide");
                        else
                            angular.element(value).removeClass("hide");
                    });
                }

                $scope.addProductIngredient = function (id) {
                    if (angular.element("#" + id + "-qty").length) {
                        var val = parseInt(angular.element("#" + id + "-qty").val()) + 1;
                        angular.element("#" + id + "-qty").val(val);
                    } else {
                        var content, name, unit, qty = 1;
                        name = angular.element("." + id + "-name").text();
                        unit = angular.element("." + id + "-unit").text();

                        content =
                                '<tr id="' + id + '-ingredient">' +
                                '<td width="25%">' +
                                '<input ' +
                                'type="hidden" ' +
                                'name="ingredient-id[]" ' +
                                'value="' + id + '"/>' +
                                name +
                                '</td>' +
                                '<td width="25%">' +
                                '<input ' +
                                'id="' + id + '-qty"' +
                                'type="number" ' +
                                'name="ingredient-qty[]" ' +
                                'value="' + qty + '"' +
                                'style="width:50%;text-align:center;"/>' +
                                '</td>' +
                                '<td width="25%">' +
                                unit +
                                '</td>' +
                                '<td width="25%">' +
                                '<div class="edit-product-ingredients-remove-btn" ' +
                                'ng-click="removeProductIngredient(\'' + id + '\');">' +
                                '<i class="fa fa-times"></i> Remove' +
                                '</div>' +
                                '</td>' +
                                '</tr>';

                        angular.element(".edit-product-ingredients-assigned table").append($compile(content)($scope));
                    }
                }

                $scope.removeProductIngredient = function (id) {
                    angular.element("#" + id + "-ingredient").remove();
                }

                $scope.generateProductsReport = function () {
                    var startDate = angular.element("#products-report-start-date").val();
                    var endDate = angular.element("#products-report-end-date").val();
                    var category = angular.element("#products-report-category").val();
                    var categoryName = angular.element("#products-report-category option:selected").text();

                    if (startDate && endDate) {
                        if (Date.parse(startDate) <= Date.parse(endDate)) {
                            $scope.loader = true;
                            $http({
                                method: "GET",
                                url: "generateProductsReport?startDate=" + startDate + "&endDate=" + endDate + "&category=" + category,
                                headers: {
                                    "Content-Type": "application/json"
                                }
                            }).then(function successCallback(response) {
                                if (response.data.length > 0) {
                                    angular.element("#products-report-content").html(
                                            '<div id="products-report-print-element">' +
                                            '<div class="center-align" id="products-report-header">' +
                                            '<div id="products-report-title" style="font-size:2em;">' +
                                            settings.name + ' Products Report</h4>' +
                                            '</div>' +
                                            '<div id="products-report-category" style="padding:5px;">Category: ' + categoryName + '</div>' +
                                            '<div id="products-report-date" style="padding:5px;">' +
                                            moment(startDate).format('ll') + ' - ' + moment(endDate).format('ll') +
                                            '</div>' +
                                            '<div class="divider" style="margin:5px 0 5px 0;"></div>' +
                                            '<table class="centered striped" id="products-report-table" width="100%">' +
                                            '<thead>' +
                                            '<tr>' +
                                            '<th>SKU</th>' +
                                            '<th>Name</th>' +
                                            '<th>Total Sold Qty</th>' +
                                            '<th>Total Sold Price (-%Discounts)</th>' +
                                            '</tr>' +
                                            '</thead>' +
                                            '<tbody>' +
                                            '</tbody>' +
                                            '</table>' +
                                            '<div class="divider" style="margin:5px 0 5px 0;"></div>' +
                                            '</div>' +
                                            '</div>'
                                            );
                                    for (var i in response.data) {
                                        angular.element("#products-report-table tbody").append(
                                                '<tr>' +
                                                '<td>' + response.data[i].sku + '</td>' +
                                                '<td>' + response.data[i].name + '</td>' +
                                                '<td>' + $filter('number')(response.data[i].sold_qty) + '</td>' +
                                                '<td>' + $filter('number')(response.data[i].sold_price) + '</td>' +
                                                '</tr>'
                                                );
                                    }
                                } else {
                                    angular.element("#products-report-content").html('No Result.');
                                }

                                $scope.loader = false;
                            }, function errorCallback(response) {
                                $scope.loader = false;
                                swal({
                                    title: "Warning",
                                    text: "Connection Timeout, Please Try Again!",
                                    type: "warning",
                                });
                            });
                        } else {
                            swal({
                                title: "Warning",
                                text: "Start Date Must Be Less Than or Equal End Date!",
                                type: "warning",
                            });
                        }
                    } else {
                        swal({
                            title: "Warning",
                            text: "Please Set Start Date and End Date of Report First!",
                            type: "warning",
                        });
                    }
                }

                $scope.printProductsReport = function () {
                    if (angular.element("#products-report-content").html().trim() == "No Result.") {
                        swal({
                            title: "Warning",
                            text: "No Result!",
                            type: "warning",
                        });
                    } else {
                        var printContents = document.getElementById("products-report-print-element").innerHTML;
                        var popupWin = window.open('', '_blank', 'width=800,height=600');
                        popupWin.document.open();
                        popupWin.document.write(
                                '<html>' +
                                '<head>' +
                                '<link rel="stylesheet" type="text/css" href="/POS/css/index.css" />' +
                                '<link rel="stylesheet" type="text/css" href="/POS/css/materialize.css" />' +
                                '</head>' +
                                '<body onload="window.print()">' +
                                '<div style="width:100%;text-align:center;">' +
                                printContents +
                                '</div>' +
                                '</body>' +
                                '</html>'
                                );
                        popupWin.document.close();
                    }
                }

                //Suppliers
                $scope.editSupplier = function (id) {
                    window.location.href = "suppliers_edit/" + id;
                }

                $scope.removeSupplier = function (id) {
                    swal({
                        title: "Are you sure?", type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, remove it!"
                    },
                    function () {
                        $scope.loader = true;
                        $http({
                            method: "POST",
                            url: "removeSupplier",
                            data: {
                                id: id
                            }
                        }).then(function successCallback(result) {
                            $scope.loader = false;
                            if (result.data == "success") {
                                swal({
                                    title: "Success",
                                    text: "Supplier Removed.",
                                    type: "success",
                                }, function () {
                                    window.location.href = "suppliers";
                                });
                            } else {
                                swal({
                                    title: "Error",
                                    text: "Supplier Has Been Attached To Purchase History or Ingredients!",
                                    type: "error",
                                });
                            }
                        }, function errorCallback(result) {
                            $scope.loader = false;
                            swal({
                                title: "Warning",
                                text: "Connection Timeout, Please Try Again!",
                                type: "warning",
                            });
                        });
                    });
                }

                $scope.suppliers = [];
                $scope.suppliersLoader = false;
                $scope.getMoreSuppliers = function () {
                    var offset = angular.element(".supplier").length;
                    if (offset % 10 == 0) {
                        if (!$scope.suppliersLoader) {
                            $scope.suppliersLoader = true;

                            var sv = angular.element("#supplier-sv").val();
                            var sc = angular.element("#supplier-sc").val();

                            $http({
                                method: "GET",
                                url: "getMoreSuppliers?sv=" + sv + "&sc=" + sc + "&offset=" + offset,
                                headers: {
                                    "Content-Type": "application/json"
                                }
                            }).then(function successCallback(response) {
                                if (response.data.length > 0) {
                                    for (var i in response.data) {
                                        $scope.suppliers.push({
                                            id: response.data[i].id,
                                            name: response.data[i].name,
                                            address: response.data[i].address,
                                            phone: response.data[i].phone,
                                            email: response.data[i].email
                                        });
                                    }
                                }
                                $scope.suppliersLoader = false;
                            }, function errorCallback(response) {
                                $scope.suppliersLoader = false;
                                getMoreSuppliers();
                            });
                        }
                    } else
                        angular.element(".supplier-content").unbind("scroll");
                }

                // Customers
                $scope.editCustomer = function (username) {
                    window.location.href = "customers_edit/" + username;
                }

                $scope.removeCustomer = function (username) {
                    swal({
                        title: "Are you sure?", type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, remove it!"
                    },
                    function () {
                        $scope.loader = true;
                        $http({
                            method: "POST",
                            url: "removeCustomer",
                            data: {
                                username: username
                            }
                        }).then(function successCallback(result) {
                            $scope.loader = false;
                            if (result.data == "success") {
                                swal({
                                    title: "Success",
                                    text: "Customer Removed.",
                                    type: "success",
                                }, function () {
                                    window.location.href = "customers";
                                });
                            } else {
                                swal({
                                    title: "Error",
                                    text: "Customer Has Been Attached To Sales History!",
                                    type: "error",
                                });
                            }
                        }, function errorCallback(result) {
                            $scope.loader = false;
                            swal({
                                title: "Warning",
                                text: "Connection Timeout, Please Try Again!",
                                type: "warning",
                            });
                        });
                    });
                }

                $scope.customers = [];
                $scope.customersLoader = false;
                $scope.getMoreCustomers = function () {
                    var offset = angular.element(".customer").length;
                    if (offset % 10 == 0) {
                        if (!$scope.customersLoader) {
                            $scope.customersLoader = true;

                            var sv = angular.element("#customer-sv").val();
                            var sc = angular.element("#customer-sc").val();

                            $http({
                                method: "GET",
                                url: "getMoreCustomers?sv=" + sv + "&sc=" + sc + "&offset=" + offset,
                                headers: {
                                    "Content-Type": "application/json"
                                }
                            }).then(function successCallback(response) {
                                if (response.data.length > 0) {
                                    for (var i in response.data) {
                                        $scope.customers.push({
                                            username: response.data[i].username,
                                            name: response.data[i].name,
                                            email: response.data[i].email,
                                            phone: response.data[i].phone
                                        });
                                    }
                                }
                                $scope.customersLoader = false;
                            }, function errorCallback(response) {
                                $scope.customersLoader = false;
                                getMoreSuppliers();
                            });
                        }
                    } else
                        angular.element(".customer-content").unbind("scroll");
                }

                // Ingredients
                $scope.editIngredient = function (id) {
                    window.location.href = "ingredients_edit/" + id;
                }

                $scope.removeIngredient = function (id) {
                    swal({
                        title: "Are you sure?", type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, remove it!"
                    },
                    function () {
                        $scope.loader = true;
                        $http({
                            method: "POST",
                            url: "removeIngredient",
                            data: {
                                id: id
                            }
                        }).then(function successCallback(result) {
                            $scope.loader = false;
                            if (result.data == "success") {
                                swal({
                                    title: "Success",
                                    text: "Ingredient Removed.",
                                    type: "success",
                                }, function () {
                                    window.location.href = "ingredients";
                                });
                            } else {
                                swal({
                                    title: "Error",
                                    text: "Ingredient Has Been Attached To Product!",
                                    type: "error",
                                });
                            }
                        }, function errorCallback(result) {
                            $scope.loader = false;
                            swal({
                                title: "Warning",
                                text: "Connection Timeout, Please Try Again!",
                                type: "warning",
                            });
                        });
                    });
                }

                // Categories
                $scope.rpc = function (id) {
                    swal({
                        title: "Are you sure?", type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, remove it!"
                    },
                    function () {
                        $scope.loader = true;
                        $http({
                            method: "POST",
                            url: "removeProductCategory",
                            data: {
                                id: id
                            }
                        }).then(function successCallback(result) {
                            $scope.loader = false;
                            if (result.data == "success") {
                                swal({
                                    title: "Success",
                                    text: "Category Removed.",
                                    type: "success",
                                }, function () {
                                    window.location.href = "categories";
                                });
                            } else {
                                swal({
                                    title: "Error",
                                    text: "Category Has Been Attached To Products.",
                                    type: "error",
                                });
                            }
                        }, function errorCallback(result) {
                            $scope.loader = false;
                            swal({
                                title: "Warning",
                                text: "Connection Timeout, Please Try Again!",
                                type: "warning",
                            });
                        });
                    });
                }

                $scope.rpm = function (id) {
                    swal({
                        title: "Are you sure?", type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, remove it!"
                    },
                    function () {
                        $scope.loader = true;
                        $http({
                            method: "POST",
                            url: "removeProductUnit",
                            data: {
                                id: id
                            }
                        }).then(function successCallback(result) {
                            $scope.loader = false;
                            if (result.data == "success") {
                                swal({
                                    title: "Success",
                                    text: "Unit Type Removed.",
                                    type: "success",
                                }, function () {
                                    window.location.href = "categories";
                                });
                            } else {
                                swal({
                                    title: "Error",
                                    text: "Unit of Unit Has Been Attached To Products.",
                                    type: "error",
                                });
                            }
                        }, function errorCallback(result) {
                            $scope.loader = false;
                            swal({
                                title: "Warning",
                                text: "Connection Timeout, Please Try Again!",
                                type: "warning",
                            });
                        });
                    });
                }

                //Accounts
                $scope.removeAccount = function (username) {
                    swal({
                        title: "Are you sure?", type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, remove it!"
                    },
                    function () {
                        $scope.loader = true;
                        $http({
                            method: "POST",
                            url: "removeAccount",
                            data: {
                                username: username
                            }
                        }).then(function successCallback(result) {
                            $scope.loader = false;
                            if (result.data == "success") {
                                swal({
                                    title: "Success",
                                    text: "Account Removed.",
                                    type: "success",
                                }, function () {
                                    window.location.href = "accounts";
                                });
                            } else {
                                swal({
                                    title: "Error",
                                    text: "Account Has Been Attached To Sales or Purchase History!",
                                    type: "error",
                                });
                            }
                        }, function errorCallback(result) {
                            $scope.loader = false;
                            swal({
                                title: "Warning",
                                text: "Connection Timeout, Please Try Again!",
                                type: "warning",
                            });
                        });
                    });
                }

                //Settings
                var settings = {};
                $http({
                    method: "GET",
                    url: "/POS/js/json/settings.json",
                    headers: {
                        "Content-Type": "application/json"
                    }
                }).then(function successCallback(response) {
                    var data = response.data;
                    settings.name = data.name;
                    settings.address = data.address;
                    settings.phone = data.phone;
                    settings.receipt_text = data.receipt_text;

                    angular.element(".company-name").text(settings.name);
                    angular.element(".company-address").text(settings.address);
                    angular.element(".company-phone").text(settings.phone);

                    angular.element("input[name='settings-name']").val(settings.name);
                    angular.element("input[name='settings-name']").next().addClass('active');

                    angular.element("input[name='settings-address']").val(settings.address);
                    angular.element("input[name='settings-address']").next().addClass('active');

                    angular.element("input[name='settings-phone']").val(settings.phone);
                    angular.element("input[name='settings-phone']").next().addClass('active');

                    angular.element("textarea[name='settings-receipt-text']").val(settings.receipt_text.replace(/<br\s*\/?>/mg, ""));
                    angular.element("textarea[name='settings-receipt-text']").next().addClass('active');
                });
            }]);

angular.module("myApp").directive("whenScrolled", function () {
    return{
        restrict: "A",
        link: function (scope, elem, attrs) {

            // we get a list of elements of size 1 and need the first element
            raw = elem[0];

            // we load more elements when scrolled past a limit
            elem.bind("scroll", function () {
                if (raw.scrollTop + raw.offsetHeight + 5 >= raw.scrollHeight) {
                    scope.loading = true;

                    // we can give any function which loads more elements into the list
                    scope.$apply(attrs.whenScrolled);
                }
            });
        }
    }
});

