<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Purchase extends Model {

    protected $table = 'purchase';
    public $incrementing = false;
    public $primarykey = 'id';
    public $timestamps = false;

    public static function getNextPurchaseId() {
        $id = Purchase::selectRaw('CONVERT(SUBSTRING_INDEX(id,"P",-1),UNSIGNED INTEGER) + 1 AS id')
                ->orderBy('id', 'desc')
                ->limit(1)
                ->get();
        if (count($id) > 0)
            return substr('00000' . $id[0]->id, -6);
        else
            return '000001';
    }

    public static function holdClosePurchase($purchase) {
        if (User::checkToken(session('username'), session('token'))) {
            $oldPurchase = Purchase::find($purchase['id']);
            if (!is_null($oldPurchase))
                $oldPurchase->delete();

            $newPurchase = new Purchase;
            $newPurchase->id = $purchase['id'];
            $newPurchase->admin = session('username');
            $newPurchase->total_qty = array_sum($purchase['productQty']);
            $newPurchase->total = implode("", explode(",", $purchase['total']));
            $newPurchase->status = $purchase['status'];

            $newPurchase->save();

            $php = array();
            for ($i = 0; $i < count($purchase['productId']); $i++) {
                $php[] = array(
                    'purchase_id' => $purchase['id'],
                    'supplier_id' => $purchase['productSupplier'][$i],
                    'product_id' => $purchase['productId'][$i],
                    'type' => $purchase['productType'][$i],
                    'qty' => $purchase['productQty'][$i],
                    'price' => $purchase['productPrice'][$i]
                );

                if ($purchase['status'] == 'Close') {
                    if ($purchase['productType'][$i] == "0") {
                        DB::update(
                                'UPDATE ingredient 
                             SET qty = qty + ?
                             WHERE id = ?', [$purchase['productQty'][$i], $purchase['productId'][$i]]
                        );
                    } else {
                        DB::update(
                                'UPDATE product 
                             SET stock = stock + ?
                             WHERE id = ?', [$purchase['productQty'][$i], $purchase['productId'][$i]]
                        );
                    }
                }
            }

            DB::table('purchase_has_product')->insert($php);
        }
    }

    public static function getPendingPurchases() {
        $purchase = Purchase::where('status', '=', 'Hold')->get();
        return $purchase;
    }

    public static function getCompletePurchases($offset, $sv, $sc) {
        if (is_null($sv) && is_null($sc)) {
            $purchase = Purchase::where('status', '=', 'Close')
                            ->orderBy('id')
                            ->offset($offset)->limit(10)->get();
        } else {
            $purchase = Purchase::where([
                                [$sc, 'like', '%' . $sv . '%'],
                                ['status', '=', 'Close']
                            ])
                            ->orderBy('id')
                            ->offset($offset)->limit(10)->get();
        }
        return $purchase;
    }

    public static function getPurchaseData($id) {
        $purchase = DB::table('purchase')->selectRaw("  
                    *, id AS pid,
                    (SELECT
                         CONCAT_WS('||',
                                   GROUP_CONCAT(php.product_id),
                                   GROUP_CONCAT(php.supplier_id),
                                   GROUP_CONCAT(s.name),
                                   GROUP_CONCAT(php.qty),
                                   GROUP_CONCAT(php.price),
                                   GROUP_CONCAT(php.type),
                                   GROUP_CONCAT(IFNULL(p.name,'')),
                                   GROUP_CONCAT(IFNULL(i.name,''))
                         )
                         FROM purchase_has_product php
                         JOIN supplier s ON php.supplier_id = s.id
                         LEFT JOIN product p ON php.product_id = p.id
                         LEFT JOIN ingredient i ON php.product_id = i.id
                         WHERE php.purchase_id = pid
                    ) AS products
                ")
                ->where('id', '=', $id)
                ->get();
        return $purchase;
    }

    public static function generatePurchaseReport($startDate, $endDate) {
        $report = Purchase::where('status', '=', 'Close')
                ->whereBetween('created', [$startDate, $endDate])
                ->get();
        return $report;
    }

    public static function countPurchases() {
        $count = Purchase::selectRaw('COUNT(id) AS total')->where('status', '=', 'Close')->get();
        return $count[0]->total;
    }

    public static function getCogs($year) {
        $cogs = Purchase::selectRaw('SUM(total) AS cogs')
                ->whereRaw('YEAR(DATE(created)) = ?', $year)
                ->get();
        return $cogs[0]->cogs;
    }

    public static function getWeekPurchasing($startDay, $endDay) {
        $purchasing = Purchase::selectRaw('DATE(created) AS purchase_created, SUM(total) AS total')
                ->where('status', '=', 'Close')
                ->whereRaw('status = "Close" AND DATE(created) BETWEEN (DATE_SUB(CURDATE(), INTERVAL ' . $startDay . ' DAY)) AND (DATE_ADD(CURDATE(), INTERVAL ' . $endDay . ' DAY))')
                ->groupBy(DB::raw('DAY(created)'))
                ->get();
        return $purchasing;
    }

}
