<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #B7D8FF;
            font-weight: bold;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .wrap-text {
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
</head>
<body>

    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>VA</th>
                <th>Category</th>
                <th>PO Date</th>
                <th>Drawing</th>
                <th>PR</th>
                <th>Loc</th>
                <th>Code</th>
                <th>Item Name</th>
                <th>Code</th>
                <th>Resin Type</th>
                <th>Unit Weight</th>
                <th>Sprue Weight</th>
                <th>G/Shot</th>
                <th>Std Cav</th>
                <th>No of Cavities</th>
                <th>Cycle Time</th>
                <th>Needed Kgs</th>
                <th>Allowance</th>
                <th>Total Need (kgs)</th>
                <th>Material Cost</th>
                <th>CT($)</th>
                <th>ME($)</th>
                <th>Shut off</th>
                <th>RMU @ Standard</th>
                <th>RMU @ Actual</th>
                <th>Unit Price</th>
                <th>P.O Qty</th>
                <th>Amount</th>
                <th>Qty</th>
                <th>Amount (Round Off)</th>
                <th>Internal Inv (Amt)</th>
                <th>External Inv (Amt)</th>
                <th>RMU @ Standard</th>
                <th>RMU @ Actual Activity</th>
                <th>Rate</th>
                <th>Balance Qty</th>
                <th>Amount</th>
                <th>Classification</th>
                <th>RMU</th>
                <th>Rate</th>
                <th>RMU @ Standard</th>
                <th>RMU @ Actual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($search_data_reports as $data)
                <tr>
                    <td class="wrap-text">{{ $data->Category }}</td>
                    <td>{{ $category ?? '' }}</td>
                    <td class="wrap-text">{{ $data->Category }} ({{ $category ?? '' }})</td>
                    <td>{{ $data->DateIssued ?? '' }}</td>
                    <td>{{ $data->DrawingNo ?? '' }}</td>
                    <td>{{ $data->OrderNo ?? '' }}</td>
                    <td>{{ $data->location ?? '' }}</td>
                    <td>{{ $data->ItemCode ?? '' }}</td>
                    <td class="wrap-text">{{ $data->ItemName ?? '' }}</td>
                    <td>{{ $data->PartNumber ?? '' }}</td>
                    <td>{{ $data->MaterialType ?? '' }}</td>
                    <td>{{ $data->UnitWgt ?? '' }}</td>
                    <td>{{ $data->SprueWgt ?? '' }}</td>
                    <td>{{ $data->ShotWgt ?? '' }}</td>
                    <td>{{ $data->NoOfCav ?? '' }}</td>
                    <td>{{ $data->CycleShot ?? '' }}</td>
                    <td>{{ $data->NeededKgs ?? '' }}</td>
                    <td>{{ $data->Allowance ?? '' }}</td>
                    <td>{{ $data->TotalNeedKgs ?? '' }}</td>
                    <td>{{ $data->MaterialCost ?? '' }}</td>
                    <td>{{ $data->CT ?? '' }}</td>
                    <td>{{ $data->ME ?? '' }}</td>
                    <td>{{ $data->ShutOff ?? '' }}</td>
                    <td>{{ $data->RMUStandard ?? '' }}</td>
                    <td>{{ $data->RMUActual ?? '' }}</td>
                    <td>{{ $data->UnitPrice ?? '' }}</td>
                    <td>{{ $data->OrderQty ?? '' }}</td>
                    <td>{{ $data->Amount ?? '' }}</td>
                    <td>{{ $data->Qty ?? '' }}</td>
                    <td>{{ $data->AmountRoundOff ?? '' }}</td>
                    <td>{{ $data->InternalInvAmt ?? '' }}</td>
                    <td>{{ $data->ExternalInvAmt ?? '' }}</td>
                    <td>{{ $data->RMUStandard ?? '' }}</td>
                    <td>{{ $data->RMUActualActivity ?? '' }}</td>
                    <td>{{ $data->Rate ?? '' }}</td>
                    <td>{{ $data->BalanceQty ?? '' }}</td>
                    <td>{{ $data->Amount ?? '' }}</td>
                    <td>{{ $data->Classification ?? '' }}</td>
                    <td>{{ $data->RMU ?? '' }}</td>
                    <td>{{ $data->Rate ?? '' }}</td>
                    <td>{{ $data->RMUStandard ?? '' }}</td>
                    <td>{{ $data->RMUActual ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>