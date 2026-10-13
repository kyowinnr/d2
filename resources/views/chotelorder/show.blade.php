<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>訂單詳細</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        th {
            background-color: #f1f3f5;
            white-space: nowrap;
        }
        td {
            word-break: break-word;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="card shadow mb-4">
        @php
            $activityClass = match($order->Activity) {
                1 => 'bg-success',   // 綠色
                2 => 'bg-warning',   // 黃色
                3 => 'bg-danger',    // 紅色
                4 => 'bg-info',      // 橘色（需自定義）
                default => 'bg-secondary'
            };
        @endphp

        <div class="card-header {{ $activityClass }} text-white">
            <h4 class="mb-0">訂單細節</h4>
        </div>

        <form method="POST" action="{{ route('chotelorder.update', $order->Cid) }}" class="card-body table-responsive">
            @csrf
            @method('PUT')

            <table class="table table-bordered align-middle">
                <tbody>
                    <tr>
                        <th>活動</th>
                        <td>
                            <select name="Activity" class="form-select">
                                <option value="1" {{ $order->Activity == 1 ? 'selected' : '' }}>綠原+一日遊</option>
                                <option value="2" {{ $order->Activity == 2 ? 'selected' : '' }}>仙境+一日遊</option>
                                <option value="3" {{ $order->Activity == 3 ? 'selected' : '' }}>一日遊A 瑞德巖進出</option>
                                <option value="4" {{ $order->Activity == 4 ? 'selected' : '' }}>一日遊B 綠原進出</option>
                            </select>
                        </td>
                        <th>狀態</th>
                        <td>
                          <select name="CloseType" class="form-select">
                            <option value="0" {{ $order->CloseType == 0 ? 'selected' : '' }}>處理中</option>
                            <option value="1" {{ $order->CloseType == 1 ? 'selected' : '' }}>已收訂</option>
                            <option value="2" {{ $order->CloseType == 2 ? 'selected' : '' }}>已完成</option>
                            <option value="3" {{ $order->CloseType == 3 ? 'selected' : '' }}>已取消</option>
                          </select>
                        </td>
                    </tr>
                    <tr>
                        <th>團體名稱</th>
                        <td><input type="text" name="GroupName" class="form-control" value="{{ $order->GroupName }}"></td>
                        <th>客群</th>
                        <td><input type="text" name="Target" class="form-control" value="{{ $order->Target }}"></td>
                    </tr>
                    <tr>
                        <th>聯絡人</th>
                        <td><input type="text" name="Customer" class="form-control" value="{{ $order->Customer }}"></td>
                        <th>電話</th>
                        <td><input type="text" name="Phone" class="form-control" value="{{ $order->Phone }}"></td>
                    </tr>
                    <tr>
                        <th>會員編號</th>
                        <td><input type="text" name="Ins" class="form-control" value="{{ $order->Ins }}"></td>
                        <th>人數</th>
                        <td><input type="number" name="Num" class="form-control" value="{{ $order->Num }}"></td>
                    </tr>
                    <tr>
                        <th>特殊優惠</th>
                        @php
    $discounts = ['免門票', '免費住宿'];
@endphp

<td colspan="3">
    @foreach ($discounts as $item)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="Discounts[]" value="{{ $item }}"
                {{ str_contains($order->Discount, $item) ? 'checked' : '' }}>
            <label class="form-check-label">{{ $item }}</label>
        </div>
    @endforeach
</td>

                    </tr>
                    <tr>
                        <th>住宿日期</th>
                        <td><input type="date" name="HotelDate" class="form-control" value="{{ $order->HotelDate }}"></td>
                        <th>行程日期</th>
                        <td><input type="date" name="TourDate" class="form-control" value="{{ $order->TourDate }}"></td>
                    </tr>
                    <tr>
                        <th>訂金</th>
                        <td><input type="number" name="Deposit" class="form-control" value="{{ $order->Deposit }}"></td>
                        <th>訂金期限</th>
                        <td><input type="date" name="DateLine" class="form-control" value="{{ $order->DateLine }}"></td>
                    </tr>
                    <tr>
                        <th rowspan="2">房間數</th>
                        <td>雙人房</td>
                        <td>三人房</td>
                        <td>四人房</td>
                    </tr>
                    <tr>
                        <td><input type="number" name="S2" class="form-control" value="{{ $order->S2 }}"></td>
                        <td><input type="number" name="T3" class="form-control" value="{{ $order->T3 }}"></td>
                        <td><input type="number" name="T4" class="form-control" value="{{ $order->T4 }}"></td>
                    </tr>
                    <tr>
                        <th>備註</th>
                        <td colspan="3"><textarea name="Ps" class="form-control" rows="3">{{ $order->Ps }}</textarea></td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">儲存變更</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

