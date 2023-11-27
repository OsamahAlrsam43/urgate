<!DOCTYPE html>
<html lang="ar">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        html, body {
            font-family: 'XB Riyaz', sans-serif;
            direction: rtl;
            text-align: right;
        }

        strong {
            font-weight: bold;
        }

        th {
            text-align: center;
            padding: 5px;
            font-size: 12px;
        }

        table.minimalistBlack {
            border: 2px solid #000000;
            width: 100%;
            border-collapse: collapse;
        }

        table.minimalistBlack td, table.minimalistBlack th {
            border: 1px solid #000000;
            padding: 5px 4px;
        }

        table.minimalistBlack tbody td {
            font-size: 13px;
            text-align: center;
            padding: 5px;
        }

        table.minimalistBlack thead {
            -webkit-print-color-adjust: exact;
            border-bottom: 2px solid #000000;
        }

        table.minimalistBlack thead th {
            background-color: #CFCFCF;
            font-weight: bold;
            color: #000000;
        }

        table.minimalistBlack tfoot {
            font-weight: bold;
            color: #000000;
            border-top: 3px solid #000000;
        }

        table.minimalistBlack tfoot td {
            font-size: 14px;
        }

        .table {
            border: 1px solid #333;
        }

        .table td {
            border: 1px solid #333;
            padding: 0 10px;
        }

        @page {
            header: page-header;
            footer: page-footer;
            margin-top: 6cm;
            margin-bottom: 3cm;
        }

        .footer-div {
            padding: 5px 10px;
            border-bottom: 1px solid #fff;
            margin-bottom: 20px;
            position: absolute;
            bottom: 40px;
            background-color: #062841;
            left: 1.5cm;
            right: 1.5cm;
        }

        .footer-div td {
            font-size: 13px;
        }

        .footer-owner {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 13px;
        }

        .copyright {
            border: 2px dashed #535353;
            font-weight: bold;
            position: absolute;
            bottom: 10px;
            left: 1.5cm;
            text-align: center;
            padding: 0 10px;
            font-size: 12px;
        }

        .copyright2 {
            position: absolute;
            bottom: 10px;
            right: 1.5cm;
            direction: ltr;
        }

        .outer_proxy {
            top: 18cm;
            left: 0;
            bottom: 0;
            right: 0;
            position: fixed;
            text-align: center;
        }
    </style>
</head>
<body>

<?php
$from = Request()->get("from");
$to = Request()->get("to");
?>

<htmlpageheader name="page-header">
    <div class="outer_proxy">
        <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('custom/images/avatar.jpg') }}"
             alt=""
             style="width: 300px;opacity: 0.15;"/>
    </div>

    <div style="clear:both; position:absolute;left:1.5cm;right:1.5cm;">
        <table width="100%">
            <tr>
                <td></td>
                <td width="100">
                    <img class="img-rounded"
                         src="{{ $user->avatar ? url('/storage/app/public/custom/images/'.$user->avatar ) : url('/storage/app/public/custom/images/avatar.jpg') }}"
                         alt=""
                         style="width: 100px;float: left;"/>
                </td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td width="60%">
                    <table class="table">
                        <tr>
                            <td style="text-align: center;background-color: #072439;color: #fff;font-size: 16px;padding: 2px 5px;">
                                <strong>من تاريخ: </strong></td>
                            <td>{{ $from }}</td>
                            <td style="text-align: center;background-color: #072439;color: #fff;font-size: 16px;padding: 2px 5px;">
                                <strong>الي تاريخ: </strong></td>
                            <td>{{ $to }}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table class="table" style="width: 100%;">
                        <tr>
                            <td style="text-align: center;background-color: #072439">
                                <strong style="color: #fff;font-size: 18px;">كشف حساب</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding: 5px;">
                                <strong>{{ $invoice->id }} - {{$invoice->company}}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <br/>
</htmlpageheader>

<table class="minimalistBlack">
    <thead>
    <tr>
        <th width="70">رقم الوصل</th>
        <th width="100">تاريخ الوصل</th>
        <th width="100">نوع الوصل</th>
        <th width="60">مدين</th>
        <th width="60">دائن</th>
        <th width="60">الرصيد</th>
        <th>التفاصيل</th>
    </tr>
    </thead>
    <tbody>
	<?php
	$i = 1;
	$types = [
		'debitor'  => 'دفع',
		'creditor' => 'سند قبض',
		'credit'   => 'رصيد سابق',
	];
	$totalDebtor = $totalCreditor = $totalCredit = 0;
	?>
    @foreach ($items as $item)
        <?php
        if($item->item_type == 'debitor') {
        	$totalDebtor += $item->credit;
        } elseif ($item->item_type == 'creditor'){
	        $totalCreditor += $item->credit;
        }

        $totalCredit = $item->credit_after;
        ?>

        @if(strtotime($item->date) >= strtotime($from) and strtotime($item->date) <= strtotime($to))
        <tr>
            <td>
                {{ str_pad($i, 4, '0', STR_PAD_LEFT) }}
            </td>
            <td>
                {{ $item->date }}
            </td>
            <td>
                {{ $types[$item->item_type] }}
            </td>
            <td>
                {{ $item->item_type == 'debitor' ? $item->credit : 0 }}
            </td>
            <td>
                {{ $item->item_type == 'creditor' ? $item->credit : 0 }}
            </td>
            <td>
                {{ $item->credit_after }}
            </td>
            <td>
                {{ $item->details }}
            </td>
        </tr>
		<?php $i ++ ?>
        @endif
    @endforeach
    <tr>
        <td colspan="3"><strong>المجموع</strong></td>
        <td>{{ $totalDebtor }}</td>
        <td>{{ $totalCreditor }}</td>
        <td>{{ $totalCredit }}</td>
        <td></td>
    </tr>
    </tbody>
</table>


<htmlpagefooter name="page-footer">
    <div class="footer-div">
        <table width="100%">
            <tr>
                <td width="33%" style="color: #fff;text-align: right;font-size: 13px;">عنوان: {{$user->address}}</td>
                <td width="33%" style="color: #fff;text-align: center;font-size: 13px;">تليفون: {{$user->phone}}</td>
                <td width="33%" style="color: #fff;text-align: left;font-size: 13px;">ايميل: {{$user->email}}</td>
            </tr>
        </table>
    </div>
    <div class="footer-owner">
        <div>{PAGENO}</div>
    </div>
    <div class="copyright">مجموعة النخيل والتيسير<br/> للسياحه والسفر</div>
    <div class="copyright2">{{date('d/m/Y h:i A')}}</div>
</htmlpagefooter>
</body>
</html>