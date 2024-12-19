<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <style>
        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 0.5cm;
            }
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: end;
        }

        .text-start {
            text-align: start;
        }

        .vertical-top {
            vertical-align: baseline;
        }

        .vertical-bottom {
            vertical-align: bottom;
        }

        .f-right {
            float: right;
        }

        .main-div {
            border: 1px solid black;
        }

        .d-inline-block {
            display: inline-block;
        }

        .header-h3 {
            width: 90%;
            margin-bottom: 0;
        }

        .width-100 {
            width: 100%;
        }

        .width-100-px {
            width: 100px;
        }

        .zero-p-m {
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
        }

        .flex-container {
            display: flex;
        }

        .d-description {
            border: 0;
            display: flex;
            justify-content: space-around;
        }

        .d-description-value {
            font-size: 10px;
        }

        .d-total-amount {
            display: flex;
            justify-content: space-between;
        }

        .border-bottom {
            border-bottom: 1px solid black !important;
        }

        .p-bank-details {
            /* padding-top: 14px; */
            padding-inline-start: 20px;
            /* padding-bottom: 40px; */
        }

        .possion-relative {
            position: relative;
        }

        .authorisation-box {
            position: absolute;
            top: 0;
            right: 0;
        }

        .original-box {
            position: absolute;
            top: -14px;
            right: 0;
        }

        .position-logo {
            position: absolute;
            top: 21px;
            left: 10px;
            width: 4rem;
        }

        .f-10 {
            font-size: 1rem;
        }

        .img-qr {
            width: 150px;
        }

        .d-block {
            display: block;
        }
		.s-table{
			width:100%;
            border-collapse: collapse;
            font-size:12px;
			text-align:center;
			td:nth-child(2){
				border-inline: 1px solid black;
			}
			th:nth-child(2){
				border-inline: 1px solid black;
			}
			td{
				font-weight: bold;
			}
			th{
				font-weight: normal;
			}
		}

    </style>

</head>

<body>
    <div class="possion-relative">
        @if ($invtype == 'gst')
            <h3 class="text-center">TAX INVOICE</h3>
        @else
            <h3 class="text-center">INVOICE</h3>
        @endif
        <p class="original-box">Original/Duplicate</p>
    </div>
    <div class="main-div">
        <table class="width-100" border="1">
            <tr>
                <th colspan="11" class="possion-relative text-center">
                    <img class="position-logo" src="{{ url($company['logo']) }}">
                    <h2 class="zero-p-m">{{ $company['cname'] }}</h2>
                    <p class="zero-p-m">{{ $company['address'] }}</p>
                    <p class="zero-p-m">Tel: {{ $company['cont1'] }} / {{ $company['cont2'] }}</p>
                    <p class="zero-p-m">Email: {{ $company['email'] }}</p>

                    @if ($invtype == 'gst')
                        <p class="zero-p-m">GSTIN: {{ $company['gstno'] }} </p>
                    @elseif ($invtype == 'nongst')
                        <p class="zero-p-m">&nbsp;</p>
                    @endif

                </th>
            </tr>

            <tr>
                <td colspan="3" rowspan="6">
                    <h4 class="zero-p-m">Buyer:</h4>
                    <h4 class="zero-p-m">{{ $client['name'] }}</h4>
                    <p class="zero-p-m">{{ $client['address'] }}</p>
                    <br>
                    <p class="zero-p-m">Phone: {{ $client['mobile'] }}</p>
                    <p class="zero-p-m">Email: {{ $client['email'] }}</p>
                    <br>
                    @if ($invtype == 'gst')
                        <p class="zero-p-m">GSTIN: {{ $client['gst'] }}</p>
                        <p class="zero-p-m">State: {{ $client['state'] }}</p>
                    @elseif($invtype == 'nongst')
                        <p class="zero-p-m"></p>
                        <p class="zero-p-m"></p>
                    @endif
                </td>
            </tr>

            <tr>
                <td colspan="3">Invoice No. <br>{{ $invoice['id'] }}</td>
                <td colspan="5">Dated: <br>{{ $invoice['date'] }}</td>
            </tr>

            <tr>
                <td colspan="3">Challan No. <br>{{ $challan['id'] }}</td>
                <td colspan="5">Dated: <br>{{ $challan['date'] }}</td>
            </tr>

            <tr>
                <td colspan="3">Order No. <br>{!! $orderno ?? '&nbsp;' !!}</td>
                <td colspan="5">Dated: <br>{!! $orderdate ?? '&nbsp;' !!}</td>
            </tr>

            <tr>
                <td colspan="3">Dispatched Through <br>&nbsp;</td>
                <td colspan="5">{!! $dispatchedthrough ?? '&nbsp;' !!}</td>
            </tr>

            <tr>
                <td colspan="8">Place of Supply: &nbsp; &nbsp; {!! $placeofsupply ?? '&nbsp;' !!} <br></td>

            </tr>
            <tr class="text-center">
                <td>SL.</td>
                <td>Job No.</td>
                <td>Description of goods</td>

                @if ($invtype == 'gst')
                    <td>
                        @if ($type == 'P')
                            HSN
                        @elseif ($type == 'S')
                            SAC
                        @endif
                    </td>
                @endif

                <td>Qty</td>

                @if ($invtype == 'gst')
                    <td>Unit</td>
                    <td>Rate</td>
                    @if ($amount['totalIgst'] == 0)
                        <td>CGST</td>
                        <td>SGST</td>
                    @endif
                    @if ($amount['totalIgst'] != 0)
                        <td>IGST</td>
                    @endif
                    <td>Amount</td>
                @elseif($invtype == 'nongst')
                    <td colspan=2>Unit</td>
                    <td colspan=2>Rate</td>
                    <td colspan=3>Amount</td>
                @endif

            </tr>

            @foreach ($invoiceData as $key => $item)
                <tr class="text-center vertical-top">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item['jobId'] }}</td>
                    <td rowspan="4">
                        <div class="d-description border-bottom">
							<table class="s-table">
								<thead>
									<tr>
                            			<th>Type</th>
                            			<th>Brand</th>
                            			<th>Model</th>
								</tr>
							</thead>
                        </div>

                        <div class="d-description d-description-value border-bottom">
                            <tbody>
								<tr>
									<td><span>{{ $item['item'] }}</span></td>
                            		<td><span>{{ $item['make'] }}</span></td>
                            		<td><span>{{ $item['model'] }}</span></td>
								</tr>
							</tbody>
							</table>
                        </div>

                        <div class="text-start d-description-value <?php if($invtype == 'gst') echo "border-bottom"; ?>">
                            <b>Serial No.</b>
                            <span>{{ $item['snno'] }}</span>
                        </div>
                        @if ($invtype == 'gst')
                            <div class="text-start d-description-value <?php if($item['narretion']) echo "border-bottom"; ?>">
                                <p class="zero-p-m">{{ $item['hsn'] }}</p>
                            </div>
                        @endif
                        <div class="text-start d-description-value">
                            <p class="zero-p-m">{{ $item['narretion'] }}</p>
                        </div>
                    </td>

                    @if ($invtype == 'gst')
                        <td>{{ $item['hsnId'] }}</td>
                    @endif

                    <td>1</td>

                    @if ($invtype == 'gst')
                        <td>PCS</td>
                        <td class="text-end">{{ number_format($item['rate'], 2) }}</td>
                        @if ($amount['totalIgst'] == 0)
                            <td class="text-end">{{ number_format($item['cgst'], 2) }}</td>
                            <td class="text-end">{{ number_format($item['sgst'], 2) }}</td>
                        @else
                            <td class="text-end">{{ number_format($item['igst'], 2) }}</td>
                        @endif
                        <td class="text-end">{{ number_format($item['total'], 2) }}</td>
                    @elseif($invtype == 'nongst')
                        <td colspan=2>PCS</td>
                        <td colspan=2 class="text-end">{{ number_format($item['rate'], 2) }}</td>
                        <td colspan=3 class="text-end">{{ number_format($item['total'], 2) }}</td>
                    @endif

                </tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
            @endforeach


            @if (count($invoiceData) == 1)
                <tr style="height: 25rem"></tr>
            @elseif (count($invoiceData) == 2)
                <tr style="height: 17rem"></tr>
            @elseif (count($invoiceData) == 3)
                <tr style="height: 14rem"></tr>
            @endif

            <tr>
                <td colspan="3"></td>
                <td>Total</td>
                <td>{{ count($invoiceData) }}</td>
                <td>Total</td>

                @if ($invtype == 'gst')

                    <td>{{ number_format($amount['totalExcludingGst'], 2) }}</td>

                    @if ($amount['totalIgst'] == 0)
                        <td>{{ number_format($amount['totalCgst'], 2) }}</td>
                        <td>{{ number_format($amount['totalSgst'], 2) }}</td>
                    @endif

                    @if ($amount['totalIgst'] != 0)
                        <td>{{ number_format($amount['totalIgst'], 2) }}</td>
                    @endif

                    <td>{{ number_format($amount['totalIncludingGst'], 2) }}</td>
                @elseif($invtype == 'nongst')
                    <td colspan=3 class="text-end">{{ number_format($amount['totalIncludingGst'], 2) }}</td>
                @endif

            </tr>
            <tr>
                <td colspan="11">
                    <div class="d-total-amount">
                        <span>Amount in words: {{ ucwords($amountInWord) }} </span>
                        {{-- <span><b>|| Amount(₹)</b></span>
						<span>{{number_format($amount['totalIncludingGst'], 2) }}</span> --}}
                    </div>
                </td>
            </tr>

            <tr>
                <th colspan="3" class="text-start p-bank-details f-10">
                    <p class="zero-p-m">BANK DETAILS</p>
                    <p class="zero-p-m">A/C NO: {{ $company['bank_ac_no'] }}</p>
                    <p class="zero-p-m">ACCOUNT NAME: {{ $company['bank_account_holder_name'] }}</p>
                    <p class="zero-p-m">BANK NAME: {{ $company['bank_name'] }}</p>
                    <p class="zero-p-m">BRANCH: {{ $company['bank_branch'] }}</p>
                    <p class="zero-p-m">IFSC CODE: {{ $company['bank_ifsc'] }}</p>
                    <span class="d-block"> ** All disputes are Subject to Kolkata Jurisdiction. **</span>

                </th>
                <td colspan="4" class="text-center vertical-bottom f-10">
                    <center>
                        <img class="d-block img-qr" alt="" src="{{ $company['bank_qr'] }}" />
                    </center>
                    <span class="d-block">Scan to pay </span>
                </td>
                <td colspan="4" class="text-end vertical-bottom possion-relative">
                    <b class="authorisation-box">E.& O.E</b>
                    <span>Authorised Signatory</span>
                </td>
            </tr>

        </table>
    </div>
</body>

</html>
