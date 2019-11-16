<?php

function orderProvinces($provinces, $send2, $successSend2)
{
    foreach($provinces as &$province)
    {
        $total = number_format($send2->where('province_id', $province->id)->count() + $send2->where('province_id', $province->id)->count() - $send2->where('province_id', $province->id)->count() + $successSend2->where('province_id', $province->id)->count() + $successSend2->where('province_id', $province->id)->count() - $successSend2->where('province_id', $province->id)->count());
        $province['sort_total'] = $total;
    }
    return $provinces->sortByDesc('sort_total');
}
