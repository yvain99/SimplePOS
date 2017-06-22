<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Sales extends Model {

    protected $table = 'sales';
    public $incrementing = false;
    public $primarykey = 'id';
    public $timestamps = false;

    public static function getNextSalesId() {
        $id = Sales::selectRaw('CONVERT(SUBSTRING_INDEX(id,"S",-1),UNSIGNED INTEGER) + 1 AS id')
                ->orderBy('id', 'desc')
                ->limit(1)
                ->get();
        if (count($id) > 0)
            return substr('00000' . $id[0]->id, -6);
        else
            return '000001';
    }

    public static function holdCloseSales($sales) {
        if (User::checkToken(session('username'), session('token'))) {
            $newSales = new Sales;
            $newSales->id = $sales['id'];
            $newSales->total_qty = array_sum($sales['productQty']);
            $newSales->admin = session('username');
            $newSales->customer = $sales['customerUsername'];
            $newSales->discount = $sales['discount'];
            $newSales->tax = $sales['tax'];
            $newSales->subtotal = implode("", explode(",", $sales['subTotal']));
            $newSales->total = implode("", explode(",", $sales['total']));
            $newSales->payment_method = $sales['paymentMethod'];
            $newSales->payment_method_number = (empty($sales['paymentMethodNumber'])) ? null : $sales['paymentMethodNumber'];
            $newSales->description = (empty($sales['description'])) ? null : $sales['description'];
            $newSales->status = $sales['status'];

            $newSales->save();

            $shp = array();
            for ($i = 0; $i < count($sales['productId']); $i++) {
                $shp[] = array(
                    'sales_id' => $sales['id'],
                    'product_id' => $sales['productId'][$i],
                    'qty' => $sales['productQty'][$i],
                    'price' => $sales['productPrice'][$i]
                );

                $ingredientsUpdate = DB::update(
                                'UPDATE ingredient i 
                JOIN product_has_ingredient phi ON i.id = phi.ingredient_id
                SET i.qty = i.qty - (phi.qty*?)
                WHERE phi.product_id = ?', [$sales['productQty'][$i], $sales['productId'][$i]]
                );

                if ($ingredientsUpdate == 0) {
                    DB::table('product')
                            ->where('id', $sales['productId'][$i])
                            ->update(['stock' => DB::raw('stock - ' . $sales['productQty'][$i])]);
                }
            }

            DB::table('sales_has_product')->insert($shp);
        }
    }

    public static function holdCloseEditSales($sales) {
        if (User::checkToken(session('username'), session('token'))) {
            $oldProductIds = $sales['oldProductId'];
            $oldProductQtys = $sales['oldProductQty'];

            for ($i = 0; $i < count($oldProductIds); $i++) {
                $ingredientsUpdate = DB::update(
                                'UPDATE ingredient i 
                JOIN product_has_ingredient phi ON i.id = phi.ingredient_id
                SET i.qty = i.qty + (phi.qty*?)
                WHERE phi.product_id = ?', [$oldProductQtys[$i], $oldProductIds[$i]]
                );

                if ($ingredientsUpdate == 0) {
                    DB::table('product')
                            ->where('id', $oldProductIds[$i])
                            ->update(['stock' => DB::raw('stock + ' . $oldProductQtys[$i])]);
                }
            }

            $delSales = Sales::find($sales['id']);
            $delSales->delete();

            Sales::holdCloseSales($sales);
        }
    }

    public static function getPendingSales() {
        $sales = Sales::where('status', '=', 'Hold')->get();
        return $sales;
    }

    public static function getCompleteSales($offset, $sv, $sc) {
        if (is_null($sv) && is_null($sc)) {
            $sales = Sales::where('status', '=', 'Close')
                            ->orderBy('id')
                            ->offset($offset)->limit(10)->get();
        } else {
            $sales = Sales::where([
                                [$sc, 'like', '%' . $sv . '%'],
                                ['status', '=', 'Close']
                            ])
                            ->orderBy('id')
                            ->offset($offset)->limit(10)->get();
        }
        return $sales;
    }

    public static function getSalesData($id) {
        $sales = DB::table('sales AS s')->selectRaw("  
                    s.*, s.id AS sid,
                    a.name AS admin_name, 
                    c.name AS customer_name,
                    (SELECT
                        CONCAT_WS('||',
                            GROUP_CONCAT(shp.product_id),
                            GROUP_CONCAT(shp.qty),
                            GROUP_CONCAT(shp.price),
                            GROUP_CONCAT(p.name)
                        )
                     FROM sales_has_product shp
                     JOIN product p ON shp.product_id = p.id
                     WHERE shp.sales_id = sid
                    ) AS products
                ")
                ->join('user AS a', 's.admin', '=', 'a.username')
                ->join('user AS c', 's.customer', '=', 'c.username')
                ->where('s.id', '=', $id)
                ->get();
        return $sales;
    }

    public static function generateSalesReport($startDate, $endDate) {
        $report = Sales::where('status', '=', 'Close')
                ->whereBetween('created', [$startDate, $endDate])
                ->get();
        return $report;
    }

    public static function countSales() {
        $count = Sales::selectRaw('COUNT(id) AS total')->where('status', '=', 'Close')->get();
        return $count[0]->total;
    }

    public static function getTurnover($year) {
        $turnover = Sales::selectRaw('SUM(total) AS turnover')
                ->whereRaw('YEAR(DATE(created)) = ?', $year)
                ->get();
        return $turnover[0]->turnover;
    }

    public static function getWeekSelling($startDay, $endDay) {
        $selling = Sales::selectRaw('DATE(created) AS sales_created, SUM(total) AS total')
                ->whereRaw('status = "Close" AND DATE(created) BETWEEN (DATE_SUB(CURDATE(), INTERVAL ' . $startDay . ' DAY)) AND (DATE_ADD(CURDATE(), INTERVAL ' . $endDay . ' DAY))')
                ->groupBy(DB::raw('DAY(created)'))
                ->get();
        return $selling;
    }

}
